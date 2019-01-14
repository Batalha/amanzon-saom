<?php

require_once 'model/ZendModel.php';

class LicencaAnatelModel extends ZendModel
{
	protected $_name = 'licenca_anatel';
	protected $_primary = 'idlicenca_anatel';
	
	// atributos
	protected $idlicenca_anatel;
	protected $nome;
	protected $endereco;
	protected $instalacoes_idinstalacoes;
	
	protected $licencaAnatelArray = array();
	
	protected $campos = array(
		'nome',
		'endereco',
		'instalacoes_idinstalacoes'
	);
	
	public function getlicencaAnatelArray()
	{
		return $this->licencaAnatelArray;
	}
	
	public function getidlicenca_anatel(){
		return $this->idlicenca_anatel;
	}
	public function getnome(){
		return $this->nome;
	} 
	public function getendereco(){ 
		return $this->endereco;
	}
	public function getinstalacoes_idinstalacoes(){ 
		return $this->instalacoes_idinstalacoes; 
	}
	
	public function setidlicenca_anatel( $idlicenca_anatel ){
		$this->idlicenca_anatel = $idlicenca_anatel;
	}
	public function setnome( $nome ){
		$this->nome =  $nome;
	} 
	public function setendereco( $endereco ){ 
		$this->endereco  =  $endereco;
	}
	public function setinstalacoes_idinstalacoes( $instalacoes_idinstalacoes ){ 
		$this->instalacoes_idinstalacoes = $instalacoes_idinstalacoes;
	}
	
	
	public function getLicencaAnatel()
	{
		if( empty($this->idlicenca_anatel) )
			return "Id da licença não declarado.";
		
		$where = " idlicenca_anatel = '{$this->idlicenca_anatel}' ";
		//exit($where);
		$licenca_anatel = $this->fetchRow( $this->select()->where( $where ) );
		
		if( $licenca_anatel != null )
		{
			$this->licencaAnatelArray = $licenca_anatel->toArray();
			foreach ( $this->licencaAnatelArray as $chave => $atributo )
			{
				if( $chave != 'idlicenca_anatel' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	public function edit()
	{
		$where = " idlicenca_anatel = '{$this->getidlicenca_anatel()}' ";
		foreach ( $this->campos as $chave => $campo ) {
			$data[ $campo ] = $this->{'get'.$campo}();	
		}
		
		if( $this->update( $data , $where ) ) return true;
		else return false;
	}
	
	public function create()
	{
		foreach( $this->campos as $campo )
		{
			$data[ $campo ] = $this->{'get'.$campo}();
		}
		$idLicencaAnatel = $this->insert( $data );
		if( $idLicencaAnatel ) return $idLicencaAnatel;
		else return false;
	}
}