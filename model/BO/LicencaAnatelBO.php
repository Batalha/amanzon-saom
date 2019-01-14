<?php


require_once 'model/LicencaAnatelModel.php';

class LicencaAnatelBO extends LicencaAnatelModel
{
	public function __construct( $adapter )
	{
		parent::__construct( $adapter );
	}
	
	public function buscaLicencaPelaInstalacao()
	{
		$where = " instalacoes_idinstalacoes = '{$this->getinstalacoes_idinstalacoes()}' ";
		$lista = $this->fetchAll( $where );
		if( count( $lista ) > 0 )
    	{
    		$this->licencaAnatelArray = $lista->toArray();
    		foreach ( $this->licencaAnatelArray[0] as $chave => $valor )
    		{
    			$this->{'set'.$chave}( $valor );
    		}
    		return true;
    	}
    	else return false;
	}
}