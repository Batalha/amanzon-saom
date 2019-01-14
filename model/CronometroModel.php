<?php

require_once 'model/ZendModel.php';

class CronometroModel extends ZendModel
{

	protected $_name = 'cronometro';
	protected $_primary = 'idcronometro';
	
	
	// dados
	
	protected $idcronometro;
	protected $idreferencia;
	protected $inicio_tarefa;
	protected $interrupcoes;
	protected $tabelareferencia;
	protected $final_tarefa;
	protected $prazo;
	
	protected $campos = array(
		'idreferencia',
		'inicio_tarefa',
		'interrupcoes',
		'tabelareferencia',
		'final_tarefa',
		'prazo'
	);
	
	
	public function setidcronometro( Integer $idcronometro )
	{
		$this->idcronometro =  $idcronometro->numero();
	}
	public function setidreferencia( $idreferencia )
	{
		$this->idreferencia = $idreferencia;
	}
	public function setinicio_tarefa( $inicio_tarefa )
	{
		$this->inicio_tarefa = $inicio_tarefa;
	}
	public function setinterrupcoes( $interrupcoes )
	{
		$this->interrupcoes = $interrupcoes;
	}
	public function settabelareferencia( $tabelareferencia )
	{
		$this->tabelareferencia = $tabelareferencia;
	}
	public function setfinal_tarefa( $final_tarefa )
	{
		$this->final_tarefa = $final_tarefa;
	}
	public function setprazo( $prazo )
	{
		$this->prazo = $prazo;
	}
	
	public function getidcronometro()
	{
		return $this->idcronometro;
	}
	public function getidreferencia()
	{
		return $this->idreferencia;
	}
	public function getinicio_tarefa()
	{
		return $this->inicio_tarefa;
	}
	public function getinterrupcoes()
	{
		return $this->interrupcoes;
	}
	public function gettabelareferencia()
	{
		return $this->tabelareferencia;
	}
	public function getfinal_tarefa()
	{
		return $this->final_tarefa;
	}
	public function getprazo()
	{
		return $this->prazo;
	}
	
	public function getCronometroPelaReferencia()
	{
		if( empty($this->idreferencia) )
			return "Id da referencia não declarada.";
		
		$where = " idreferencia = '{$this->idreferencia}' AND tabelareferencia = '{$this->tabelareferencia}' ";
		$cronometro = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($cronometro) > 0 )
		{
			$linha = $cronometro->toArray();
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idcronometro' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	
	public function getCronometro()
	{
		if( empty($this->idcronometro) )
			return "Id do cronometro não declarado.";

		$where = " idcronometro = '{$this->idcronometro}' ";
		$cronometro = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($cronometro) > 0 )
		{
			$linha = $cronometro->toArray();
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idcronometro' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	
	public function edit()
	{
		$where = " idcronometro = '{$this->getidcronometro()}' ";
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

}