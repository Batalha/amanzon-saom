<?php

class EquipamentosAntenasLocaisModel extends ZendModel
{
	
	protected $_name = 'equipamentos_antenas_locais';
	protected $_primary = 'idequipamentos_antenas_locais';
	
	protected $_referenceMap    = array(
        'EquipamentoDoLocal' => array(
            'columns'           => array('idequipamentos_antenas'),
            'refTableClass'     => 'EquipamentosAntenasModel',
            'refColumns'        => array('idequipamentos_antenas')
        ),
        'LocaldoEquipamento' => array(
            'columns'           => array('idlocais_equipamentos'),
            'refTableClass'     => 'LocaisEquipamentosModel',
            'refColumns'        => array('idlocais_equipamentos')
        )
    );
	
}