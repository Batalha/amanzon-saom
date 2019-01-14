<?php

require_once "model/ZendModel.php";

class LocaisEquipamentosModel extends ZendModel
{

	protected $_name = 'locais_equipamentos';
	protected $_primary = 'idlocais_equipamentos';
	
	protected $_dependentTables = array('EquipamentosLocaisModel');
	
	protected $_referenceMap    = array(
        'SubLocal' => array(
            'columns'           => array('locais_equipamentos_idlocais_equipamentos'),
            'refTableClass'     => 'LocaisEquipamentosModel',
            'refColumns'        => array('idlocais_equipamentos')
        )
    );

}