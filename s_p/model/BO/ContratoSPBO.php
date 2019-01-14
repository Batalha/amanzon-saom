<?php

include_once "s_p/model/ContratoSPModel.php";

class ContratoSPBO extends ContratoSPModel
{
	/**
	 * Resgata Termo de Responsabilidade pelo Id da Instalação do mesmo
	 * 
	 * @param Integer $instalacao
	 */
	public function getContratoSP( Integer $pedido_os )
	{

		$where = " contrato_idpedido_os = '{$pedido_os->numero()}' ";
		
		$linha = $this->fetchRow( $where );
		
		if( $linha instanceof Zend_Db_Table_Row ){ // resultados positivos

			$this->termo = $linha->toArray();
		}else{
			$this->termo = false;
		}
	}
	
	/**
	 * Aprova Termo de Responsabilidade
	 * 
	 * @param {string} $id_termo_responsabilidade
	 */
// 	public function aprova( Integer $id_termo_responsabilidade )
// 	{
// 		$dados = array( "status" => 1 );
		
// 		$where = " id_termo_responsabilidade = '{$id_termo_responsabilidade->numero()}' ";
		
// 		if( $this->update( $dados , $where ) ) 
// 			return true;
// 		else
// 			return false;
// 	}
	
	/**
	 * Desaprova Termo de Responsabilidade
	 * 
	 * @param {string} $id_termo_responsabilidade
	 */
// 	public function desaprova( Integer $id_termo_responsabilidade )
// 	{
// 		$dados = array( "status" => 2 );
		
// 		$where = " id_termo_responsabilidade = '{$id_termo_responsabilidade->numero()}' ";
		
// 		if( $this->update( $dados , $where ) ) 
// 			return true;
// 		else
// 			return false;
// 	}
	
	/**
	 * Justifica desaprovação do Termo de Responsabilidade
	 * 
	 * @param Integer $id_termo_responsabilidade
	 * @param {string} $comentario
	 */
// 	public function justificaDesaprovacao( Integer $id_termo_responsabilidade , $comentario )
// 	{
// 		$where = " id_termo_responsabilidade = '{$id_termo_responsabilidade->numero()}' ";
		
// 		$dados = array( 'comentario' => $comentario );
		
// 		if( $this->update( $dados , $where ) )
// 			return true;
// 		else
// 			return false;
// 	}
}