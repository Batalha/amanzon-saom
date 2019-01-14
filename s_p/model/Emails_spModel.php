<?php

require_once 's_p/model/Zend_spModel.php';
require_once 's_p/model/Empresas_spModel.php';
require_once 's_p/model/Emails_spModel.php';
include_once 'helpers/Utilitarios.php';

class Emails_spModel extends Zend_spModel
{
	
	protected $_name = 'emails';
	protected $_primary = 'idemail';
	protected $linhaArray = array();

	// dados
	protected $idemail;
	protected $empresas_idempresas;
	protected $to2;

	protected $clienteArray = array();
	
	protected $campos = array(
		'idemail',
		'empresas_idempresas',
		'to2'
	);

	/**
	 * @return mixed
	 */
	public function getIdemail()
	{
		return $this->idemail;
	}

	/**
	 * @param mixed $idemail
	 */
	public function setIdemail($idemail)
	{
		$this->idemail = $idemail;
	}

	/**
	 * @return mixed
	 */
	public function getEmpresasIdempresas()
	{
		return $this->empresas_idempresas;
	}

	/**
	 * @param mixed $empresas_idempresas
	 */
	public function setEmpresasIdempresas($empresas_idempresas)
	{
		$this->empresas_idempresas = $empresas_idempresas;
	}

	/**
	 * @return mixed
	 */
	public function getTo2()
	{
		return $this->to2;
	}

	/**
	 * @param mixed $to2
	 */
	public function setTo2($to2)
	{
		$this->to2 = $to2;
	}




	
	//===========campo novo =============	
	public function getativacao()
	{
		return $this->ativacao;
	}
	
	public function getEmails()
	{
		if( empty($this->idemail) )
			return "Id do cliente não declarado.";

		$where = " idemail = '{$this->idemail}' ";
		$emails = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($emails) > 0 )
		{
			$linha = $emails->toArray();
			$this->clienteArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idemail' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
}








