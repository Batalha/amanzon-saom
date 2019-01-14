<?php

require_once "s_p/model/Zend_spModel.php";

class LocaisEquipamentos_spModel extends Zend_spModel
{

	protected $_name = 'locais_equipamentos_sp';
	protected $_primary = 'idlocais_equipamentos';
	
	protected $_dependentTables = array('EquipamentosLocais_spModel');
	
	protected $_referenceMap    = array(
        'SubLocal' => array(
            'columns'           => array('locais_equipamentos_idlocais_equipamentos'),
            'refTableClass'     => 'LocaisEquipamentos_spModel',
            'refColumns'        => array('idlocais_equipamentos')
        )
    );

}