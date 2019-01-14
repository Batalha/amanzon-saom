<?php

require_once 'model/ProdemgeModel.php';
// include_once 'helpers.class.php';
// require_once  'helpers/Utilitarios.php';

class ProdemgeBO extends ProdemgeModel
{
	protected $_name = 'prodemge';
	protected $_primary = 'idprodemge';
	
	protected $dados_modificados = array();
	protected $form;
	
	
	// TODO: atributos de necessidade  questionável
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
	
	
	public function getProdemgePeloNome( $numeroProdemge )
	{
		//TODO: encontrar um meio de validar a variavel numeroProdemge de entrada
		$where = " numero_prodemge = '{$numeroProdemge}' ";
		$prodemges = $this->fetchAll( $where );
		if( count($prodemges) > 0 )
		{
			//print_b();
			$prodemge = $prodemges->toArray();
			
			$this->setidprodemge( $prodemge[0]['idprodemge'] );
			foreach ( $this->campos as $campo )
			{
				$this->{'set'.$campo}( $prodemge[0][ $campo ] );
			}
			return true;
		}else return false;
	}
	
	
	// --
	

    
//     public function getNomeVsatPeloIdInstalacao( $idinstalacao )
//     {
//     	$where = " idinstalacoes = '{$idinstalacao}' ";
//     	$instalacaoLista = $this->fetchAll( $where );
//     	return $instalacaoLista[0]->nome;
//     }
}
