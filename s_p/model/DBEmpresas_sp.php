<?php

include_once "s_p/model/DBModel_sp.php";

class DBEmpresas_sp extends DBModel_sp
{
	protected $idempresas;
    protected $empresa;
    protected $local;
    protected $tipo;
    protected $funcionario;

    protected $tabela = 'empresas';
    protected $prk = 'idempresas';
    
    protected $where;
    
    protected $camposForm = array(
        						'empresa',
                                'local',
                                'tipo',

                                'contatoFaturamento',
                                'cnpjFaturamento',
                                'enderecoFaturamento',
                                'paisFaturamento',
                                'cidadeFaturamento',
                                'estadoFaturamento',
                                'cepFaturamento',
                                'emailFaturamento'

    							);
    
    protected $cmpReq   = array(
    						'empresa',
                            'local',
                            'tipo',

							'contatoFaturamento',
							'cnpjFaturamento',
							'enderecoFaturamento',
							'paisFaturamento',
							'cidadeFaturamento',
							'estadoFaturamento',
							'cepFaturamento',
							'emailFaturamento'
    						);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function listaEmpresas()
	{
		$this->where = '*';
		
		$sql = "SELECT {$this->where} FROM {$this->tabela} ORDER BY empresa ASC ";
		return $this->queryDados($sql);
	}
	
}