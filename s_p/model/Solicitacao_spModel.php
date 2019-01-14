<?php

require_once 's_p/model/Zend_spModel.php';
require_once 's_p/model/GruposUsuarios_spModel.php';
require_once 's_p/model/Grupos_spModel.php';
require_once 's_p/model/Perfis_spModel.php';
require_once 's_p/model/Empresas_spModel.php';
require_once 's_p/model/Saom_spModel.php';
require_once 's_p/model/Subperfil_spModel.php';
require_once 's_p/model/Usuarios_spModel.php';

include_once 'helpers/Utilitarios.php';

class Solicitacao_spModel extends Zend_spModel
{
	
	protected $_name = 'solicitacao_sp';
	protected $_primary = 'idsolicitacao';
	protected $linhaArray = array();
	
	protected $_dependentTables = array('GruposUsuarios_spModel');
	
	// dados
	protected $idsolicitacao;
	protected $nomeSolicitacao;
	protected $descricao;

	
	protected $usuarioArray = array();
	
	protected $campos = array(
		'nomeSolicitacao',
		'descricao',

	);
	
	
	public function setidsolicitacao( Integer $idsolicitacao )
	{
		$this->idsolicitacao = $idsolicitacao->numero();
	}
	
	public function setnomeSolicitacao( $nomeSolicitacao )
	{
		$this->nomeSolicitacao = $nomeSolicitacao;
	}

	public function setdescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	
	
	public function getidsolicitacao()
	{
		return $this->idsolicitacao;
	}
	
	public function getnomeSolicitacao()
	{
		return $this->nomeSolicitacao;
	}

	public function getdescricao()
	{
		return $this->descricao;
	}

	
	
	public function getSolicitacaoArray()
	{
		return $this->solicitacaoArray;
	}
	
	
	public function getSolicitacao()
	{
		if( empty($this->idsolicitacao) )
			return "Id do solicitacao não declarado.";

		$where = " idsolicitacao = '{$this->idsolicitacao}' ";
		$solicitacao = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($solicitacao) > 0 )
		{
			$linha = $solicitacao->toArray();
			$this->solicitacaoArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idsolicitacao' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
}








