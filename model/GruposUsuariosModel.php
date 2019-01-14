<?php

class GruposUsuariosModel extends ZendModel
{
	
	protected $_name = 'grupos_usuarios';
	protected $_primary = 'id_grupos_usuarios';
	
	protected $_referenceMap    = array(
        'Grupo' => array(
            'columns'           => array('id_grupos'),
            'refTableClass'     => 'GruposModel',
            'refColumns'        => array('id_grupos')
        ),
        'Cliente' => array(
            'columns'           => array('id_usuarios'),
            'refTableClass'     => 'UsuariosModel',
            'refColumns'        => array('idusuarios')
        )
    );
	
}