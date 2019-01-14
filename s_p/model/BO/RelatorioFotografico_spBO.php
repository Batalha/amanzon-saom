<?php

include_once "s_p/model/RelatorioFotografico_spModel.php";

class RelatorioFotografico_spBO extends RelatorioFotografico_spModel
{
	/**
	 * Resgata Relatorio Fotografico pelo Id da Instalação do mesmo
	 * 
	 * @param Integer $instalacao
	 */
	public function getRelatorioDeInstalacao( Integer $instalacao )
	{
		$where = " id_instalacoes = '{$instalacao->numero()}' ";
		
		$linha = $this->fetchRow( $where );
		
		if( $linha instanceof Zend_Db_Table_Row ) // resultados positivos
			$this->relatorio = $linha->toArray();
		else
			$this->relatorio = false;
	}
	
	/**
	 * Aprova Relatorio Fotografico
	 * 
	 * @param {string} $id_relatorio_fotografico
	 */
	public function aprova( Integer $id_relatorio_fotografico )
	{
		$dados = array( "status" => 1 );
		
		$where = " id_relatorio_fotografico = '{$id_relatorio_fotografico->numero()}' ";
		
		if( $this->update( $dados , $where ) ) 
			return true;
		else
			return false;
	}
	
	/**
	 * Desaprova Relatorio Fotografico
	 * 
	 * @param {string} $id_relatorio_fotografico
	 */
	public function desaprova( Integer $id_relatorio_fotografico )
	{
		$dados = array( "status" => 2 );
		
		$where = " id_relatorio_fotografico = '{$id_relatorio_fotografico->numero()}' ";
		
		if( $this->update( $dados , $where ) ) 
			return true;
		else
			return false;
	}
	
	/**
	 * Justifica desaprovação do Relatorio Fotografico
	 * 
	 * @param Integer $id_relatorio_fotografico
	 * @param {string} $comentario
	 */
	public function justificaDesaprovacao( Integer $id_relatorio_fotografico , $comentario )
	{
		$where = " id_relatorio_fotografico = '{$id_relatorio_fotografico->numero()}' ";
		
		$dados = array( 'comentario' => $comentario );
		
		if( $this->update( $dados , $where ) )
			return true;
		else
			return false;
	}
}