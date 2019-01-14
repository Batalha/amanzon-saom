<?php

class TipoEquipamentos_spModel extends Zend_spModel
{

	protected $_name = 'tipo_equipamentos_sp';
	protected $_primary = 'idtipo_equipamentos_sp';

	protected $_dependentTables = array('Equipamentos_spModel');
	
	// atributos
	protected $idtipo_equipamentos_sp;
	protected $nome;
	protected $descricao;
	
	protected $tipoEquipamentosArray;
	
	function getidtipo_equipamentos_sp()
	{
		return $this->idtipo_equipamentos_sp;
	}
	function getnome()
	{
		return $this->nome;
	}
	function getdescricao()
	{
		return $this->descricao;
	}
	
	function setidtipo_equipamentos_sp( Integer $idtipo_equipamentos_sp )
	{
		$this->idtipo_equipamentos_sp = $idtipo_equipamentos_sp->numero();
	}
	
	function setnome( $nome )
	{
		$this->nome = $nome;
	}
	
	function setdescricao( $descricao )
	{
		$this->descricao = $descricao;
	}
	
	function getTipoEquipamentosArray()
	{
		return $this->tipoEquipamentosArray;
	}
	
	
	public function getTipoEquipamento()
	{
		if( empty($this->idtipo_equipamentos_sp) )
			return "Id do Tipo do Equipamento não declarado.";

		$where = " idtipo_equipamentos_sp = '{$this->idtipo_equipamentos_sp}' ";
		$tipo_equipamentos_sp = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($tipo_equipamentos_sp) > 0 )
		{
			$linha = $tipo_equipamentos_sp->toArray();
			$this->tipoEquipamentosArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idtipo_equipamentos_sp' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}

}