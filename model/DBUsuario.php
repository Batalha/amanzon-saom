<?php
/**
 * Classe de banco de dados de usuários
 *
 * @author Daniel
 */
include_once 'DBModel.php';

class DBUsuario extends DBModel 
{
    
    protected $idusuario;
    protected $nome;
    protected $empresa;
    protected $telefone;
    protected $email;
    protected $login;
    protected $senha;
    protected $empresas_idempresas;
    protected $incidentes;
    protected $subperfil; // utilizado para determinar perfil supervisionado por supervidor(5)
    protected $arquivo_supervisor;
    protected $ativacao;
        
    
    
    // ---------------------------------------
    // -------- RELACIONAMENTOS --------------
    // ---------------------------------------
    protected $relacionamentos = array(
							    	'perfis',
							    	'empresas',
							    	'grupos'
							    	);
    
    
    
    protected $tabela   = 'usuarios';
    protected $prk      = 'idusuarios'; 
    protected $rel      = array(
    							'perfis',
    							'empresas'
    							);
    protected $fgk      = array(
    							'perfis_idperfis',
    							'empresas_idempresas'
    							);
    
    protected $camposForm = array(
        						'nome',
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
    							'ativacao'
    							);
    
    protected $cmpReq   = array(
    						'nome',
    						'empresa',
    						'funcao',
    						'login',
    						'senha',
    						'perfis_idperfis',
    						'empresas_idempresas'
    						);
    						
   	protected $cmpCheckBox = array(
   								'incidentes',
   								'arquivo_supervisor'
   								);
    
    public function  __construct()
    {
        parent::__construct();    
    }
   
    public function login($login, $senha)
    {
    	$senhaCriptografada = md5($senha);//criptografando para md5
    	
    	$sql = "SELECT * FROM usuarios WHERE login = '{$login}' AND senha = '{$senhaCriptografada}'";
    	$dados = $this->queryDados($sql);
    	return $dados;
    }
    
	public function create($form)
	{
        
        $str = 'INSERT INTO '.$this->tabela;
        $strCampos = array();
        $values = array();
        $erros['erros'] = array();
        
        foreach ($this->camposForm as $campo) 
        {
            //trata data para salvar no BD
             
         	if( array_key_exists($campo,$form)) 
         	{
				$form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
             
            	//trata check box
            	$form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
            	//fim
				
            	//CODIFICANDO MD5
	            if($campo == 'senha')
	            {
	            	$form[$campo] = md5($form[$campo]);
	            }
            	
	            $this->$campo  = $form[$campo];      
             	
            	if(in_array($campo, $this->cmpReq) && empty($this->$campo))
             	{ 
                	$erros['erros'][$campo] = "O campo <b>$campo</b> n�o pode estar em branco";
             	}
                
             	$values[]      = empty($this->$campo) ? 'NULL' :  "'{$this->$campo}'"; 
            	$strCampos[] = $campo;
	        }
	        else 
	       	{
	         	//trata, caso seja um checkbox
	            if(in_array($campo, $this->cmpCheckBox))
	            {
	            	$this->$campo = 0;
	            	$values[]      = empty($this->$campo) ? 'NULL' :  "'{$this->$campo}'"; 
	            	$strCampos[] = $campo;
	            }            
			}
        }
        
        if(count($erros['erros'])) 
        {
            return $erros;
        }
        
        $strCampos = implode(",",$strCampos);
        $values = implode(",",$values);
        $sql    = "$str($strCampos)VALUES($values)";
        
       	if($this->query($sql))
       	{
       		return mysql_insert_id($this->link);
       	}
       	else
		{
			return false;
       	}
    }
    
}

?>
