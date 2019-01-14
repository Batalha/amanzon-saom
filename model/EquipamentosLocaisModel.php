<?php

class EquipamentosLocaisModel extends ZendModel
{
	
	protected $_name = 'equipamentos_locais';
	protected $_primary = 'idequipamentos_locais';
	
	protected $_referenceMap    = array(
        'EquipamentoDoLocal' => array(
            'columns'           => array('idequipamentos'),
            'refTableClass'     => 'EquipamentosModel',
            'refColumns'        => array('idequipamentos')
        ),
        'LocaldoEquipamento' => array(
            'columns'           => array('idlocais_equipamentos'),
            'refTableClass'     => 'LocaisEquipamentosModel',
            'refColumns'        => array('idlocais_equipamentos')
        )
    );
	
}