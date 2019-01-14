<?php

/**
 * CLASSE DE CONTROLE PARA DBUsuario
 *
 * @author daniel
 */

require_once 'model/DBUsuario.php';

require_once 'controller/Comissionamento.php';

require_once 'helpers/Controller.php';


class Sistema extends Controller
{
    
    protected $DB;
    protected $tplDir = 'usuario';
    
    public function __construct()
    {
    	parent::__construct();
        $this->DB = new DBUsuario();  

        //zend
        $this->Comissionamento = new Comissionamento( $this->adapter->getAdapterZend() );
    }
  
	public function home()
	{
		$listas = $this->getDadosHome();
		
		$this->smarty->assign('lista_comissionamentos_pendentes',$listas['lista_comissionamentos_pendentes']);
		
		$this->smarty->assign('lista_atendimentos_pendentes',$listas['lista_atendimentos_pendentes']);
		
		$this->smarty->assign('empresa',$listas['empresa']);
		
		//TODO: aplicar verificacao de pendencias de comissionamentod e usuario noc
		
		$this->smarty->display("index_noc.tpl");
	}
	
	public function getDadosHome()
	{
		//TODO: solução estranha =(
		require_once "controller/Home.php";
		$Home = new Home();
		
		$idusuarios  = new Integer( $_SESSION['login']['idusuarios'] );
		$this->Usuarios->setidusuarios( $idusuarios );
		$this->Usuarios->getUsuario();
		
		$lista_pendencias = $Home->getPendenciasDeUsuario( $this->Usuarios );
		//print_b($lista_pendencias['comissionamentos'],true);
		
		return array(
			'lista_comissionamentos_pendentes' => $lista_pendencias['comissionamentos'] ,
			'lista_atendimentos_pendentes' => $lista_pendencias['atendimentos'] , 
			'empresa' => $_SESSION['login']['empresas_idempresas'] 
		);
	}
	
	/*
	 * Carrega XML para local
	 */
	public function local()
	{
		$path = "local/SAOM_".$_SESSION['SAOM'].".xml";
		$fopen = fopen($path,"r" );
		$arquivo = "";
		$arquivo = fread($fopen, filesize($path));
		fclose($fopen);
		$xml = new SimpleXMLElement($arquivo);
		return $xml;
	}
	
}    

?>