<?php

include_once 'model/DBMunicipio.php';

class Municipio extends Controller 
{
    protected $tplDir = 'municipio';
    
    function __construct() 
    {
        parent::__construct();
        $this->DB = new DBMunicipio();
    }  
    
    public function delete()
    {
    	//TODO: fazer isso na model
    	//idmunicipios
    	//print_b($this->dadosP,true);
    	$sql = "DELETE FROM municipios WHERE idmunicipios = '{$this->dadosP['form']['idmunicipios']}'";
    	if($this->DB->query($sql))
    	{
    		$arrReturn['status']  = 'ok';
		    $arrReturn['msg']     = 'Apagado com sucesso!';
	        die_json($arrReturn);
    	}
    	else
    	{
    		$arrReturn['status'] = 'erro';
	    	$arrReturn['msg']    = implode("<hr>", $return['erros']);
	    	die_json($arrReturn);
    	}
    }
    
	public function liste()
    {
		if ( ! empty($this->dadosP['ini']))
	    {
	        $pag = $this->DB->getPag();
	        $pag['ini'] = $this->dadosP['ini'];
	        $pag['end'] = $this->dadosP['end'];
	        $this->DB->setPag($pag);
	    }  
	    if( isset($this->dadosP['orderBy']))
	    {    
	        $this->DB->setOrderBy($this->dadosP['orderBy']);
	        $this->DB->setDefaultOrder('ASC');
	        
	        $this->smarty->assign('orderBy',$this->dadosP['orderBy']);
	    }
	      
	    //SESSAO
	    	//print_b($_SESSION,true);
	    	$this->smarty->assign('login',$_SESSION['login']);
	      
	    $arr = ! empty($this->dadosP['param']) ? $this->DB->liste($this->dadosP['param']) : $this->DB->liste() ;
	    //print_b($arr,true);
	    $arr['pag']['url']   = get_class($this)."/liste";
	      
	    $this->smarty->assign('pag',$arr['pag']);
	    unset($arr['pag']);
	    $this->smarty->assign('arr',$arr);
	    //print_b($arr,true);
	    $this->smarty->display("{$this->tplDir}/list.tpl");
	      
    }
}

?>