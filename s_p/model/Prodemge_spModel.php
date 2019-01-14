<?php

// require_once 'model/BO/OSBO.php';
// require_once 'model/BO/MunicipiosBO.php';
// require_once 'model/BO/UsuariosBO.php';
// require_once 'model/BO/TipoEquipamentosBO.php';
// require_once 'helpers.class.php';

require_once 's_p/model/Zend_spModel.php';

class Prodemge_spModel extends Zend_spModel
{

	protected $_name = 'prodemge_sp';
	protected $_primary = 'idprodemge';
	//protected $_dependentTables = array('EquipamentosLocaisModel');

	// TODO: atributos principais a serem verificados e servirem para objetivação 
	protected $idprodemge;
	protected $numero_prodemge; // TODO: apagar

	
	protected $campos = array(
								'idprodemge',
								'numero_prodemge',

	);
	
	
	protected $prodemgeArray;
	
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
		
// 		$this->OSBO = new OSBO( $adapter );
// 		$this->MunicipiosBO = new MunicipiosBO( $adapter );
// 		$this->UsuariosBO =  new UsuariosBO( $adapter );
// 		$this->TipoEquipamentosBO = new TipoEquipamentosBO( $adapter );
// 		$this->Helpers = new Helpers();
		
	}
	
	public function getidprodemge()
	{
		return $this->idprodemge;
	}
	
	public function getnumero_prodemge ()
    {
        return $this->numero_prodemge;
    }

    // --

	public function setidprodemge ($idprodemge)
    {
        $this->idprodemge = $idprodemge;
    }
    
	public function setnumero_prodemge ($numero_prodemge)
    {
        $this->numero_prodemge = $numero_prodemge;
    }

	   
    

	public function setprodemgeArray ($prodemgeArray)
    {
        $this->prodemgeArray = $prodemgeArray;
    }

	public function getProdemge()
	{
		if( empty($this->idprodemge) )
			return "Id da Prodemge não declarado.";

		$where = " idprodemge = '{$this->idprodemge}' ";
		$prodemge = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($prodemge) > 0 )
		{
			$linha = $prodemge->toArray();
			$this->prodemgeArray = $linha[0];
			foreach ( $this->campos as $atributo )
			{
				if( $atributo != 'idprodemge' )
					$this->{"set".$atributo}( $linha[0][$atributo] );
			}
		}
	}
	
}