<?php
include_once 'model/DBInstalacao.php';
require_once 'model/InstalacoesModel.php';
// require_once 'model/BO/UsuariosBO.php';
include_once 'helpers.class.php';
require_once  'helpers/Utilitarios.php';


class InstalacoesBO extends InstalacoesModel
{
    
	protected $_name = 'instalacoes';
	protected $_primary = 'idinstalacoes';
	
	protected $form_check_box = array(
        						'packetshapper',
        						'webnms',
        						'test_geo',
        						'reglicenca',
        						'opmanager',
        						'test_e_termo_aceite',// Enviou o Termo de Aceite à Prodemge?
    							'cabo_rj45'
    							);
	protected $campo_data = array(
								'data_aceite',
    							'data_ativacao'
								);
	protected $dados_modificados = array();
	protected $form;
	
	
	// TODO: atributos de necessidade  questionável
	protected $Helpers;
	protected $Helper;
	protected $comissiona;
	
	
	public function __construct( $adapter )
	{

		parent::__construct( $adapter );
		
		$this->DBComissiona = new DBInstalacao();
// 		$this->UsuariosBO =  new UsuariosBO( $adapter );
	}
	
	
	
	public function getInstalacaoPeloNome( $nomeInstalacao )
	{

		//TODO: encontrar um meio de validar a variavel nomeInstalacao de entrada
		$where = " nome = '{$nomeInstalacao}' ";
		$instalacoes = $this->fetchAll( $where );
		if( count($instalacoes) > 0 )
		{
			//print_b();
			$instalacao = $instalacoes->toArray();
			
			$this->setidinstalacoes( $instalacao[0]['idinstalacoes'] );
			foreach ( $this->campos as $campo )
			{
				$this->{'set'.$campo}( $instalacao[0][ $campo ] );
			}
			return true;
		}else return false;
	}
	
	
	// --
	
// 	public function liste($where){
	    
// 	    $this->DBComissiona->liste_total($where);
	    
// 	}
	
	public function edit( Array $form , Zend_Db_Table_Row $instalacao )
	{
	   
		$this->Helpers = new Helpers();
		$this->form = $form;
		
		$this->cria_checkbox_nao_marcados();
		
		$this->converte_checkbox_para_numerico();
		
		$this->converte_datas_br_para_us();
		
		$this->retira_campos_desnecessarios();
		
		$this->verificaDadosModificados( $instalacao );
		
		$this->verifica_termo_aceite( $instalacao );
		
		if( count($this->dados_modificados) > 0 )
		{
// 		    $arrReturn['msg']     = json_encode($this->dados_modificados);
// 		    die_json($arrReturn);


			$this->DBComissiona->setPrkValue($this->form['idinstalacoes']);
			
// 			$arrReturn['msg']     = $this->DBComissiona->getPrkValue();
// 			die_json($arrReturn);

			unset( $this->form['idinstalacoes'] );
// 			unset( $this->tabela );
			if( $this->DBComissiona->edit_comiss($this->form) ){

				return $this->dados_modificados;
			}
			else
			{
				$arrReturn['status'] = 'erro';
		    	$arrReturn['msg']    = "Dados da Instalação não atualizados, eles podem já estar salvos.";
		    	return $arrReturn; //die_json($arrReturn);
			}
		}
	}
	
	public function verificaDadosModificados( Zend_Db_Table_Row $instalacao )
	{
		$instalacao_array = $instalacao->toArray();
		
		foreach( $this->form as $chave => $valor )
			if( 
				$valor != $instalacao_array[$chave]
			)
				array_push( $this->dados_modificados , array( $chave => $valor ) );
	}
	
	public function cria_checkbox_nao_marcados()
	{
		foreach ( $this->form_check_box as $checkbox )
			if( !isset( $this->form[ $checkbox ] ) ){
				$this->form[ $checkbox ] = '0';}
	} 
	
	public function converte_checkbox_para_numerico()
	{
		foreach( $this->form as $chave => $valor )
			if( in_array( $chave , $this->form_check_box ) )
				$this->form[$chave] = ( $valor == 'on' )?1:0;
	}
	
	public function converte_datas_br_para_us()
	{
		foreach( $this->form as $chave => $valor )
			if( in_array( $chave , $this->campo_data ) )
				$this->form[$chave] = $this->Helpers->data_br_us( $valor );
	}
	
	public function retira_campos_desnecessarios()
	{
		if( $this->form['data_final_comiss'] == '' )
			unset( $this->form['data_final_comiss'] );
	}
	
	public function verifica_termo_aceite( Zend_Db_Table_Row $instalacao )
	{
		$instalacao_array = $instalacao->toArray();
		
		if( $instalacao_array['termo_aceite'] != '' )
			$this->form['test_e_termo_aceite'] = 1;
	}
	
	
	// ---------------------------------------------------------------------------------
	// ------------------ TRATAMENTO DA FINALZIACAO COMISSIONAMENTO --------------------
	// ---------------------------------------------------------------------------------
	
	public function trata_finalizacao_comissionamento( 
													$termo_aceite , 
													Zend_Db_Table_Row $instalacao ,
													Zend_Db_Table_Row $os ,
													$data_final_comiss
													)
	{
//		$this->Helper = new Helpers();
		
		if( $this->validaCamposFinalizacaoComissionamento( $termo_aceite ) )
    	{
    		//solucao para tratar termo enviado
    		$termo = explode('\\',$termo_aceite);
    		$termo_aceite = $termo[count($termo)-1];

    		//EDITA DATA FINALIZACAO DO COMISSIONAMENTO A SER RETORNADA
    			if(
    				$instalacao->data_final_comiss == '' ||
    				$instalacao->data_final_comiss == '0000-00-00 00:00:00' ||
    				$instalacao->data_final_comiss == NULL
    			  )
    				$data_final_comiss = date('Y-m-d H:i:s');
    				
    			else
    				$data_final_comiss = $instalacao->data_final_comiss;
    			
    				
    		$cumprimento = $this->verifica_horario_para_cumprimento();
    			
    		
    		//ENVIO DE EMAILS 
    			$assunto = "Termo de aceite Vodanet {$instalacao->nome}";
    			$to = array(
    						"celio.batalha@gmail.com",
    						"noc.sp@globaleagle.com"
    						);
    			$msg = "{$cumprimento},<br/><br/>
						A GlobalEagle informa que os testes de aceitação do terminal {$instalacao->nome} com
						IP LAN {$os['iplan']} e IP DVB {$os->ipdvb}, foram realizados 
						com sucesso. Segue o termo de aceitação:<br/>
						<a href='http://saom.vodanet-telecom.com/public/imagens/instalacoes/{$termo_aceite}'>Termo de aceite</a>
						<br/><br/>
						Atenciosamente,<br/>
						<br/>
						{$_SESSION['login']['nome']}<br/>
						EMC.<br/>
						http://www.geemedia.com//<br/>
						<img src='http://saom.vodanet-telecom.com/public/imagens/logo_gee.png' height='50' width='300'/>";
//    			$anexo = "http://saom.vodanet-telecom.com/{$instalacao->termo_aceite}";
    			
			/*
			if( !sendMailComissionamento( $assunto , $to , $msg) )
    			{
    				$arrReturn['status'] = 'erro';
			    	$arrReturn['msg'] = 'Erro ao enviar email para informar finalização de comissionamento.';
			    	die_json($arrReturn);
    			}
			*/
    		
    		return $data_final_comiss;
        }
        else
        	return false;
	}
	
	public function validaCamposFinalizacaoComissionamento( $termo_aceite )
	{
		if( $termo_aceite != '' )
			return true;
			
		else
			return false;
	}
	
	public function verifica_horario_para_cumprimento()
	{
		$agora = date('H');
    	if($agora > 00 && $agora < 12)
    		return "Bom Dia";
    				
		else if($agora >= 12 && $agora < 18)
    		return "Boa Tarde";
    				
		else if($agora >= 18)
    		return "Boa Noite";
	}
	
	
	public function busca_comissionamentos_pendentes_para_usuario( Integer $idusuario )
    {
    	$idusuarioNumero = $idusuario->numero();
    	$where = "
    		(
	    		data_final_comiss = '0000-00-00 00:00:00' ||
	    		data_final_comiss IS NULL ||
	    		data_final_comiss = ''
	    	) AND create_user_comiss = '{$idusuarioNumero}'
    	";
    	$listaComissionamentos = $this->fetchAll( $where );
    	if( count($listaComissionamentos) > 0 )
    	{
    		$lista = $this->buscaDependenciasParaComissionamentosDeUsuario( $listaComissionamentos->toArray() );
    		return $lista;
    	}
    	else
    		return array();
    }
    
    private function buscaDependenciasParaComissionamentosDeUsuario( Array $lista )
    {
    	foreach ( $lista as $chave => $comissionamento )
    	{
    		// get os
    		$idos = new Integer( $comissionamento['os_idos'] );
    		$this->OSBO->setidos( $idos );
    		$this->OSBO->getOS();
    		$lista[ $chave ]['os'] = $this->OSBO->getosArray();
    		
    		// get cidade da os
    		$idmunicipios = new Integer( $this->OSBO->getmunicipios_idcidade() );
    		$this->MunicipiosBO->setidmunicipios( $idmunicipios );
    		$this->MunicipiosBO->getMunicipioObject();
    		$lista[ $chave ]['municipio'] = $this->MunicipiosBO->getmunicipiosarray();
    		
    		// get usuario teccampo
    		$idusuarios = new Integer( $comissionamento['teccampo'] );
    		$this->UsuariosBO->setidusuarios( $idusuarios );
    		$this->UsuariosBO->getUsuario();
    		$lista[ $chave ]['usuarioTeccampo'] = $this->UsuariosBO->getUsuarioArray();
    		
    		// get usuario que criou comissionamento
    		$idusuarios = new Integer( $comissionamento['create_user_comiss'] );
    		$this->UsuariosBO->setidusuarios(  $idusuarios );
    		$this->UsuariosBO->getUsuario();
    		$lista[ $chave ]['usuarioComissionador'] = $this->UsuariosBO->getUsuarioArray();
    		
    		// get usuario que editou por ultimo
    		$idusuarios = new Integer( $comissionamento['last_user_comiss'] );
    		$this->UsuariosBO->setidusuarios(  $idusuarios );
    		$this->UsuariosBO->getUsuario();
    		$lista[ $chave ]['usuarioEditouPorUltimo'] = $this->UsuariosBO->getUsuarioArray();
    		
    		//  get tipo de equipamento odu
    		$idtipo_equipamentos = new Integer( $comissionamento['odu'] );
    		$this->TipoEquipamentosBO->setidtipo_equipamentos( $idtipo_equipamentos );
    		$this->TipoEquipamentosBO->getTipoEquipamento();
    		$lista[ $chave ]['tipoEquipamentoODU'] = $this->TipoEquipamentosBO->getTipoEquipamentosArray();
    	}
    	
    	return $lista;
    }
    
    public function getNomeVsatPeloIdInstalacao( $idinstalacao )
    {
    	$where = " idinstalacoes = '{$idinstalacao}' ";
    	$instalacaoLista = $this->fetchAll( $where );
    	return $instalacaoLista[0]->nome;
    }
}
