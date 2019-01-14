<?php

require_once 's_p/controller/Instalacao_sp.php';

class Comissionamento_sp extends Instalacao_sp
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
    	$tipo_equipamentos = $this->TipoEquipamentos_sp->listaEquipamentosODU();

        $this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());

        $equipamentos = $this->Equipamento_sp->fetchAll();
        $this->smarty->assign('listaEquipamentos',$equipamentos->toArray());

        $listaautocomplete = array();
        foreach( $equipamentos->toArray() as $equipamento_unico )
        	$listaautocomplete[] = $equipamento_unico['sno'];
        $listaautocomplete = implode(',',$listaautocomplete);
        $this->smarty->assign('listaautocomplete',$listaautocomplete);

        //TODO: registra log

    	$agora = date('Y-m-d H:i:s');
//        echo die_json($_SESSION);

        $this->smarty->assign('agora',$agora);
        $this->smarty->assign('session',$_SESSION);
        $this->smarty->display("{$this->tplDir}/comiss.tpl");
    }
	    
	public function inicia_comiss()
    {

    	$idInstalacao = $_POST['idinstalacoes_sp'];
    	
    	$where = " idinstalacoes_sp  = '{$idInstalacao}' ";
    	$this->instalacao = $this->Instalacao_sp->fetchRow( $where );
    	
    	$this->os = $this->OSSP->fetchRow(" idos = '{$this->instalacao->os_sp_idos}' ");
    		
    	$dataAtual = date('Y-m-d H:i:s');
    	
    	$data = array(
    		'comiss' => 1,
    		'create_user_comiss_time' => $dataAtual,
    		'create_user_comiss' => $_SESSION['login']['idusuarios']
    	);
    	
		$where = " idinstalacoes_sp  = '{$this->instalacao->idinstalacoes_sp}' ";

    	if( !$this->Instalacao_sp->update( $data , $where ) )
    		exit("erro|Erro ao iniciar Comissionamento.");
    		
    	$agora = date('H');
    	if($agora > 00 && $agora < 12)
    		$this->cumprimento = "Bom Dia";
    	
    	else if($agora >= 12 && $agora < 18)
    		$this->cumprimento = "Boa Tarde";
    	
    	else if($agora >= 18)
    		$this->cumprimento = "Boa Noite";
    		
    	$this->emailInicioComissionamento();

    	exit($this->resultInicioComiss);
    }
    
	public function comiss_view()
    {
    	if ( ! empty($this->dadosP['param']) )
       	{
       		$tipo_equipamentos = $this->TipoEquipamentos_sp->fetchAll();
        	$this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());
        	
        	$equipamentos = $this->Equipamento_sp->fetchAll();
            $listaautocomplete = array();
	        foreach( $equipamentos->toArray() as $equipamento_unico )
	        	$listaautocomplete[] = $equipamento_unico['sno'];
	        $listaautocomplete = implode(',',$listaautocomplete);
	        $this->smarty->assign('listaautocomplete',$listaautocomplete);
	        
			$dados = $this->Instalacao_sp->fetchRow(" idinstalacoes_sp = '{$this->dadosP['param']}' ")->toArray();

//			echo die_json($dados);
			
			$dados['comissionado_por'] = $this->Usuarios_sp->fetchRow(" idusuarios = '{$dados['create_user_comiss']}' ");
			$dados['comissionado_por'] = ($dados['comissionado_por'] instanceof Zend_Db_Table_Row )?$dados['comissionado_por']->nome:'';
			$dados['editado_por'] = $this->Usuarios_sp->fetchRow(" idusuarios = '{$dados['last_user_comiss']}' ");
			$dados['editado_por'] = ( $dados['editado_por'] instanceof Zend_Db_Table_Row )?$dados['editado_por']->nome:'';
			
			$dados['create_user_comiss_time'] = ( $dados['create_user_comiss_time'] != '' )?$this->Helpers->data_us_br_com_hora($dados['create_user_comiss_time']):'';
			$dados['last_user_comiss_time'] = ( $dados['last_user_comiss_time'] != '' )?$this->Helpers->data_us_br_com_hora($dados['last_user_comiss_time']):'';

// 		    $this->alterandoCaminhoDoTermoAceiteNoBanco();

		    
			$dados = $this->mesclaPerguntasComissionamentoComDadosInstalacao( $dados );

			$this->smarty->assign('obj',$dados);
			
            $this->smarty->display("{$this->tplDir}/comiss_view.tpl");
        }   
    }
    
    function alterandoCaminhoDoTermoAceiteNoBanco($dados){
        
        $dados = array();
        $sql = "SELECT idinstalacoes_sp, termo_aceite FROM instalacoes_sp";
        $dados = $this->DB->queryDados($sql);
        foreach($dados as $campo){
            $sql = "UPDATE instalacoes_sp set termo_aceite ='public/{$campo['termo_aceite']}'
                    WHERE idinstalacoes_sp = '{$campo['idinstalacoes_sp']}';";
           $this->DB->query($sql);               
          
        }
        
        
//         if(!$publico[0] == 'public'){
//             return true;
//         }else{
//             $sql = "UPDATE instalacoes set termo_aceite ='public/{$dados['termo_aceite']}'
//                     WHERE idinstalacoes_sp = '{$dados['idinstalacoes_sp']}'";
//             if(!$this->DB->queryDados($sql)){
                
//     			$arrReturn['erro']     = 'Erro ao mudar o endereço do termo aceite';
//     		    die_json($arrReturn);			
//             }
//         }
        
    }
    
    // TODO: simplificar método
    public function edit_comiss() 
	{
        if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))//FORMULARIO 
        {
            
            
        	$tipo_equipamentos = $this->TipoEquipamentos_sp->listaEquipamentosODU();

            $this->smarty->assign('tipoEquipamentos',$tipo_equipamentos->toArray());
            
        	$equipamentos = $this->Equipamento_sp->fetchAll();
            $listaautocomplete = array();
            
	        foreach( $equipamentos->toArray() as $equipamento_unico )
	        	$listaautocomplete[] = $equipamento_unico['sno'];
	        	
	        $listaautocomplete = implode(',',$listaautocomplete);
	        $this->smarty->assign('listaautocomplete',$listaautocomplete);
            
            $agora = date('Y-m-d H:i:s');
			$this->smarty->assign('agora',$agora);
        	
			// busca instalacao
                
        		$dados = $this->Instalacao_sp->fetchRow(" idinstalacoes_sp = '{$this->dadosP['param']}' ");

        		$dados = $this->mesclaPerguntasComissionamentoComDadosInstalacao( $dados->toArray() );

//         		echo die_json($dados);
        		$this->smarty->assign('obj',$dados);
            
            $this->smarty->assign('session',$_SESSION);
            $this->smarty->display("{$this->tplDir}/comiss_edit.tpl");
        }
        elseif ( ! empty($this->dadosP['form']))//SUBMIT
        {

        	$instalacao = $this->Instalacao_sp->fetchRow(" idinstalacoes_sp = '{$this->dadosP['form']['idinstalacoes_sp']}' ");

        	$os = $this->OSSP->fetchRow(" idos = '{$instalacao['os_sp_idos']}' ");



        	// -------------------------------------------------------- tratamento de equipamentos

        	$this->Equipamento_sp->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['mac_comiss'] , 'MAC' );
        	$this->Equipamento_sp->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['nsmodem_comiss'] , 'Número de Série da Vsat' );
        	$this->Equipamento_sp->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['nsodu_comiss'] , 'Número de Série ODU/BUC' );
        	//$this->Equipamento_sp->valida_campo_equipamento_comissionamento_vazio( $this->dadosP['form']['antena_ns_comiss'] , 'Número de Série da Antena' );



        	if( $this->dadosP['form']['mac_comiss'] != '' )
        		$verificacao_mac = $this->Equipamento_sp->verifica_existencia_mac( $this->dadosP['form']['mac_comiss'] );


        	if( isset($this->dadosP['form']['nsmodem_comiss']) )
        		$nsmodem_comiss_carregado = $this->Equipamento_sp->valida_ns( $this->dadosP['form']['nsmodem_comiss'] , $instalacao , 'nsmodem_comiss' , $this->EquipamentosLocais_sp );

//			$arrReturn['msg'] = 'TESTE';
//			die_json($arrReturn);

        	if( isset($this->dadosP['form']['nsodu_comiss']) )
        		$nsodu_comiss_carregado = $this->Equipamento_sp->valida_ns( $this->dadosP['form']['nsodu_comiss'] , $instalacao , 'nsodu_comiss' , $this->EquipamentosLocais_sp );


			$this->Equipamento_sp->atualiza_status_equipamento( $nsmodem_comiss_carregado , $this->EquipamentosLocais_sp , 2 , $instalacao , 'nsmodem_comiss' );


			$this->Equipamento_sp->atualiza_status_equipamento( $nsodu_comiss_carregado , $this->EquipamentosLocais_sp , 2 , $instalacao , 'nsodu_comiss' );

			// -------------------------------------------------------- finalizacao de comissionamento

			$data_final_comiss = ( isset($this->dadosP['form']['data_final_comiss']) )?$this->dadosP['form']['data_final_comiss']:'';


			$this->dadosP['form']['data_final_comiss'] = $this->Instalacao_sp->trata_finalizacao_comissionamento(
														     ( isset($this->dadosP['form']['termo_aceite']) )?$this->dadosP['form']['termo_aceite']:'' ,
															 $instalacao ,
															 $os ,
														 	 $data_final_comiss
														 );





			// -------------------------------------------------------- edita instalação


			$formPerguntasComissionamento = $this->separaFormParaInstalacoesEPerguntas();



			$dados_modificados = $this->Instalacao_sp->edit( $this->dadosP['form'] , $instalacao );

			//----Depois que for editado a tabela de Instala�ao,  sera editado a tabela de perguntas comissionamento--------------


			$respostaAtualizacaoPerguntas = $this->PerguntasComissionamento_sp->atualizaPerguntasPelaInstalacao( $formPerguntasComissionamento );


			if( isset($dados_modificados['status']) && $respostaAtualizacaoPerguntas == false )
				die_json($dados_modificados);





        	// -------------------------------------------------------- registro de log

			$this->Log_sp->registroLogEdicaoComissionamento(
														$this->dadosP['form'] ,
														$instalacao ,
														$dados_modificados
														);

			// --
			
	        $arrReturn['status']  = 'ok';
			$arrReturn['msg']     = 'Edição realizada com sucesso!';
	    	die_json($arrReturn);
        }
    }


//	public function valida_ns(
//										$ns ,
//										$instalacao ,
//										$equipamento ,
//										$equipamentosLocais
//								)
//	{
//
////		$where = " sno = '{$ns}' ";
//
//		$sql = "
//    		SELECT sno
//    		FROM equipamentos_sp
//    		WHERE sno = '{$ns}'
//    	";
//		$dados = $this->DB->queryDados($sql);
//
//		if( count($dados) < 1 )
//		{
//			$arrReturn['status'] = 'erro';
//			$arrReturn['msg']    = "{$this->nomes_equipamento[$equipamento]} não consta entre os equipamentos.";
//			die_json($arrReturn);
//		}
//		else
//		{
//
//			$this->Equipamento_sp->verifica_status_equipamento_invocado(
//																		$dados ,
//																		$instalacao ,
//																		$equipamento ,
//																		$equipamentosLocais
//																);
//
//			return $dados;
//		}
//	}
    
    
    public function emailInicioComissionamento()
    {
    	//EMAIL PARA PRODEMGE - para informar do inicio do comissionamento
	    	$assunto = "Ativação {$this->instalacao->nome}";
	        $to = array(
//					"noc.sp@emc-corp.net",
					"celio.batalha@emc-corp.net"
    		);
    		$msg = "
    			{$this->cumprimento},<br/><br/>
    			Informamos que os testes de aceitação do terminal {$this->instalacao->nome} com
    			o IP LAN {$this->os->iplan} e o IP DVB {$this->os->ipdvb}, estão iniciando 
    			neste momento {$this->os->emailFaturamento}.
    			<br/><br/>
				Atenciosamente,<br/><br/>
				{$_SESSION['login']['nome']}<br/>
				EMERGING MARKETS COMUNICATIONS LLC.<br/>
				<a href='http://www.emc-corp.net'>http://www.emc-corp.net</a><br/><br/>
				<img src='http://saom.vodanet-telecom.com/public/imagens/logoEMC.png' height='100' width='300'/>
			";
    		
    		if( !$this->Helpers->sendMailComiss($assunto , $to , $msg) )
    			$this->resultInicioComiss = "Pronto pra Começar!";

    		else //EMAIL PARA PRODEMGE - fim
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
    	$this->comissionamentos_pendentes = $this->Instalacao_sp->fetchAll($where)->toArray();
    	
    	foreach( $this->comissionamentos_pendentes as $chave => $comissionamento_pendente )
    	{
	    	$os = $this->OSSP->fetchRow(" idos = '{$comissionamento_pendente['os_sp_idos']}' ");
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
    	$this->dadosF['licenca_anatel']['name'] = $this->Instalacao_sp->getNomeVsatPeloIdInstalacao( $this->dadosP['idinstalacoes_para_licenca'] ) . "." . $buscaDaExtencao[1];
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
    			$this->LicencaAnatel_sp->setnome( $nome[0] );
    		$endereco = 'upload/licenca_anatel/'.$arquivo['licenca_anatel']['name'];
    			$this->LicencaAnatel_sp->setendereco( $endereco );
    			
    		if( $this->LicencaAnatel_sp->edit() ) return true;
    		else return false;
    	}
    	else
    	{
    		$nome = explode( '.' , $arquivo['licenca_anatel']['name'] );
    			$this->LicencaAnatel_sp->setnome( $nome[0] );
    		$endereco = 'upload/licenca_anatel/'.$arquivo['licenca_anatel']['name'];
    			$this->LicencaAnatel_sp->setendereco( $endereco );
    		$this->LicencaAnatel_sp->setinstalacoes_idinstalacoes( $idinstalacao );
    		
    		if( $this->LicencaAnatel_sp->create() ) return true;
    		else return false;
    	}
    }
    
    private function verificaPreExistenciaLicencaAnatelParaEstacao( Integer $idinstalacao )
    {
    	$this->LicencaAnatel_sp->setinstalacoes_idinstalacoes( $idinstalacao->numero() );
    	return $this->LicencaAnatel_sp->buscaLicencaPelaInstalacao();
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
    	$odu = $this->Equipamento_sp->buscaODUdeNSODU( $this->dadosP['nsodu'] );
    	if( count($odu) > 0 ) echo $odu[0]['tipo_equipamentos_sp_idtipo_equipamentos_sp'];
    	else echo '';
    }
}
