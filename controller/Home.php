<?php

include_once "helpers/Controller.php";

class Home extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getPendenciasDeUsuario( UsuariosBO $usuario )
	{
		$idusuario = new Integer( $usuario->getidusuarios() );
		
		$listaComissionamentosPendentes = $this->getComissionamentosDeUsuario( $idusuario );
		
		$listaAtendimentosPendentes = $this->getAtendimentosDeUsuario( $idusuario );
		
		$pendencias = array(
			'comissionamentos' => $listaComissionamentosPendentes ,
			'atendimentos' => $listaAtendimentosPendentes
		);
		
		return $pendencias;
	}
	
	private function getComissionamentosDeUsuario( Integer $idusuario )
	{
		return $this->Instalacao->busca_comissionamentos_pendentes_para_usuario( $idusuario );
	}
	
	private function getAtendimentosDeUsuario( Integer $idusuario )
	{
		return $this->Atendimento->busca_atendimentos_pendentes_para_usuario( $idusuario );
	}
	
}