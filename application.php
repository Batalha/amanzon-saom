<?php

class Application
{
	var $uri;
	var $model;

	function __construct($uri)
	{
		$this->uri = $uri;
	}

    	/**      
	 * @param $class      
	 */

	function loadController( $class )
	{
    	//require_once 'controller/Controller.php';
        require_once 'helpers/Controller.php';
        require_once 'controller/Sistema.php';



    	//print_b($this->uri,true);
    	//print_b($_SESSION,true);
//     	echo die_json($_SESSION['SAOM']);

    	//TODO: verificar retirada desse if visto que as controllers são acessadas antes de tudo
	
	$saom = @$_SESSION["SAOM"];
        if($saom != "SP"){

            if(substr($class,0,2) == 'DB'){
                $file = "model/".$this->uri['controller'].".php";
    //         	$file_sp = "sao_paulo/model/".$this->uri['controller'].".php";
//                print_r($file);

            }else{
                $file = "controller/".$this->uri['controller'].".php";
    //         	$file_sp = "sao_paulo/controller/".$this->uri['controller'].".php";
            }
        }else{

            if(substr($class,0,2) == 'DB'){
                $file = "s_p/model/".$this->uri['controller'].".php";
                //         	$file_sp = "sao_paulo/model/".$this->uri['controller'].".php";
            }else {
                $file = "s_p/controller/" . $this->uri['controller'] . ".php";
                //         	$file_sp = "sao_paulo/controller/".$this->uri['controller'].".php";
            }
        }

        if($this->uri['controller'] == 'Controller'){
            $file = "helpers/".$this->uri['controller'].".php";
        }

        if($this->uri['controller'] == 'Usuario'){
            $file = "controller/".$this->uri['controller'].".php";
        }

        if($this->uri['controller'] == 'Unificado'){
            $file = "controller/".$this->uri['controller'].".php";
        }

//     	$file = "saopaulo/".$file;
//        echo die_json(!file_exists($file));
//        print_r($file);exit;
        if(!file_exists($file))
            die('erro');

        require_once($file);

        $controller = new $class();
//

        if( method_exists($controller, $this->uri['method']) )
        	$controller->{$this->uri['method']}( ( isset($this->uri['var']) )?$this->uri['var']:'' );

        else
        	$controller->index();

	}

	function loadView($view,$vars="")
	{
		if(is_array($vars) && count($vars) > 0)
			extract($vars, EXTR_PREFIX_SAME, "wddx");
		require_once('view/'.$view.'.php');
	}

	function loadModel($model)
	{
		require_once('model/'.$model.'.php');
		$this->$model = new $model;
	}
}
?>
