<?php

require_once 'model/UsuariosModel.php';

class UsuariosBO extends UsuariosModel
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