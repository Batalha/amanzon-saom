<?php

require_once 's_p/model/Zend_spModel.php';

class Saom_spModel extends Zend_spModel
{

	protected $_name = 'saom';
	protected $_primary = 'id_saom';
	
	// atributos
	protected $id_saom;
	protected $nome;
	
	protected $saomArray;


	protected $campos = array(
		'is_saom',
		'nome'
	);
	
	public function getsaomArray()
	{
		return $this->saomArray;
	}
	
	public function setid_saom( $id_saom )
	{
		$this->id_saom =  $id_saom;
	}
	public function setnome( $nome )
	{
		$this->nome = $nome;
	}
	
	public function getid_saom()
	{
		return $this->id_saom;
	}
	public function getnome()
	{
		return $this->nome;
	}
	
	public function getsaom()
	{
		if( empty($this->id_saom) )
			return "Id do Saom não declarado.";
		
		$where = " id_saom = '{$this->id_saom}' ";
		//exit($where);
		$saom = $this->fetchRow( $this->select()->where( $where ) );
		
		if( $saom != null )
		{
			$this->saomArray = $incidente->toArray();
			foreach ( $this->saomArray as $chave => $atributo )
			{
				if( $chave != 'id_saom' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}

}