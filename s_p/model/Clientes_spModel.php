<?php

require_once 's_p/model/Zend_spModel.php';
require_once 's_p/model/Empresas_spModel.php';
require_once 's_p/model/Clientes_spModel.php';
include_once 'helpers/Utilitarios.php';

class Clientes_spModel extends Zend_spModel
{
	
	protected $_name = 'clientes_sp';
	protected $_primary = 'idcliente';
	protected $linhaArray = array();

	// dados
	protected $idcliente;
	protected $empresa;
	protected $empresas_idempresas;
	protected $contatoFaturamento;
	protected $cnpjFaturamento;
	protected $enderecoFaturamento;
	protected $paisFaturamento;
	protected $cidadeFaturamento;
	protected $estadoFaturamento;
	protected $cepFaturamento;
	protected $emailFaturamento;

	protected $clienteArray = array();
	
	protected $campos = array(
		'idcliente',
		'empresa',
		'empresas_idempresas',
		'contatoFaturamento',
		'cnpjFaturamento',
		'enderecoFaturamento',
		'paisFaturamento',
		'cidadeFaturamento',
		'estadoFaturamento',
		'cepFaturamento',
		'subperfil_idsubperfil',
		'emailFaturamento'
	);

	/**
	 * @return mixed
	 */
	public function getIdcliente()
	{
		return $this->idcliente;
	}

	/**
	 * @param mixed $idcliente
	 */
	public function setIdcliente(Integer $idcliente)
	{
		$this->idcliente = $idcliente;
	}

	/**
	 * @return mixed
	 */
	public function getContatoFaturamento()
	{
		return $this->contatoFaturamento;
	}

	/**
	 * @param mixed $contatoFaturamento
	 */
	public function setContatoFaturamento($contatoFaturamento)
	{
		$this->contatoFaturamento = $contatoFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getCnpjFaturamento()
	{
		return $this->cnpjFaturamento;
	}

	/**
	 * @param mixed $cnpjFaturamento
	 */
	public function setCnpjFaturamento($cnpjFaturamento)
	{
		$this->cnpjFaturamento = $cnpjFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getEnderecoFaturamento()
	{
		return $this->enderecoFaturamento;
	}

	/**
	 * @param mixed $enderecoFaturamento
	 */
	public function setEnderecoFaturamento($enderecoFaturamento)
	{
		$this->enderecoFaturamento = $enderecoFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getPaisFaturamento()
	{
		return $this->paisFaturamento;
	}

	/**
	 * @param mixed $paisFaturamento
	 */
	public function setPaisFaturamento($paisFaturamento)
	{
		$this->paisFaturamento = $paisFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getCidadeFaturamento()
	{
		return $this->cidadeFaturamento;
	}

	/**
	 * @param mixed $cidadeFaturamento
	 */
	public function setCidadeFaturamento($cidadeFaturamento)
	{
		$this->cidadeFaturamento = $cidadeFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getEstadoFaturamento()
	{
		return $this->estadoFaturamento;
	}

	/**
	 * @param mixed $estadoFaturamento
	 */
	public function setEstadoFaturamento($estadoFaturamento)
	{
		$this->estadoFaturamento = $estadoFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getCepFaturamento()
	{
		return $this->cepFaturamento;
	}

	/**
	 * @param mixed $cepFaturamento
	 */
	public function setCepFaturamento($cepFaturamento)
	{
		$this->cepFaturamento = $cepFaturamento;
	}

	/**
	 * @return mixed
	 */
	public function getEmailFaturamento()
	{
		return $this->emailFaturamento;
	}

	/**
	 * @param mixed $emailFaturamento
	 */
	public function setEmailFaturamento($emailFaturamento)
	{
		$this->emailFaturamento = $emailFaturamento;
	}

	/**
	 * @return array
	 */
	public function getClienteArray()
	{
		return $this->clienteArray;
	}

	/**
	 * @param array $clienteArray
	 */
	public function setClienteArray($clienteArray)
	{
		$this->clienteArray = $clienteArray;
	}



	
	
//	public function setidusuarios( Integer $idusuarios )
//	{
//		$this->idusuarios = $idusuarios->numero();
//	}
//
//	public function setnome( $nome )
//	{
//		$this->nome = $nome;
//	}
//
//	public function setempresa( $empresa )
//	{
//		$this->empresa = $empresa;
//	}
//
//    public function setfuncao( $funcao )
//	{
//		$this->funcao = $funcao;
//	}
//
//	public function settelefone( $telefone )
//	{
//		$this->telefone = $telefone;
//	}
//
//	public function setlogin( $login )
//	{
//		$this->login =  $login;
//	}
//
//	public function setsenha( $senha )
//	{
//		$this->senha =  $senha;
//	}
//
//	public function setperfis_idperfis( $perfis_idperfis )
//	{
//		$this->perfis_idperfis = $perfis_idperfis;
//	}
//
//	public function setempresas_idempresas( $empresa_idempresas )
//	{
//		$this->empresas_idempresas =  $empresa_idempresas;
//	}
//
//	public function setincidentes( $incidentes )
//	{
//		$this->incidentes = $incidentes;
//	}
//
//	public function setemail( $email )
//	{
//		$this->email = $email;
//	}
//
//	public function setsubperfil_idsubperfil( $subperfil_idsubperfil )
//	{
//		$this->subperfil_idsubperfil = $subperfil_idsubperfil;
//	}
//
//	public function setarquivo_supervisor( $arquivo_supervisor )
//	{
//		$this->arquivo_supervisor = $arquivo_supervisor;
//	}
//
//	public function setsaom( $saom )
//	{
//		$this->saom = $saom;
//	}
//
//
//	//===========campo novo =============
//	public function setativacao( $ativacao )
//	{
//		$this->saom = $ativacao;
//	}
//
//
//
//	public function getidusuarios()
//	{
//		return $this->idusuarios;
//	}
//
//	public function getnome()
//	{
//		return $this->nome;
//	}
//
//	public function getempresa()
//	{
//		return $this->empresa;
//	}
//
//    public function getfuncao()
//	{
//		return $this->funcao;
//	}
//
//	public function gettelefone()
//	{
//		return $this->telefone;
//	}
//
//	public function getlogin()
//	{
//		return $this->login;
//	}
//
//	public function getsenha()
//	{
//		return $this->senha;
//	}
//
//	public function getperfis_idperfis()
//	{
//		return $this->perfis_idperfis;
//	}
//
//	public function getempresas_idempresas()
//	{
//		return $this->empresas_idempresas;
//	}
//
//	public function getincidentes()
//	{
//		return $this->incidentes;
//	}
//
//	public function getemail()
//	{
//		return $this->email;
//	}
//
//	public function getsubperfil_idsubperfil()
//	{
//		return $this->subperfil_idsubperfil;
//	}
//
//	public function getarquivo_supervisor()
//	{
//		return $this->arquivo_supervisor;
//	}
//
//	public function getsaom()
//	{
//		return $this->saom;
//	}
	
	//===========campo novo =============	
	public function getativacao()
	{
		return $this->ativacao;
	}
	
	
	public function getUsuarioArray()
	{
		return $this->usuarioArray;
	}
	
	
	public function getCliente()
	{
		if( empty($this->idcliente) )
			return "Id do cliente não declarado.";

		$where = " idcliente = '{$this->idcliente}' ";
		$clientes = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($clientes) > 0 )
		{
			$linha = $clientes->toArray();
			$this->clienteArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idcliente' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	// ----------------------------------------------------------
	
	public function getDependencias( Zend_Db_Table_Row $linha )
	{
		//para grupo
		$grupo = $linha->findGruposModelViaGruposUsuariosModel();
		if( $grupo->count() > 0 )
		{
			$this->linhaArray['id_grupo'] = $grupo->current()->id_grupos;
			$this->linhaArray['nome_grupo'] = $grupo->current()->nome;
		}
		
		//para perfil
		$perfil = $linha->findPerfisModelByPerfil();
		if( $perfil->count() > 0 )
		{
			$this->linhaArray['id_perfil'] = $perfil->current()->idperfis;
			$this->linhaArray['nome_perfil'] = $perfil->current()->perfil;
		}
		
		//para subperfil
		$subperfil = $linha->findPerfisModelBySubperfil();
		if( $subperfil->count() > 0 )
		{
			$this->linhaArray['id_subperfil'] = $subperfil->current()->idperfis;
			$this->linhaArray['nome_subperfil'] = $subperfil->current()->perfil;
		}
		
		//para empresa
		$empresa = $linha->findEmpresasModelByEmpresa();
		if( $empresa->count() > 0 )
		{
			$this->linhaArray['id_empresa'] = $empresa->current()->idempresas;
			$this->linhaArray['nome_empresa'] = $empresa->current()->empresa;
		}
		
		//para saom
		$saom = $linha->findSaomModelBySaom();
		if( $saom->count() > 0 )
		{
			$this->linhaArray['id_saom'] = $saom->current()->id_saom;
			$this->linhaArray['nome_saom'] = $saom->current()->nome;
		}
	}
	
}








