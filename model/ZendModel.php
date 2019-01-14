<?php


class ZendModel extends Zend_Db_Table_Abstract
{
	protected $objetoArray = array();
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
	public function getobjetoArray()
	{
		return $this->objetoArray;
	}
	
	public function lista()
	{
		$listaTabela = $this->fetchAll();
		$lista = array();
		
		for( $i = 0 ; $i < count($listaTabela) ; $i++ )
		{
			$busca = $listaTabela->seek($i);
			$linha = $busca->current();
			$this->linhaArray = $linha->toArray();
			
			if( method_exists( $this, 'getDependencias') )
				$this->getDependencias( $linha );
			
			array_push($lista, $this->linhaArray);
		}
		
		return $lista;
	}
	
	public function view( $id )
	{
		$linha = $this->fetchRow("idusuarios = {$id}");
		$this->linhaArray = $linha->toArray();
		
		if( method_exists( $this, 'getDependencias') )
			$this->getDependencias( $linha );
		
		return $this->linhaArray;
	}
	
	public function edit(){
	    

		$where = " {$this->_primary} = '{$this->getidmotivo_atendimento()}' ";
		foreach ( $this->campos as $chave => $campo ) {
			$data[ $campo ] = $this->{'get'.$campo}();	
		}
		
		if( $this->update( $data , $where ) )
			return 'ok';
		else
			return 'erro';
	}
	
	public function create()
	{
   				
		$arrayData = array();
		foreach( $this->campos as $chave => $campo )
		{
			$arrayData[$campo] = $this->{"get".$campo}();
		}
		return $this->insert( $arrayData );
	}
	
	public function getObject()
	{
		if( empty($this->{$this->_primary}) )
			return "Id não declarado.";
			
		$where = " {$this->_primary} = '{$this->{$this->_primary}}' ";
		$linhas = $this->fetchAll( $where );
		if( count($linhas) > 0 )
		{
			$linha = $linhas->toArray();
			$this->objetoArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != $this->_primary )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	public function executaSql( $sql )
	{
		$db = $this->getAdapter();
		$lista = $db->fetchAll( $sql );
		return $lista;
	}
}