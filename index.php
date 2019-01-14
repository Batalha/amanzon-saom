<?php
require_once 'configs.php';
date_default_timezone_set('Brazil/East');

$testes = 0;
if($testes == 1)
{
	session_start();
	if( $_SESSION['login']['idusuarios'] != 28 )
	{
		exit(' SAOM em Manuten&ccedil;&atilde;o. ');
	}
}

// -------------------------------------------------------------------
// --------------------- Configuração ZEND ---------------------------
// -------------------------------------------------------------------

require_once 'Zend/Loader/Autoloader.php';
require_once 'Zend/Db.php';

$autoloader = Zend_Loader_Autoloader::getInstance();

// -------------------------------------------------------------------
// --------------------- Configuração Inicial ------------------------
// -------------------------------------------------------------------

	session_start();
	
// ----------------------------------------------------------------
// --------------------- Tratamento de URL ------------------------
// ----------------------------------------------------------------

	$url = $_SERVER['REQUEST_URI'];
	$array_tmp_uri = preg_split( '[\\/]' , $url , -1 , PREG_SPLIT_NO_EMPTY );
	

	if( $array_tmp_uri )//evita erro
	{
		switch( $array_tmp_uri[0] )
		{
			case 'SP':
				$_SESSION['SAOM'] = 'SP';
				$array_uri['controller'] = (isset($array_tmp_uri[1]))?$array_tmp_uri[1]:'';
				$array_uri['method'] = (isset($array_tmp_uri[2]))?$array_tmp_uri[2]:'';
				$array_uri['var'] = (isset($array_tmp_uri[3]))?$array_tmp_uri[3]:'';
				break;
				
			case 'PRODEMGE':
				$_SESSION['SAOM'] = 'PRODEMGE';
				$array_uri['controller'] = (isset($array_tmp_uri[1]))?$array_tmp_uri[1]:'';
				$array_uri['method'] = (isset($array_tmp_uri[2]))?$array_tmp_uri[2]:'';
				$array_uri['var'] = (isset($array_tmp_uri[3]))?$array_tmp_uri[3]:'';
				break;
				
			default:
				$array_uri['controller'] = (isset($array_tmp_uri[0]))?$array_tmp_uri[0]:'';
				$array_uri['method'] = (isset($array_tmp_uri[1]))?$array_tmp_uri[1]:'';
				$array_uri['var'] = (isset($array_tmp_uri[2]))?$array_tmp_uri[2]:'';
				break;
		}
		
		$flag_redirecionamento = 1;
	}

	
	if( !isset($array_uri) )
	{
		if( !isset($_SESSION['login']) ) // para ausencia de login
			$endereco = BASE_PATH . "/Unificado/loginCentral";
		else
			$endereco = BASE_PATH . "/Unificado/listaSistemas";

		header("Location: {$endereco}");exit;
	}

	
// --------------------------------------------------------------------
// --------------------- Bootstrap ------------------------------------
// --------------------------------------------------------------------
	
	
	
	
// --------------------------------------------------------------------
// --------------------- Tratamento de Usuario ------------------------
// --------------------------------------------------------------------

	//Load our base API
	require_once("application.php");
	
	if ( 
		//para controller existente
		!empty($array_uri['controller']) &&  
		(
			//para condicional de login
			(
				isset($_SESSION['login']) || 
				(
					($array_uri['controller'] == 'Usuario') && 
					($array_uri['method'] == 'login')
				)
			) ||
			//para condicional de saom unificado
			$array_uri['controller'] == 'Unificado'
		)
	)
	{
//     		print_r($_SESSION['SAOM']);
		//loads controller
    		$application = new Application($array_uri);
    		$application->loadController( $array_uri['controller'] );   
	}
	else
	{
		require_once('libs/Smarty.class.php');
	    $smarty = new Smarty();
	    
	    //global SAOM para todos os templates
        $smarty->assign('SAOM',$_SESSION['SAOM']);
        $trocarSistema = ($_SESSION['SAOM'] == 'SP') ? 'PRODEMGE' : 'SP';
        $smarty->assign('trocarSistema', $trocarSistema);
        
	    
	    
        if( isset($_SESSION['url_espera']) )
		{
			$url = $_SESSION['url_espera'];
			unset($_SESSION['url_espera']);
			header('Location: '.$url);
		}
		
	    if( !isset($_SESSION['login']))
	    {
	    	//MENSAGEM DE RESPOSTA DE LOGIN
		    	if(isset($_SESSION['mensagemLog'])){
		    		$smarty->assign('mensagemLog',$_SESSION['mensagemLog']);
		    		unset($_SESSION['mensagemLog']);
		    	}else
		    		$smarty->assign('mensagemLog','');
		    //MENSAGEM DE RESPOSTA DE LOGIN - FIM
		    
	    	if(isset($array_uri))
	    	{
		    	if($array_uri['controller']!='')
		    	{
		    		//para redirecionar quando logado
		    		if($array_uri['controller']=='Compartilhamento')
		    			$_SESSION['url_espera'] = BASE_PATH.$_SERVER['REQUEST_URI'];
		    		
		    		header("Location: " . BASE_PATH);
		    	}
	    	}
	    	
	    	// MOSTRA LOGIN SEM A MARCA VODANET PARA SP
	    	if( $_SESSION['SAOM'] == 'SP' )
	    		$smarty->display('s_p/tampletes/index_no_login_sp.tpl');
	    	else
	    		$smarty->display('index_no_login.tpl');
		}
		else
		{
			$smarty->assign('login',$_SESSION['login']);
			
			// ------------------------------------------------------------
			// ------- GESTÃO DE PENDENCIAS DE USUARIO --------------------
			// ------------------------------------------------------------
				
				if( 
					$_SESSION['login']['perfis_idperfis'] != 6 &&
					$_SESSION['login']['perfis_idperfis'] != 3
				)
				{
					require_once "controller/Sistema.php";
						
					$Sistema = new Sistema();
					$listas = $Sistema->getDadosHome();
					
					$smarty->assign('lista_comissionamentos_pendentes',$listas['lista_comissionamentos_pendentes']);
					$smarty->assign('lista_atendimentos_pendentes',$listas['lista_atendimentos_pendentes']);
					$smarty->assign('empresa',$listas['empresa']);
				}
				else
					$smarty->assign('lista_comissionamentos_pendentes',array(''));
				
			// ------------------------------------------------------------
			// ------- SOLUÇÃO PARA USUARIO CLIENTE SP --------------------
			// ------------------------------------------------------------
			
				if( $_SESSION['login']['perfis_idperfis'] == 4 || $_SESSION['login']['perfis_idperfis'] == 8 || $_SESSION['login']['perfis_idperfis'] == 9 || $_SESSION['login']['perfis_idperfis'] == 10)
				{
// 					if( $_SESSION['SAOM'] == 'PRODEMGE' )
// 					{
// 						$_SESSION['SAOM'] = 'SP';
// 						header("Location: ".BASE_PATH . "/SP");exit;
// 					}	
					if( $_SESSION['SAOM'] == 'SP' )
					{
					$smarty->display('s_p/tampletes/header_sp.tpl');
					$smarty->display('s_p/tampletes/footter_sp.tpl');exit;
					}	
				}
				if( $_SESSION['login']['perfis_idperfis'] == 8 || $_SESSION['login']['perfis_idperfis'] == 9 || $_SESSION['login']['perfis_idperfis'] == 10 )
				{
// 					echo "comeco";echo "<pre>";print_r($_SESSION);echo "</pre>";echo "fim";
// 					echo "comeco";echo "<pre>";print_r($login);echo "</pre>";echo "fim";
					if( $_SESSION['SAOM'] == 'PRODEMGE' )
					{
						$_SESSION['SAOM'] = 'SP';
						header("Location: ".BASE_PATH . "/SP");exit;
					}	

				}
            if( $_SESSION['SAOM'] == 'SP' )
			    $smarty->display('s_p/tampletes/index.tpl');
            else
                $smarty->display('index.tpl');
        }
	}
?>
