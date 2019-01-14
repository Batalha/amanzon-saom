<?php

require_once "s_p/model/AssociacaoInstalacaoIncidente_spModel.php";

class AssociacaoInstalacaoIncidente_spBO extends AssociacaoInstalacaoIncidente_spModel
{
	
	// para verificacao quais das associacoes existem
	public function getAssociacaoPelaInstalacaoEPeloIncidente( Instalacoes_spBO $instalacao , Incidentes_spBO $incidente, Prodemge_spBO $prodemge)
	{
		$idinstalacoes =  $instalacao->getidinstalacoes_sp();
		$idincidentes =  $incidente->getidincidentes();
		$idprodemge =  $prodemge->getidprodemge();

		$where = " idinstalacoes_sp = '{$idinstalacoes}' AND idincidentes = '{$idincidentes}' AND idprodemge = '{$idprodemge}'  ";
		
		$associacao = $this->fetchAll( $where );
		
		if( count($associacao) > 0 )
			return true;
		else
			return false;
	}

	public function apagarAssociacao()
	{
		$where = " idinstalacoes_sp = '{$this->idinstalacoes_sp}' AND idincidentes = '{$this->idincidentes}' AND idprodemge = '{$this->idprodemge}' ";
		if( $this->delete( $where ) )
			return true;
		else
			return false;
	}
	
}