<?php

class SubperfilModel extends Zend_Db_Table_Abstract
{

	protected $_name = 'perfis';
	protected $_primary = 'idperfis';
	
	protected $_dependentTables = array('UsuariosModel');
	
	protected $_referenceMap    = array(
        'Subperfil' => array(
            'columns'           => array('idperfis'),
            'refTableClass'     => 'UsuariosModel',
            'refColumns'        => array('subperfil_idsubperfil')
        )
	);

}