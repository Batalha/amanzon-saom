<?php

require_once 'helpers/Controller.php';

class TelefonemasParaIncidentes_sp extends Controller
{
	
	public function liberaTelefonemaIncidente()
	{
		$dados = $this->dadosP;
		//print_b($dados,true);
		
		$this->TelefonemasParaIncidentes_sp->setidassociacao_instalacao_incidente( $dados['associacao'] );
		$this->TelefonemasParaIncidentes_sp->setorder_telefonema( $dados['telefonema'] );
		$this->TelefonemasParaIncidentes_sp->liberaTelefonemaDeIncidente();
		
	}
	
}