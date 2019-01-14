<?php

require_once 'controller/Instalacao.php';

class Comissionamento extends Instalacao
{
	protected $comissionamentos_pendentes;
	
	function __construct(){
	    parent::__construct();

	}
	
	public function comiss()
    {
    	if ( ! empty($this->dadosP['param']) )
        	$this->smarty->assign('param',$this->dadosP['param']);

    	//$tipo_equipamentos = $this->TipoEquipamentos->fetchAll();
    	$tipo_equipamentos = $this->TipoEquipamentos->listaEquipamentosODU();
    	
        $this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());
        
        $equipamentos = $this->Equipamento->fetchAll();
        $this->smarty->assign('listaEquipamentos',$equipamentos->toArray());
        
        $listaautocomplete = array();
        foreach( $equipamentos->toArray() as $equipamento_unico )
        	$listaautocomplete[] = $equipamento_unico['sno'];
        $listaautocomplete = implode(',',$listaautocomplete);
        $this->smarty->assign('listaautocomplete',$listaautocomplete);
    	
        //TODO: registra log
        
    	$agora = date('Y-m-d H:i:s');
		
        $this->smarty->assign('agora',$agora);
        $this->smarty->assign('session',$_SESSION);
        $this->smarty->display("{$this->tplDir}/comiss.tpl");
    }
	    
	public function inicia_comiss()
    {


    	$idInstalacao = $_POST['idinstalacoes'];

    	$where = " idinstalacoes  = '{$idInstalacao}' ";

    	$this->instalacao = $this->Instalacao->fetchRow( $where );

    	$this->os = $this->OS->fetchRow(" idos = '{$this->instalacao->os_idos}' ");

    	$dataAtual = date('Y-m-d H:i:s');

    	$data = array(
    		'comiss' => 1,
    		'create_user_comiss_time' => $dataAtual,
    		'create_user_comiss' => $_SESSION['login']['idusuarios']
    	);

    	$where = " idinstalacoes  = '{$this->instalacao->idinstalacoes}' ";
    	if( !$this->Instalacao->update( $data , $where ) )
    		exit("erro|Erro ao iniciar Comissionamento.");
    		
    	$agora = date('H');
    	if($agora > 00 && $agora < 12)
    		$this->cumprimento = "Bom Dia";
    	
    	else if($agora >= 12 && $agora < 18)
    		$this->cumprimento = "Boa Tarde";
    	
    	else if($agora >= 18)
    		$this->cumprimento = "Boa Noite";

    		
    	$this->emailInicioComissionamento();
//
    	exit($this->resultInicioComiss);
    }
    
	public function comiss_view()
    {

    	if ( ! empty($this->dadosP['param']) )
       	{
       		$tipo_equipamentos = $this->TipoEquipamentos->fetchAll();
        	$this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());
        	
        	$equipamentos = $this->Equipamento->fetchAll();
            $listaautocomplete = array();
	        foreach( $equipamentos->toArray() as $equipamento_unico )
	        	$listaautocomplete[] = $equipamento_unico['sno'];
	        $listaautocomplete = implode(',',$listaautocomplete);
	        $this->smarty->assign('listaautocomplete',$listaautocomplete);
	        
			$dados = $this->Instalacao->fetchRow(" idinstalacoes = '{$this->dadosP['param']}' ")->toArray();
			
			$dados['comissionado_por'] = $this->Usuarios->fetchRow(" idusuarios = '{$dados['create_user_comiss']}' ");
			$dados['comissionado_por'] = ($dados['comissionado_por'] instanceof Zend_Db_Table_Row )?$dados['comissionado_por']->nome:'';
			$dados['editado_por'] = $this->Usuarios->fetchRow(" idusuarios = '{$dados['last_user_comiss']}' ");
			$dados['editado_por'] = ( $dados['editado_por'] instanceof Zend_Db_Table_Row )?$dados['editado_por']->nome:'';
			
			$dados['create_user_comiss_time'] = ( $dados['create_user_comiss_time'] != '' )?$this->Helpers->data_us_br_com_hora($dados['create_user_comiss_time']):'';
			$dados['last_user_comiss_time'] = ( $dados['last_user_comiss_time'] != '' )?$this->Helpers->data_us_br_com_hora($dados['last_user_comiss_time']):'';

//			$this->alterandoCaminhoDoTermoAceiteNoBanco();

			$dados = $this->mesclaPerguntasComissionamentoComDadosInstalacao( $dados );
			
			$this->smarty->assign('obj',$dados);
			
            $this->smarty->display("{$this->tplDir}/comiss_view.tpl");
        }   
    }


//	function alterandoCaminhoDoTermoAceiteNoBanco()
//	{
//
//		$dados = array();
//		$sql = "SELECT idinstalacoes, termo_aceite FROM instalacoes";
//		$dados = $this->DB->queryDados($sql);
//		foreach ($dados as $campo) {
//			$sql = "UPDATE instalacoes set termo_aceite ='public/{$campo['termo_aceite']}'
//                    WHERE idinstalacoes = '{$campo['idinstalacoes']}';";
//			$this->DB->query($sql);
//
//		}
//	}
    
    // TODO: simplificar método
    public function edit_comiss() 
	{
        if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))//FORMULARIO 
        {
            
            
        	$tipo_equipamentos = $this->TipoEquipamentos->listaEquipamentosODU();
        	
        	$this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());
            
        	$equipamentos = $this->Equipamento->fetchAll();
            $listaautocomplete = array();
            
	        foreach( $equipamentos->toArray() as $equipamento_unico )
	        	$listaautocomplete[] = $equipamento_unico['sno'];
	        	
	        $listaautocomplete = implode(',',$listaautocomplete);
	        $this->smarty->assign('listaautocomplete',$listaautocomplete);
            
            $agora = date('Y-m-d H:i:s');
			$this->smarty->assign('agora',$agora);
        	
			// busca instalacao
                
        		$dados = $this->Instalacao->fetchRow(" idinstalacoes = '{$this->dadosP['param']}' ");

        		$dados = $this->mesclaPerguntasComissionamentoComDadosInstalacao( $dados->toArray() );

        		$this->smarty->assign('obj',$dados);
            
            $this->smarty->assign('session',$_SESSION);
            $this->smarty->display("{$this->tplDir}/comiss_edit.tpl");
        }
        elseif ( ! empty($this->dadosP['form']))//SUBMIT
        {
//            $arrReturn['msg']     = $this->dadosP['form'][''];
//            die_json($arrReturn);
        	$instalacao = $this->Instalacao->fetchRow(" idinstalacoes = '{$this->dadosP['form']['idinstalacoes']}' ");

        	$os = $this->OS->fetchRow(" idos = '{$instalacao['os_idos']}' ");

        	
        	
        	
        	// -------------------------------------------------------- tratamento de equipamentos
        	
        	$this->Equipamento->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['mac_comiss'] , 'MAC' );
        	$this->Equipamento->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['nsmodem_comiss'] , 'Número de Série da Vsat' );
        	$this->Equipamento->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['nsodu_comiss'] , 'Número de Série ODU' );
        	//$this->Equipamento->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['antena_ns_comiss'] , 'Número de Série da Antena' );
        	        	

        	if( $this->dadosP['form']['mac_comiss'] != '' )
        		$verificacao_mac = $this->Equipamento->verifica_existencia_mac( $this->dadosP['form']['mac_comiss'] );
        	
        	if( isset($this->dadosP['form']['nsmodem_comiss']) )
        		$nsmodem_comiss_carregado = $this->Equipamento->valida_ns( $this->dadosP['form']['nsmodem_comiss'] , $instalacao , 'nsmodem_comiss' , $this->EquipamentosLocais );

        	if( isset($this->dadosP['form']['nsodu_comiss']) )
        		$nsodu_comiss_carregado = $this->Equipamento->valida_ns( $this->dadosP['form']['nsodu_comiss'] , $instalacao , 'nsodu_comiss' , $this->EquipamentosLocais );
        		

			$this->Equipamento->atualiza_status_equipamento( $nsmodem_comiss_carregado , $this->EquipamentosLocais , 2 , $instalacao , 'nsmodem_comiss' );

			$this->Equipamento->atualiza_status_equipamento( $nsodu_comiss_carregado , $this->EquipamentosLocais , 2 , $instalacao , 'nsodu_comiss' );



			// -------------------------------------------------------- finalizacao de comissionamento

			$data_final_comiss = ( isset($this->dadosP['form']['data_final_comiss']) )?$this->dadosP['form']['data_final_comiss']:'';
			$this->dadosP['form']['data_final_comiss'] = $this->Instalacao->trata_finalizacao_comissionamento(
														     ( isset($this->dadosP['form']['termo_aceite']) )?$this->dadosP['form']['termo_aceite']:'' , 
															 $instalacao ,
															 $os ,
														 	 $data_final_comiss
														 );
														 
														 
														 
			// -------------------------------------------------------- edita instalação


			$formPerguntasComissionamento = $this->separaFormParaInstalacoesEPerguntas();

			$dados_modificados = $this->Instalacao->edit( $this->dadosP['form'] , $instalacao );
//             $arrReturn['msg']     = 'teste';
//             die_json($arrReturn);
			
			//----Depois que for editado a tabela de Instala�ao,  sera editado a tabela de perguntas comissionamento--------------
			

			$respostaAtualizacaoPerguntas = $this->PerguntasComissionamento->atualizaPerguntasPelaInstalacao( $formPerguntasComissionamento );
			if( isset($dados_modificados['status']) && $respostaAtualizacaoPerguntas == false )
				die_json($dados_modificados);
				
        	
        	// -------------------------------------------------------- registro de log
        	
			$this->Log->registroLogEdicaoComissionamento(
														$this->dadosP['form'] ,
														$instalacao ,
														$dados_modificados
														);

//            $arrReturn['msg']     = 'teste';
//            die_json($arrReturn);
			// --
			
	        $arrReturn['status']  = 'ok';
			$arrReturn['msg']     = 'Edição realizada com sucesso!';
	    	die_json($arrReturn);
        }
    }
    
    
    public function emailInicioComissionamento()
    {
//    	//EMAIL PARA PRODEMGE - para informar do inicio do comissionamento
//	    	$assunto = "Ativação Vodanet {$this->instalacao->nome}";
//	        $to = array(
////    			"rms.cgr@prodemge.gov.br",
//    			"noc.sp@globaleagle.com",
//    			"celio.batalha@gmail.com"
//
//    		);
//    		$msg = "
//    			{$this->cumprimento},<br/><br/>
//    			A Vodanet informa que os testes de aceitação do terminal {$this->instalacao->nome} com
//    			o IP LAN {$this->os->iplan} e o IP DVB {$this->os->ipdvb}, estão iniciando
//    			neste momento. Por favor, informar o profissional da Prodemge que será o responsável
//    			por acompanhar esta ativação.
//    			<br/><br/>
//				Atenciosamente,<br/><br/>
//				{$_SESSION['login']['nome']}<br/>
//				Vodanet Telecomunicações Ltda.<br/>
//				http://www.vodanet-telecom.com<br/>
//				<img src='http://saom.vodanet-telecom.com/public/imagens/logo_gee.png' height='50' width='350'/>
//			";
//
//
////    		if( !$this->Helpers->sendMail( $assunto , $to , $msg , '' , 'noc.sp@globaleagle.com' ) )
//    		if( !sendMailComissionamento( $assunto , $to , $msg) )
//    			$this->resultInicioComiss = "erro|Erro ao enviar email a PRODEMGE!";
//
//    		else //EMAIL PARA PRODEMGE - fim
    			$this->resultInicioComiss = "ok|Comissionamento criado com sucesso.";
    }
    
    public function verificaPendenciaUsuario()
    {
    	//pendencias possiveis:
    	//1.Data Aceite sem Termo Aceite
    	//2.Data Aceite sem salvamento do formulário do comissionamento (em 'Editar Comissionamento', Salvar o formulário)
    	
    	$where = " 
    		create_user_comiss = '{$_SESSION['login']['idusuarios']}' AND 
    		( 
    			(
	    			(
						data_aceite IS NOT NULL AND 
						data_aceite !=  '0000-00-00'
					) AND (
						data_final_comiss =  '0000-00-00 00:00:00' OR 
						data_final_comiss IS NULL
					) 
				) OR (
					termo_aceite =  '' AND 
					(
						data_aceite IS NOT NULL AND 
						data_aceite !=  '0000-00-00'
					)
				)
			)
    	";
    	$this->comissionamentos_pendentes = $this->Instalacao->fetchAll($where)->toArray();
    	
    	foreach( $this->comissionamentos_pendentes as $chave => $comissionamento_pendente )
    	{
	    	$os = $this->OS->fetchRow(" idos = '{$comissionamento_pendente['os_idos']}' ");
	    	$this->comissionamentos_pendentes[$chave]['os'] = ( $os instanceof Zend_Db_Table_Row )?$os->toArray():'';
    	}
    	
    	//TODO: aguardando que os emails do saom estejam arrumados 
    	//		de acordo com as informações corretas do usuário
    	$this->informaPendenciaAUsuario();
		
		return $this->comissionamentos_pendentes;
    }
    
    public function informaPendenciaAUsuario()
    {
    	$assunto = "SAOM - Comissionamentos Pendentes";
    	
    	$mensagem = trim("
    		{$_SESSION['login']['nome']},
    		O SAOM verificou que os seguintes Comissionamentos sob sua responsabilidade estão pendentes:<br/>
    	");
    	foreach( $this->comissionamentos_pendentes as $comissionamento_pendente )
    		$mensagem .= trim("
    			Instalação {$comissionamento_pendente['nome']},<br/>
    		");
    	
    	if( !$this->Helpers->sendMail(
								$assunto,
								$_SESSION['login']['email'],
								$mensagem,
								$anexo='vazio',
								$origem='saom@vodanet-telecom.com',
								$autor='SAOM'
								))
			mail(
				'savio@vodanet-telecom.com', 
				'Erro ao informar pendência de comissionamento a usuário', 
				"Houve um erro ao informar pendência do Comissionamento da Instalação {$this->comissionamento_pendente['nome']}.");
    }
    
    
    
    // upload de licenca anatel
    
    public function formulario_upload_licenca_anatel()
    {
    	$this->smarty->assign('idinstalacao',$this->dadosP['idinstalacao']);	
    	$this->smarty->display("{$this->tplDir}/licenca_anatel.tpl");
    }
    
	public function upload_licenca_anatel()
    {
    	//print_b($this->dadosP,true);
    	
    	// TODO: melhorar esse método de pegar a extensao
    		$buscaDaExtencao = explode('.',$this->dadosF['licenca_anatel']['name']);
    	$this->dadosF['licenca_anatel']['name'] = $this->Instalacao->getNomeVsatPeloIdInstalacao( $this->dadosP['idinstalacoes_para_licenca'] ) . "." . $buscaDaExtencao[1];
    	//print_b($this->dadosF,true);
    	
    	if( $this->upload( $this->dadosF , 'upload/licenca_anatel/' ) )
    	{
    		$this->insereLicencaAnatel( $this->dadosF , $this->dadosP['idinstalacoes_para_licenca'] );
    		
    		$nome = explode( '.' , $this->dadosF['licenca_anatel']['name'] );
    		$arquivo = "<a id='arquivo_novo_licenca_anatel' target='_blank' href='upload/licenca_anatel/{$this->dadosF['licenca_anatel']['name']}'><i class='icon-file'></i><font style='color:#000;'>{$this->dadosF['licenca_anatel']['name']}</font></a>";
    		die($arquivo."<div id='local_licenca_anatel_status' class='alert alert-success'>Arquivo enviado com sucesso.</div>");
    	}
        else die("<div id='local_licenca_anatel_status' class='alert alert-error'>Erro ao enviar arquivo.</div>");
    }
    
    private function insereLicencaAnatel( $arquivo , $idinstalacao )
    {
    	if( $preExistencia = $this->verificaPreExistenciaLicencaAnatelParaEstacao( new Integer($idinstalacao) ) )
    	{
    		$nome = explode( '.' , $arquivo['licenca_anatel']['name'] );
    			$this->LicencaAnatel->setnome( $nome[0] );
    		$endereco = 'upload/licenca_anatel/'.$arquivo['licenca_anatel']['name'];
    			$this->LicencaAnatel->setendereco( $endereco );
    			
    		if( $this->LicencaAnatel->edit() ) return true;
    		else return false;
    	}
    	else
    	{
    		$nome = explode( '.' , $arquivo['licenca_anatel']['name'] );
    			$this->LicencaAnatel->setnome( $nome[0] );
    		$endereco = 'upload/licenca_anatel/'.$arquivo['licenca_anatel']['name'];
    			$this->LicencaAnatel->setendereco( $endereco );
    		$this->LicencaAnatel->setinstalacoes_idinstalacoes( $idinstalacao );
    		
    		if( $this->LicencaAnatel->create() ) return true;
    		else return false;
    	}
    }
    
    private function verificaPreExistenciaLicencaAnatelParaEstacao( Integer $idinstalacao )
    {
    	$this->LicencaAnatel->setinstalacoes_idinstalacoes( $idinstalacao->numero() );
    	return $this->LicencaAnatel->buscaLicencaPelaInstalacao();
    }
    
    private function upload( $form , $pasta )
    {
    	if( !empty($form['licenca_anatel']) )
		{
			$move = move_uploaded_file( $form['licenca_anatel']['tmp_name'] , $pasta.$form['licenca_anatel']['name'] );
					
			if ( $move ) return true;
			else return false;
        }
        else return false;
    }
    
    public function resgataODUdeNSODU()
    {
    	$odu = $this->Equipamento->buscaODUdeNSODU( $this->dadosP['nsodu'] );
    	if( count($odu) > 0 ) echo $odu[0]['tipo_equipamentos_idtipo_equipamentos'];
    	else echo '';
    }
}
