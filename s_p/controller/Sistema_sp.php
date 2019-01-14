<?php

/**
 * CLASSE DE CONTROLE PARA DBUsuario
 *
 * @author daniel
 */

require_once 's_p/model/DBUsuario_sp.php';

require_once 's_p/controller/Comissionamento_sp.php';

require_once 'helpers/Controller.php';


class Sistema_sp extends Controller
{
    
    protected $DB;
    protected $tplDir = 'usuario';
    
    public function __construct()
    {
    	parent::__construct();
        $this->DB = new DBUsuario_sp();

        //zend
        $this->Comissionamento_sp = new Comissionamento_sp( $this->adapter->getAdapterZend() );
    }
  
	public function home()
	{
		$listas = $this->getDadosHome();

		$this->smarty->assign('lista_comissionamentos_pendentes',$listas['lista_comissionamentos_pendentes']);

		$this->smarty->assign('lista_atendimentos_pendentes',$listas['lista_atendimentos_pendentes']);

		$this->smarty->assign('empresa',$listas['empresa']);


		//TODO: aplicar verificacao de pendencias de comissionamentod e usuario noc
		
		$this->smarty->display("s_p/tampletes/index_noc_sp.tpl");
//		$this->smarty->display("s_p/tampletes/home/lista_comissionamentos.tpl");
	}
	
	public function getDadosHome()
	{
		//TODO: solução estranha =(
		require_once "s_p/controller/Home_sp.php";

		$Home = new Home_sp();

		$idusuarios  = new Integer( $_SESSION['login']['idusuarios'] );
		$this->Usuarios_sp->setidusuarios( $idusuarios );
		$this->Usuarios_sp->getUsuario();

		$lista_pendencias = $Home->getPendenciasDeUsuario( $this->Usuarios_sp );
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