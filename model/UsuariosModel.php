<?php

require_once 'model/ZendModel.php';
require_once 'model/GruposUsuariosModel.php';
require_once 'model/GruposModel.php';
require_once 'model/PerfisModel.php';
require_once 'model/EmpresasModel.php';
require_once 'model/SaomModel.php';
require_once 'model/SubperfilModel.php';
require_once 'model/UsuariosModel.php';

include_once 'helpers/Utilitarios.php';

class UsuariosModel extends ZendModel
{
	
	protected $_name = 'usuarios';
	protected $_primary = 'idusuarios';
	protected $linhaArray = array();
	
	protected $_dependentTables = array('GruposUsuariosModel');
	
	// dados
	protected $idusuarios;
	protected $nome;
	protected $sobre_nome;
	protected $empresa;
	protected $funcao;
	protected $telefone;
	protected $login;
	protected $senha;
	protected $perfis_idperfis;
	protected $empresas_idempresas;
	protected $incidentes;
	protected $email;
	protected $subperfil_idsubperfil;
	protected $arquivo_supervisor;
	protected $saom;
	protected $ativacao;
	
	protected $usuarioArray = array();
	
	protected $campos = array(
		'nome',
		'sobre_nome',
		'empresa',
		'funcao',
		'telefone',
		'login',
		'senha',
		'perfis_idperfis',
		'empresas_idempresas',
		'incidentes',
		'email',
		'subperfil_idsubperfil',
		'arquivo_supervisor',
		'saom',
		'ativacao',
	);
	
	
	public function setidusuarios( Integer $idusuarios )
	{
		$this->idusuarios = $idusuarios->numero();
	}
	
	public function setnome( $nome )
	{
		$this->nome = $nome;
	}

	public function setsobre_nome( $sobre_nome )
	{
		$this->sobre_nome = $sobre_nome;
	}
	
	public function setempresa( $empresa )
	{
		$this->empresa = $empresa;
	}

    public function setfuncao( $funcao )
	{
		$this->funcao = $funcao;
	}
	
	public function settelefone( $telefone )
	{
		$this->telefone = $telefone;
	}
	
	public function setlogin( $login )
	{
		$this->login =  $login;
	}
	
	public function setsenha( $senha )
	{
		$this->senha =  $senha;
	}
	
	public function setperfis_idperfis( $perfis_idperfis )
	{
		$this->perfis_idperfis = $perfis_idperfis;
	}
	
	public function setempresas_idempresas( $empresa_idempresas )
	{
		$this->empresas_idempresas =  $empresa_idempresas;
	}
	
	public function setincidentes( $incidentes )
	{
		$this->incidentes = $incidentes;
	}
	
	public function setemail( $email )
	{
		$this->email = $email;
	}
	
	public function setsubperfil_idsubperfil( $subperfil_idsubperfil )
	{
		$this->subperfil_idsubperfil = $subperfil_idsubperfil;
	}
	
	public function setarquivo_supervisor( $arquivo_supervisor )
	{
		$this->arquivo_supervisor = $arquivo_supervisor;
	}
	
	public function setsaom( $saom )
	{
		$this->saom = $saom;
	}
	
	
	//===========campo novo =============
	public function setativacao( $ativacao )
	{
		$this->saom = $ativacao;
	}
	
	
	
	public function getidusuarios()
	{
		return $this->idusuarios;
	}
	
	public function getnome()
	{
		return $this->nome;
	}

	public function getsobre_nome()
	{
		return $this->sobre_nome;
	}
	
	public function getempresa()
	{
		return $this->empresa;
	}

    public function getfuncao()
	{
		return $this->funcao;
	}
	
	public function gettelefone()
	{
		return $this->telefone;
	}
	
	public function getlogin()
	{
		return $this->login;
	}
	
	public function getsenha()
	{
		return $this->senha;
	}
	
	public function getperfis_idperfis()
	{
		return $this->perfis_idperfis;
	}
	
	public function getempresas_idempresas()
	{
		return $this->empresas_idempresas;
	}
	
	public function getincidentes()
	{
		return $this->incidentes;
	}
	
	public function getemail()
	{
		return $this->email;
	}
	
	public function getsubperfil_idsubperfil()
	{
		return $this->subperfil_idsubperfil;
	}
	
	public function getarquivo_supervisor()
	{
		return $this->arquivo_supervisor;
	}
	
	public function getsaom()
	{
		return $this->saom;
	}
	
	//===========campo novo =============	
	public function getativacao()
	{
		return $this->ativacao;
	}
	
	
	public function getUsuarioArray()
	{
		return $this->usuarioArray;
	}
	
	
	public function getUsuario()
	{
		if( empty($this->idusuarios) )
			return "Id do usuário não declarado.";

		$where = " idusuarios = '{$this->idusuarios}' ";
		$usuarios = $this->fetchAll( $this->select()->where( $where ) );
		
		if( count($usuarios) > 0 )
		{
			$linha = $usuarios->toArray();
			$this->usuarioArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idusuarios' )
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








