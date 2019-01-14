<?php

require_once 'model/ZendModel.php';

class RelatorioGraficoModel extends ZendModel
{
	
	protected $_name = 'relatorio_grafico';
	protected $_primary = 'id_relatorio_grafico';
	
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
		
		
	}
	
}