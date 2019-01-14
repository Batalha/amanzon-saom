<?php

require_once 's_p/model/Usuarios_spModel.php';

class Usuarios_spBO extends Usuarios_spModel
{
	protected $listaUsuarios = array();
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
	public function getlistaUsuarios()
	{
		return $this->listaUsuarios;
	}
	
	public function getListaUsuariosIncidente()
	{
		$where = " incidentes = 1 ";
		$usuarios = $this->fetchAll( $where );
		$this->listaUsuarios = $usuarios->toArray();
	}
	
}