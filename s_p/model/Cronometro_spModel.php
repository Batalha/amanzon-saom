<?php

require_once 's_p/model/Zend_spModel.php';

class Cronometro_spModel extends Zend_spModel
{

	protected $_name = 'cronometro_sp';
	protected $_primary = 'idcronometro_sp';
	
	
	// dados
	
	protected $idcronometro;
	protected $idreferencia;
	protected $data_inicio;
	protected $inicio_tarefa;
	protected $interrupcoes;
	protected $ordem;
	protected $data_pausa;
	protected $tabelareferencia;
	protected $final_tarefa;
	protected $prazo;
	
	protected $campos = array(
		'idreferencia',
		'data_inicio',
		'inicio_tarefa',
		'interrupcoes',
		'ordem',
		'data_pausa',
		'tabelareferencia',
		'final_tarefa',
		'prazo'
	);
	
	
	public function setidcronometro_sp( Integer $idcronometro )
	{
		$this->idcronometro =  $idcronometro->numero();
	}
	public function setidreferencia( $idreferencia )
	{
		$this->idreferencia = $idreferencia;
	}
	public function setdata_inicio( $data_inicio )
	{
		$this->data_inicio = $data_inicio;
	}

	public function setinicio_tarefa( $inicio_tarefa )
	{
		$this->inicio_tarefa = $inicio_tarefa;
	}
	public function setinterrupcoes( $interrupcoes )
	{
		$this->interrupcoes = $interrupcoes;
	}
	public function setordem( $ordem )
	{
		$this->ordem = $ordem;
	}

	public function setdata_pausa( $data_pausa )
	{
		$this->data_pausa = $data_pausa;
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
	
	public function getidcronometro_sp()
	{
		return $this->idcronometro;
	}
	public function getidreferencia()
	{
		return $this->idreferencia;
	}

	public function getdata_inicio()
	{
		return $this->data_inicio;
	}

	public function getinicio_tarefa()
	{
		return $this->inicio_tarefa;
	}
	public function getinterrupcoes()
	{
		return $this->interrupcoes;
	}

	public function getordem()
	{
		return $this->ordem;
	}

	public function getdata_pausa()
	{
		return $this->data_pausa;
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
				if( $chave != 'idcronometro_sp' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	
	public function getCronometro()
	{
		if( empty($this->idcronometro) )
			return "Id do cronometro não declarado.";

		$where = " idcronometro_sp = '{$this->idcronometro}' ";
		$cronometro = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($cronometro) > 0 )
		{
			$linha = $cronometro->toArray();
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idcronometro_sp' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	
	public function edit()
	{

		$where = " idcronometro_sp = '{$this->getidcronometro_sp()}' ";
//		$arrReturn['msg']    = $where;
//		echo die_json($arrReturn);
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