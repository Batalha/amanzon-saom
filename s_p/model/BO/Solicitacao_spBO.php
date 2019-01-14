<?php

require_once 's_p/model/Solicitacao_spModel.php';

class Solicitacao_spBO extends Solicitacao_spModel
{
	protected $listaUsuarios = array();
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
	public function getlistaSolicitacao()
	{
		return $this->listaSolicitacao;
	}
	
	public function getListaSolicitacaoIncidente()
	{
		$where = " incidentes = 1 ";
		$solicitacao = $this->fetchAll( $where );
		$this->listaSolicitacao = $solicitacao->toArray();
	}
	
}