<?php

class StatusAtendimentoModel extends ZendModel
{
	protected $_name = 'status_atend';
	protected $_primary = 'idstatus_atend';
	protected $_rowClass = 'StatusAtendimentoModel';
	
	//dados 
	protected $idstatus_atend;
	protected $status;
	protected $descricao;
	
	
	public function setidstatus_atend( $idstatus_atend )
	{
		$this->idstatus_atend = $idstatus_atend;
	}
	public function setstatus( $status )
	{
		$this->status  = $status;
	}
	public function setdescricao( $descricao )
	{
		$this->descricao = $descricao;
	}
	
	public function getidstatus_atend( $idstatus_atend )
	{
		return $this->idstatus_atend;
	}
	public function getstatus( $status )
	{
		return $this->status;
	}
	public function getdescricao( $descricao )
	{
		return $this->descricao;
	}
	
	
	protected $campos = array(
		'idstatus_atend',
		'status',
		'descricao'
	);
	
	public function getStatusAtendimento( Integer $idStatusAtendimento )
	{
		$where = " idstatus_atend  = '{$idStatusAtendimento->numero()}' ";
		$statusAtendimento = $this->fetchAll( $where );
		$status = "";
		foreach( $statusAtendimento->toArray() as $chave => $status )
		{
			$status = $status['status'];continue;
		}
		return $status;
	}
	
}