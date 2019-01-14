<?php

class EquipamentosLocais_spModel extends Zend_spModel
{
	
	protected $_name = 'equipamentos_locais_sp';
	protected $_primary = 'idequipamentos_locais';
	
	protected $_referenceMap    = array(
        'EquipamentoDoLocal'    => array(
            'columns'           => array('idequipamentos_sp'),
            'refTableClass'     => 'Equipamentos_spModel',
            'refColumns'        => array('idequipamentos_sp')
        ),
        'LocaldoEquipamento'    => array(
            'columns'           => array('idlocais_equipamentos'),
            'refTableClass'     => 'LocaisEquipamentos_spModel',
            'refColumns'        => array('idlocais_equipamentos')
        )
    );
	
}