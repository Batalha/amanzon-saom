<?php

include_once ('helpers/Controller.php');

class Home_sp extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getPendenciasDeUsuario( Usuarios_spBO $usuario )
	{
		$idusuario = new Integer( $usuario->getidusuarios() );
		$listaComissionamentosPendentes = $this->getComissionamentosDeUsuario( $idusuario );

//		echo die_json($listaComissionamentosPendentes);
		
		$listaAtendimentosPendentes = $this->getAtendimentosDeUsuario( $idusuario );
		
		$pendencias = array(
			'comissionamentos' => $listaComissionamentosPendentes ,
			'atendimentos' => $listaAtendimentosPendentes
		);
		
		return $pendencias;
	}
	
	private function getComissionamentosDeUsuario( Integer $idusuario )
	{
		return $this->Instalacao_sp->busca_comissionamentos_pendentes_para_usuario( $idusuario );
	}
	
	private function getAtendimentosDeUsuario( Integer $idusuario )
	{
		return $this->Atendimento_sp->busca_atendimentos_pendentes_para_usuario( $idusuario );
	}
	
}