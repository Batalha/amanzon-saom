<?php

require_once 'model/ZendModel.php';

class RelatorioFotograficoModel extends ZendModel
{
	
	protected $_name = 'relatorio_fotografico';
	protected $_primary = 'id_relatorio_fotografico';
	
	public $relatorio = false;
	
	/*
	 * Observações acerca do "Status"
	 * 0: o relatorio está com aprovação pendente
	 * 1: o relatorio foi aprovado
	 * 2: o relatorio foi desaprovado
	 */
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
		
		
	}
	
	/**
	 * Resgata Relatorio Fotografico a partir do id
	 * 
	 * @param Integer $id_relatorio_fotografico
	 */
	public function getRelatorioFotografico( Integer $id_relatorio_fotografico )
	{
		$where = " id_relatorio_fotografico = '{$id_relatorio_fotografico->numero()}' ";
		
		$linha = $this->fetchRow( $where );
		
		if( $linha instanceof Zend_Db_Table_Row )
			$this->relatorio = $linha->toArray();
	}
	
	/**
	 * Insere o Relatorio Fotografico no bd
	 * 
	 * @param Array $dados
	 */
	public function insertRelatorioFotografico( Array $dados )
	{
		if( $this->insert( $dados ) ) return true;
		else return false;
	}
	
	/**
	 * Atualiza Relatorio Fotografico no bd
	 * 
	 * @param array $dados
	 * @param Integer $id_relatorio_fotografico
	 */
	public function updateRelatorioFotografico( Array $dados , Integer $id_relatorio_fotografico )
	{
		if( $this->update( $dados , $id_relatorio_fotografico->numero() ) ) return true;
		else return false;
	}
	
	/**
	 * Apaga Relatorio Fotografico no bd
	 * 
	 * @param Integer $id_relatorio_fotografico
	 */
	public function deleteRelatorioFotografico( Integer $id_relatorio_fotografico )
	{
		$where = " id_relatorio_fotografico = '{$id_relatorio_fotografico->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
	
	/**
	 * Apaga Relatorio Fotografico no bd pelo id_instalacao
	 * 
	 * @param Integer $id_instalacoes
	 */
	public function deleteRelatorioFotograficoPeloIdInstalacao( Integer $id_instalacoes )
	{
		$where = " id_instalacoes = '{$id_instalacoes->numero()}' ";
		if( $this->delete( $where ) ) return true;
		else return false;
	}
	
}