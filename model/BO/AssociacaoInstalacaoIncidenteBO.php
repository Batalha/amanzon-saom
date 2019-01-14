<?php

require_once "model/AssociacaoInstalacaoIncidenteModel.php";

class AssociacaoInstalacaoIncidenteBO extends AssociacaoInstalacaoIncidenteModel
{
	
	// para verificacao quais das associacoes existem
	public function getAssociacaoPelaInstalacaoEPeloIncidente( InstalacoesBO $instalacao , IncidentesBO $incidente, ProdemgeBO $prodemge)
	{
		$idinstalacoes =  $instalacao->getidinstalacoes();
		$idincidentes =  $incidente->getidincidentes();
		$idprodemge =  $prodemge->getidprodemge();

		$where = " idinstalacoes = '{$idinstalacoes}' AND idincidentes = '{$idincidentes}' AND idprodemge = '{$idprodemge}'  ";
		
		$associacao = $this->fetchAll( $where );
		
		if( count($associacao) > 0 )
			return true;
		else
			return false;
	}

	public function apagarAssociacao()
	{
		$where = " idinstalacoes = '{$this->idinstalacoes}' AND idincidentes = '{$this->idincidentes}' AND idprodemge = '{$this->idprodemge}' ";
		if( $this->delete( $where ) )
			return true;
		else
			return false;
	}
	
}