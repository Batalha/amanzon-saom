<?php

require_once 's_p/model/Zend_spModel.php';

class TelefonemasParaIncidentes_spModel extends Zend_spModel 
{
	
	protected $_name = 'telefonemas_para_incidentes_sp';
	protected $_primary = 'idtelefonemas_para_incidentes';
	
	// atributos
	protected $idtelefonemas_para_incidentes;
	protected $data_criacao;
	protected $prazo;
	protected $order_telefonema;
	protected $idassociacao_instalacao_incidente;
	protected $finalizado;
	protected $data_finalizacao;
	protected $telefonemasParaIncidentesArray;
	
	
	protected $campos = array(
		'data_criacao',
		'prazo',
		'order_telefonema',
		'idassociacao_instalacao_incidente',
		'finalizado',
		'data_finalizacao'
	);
	
	public function gettelefonemasParaIncidentesArray()
	{
		return $this->telefonemasParaIncidentesArray;
	}
	
	
	public function getidtelefonemas_para_incidentes()
	{
		return $this->idtelefonemas_para_incidentes;
	}
	public function getdata_criacao()
	{
		return $this->data_criacao;
	}
	public function getprazo()
	{
		return $this->prazo;
	}
	public function getorder_telefonema()
	{
		return $this->order_telefonema;
	}
	public function getidassociacao_instalacao_incidente()
	{
		return $this->idassociacao_instalacao_incidente;
	}
	public function getfinalizado()
	{
		return $this->finalizado;
	}
	public function getdata_finalizacao()
	{
		return $this->data_finalizacao;
	}
	
	public function setidtelefonemas_para_incidentes( Integer $idtelefonemas_para_incidentes )
	{
		$this->idtelefonemas_para_incidentes = $idtelefonemas_para_incidentes->numero();
	}
	public function setdata_criacao( $data_criacao )
	{
		$this->data_criacao = $data_criacao;
	}
	public function setprazo( $prazo )
	{
		$this->prazo  =  $prazo;
	}
	public function setorder_telefonema( $order_telefonema )
	{
		$this->order_telefonema = $order_telefonema;
	}
	public function setidassociacao_instalacao_incidente( $idassociacao_instalacao_incidente )
	{
		$this->idassociacao_instalacao_incidente = $idassociacao_instalacao_incidente;
	}
	public function setfinalizado( $finalizado )
	{
		$this->finalizado = $finalizado;
	}
	public function setdata_finalizacao( $data_finalizacao )
	{
		$this->data_finalizacao = $data_finalizacao;
	}
	
	
	public function getTelefonemasParaIncidentes()
	{
		if( empty($this->idtelefonemas_para_incidentes) )
			return "Id do Município não declarado.";
			
		if( empty($this->order_telefonema) )
			return "O número do telefonema deve estar preenchido.";
		
		$where = " 
			idtelefonemas_para_incidentes = '{$this->idtelefonemas_para_incidentes}' AND
			order_telefonema = '{$this->order_telefonema}'
		";
		$telefonemasParaIncidentes = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($municipios) > 0 )
		{
			$linha = $telefonemasParaIncidentes->toArray();
			$this->telefonemasParaIncidentesArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idtelefonemas_para_incidentes' )
					$this->{"set".$chave}( $atributo );
				else
				{
					$id = new Integer( $atributo );
					$this->{"set".$chave}( $id );
				}
			}
		}
	}
	
	public function create()
	{
		$data = array();
		foreach ( $this->campos as $chave => $campo )
		{
			$data[ $campo ] = $this->{'get'.$campo}();
		}
		
		if( $this->insert( $data ) ) return true;
		else return false;
	}
	
	public function edit()
	{
		$where = " idtelefonemas_para_incidentes = '{$this->getidtelefonemas_para_incidentes()}' ";
		foreach ( $this->campos as $chave => $campo ) {
			$data[ $campo ] = $this->{'get'.$campo}();
		}
		//print_b($data,true);
		
		if( $this->update( $data , $where ) )
			return 'ok';
		else
			return 'erro';
	}
	
}