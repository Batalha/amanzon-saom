<?php

require_once 'model/ZendModel.php';

class ContratoSPModel extends ZendModel
{
	
	protected $_name = 'contrato_sp';
	protected $_primary = 'id_contrato_sp';
	
	public $termo = false;
	
// 	/*
// 	 * Observações acerca do "Status"
// 	 * 0: o termo está com aprovação pendente
// 	 * 1: o termo foi aprovado
// 	 * 2: o termo foi desaprovado
// 	 */
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
// 	/**
// 	 * Resgata Termo de Responsabilidade a partir do id
// 	 * 
// 	 * @param Integer $id_termo_responsabilidade
// 	 */
	public function getContratoSP( Integer $id_termo_contrato_sp )
	{

		$where = " id_contrato_sp = '{$id_termo_contrato_sp->numero()}' ";
		
		$linha = $this->fetchRow( $where );
		
		if( $linha instanceof Zend_Db_Table_Row )
			$this->termo = $linha->toArray();
	}
	
// 	/**
// 	 * Insere o Termo de Responsabilidade no bd
// 	 * 
// 	 * @param Array $dados
// 	 */
	public function insertContratoSP( Array $dados )
	{
		if( $this->insert( $dados ) ) 
			return true;
		else 
			return false;
	}
	
// 	/**
// 	 * Atualiza Termo de Responsabilidade no bd
// 	 * 
// 	 * @param array $dados
// 	 * @param Integer $id_termo_responsabilidade
// 	 */
	public function updateContratoSP( Array $dados , Integer $id_termo_contrato_sp )
	{
		if( $this->update( $dados , $id_termo_contrato_sp->numero() ) ) return true;
		else return false;
	}
	
// 	/**
// 	 * Apaga Termo de Responsabilidade no bd
// 	 * 
// 	 * @param Integer $id_termo_resposabilidade
// 	 */
	public function deleteContratoSP( Integer $id_termo_contrato_sp )
	{
		$where = " id_termo_contrato_sp = '{$id_termo_contrato_sp->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
	
// 	/**
// 	 * Apaga Termo de Responsabilidade no bd pelo id_instalacao
// 	 * 
// 	 * @param Integer $id_instalacoes
// 	 */
	public function deleteContratoSPPeloIdPedidoOs( Integer $idpedido_os )
	{
		$where = " contrato_idpedido_os = '{$idpedido_os->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
}