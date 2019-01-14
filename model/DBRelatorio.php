<?php

class DBRelatorio extends DBModel
{
	
	//campos
	protected $idrelatorios;
	protected $nome;
	protected $endereco;
	
	//em array
	protected $dadosCarregados = array();
	
	//padrao
	//protected $tabela = 'relatorio';
    protected $rel    = array();
    protected $fgk    = array();
    //protected $prk    = 'idrelatorios';//primary key
    //protected $cmpData= array('inicio_tarefa','final_tarefa');
    //protected $cmpReq = array('nome','endereco');
    
    protected $camposForm = array(
    							'idrelatorios',
    							'nome',
    							'endereco'
    							);
    
   	
	
}