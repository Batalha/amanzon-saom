<?php

class Subperfil_spModel extends Zend_Db_Table_Abstract
{

	protected $_name = 'perfis';
	protected $_primary = 'idperfis';
	
	protected $_dependentTables = array('UsuariosModel');
	
	protected $_referenceMap    = array(
        'Subperfil' => array(
            'columns'           => array('idperfis'),
            'refTableClass'     => 'Usuarios_spModel',
            'refColumns'        => array('subperfil_idsubperfil')
        )
	);

}