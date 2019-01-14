<?php

require_once 's_p/model/Zend_spModel.php';

class AtendArquivo_spModel extends Zend_spModel
{
	
	protected $_name = 'atend_arquivo_sp';
	protected $_primary = 'id_atend_arquivo';
	
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
	public function getAtendArquivo( Integer $id_atend_arquivo )
	{
	    

		$where = " id_atend_arquivo = '{$id_atend_arquivo->numero()}' ";
		
		$linha = $this->fetchRow( $where );
		
		if( $linha instanceof Zend_Db_Table_Row )
			$this->termo = $linha->toArray();
	}
	
	/**
	 * Insere o Termo de Responsabilidade no bd
	 * 
	 * @param Array $dados
	 */
	public function insertAtendArquivo( Array $dados )
	{
		if( $this->insert( $dados ) ){

			return true;
		}else{
			return false;

		}
	}
	
	/**
	 * Atualiza Termo de Responsabilidade no bd
	 * 
	 * @param array $dados
	 * @param Integer $id_termo_responsabilidade
	 */
	public function updateAtendArquivo( Array $dados , Integer $id_atend_arquivo )
	{
		if( $this->update( $dados , $id_atend_arquivo->numero() ) ) return true;
		else return false;
	}
	
	/**
	 * Apaga Termo de Responsabilidade no bd
	 * 
	 * @param Integer $id_termo_resposabilidade
	 */
	public function deleteAtendArquivo( Integer $id_atend_arquivo )
	{
		$where = " id_atend_arquivo = '{$id_atend_arquivo->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
	
	/**
	 * Apaga Termo de Responsabilidade no bd pelo id_instalacao
	 * 
	 * @param Integer $id_instalacoes
	 */
//	public function deleteTermoResponsabilidadePeloIdInstalacao( Integer $id_instalacoes )
//	{
//		$where = " id_instalacoes = '{$id_instalacoes->numero()}' ";
//		if( $this->delete( $where ) ) return true;
//		else return false;
//	}
}