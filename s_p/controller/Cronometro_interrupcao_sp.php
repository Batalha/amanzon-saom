<?php

/**
 * 
 * Classe Cronômetro interrupção
 * 
 * @author Lothar
 *
 */

include_once "helpers/Controller.php";
include_once "s_p/model/DBCronometro_interrupcao_sp.php";
include_once "s_p/model/DBCronometro_sp.php";

class Cronometro_interrupcao_sp extends Controller
{
	
	protected $tplDir = 's_p/tampletes/cronometro_interrupcao';
	
	function __construct() 
	{
        parent::__construct();
        $this->DB = new DBCronometro_interrupcao_sp();
        $this->DBCronometro = new DBCronometro_sp();
    }
    
	//pausa cronometro
    public function formPausa()
    {
    	//carrega cronometro
	    	$this->DBCronometro->setIdcronometro($_POST['cronometro']);
	    	$this->DBCronometro->carrega();
	    	$this->smarty->assign('cronometro',$this->DBCronometro->getDadosCarregados());
	    $horaAtual = date('Y-m-d H:i:s');
	   	$this->smarty->assign('horaAtual',$horaAtual);
	    	
    	$this->smarty->display("{$this->tplDir}/formPausa.tpl");
    }
    
    //edita pausa cronometro
    public function formEditaPausa()
    {
    	//carrega cronometro
    		$this->DB->setIdcronometro_interrupcao($_POST['cronometro']);
	    	$this->DB->carrega();
	    	$this->smarty->assign('cronometro',$this->DB->getDadosCarregados());
	    	
    	$this->smarty->display("{$this->tplDir}/editaPausa.tpl");
    }
    
    //despausa cronometro
    public function despausaCronometro()
    {
    	//executa despausar
    		$this->DB->setIdcronometro_interrupcao($_POST['cronometro_interrupcao']);
    		$this->DB->despausaCronometro();
    	//prepara retorno
    		$this->DB->carrega();
    		$cronometro = $this->DB->getCronometro_idcronometro();
    		$this->DBCronometro->setIdcronometro($cronometro);
    		$this->DBCronometro->carrega();
    	if($this->DB->getResultadoUpdate())
    	{
    		echo $this->DBCronometro->getIdreferencia()."|ok";exit;
    	}
    	else
    	{
    		echo $this->DBCronometro->getIdreferencia()."|erro";exit;
    	}
    }
	
}