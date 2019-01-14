<?php

require_once 'model/ZendModel.php';

class TermoResponsabilidadeModel extends ZendModel
{
	
	protected $_name = 'termo_responsabilidade';
	protected $_primary = 'id_termo_responsabilidade';
	
	public $termo = false;
	
	/*
	 * Observações acerca do "Status"
	 * 0: o termo está com aprovação pendente
	 * 1: o termo foi aprovado
	 * 2: o termo foi desaprovado
	 */
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	/**
	 * Resgata Termo de Responsabilidade a partir do id
	 * 
	 * @param Integer $id_termo_responsabilidade
	 */
	public function getTermoResponsabilidade( Integer $id_termo_responsabilidade )
	{
	    

		$where = " id_termo_responsabilidade = '{$id_termo_responsabilidade->numero()}' ";
		
		$linha = $this->fetchRow( $where );
		
		if( $linha instanceof Zend_Db_Table_Row )
			$this->termo = $linha->toArray();
	}
	
	/**
	 * Insere o Termo de Responsabilidade no bd
	 * 
	 * @param Array $dados
	 */
	public function insertTermoResponsabilidade( Array $dados )
	{
		if( $this->insert( $dados ) ) return true;
		else return false;
	}
	
	/**
	 * Atualiza Termo de Responsabilidade no bd
	 * 
	 * @param array $dados
	 * @param Integer $id_termo_responsabilidade
	 */
	public function updateTermoResponsabilidade( Array $dados , Integer $id_termo_responsabilidade )
	{
		if( $this->update( $dados , $id_termo_responsabilidade->numero() ) ) return true;
		else return false;
	}
	
	/**
	 * Apaga Termo de Responsabilidade no bd
	 * 
	 * @param Integer $id_termo_resposabilidade
	 */
	public function deleteTermoResponsabilidade( Integer $id_termo_resposabilidade )
	{
		$where = " id_termo_responsabilidade = '{$id_termo_resposabilidade->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
	
	/**
	 * Apaga Termo de Responsabilidade no bd pelo id_instalacao
	 * 
	 * @param Integer $id_instalacoes
	 */
	public function deleteTermoResponsabilidadePeloIdInstalacao( Integer $id_instalacoes )
	{
		$where = " id_instalacoes = '{$id_instalacoes->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
}