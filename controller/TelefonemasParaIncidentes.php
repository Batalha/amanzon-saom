<?php

require_once 'helpers/Controller.php';

class TelefonemasParaIncidentes extends Controller
{
	
	public function liberaTelefonemaIncidente()
	{
		$dados = $this->dadosP;
		//print_b($dados,true);
		
		$this->TelefonemasParaIncidentes->setidassociacao_instalacao_incidente( $dados['associacao'] );
		$this->TelefonemasParaIncidentes->setorder_telefonema( $dados['telefonema'] );
		$this->TelefonemasParaIncidentes->liberaTelefonemaDeIncidente();
		
	}
	
}