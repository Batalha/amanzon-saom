<?php

class TipoEquipamentosModel extends ZendModel
{

	protected $_name = 'tipo_equipamentos';
	protected $_primary = 'idtipo_equipamentos';
	
	protected $_dependentTables = array('EquipamentosModel');
	
	// atributos
	protected $idtipo_equipamentos;
	protected $nome;
	protected $descricao;
	
	protected $tipoEquipamentosArray;
	
	function getidtipo_equipamentos()
	{
		return $this->idtipo_equipamentos;
	}
	function getnome()
	{
		return $this->nome;
	}
	function getdescricao()
	{
		return $this->descricao;
	}
	
	function setidtipo_equipamentos( Integer $idtipo_equipamentos )
	{
		$this->idtipo_equipamentos = $idtipo_equipamentos->numero();
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
		if( empty($this->idtipo_equipamentos) )
			return "Id do Tipo do Equipamento não declarado.";

		$where = " idtipo_equipamentos = '{$this->idtipo_equipamentos}' ";
		$tipo_equipamentos = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($tipo_equipamentos) > 0 )
		{
			$linha = $tipo_equipamentos->toArray();
			$this->tipoEquipamentosArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idtipo_equipamentos' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}

}