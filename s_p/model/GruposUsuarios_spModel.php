<?php

class GruposUsuarios_spModel extends Zend_spModel
{
	
	protected $_name = 'grupos_usuarios_sp';
	protected $_primary = 'id_grupos_usuarios';
	
	protected $_referenceMap    = array(
        'Grupo' => array(
            'columns'           => array('id_grupos'),
            'refTableClass'     => 'Grupos_spModel',
            'refColumns'        => array('id_grupos')
        ),
        'Cliente' => array(
            'columns'           => array('id_usuarios'),
            'refTableClass'     => 'Usuarios_spModel',
            'refColumns'        => array('idusuarios')
        )
    );
	
}