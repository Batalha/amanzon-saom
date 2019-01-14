<?php

class EquipamentosAntenasLocais_spModel extends Zend_spModel
{
	
	protected $_name = 'equipamentos_antenas_locais_sp';
	protected $_primary = 'idequipamentos_antenas_locais';
	
	protected $_referenceMap    = array(
        'EquipamentoDoLocal' => array(
            'columns'           => array('idequipamentos_antenas'),
            'refTableClass'     => 'EquipamentosAntenas_spModel',
            'refColumns'        => array('idequipamentos_antenas')
        ),
        'LocaldoEquipamento' => array(
            'columns'           => array('idlocais_equipamentos'),
            'refTableClass'     => 'LocaisEquipamentos_spModel',
            'refColumns'        => array('idlocais_equipamentos')
        )
    );
	
}