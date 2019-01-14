<?php

/**
 * 
 * Classe Cronômetro interrupção
 * 
 * @author Lothar
 *
 */

include_once "Controller.php";
include_once "model/DBCronometro_interrupcao.php";
include_once "model/DBCronometro.php";

class Cronometro_interrupcao extends Controller
{
	
	protected $tplDir = 'cronometro_interrupcao';
	
	function __construct() 
	{
        parent::__construct();
        $this->DB = new DBCronometro_interrupcao();
        $this->DBCronometro = new DBCronometro();
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