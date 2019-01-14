<?php

/**
 * CLASSE DE CONTROLE PARA DBUsuario
 *
 * @author daniel
 */

//zend
include_once 'model/UsuariosModel.php';
include_once 'helpers/AdapterZend.php';
include_once 'model/GruposUsuariosModel.php';

include_once 'model/DBUsuario.php';
//include_once 'model/DBEmpresas.php';
include_once 'model/DBPerfis.php';

include_once 'helpers/Controller.php';

class Usuario extends Controller
{
	protected $DB;
	protected $tplDir = 'usuario';
	protected $dados;
	protected $endereco;
	protected $saom;
	protected $form;
	protected $dependencias = array();
	protected $dependenciasResult;
	protected $idTabela;
	protected $idAssociacao;

	protected $idusuarios;

	function __construct()
	{
		//ATUALIZACAO
		$url = explode('/',$_SERVER['REQUEST_URI']);
		$metodo = $url[3];
		if( $metodo == 'logout' || $metodo == 'login' )
			$this->passagemLivreAtualizacao = true;
		 
		parent::__construct();
		 
		$this->DB = new DBUsuario();
//		$this->DBEmpresas = new DBEmpresas();
		$this->DBPerfis = new DBPerfis();
	}
	
	public function setIdusuarios( $idusuarios )
	{
		//TODO: validar integer para o parametro $idusuarios
		$this->idusuarios = $idusuarios;
	}
	
	public function getIdusuarios()
	{
		return $this->idusuarios;
	}

	public function view()
	{
		if ( ! empty($this->dadosP['param']))
		{
			$this->DB->setPrkValue($this->dadosP['param']);
			$dados = $this->DB->view();
			//print_b($dados,true);

			//busca do nome do perfil para subperfil
			//TODO: arrumar esse pog
			if($dados['subperfil_idsubperfil']!=0)
			{
				$sql = "SELECT perfil FROM perfis WHERE idperfis = '{$dados['subperfil_idsubperfil']}'";
				//exit($sql);
				$resgateNomeSubperfil = $this->DB->queryDados($sql);
				$dados['subperfil'] = $resgateNomeSubperfil[0]['perfil'];
			}
			else
			{
				$dados['subperfil'] = '';
			}

			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/view.tpl");
		}
	}

	public function liste()
	{
		$usuarios = new UsuariosModel( $this->adapter->getAdapterZend() );
		$lista_usuarios = $usuarios->fetchAll()->toArray();
		
		$empresa = new EmpresasModel( $this->adapter->getAdapterZend() );
		$perfil = new PerfisModel( $this->adapter->getAdapterZend() );
		$subperfil = new PerfisModel( $this->adapter->getAdapterZend() );
		
		foreach ( $lista_usuarios as $chave => $usuario )
		{
			$empresaRow = $empresa->fetchRow( " idempresas = '{$usuario['empresas_idempresas']}' " );
			if( $empresaRow instanceof Zend_Db_Table_Row )
				$lista_usuarios[$chave]['nome_empresa'] = $empresaRow->empresa;
			else
				$lista_usuarios[$chave]['nome_empresa'] = '';
			
			$perfilRow = $perfil->fetchRow( " idperfis = '{$usuario['perfis_idperfis']}' " );
			if( $perfilRow instanceof Zend_Db_Table_Row )
				$lista_usuarios[$chave]['nome_perfil'] = $perfilRow->perfil;
			else
				$lista_usuarios[$chave]['nome_perfil'] = '';
			
			$subperfilRow = $subperfil->fetchRow( " idperfis = '{$usuario['subperfil_idsubperfil']}' " );
			if( $subperfilRow instanceof Zend_Db_Table_Row )
				$lista_usuarios[$chave]['nome_subperfil'] = $subperfilRow->perfil;
			else
				$lista_usuarios[$chave]['nome_subperfil'] = '';
		}


		$this->smarty->assign('arr',$lista_usuarios);
		$this->smarty->display("{$this->tplDir}/list.tpl");
	}

	public function create()
	{
		$adapter = new AdapterZend();
		 
		if (empty($this->dadosP['form']))
		{
			$empresas = new EmpresasModel( $this->adapter->getAdapterZend() );
			$lista_empresa = $empresas->lista();
				
			$grupos = new GruposModel( $this->adapter->getAdapterZend() );
			$lista_grupos = $grupos->lista();

			$this->smarty->assign('param',!empty($this->dadosP['param'])?$this->dadosP['param']:'');
			$this->smarty->assign('empresas',$lista_empresa);
			$this->smarty->assign('grupos',$lista_grupos);
			$this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
			$this->smarty->display("{$this->tplDir}/new.tpl");
		}
		else
		{

			$empresas = new EmpresasModel( $this->adapter->getAdapterZend() );
			$lista_empresa = $empresas->lista();
			foreach($lista_empresa as $empresas){
				if($this->dadosP['form']['empresas_idempresas'] == $empresas['idempresas']){
					$this->dadosP['form']['empresa'] = $empresas['prefixo'];
				}
			}

			$this->validation($this->dadosP['form']);

			$this->form = $this->dadosP['form'];
			 
			$usuarios = new UsuariosModel( $this->adapter->getAdapterZend() );
			 
			$this->trataCheckBox();
			 
			$this->trataDependencias();
			
			$this->trataSenha( 0 );
			
			$this->form['saom'] = $this->getSaomAtual();

			$id = $usuarios->insert( $this->form );

			$this->gravaDependencias( $id );

			if( $id > 0 )
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
				
				//envia email de notificação
				$sendMail = $this->DB->getSendMail();
				//die_r($sendMail);
				if(array_key_exists('create', $sendMail))
				{
					$this->DB->setPrkValue($return);
					$this->DB->setEmailMsg($this->DB->view());
					$sendMail = $this->DB->getSendMail();
					 
					sendMail($sendMail['create']['assunto'], $sendMail['create']['msg']);
				}
			}
			else
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = 'Usuário não gravado';
			}
			
			die_json($arrReturn);
		}
	}

	public function edit()
	{
		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{
			$usuario = new UsuariosModel( $this->adapter->getAdapterZend() );
			$dados = $usuario->fetchRow( " idusuarios = '{$this->dadosP['param']}' " )->toArray();
			
			$empresas = new EmpresasModel( $this->adapter->getAdapterZend() );
			$lista_empresa = $empresas->fetchAll()->toArray();
			
			$perfis = new PerfisModel( $this->adapter->getAdapterZend() );
			$lista_perfis = $perfis->fetchAll()->toArray();
				
			$grupos = new GruposModel( $this->adapter->getAdapterZend() );
			$lista_grupos = $grupos->lista();
			
			$this->smarty->assign('perfis',$lista_perfis);
			$this->smarty->assign('empresas',$lista_empresa);
			$this->smarty->assign('grupos',$lista_grupos);
			$this->smarty->assign('obj',$dados);
			$this->smarty->display("{$this->tplDir}/edit.tpl");
		}
		elseif ( ! empty($this->dadosP['form']))
		{

			$this->validationEdit($this->dadosP['form']);
			$this->form = $this->dadosP['form'];
			
			//TODO: melhorar a solucao para os checkbox vazios que estao sendo ignorados no envio do form
			if( !isset($this->form['arquivo_supervisor']) )
				$this->form['arquivo_supervisor'] = 'off';
			if( !isset($this->form['incidentes']) )
				$this->form['incidentes'] = 'off';
			 
			$usuarios = new UsuariosModel( $this->adapter->getAdapterZend() );
			 
			$this->trataCheckBox();
			 
			$this->trataDependencias();
			
			$this->trataIdTabela();
			
			if( isset($this->form['conf_senha']) )
				unset( $this->form['conf_senha'] );
				
			if( isset($this->form['senha']) )
				$this->form['senha'] = md5($this->form['senha']);
			
			//grava no banco de dados
			$resultado = $usuarios->update( $this->form , "idusuarios = '{$this->idTabela}'" );
			
			//grava dependencias
			$this->atualizaDependencias();
			 
			if( !$resultado && !$this->dependenciasResult )
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = "Erro ao editar dados de usuário.";
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Edição realizada com sucesso!';
				//EMAIL DE RETORNO
				/*
				if($this->dadosP['form']['confirm']==1)
				{
					$sendMail = $this->DB->getSendMailEdit();
					if(array_key_exists('edit', $sendMail))
					{
						$this->DB->setPrkValue($this->dadosP['form']['idagenda_instal']);
						$this->DB->setEmailMsgEdit($this->DB->view());
						$sendMail = $this->DB->getSendMailEdit();
						sendMail($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
					}
				}
				*/
			}
			die_json($arrReturn);
		}
	}

	public function validationEdit($form)
	{
		if(
			$form['nome'] == '' ||
			$form['empresas_idempresas'] == '' ||
			$form['perfis_idperfis'] == '' ||
			$form['email'] == '' ||
			$form['login'] == ''
		){
			$arrReturn['msg'] = 'Por Favor! Preencha os Campos Destacado.';
			die_json($arrReturn);
		}
	}

	public function validation($form)
	{
		if(
			$form['nome'] == '' ||
			$form['empresas_idempresas'] == '' ||
			$form['perfis_idperfis'] == '' ||
			$form['email'] == '' ||
			$form['login'] == '' ||
			$form['senha'] == ''
		){
			$arrReturn['msg'] = 'Por Favor! Preencha os Campos Destacado.';
			die_json($arrReturn);
		}
	}

	public function editSenha()
	{
		if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
		{
			$where = " idusuarios = '{$this->dadosP['param']}' ";
			$usuario = $this->Usuarios->fetchRow( $where );
			if( $usuario instanceof Zend_Db_Table_Row )
				$usuario = $usuario->toArray();

			$this->smarty->assign('obj',$usuario);
			$this->smarty->display("{$this->tplDir}/edit_senha.tpl");
		}
		elseif ( ! empty($this->dadosP['form']))
		{
			$this->form = $this->dadosP['form'];
			
			$this->trataIdTabela();
			
			$this->trataSenha(0);
			$this->trataSenha(1);
			
			if( $this->form['confirma_senha'] == $this->form['senha'] ) 
			{
				unset( $this->form['confirma_senha'] );
				unset( $this->form['conf_senha'] );
				$usuario = new UsuariosModel( $this->adapter->getAdapterZend() );
				$resultado = $usuario->update( $this->form , "idusuarios = '{$this->idTabela}'" );
			}

			if( !$resultado )
			{
				$arrReturn['status'] = 'erro';
				$arrReturn['msg']    = "Houve um erro ao atualizar senha.";
			}
			else
			{
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Edição realizada com sucesso!';
				//EMAIL DE RETORNO
				if($this->dadosP['form']['confirm']==1)
				{
					$sendMail = $this->DB->getSendMailEdit();
					if(array_key_exists('edit', $sendMail))
					{
						$this->DB->setPrkValue($this->dadosP['form']['idagenda_instal']);
						$this->DB->setEmailMsgEdit($this->DB->view());
						$sendMail = $this->DB->getSendMailEdit();
						sendMail($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
					}
				}
				//EMAIL DE RETORNO - FIM
			}
			die_json($arrReturn);
		}
	}



	// #################################################################
	// ############### LOGIN ###########################################
	// #################################################################

	function login()
	{
		$this->dados = $this->DB->login( $this->dadosP['login'] , $this->dadosP['senha'] );
		$this->gestaoRdirecionamentoUsuario();

//		echo die_json($this->dados);
		if ( count($this->dados))
		{
			if( $this->dados[0]['ativacao'] == 1){
				//ATUALIZACAO
				$dados[0]['atualizacao'] = $this->dataAtualizacao;

				$_SESSION['login'] = $this->dados[0];
				header("location: {$this->endereco}{$this->saom}");
				return true;

			}else{
				//MENSAGEM DO LOG
				$_SESSION['mensagemLog'] = 'Esse usuário não esta ativado';
				header("location: {$this->endereco}");
				return false;
			}
		}
		else
		{
			//MENSAGEM DO LOG
			$_SESSION['mensagemLog'] = 'Usuario ou Senha Invalido';
			header("location: {$this->endereco}");
			return false;
		}
	}



	// #################################################################
	// ############### LOGOUT ##########################################
	// #################################################################

	function logout( $atualizacao = 0 )
	{
		//print_b($_SESSION,true);
		 
		$this->endereco = "http://{$_SERVER['HTTP_HOST']}/";
		 
		if(session_destroy())
		{
			header("location: {$this->endereco}");
			return true;
		}
		else
		{
			//MENSAGEM DO LOG
			$_SESSION['mensagemLog'] = 'Erro no logout.';
			 
			header("location: {$this->endereco}");
			return false;
		}
	}



	public function change_pass()
	{
		$this->smarty->display("{$this->tplDir}/change_pass.tpl");
	}

	/*
	 * método para verificar permissão para manuseio de elementos
	 */
	public function verificaAutorizacaoCompartilhamento()
	{
		$dados = $this->dadosP['form'];
		$senha = md5($dados['senha']);
		//print_b($dados);
		 
		//procedimento
		$sql = "
    		SELECT IF(
    			(
    				SELECT count(*)
    				FROM usuarios
    				WHERE 
    					idusuarios = {$dados['idusuarios']} AND
    					senha = '{$senha}' AND
    					perfis_idperfis = 4
    			) > 0 OR
    			(
    				(
    					SELECT count(*)
    					FROM usuarios
    					WHERE
    						idusuarios = {$dados['idusuarios']} AND
    						senha = '{$senha}' AND
    						perfis_idperfis = 5
    				) > 0 AND
    				(
    					SELECT usuario_envio
    					FROM compartilhamento
    					WHERE 
    						idcompartilhamento = {$dados['idcompartilhamento']} AND
    						NOW() < ( data_envio + INTERVAL 15 MINUTE )
    				) = {$dados['idusuarios']}
    			),
    			'ok',
    			'no'
    		) AS resposta
    	";
		$resposta = $this->DB->queryDados($sql);
		 
		if($resposta[0]['resposta'] == 'ok')
		{
			$arrReturn['status']  = 'ok';
			$arrReturn['msg']     = 'Autorizado!';
		}
		else
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = "Não Autrizado!";
		}
		die_json($arrReturn);
	}


	// #################################################################
	// ############### GESTÃO E USUARIOS ###############################
	// #################################################################

	public function gestaoRdirecionamentoUsuario()
	{
		switch($this->dados[0]['saom']) {
			case 1: //prodemge
				$this->endereco = "http://{$_SERVER['HTTP_HOST']}/";
				if ($this->dados[0]['perfis_idperfis'] == 4) {
						$this->saom = "/Unificado/listaSistemas";
				} else {
						$this->saom = "/PRODEMGE";
				}
				break;

			case 2: //sp
				$this->endereco = "http://{$_SERVER['HTTP_HOST']}/";
				if($this->dados[0]['perfis_idperfis'] == 4)
						$this->saom = "/Unificado/listaSistemas";
				else
					$this->saom = "/SP";
				break;

			default:
				$this->endereco = "http://{$_SERVER['HTTP_HOST']}/";
				$this->saom = "/";
				break;
		}
	}



	// #################################################################
	// ############ GESTAO DE DEPENDENCIAS #############################
	// #################################################################

	public function trataDependencias()
	{
		if( isset($this->form['grupo']) && $this->form['grupo'] != '' )
		{
			//armazena em array
			array_push( $this->dependencias , array('grupo'=>$this->form['grupo']) );
			//unset no campo do form
			unset( $this->form['grupo'] );
		}
		else
			unset($this->form['grupo']);
	}

	public function gravaDependencias( $id )
	{
		//grava grupo
		if( isset($this->dependencias[0]['grupo']) )
		{
			$gruposUsuarios = new GruposUsuariosModel( $this->adapter->getAdapterZend() );

			$dados = array(
    			"id_grupos" => $this->dependencias[0]['grupo'],
    			"id_usuarios" => $id
			);
			
			$this->idAssociacao = $gruposUsuarios->insert($dados);
		}
	}
	
	public function atualizaDependencias()
	{
		if( isset($this->dependencias[0]['grupo']) )
		{
			//grupo
			$gruposUsuarios = new GruposUsuariosModel( $this->adapter->getAdapterZend() );
			$listaAssociacoes = $gruposUsuarios->fetchAll("id_usuarios = '{$this->idTabela}'");
			$listaAssociacoesArray = $listaAssociacoes->toArray();
			
			if( count($listaAssociacoesArray) > 0 )
			{
				foreach ($listaAssociacoesArray as $associacao)
				{
					if( $associacao['id_grupos'] != $this->dependencias[0]['grupo'] )
						$this->dependenciasResult = $gruposUsuarios->update( 
							array('id_grupos'=>$this->dependencias[0]['grupo']) , 
							"id_grupos_usuarios = '{$associacao['id_grupos_usuarios']}'" 
						);
				}
			}
			else
				$this->gravaDependencias( $this->idTabela );
		}
	}
	
	
	
	// ###################### TRATA SENHA ##############################
	public function trataSenha( $flag )
	{
		if( !$flag )
		{
			if( isset($this->form['senha']) )
				$this->form['senha'] = md5($this->form['senha']);
		}
		else
		{
			if( isset($this->form['confirma_senha']) )
				$this->form['confirma_senha'] = md5($this->form['confirma_senha']);
		}
	}
	
	
	
	// ##################### TRATA ID TABELA ############################
	public function trataIdTabela()
	{
		$this->idTabela = $this->form['idusuarios'];
		unset($this->form['idusuarios']);
	}
	
	
	
	// -----------------------------------------------------------------
	// -------------- TROCAR SENHA -------------------------------------
	// -----------------------------------------------------------------
	
	public function trocarSenha()
	{
		$form = $this->dadosP['form'];
		
		$senha = md5( $form['senha'] );
		
		$data = array(
			'senha' => $senha
		);
		
		$where = "
			idusuarios = '{$form['idusuarios']}'
		";
		
		if( $this->Usuarios->update( $data, $where ) )
		{
			$arrReturn['status'] = 'ok';
			$arrReturn['msg']    = 'Usuário modificado';
			die_json($arrReturn);
		}
		else 
		{
			$arrReturn['status'] = 'erro';
			$arrReturn['msg']    = 'Usuário não gravado';
			die_json($arrReturn);
		}
	}
	
}

?>
