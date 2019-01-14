<?php

class PreIncidentesNagiosModel extends ZendModel
{

	protected $_name = 'pre_incidentes_nagios';
	protected $_primary = 'id_pre_incidentes_nagios';
	
	public function buscaPreIncidentesSemResponsaveisParaDesignacao( $designacao )
	{
		$where = " vsat = '{$designacao}' AND responsavel IS NULL ";
		$lista = $this->fetchAll( $where );
		if( count($lista) > 0 ) return true;
		else return false;
	}
	
}