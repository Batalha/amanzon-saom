<?php

/**
 * Classe responsável por fazer a conexão ao banco
 *
 * @author Daniel
 */

//require_once realpath(dirname(__FILE__) . '/..') . '/helpers.php';
 require_once ('helpers.php');

class DBCon {
    
    protected $link;
    protected $infoBanco = array();
    protected $last_insert;
    
    private $server, $username, $password, $db;

    public function __construct()
    {
    	$infoBanco = $this->infosBanco();
    	switch(AMBIENTE)
    	{
    		case 'producao':
    			$this->server = $infoBanco['serverProducao'];
	        	$this->username = $infoBanco['usernameProducao'];
	        	$this->password = $infoBanco['passwordProducao'];
	        	$this->db = $infoBanco['dbProducao'];
    			break;
    		case 'homologacao':
    			$this->server = $infoBanco['serverHomologacao'];
	            $this->username = $infoBanco['usernameHomologacao'];
	            $this->password = $infoBanco['passwordHomologacao'];
	            $this->db = $infoBanco['dbHomologacao'];
    			break;
    		default:
    			$this->server = $infoBanco['serverProducao'];
	        	$this->username = $infoBanco['usernameProducao'];
	        	$this->password = $infoBanco['passwordProducao'];
	        	$this->db = $infoBanco['dbProducao'];
    			/*
    			$this->server = $infoBanco['serverHomologacao'];
	            $this->username = $infoBanco['usernameHomologacao'];
	            $this->password = $infoBanco['passwordHomologacao'];
	            $this->db = $infoBanco['dbHomologacao'];
	            */
    			break;
    	}
        
        $this->connect();
    }
    private function connect()	
    {
	$dbConfig   = new DbConfig();
	$this->link = new mysqli(
	    $dbConfig->host,
	    $dbConfig->username,
	    $dbConfig->password,
	    $dbConfig->dbname
	);
    	$this->link->set_charset($dbConfig->charset);
    }
    public function __sleep()
    {
    	mysqli_close($this->link);
    }
    public function __wakeup()
    {
    	$this->connect();
    }
    public function get_con()
    {
    	return $this->link;
    }
    public function query($sql)
    {

        //$sql = mysql_escape_string($sql);
        if (!$res  = $this->link->query($sql)) {
            $br   = '<br /><br />' . PHP_EOL . PHP_EOL;
            $msg  = 'Erro:'  . $br . $this->link->error . $br;
            $msg .= 'ERRNO:' . $br . $this->link->errno . $br;
            $msg .= 'SQL:'   . $br . $sql . $br;
            $msg .= 'Stack Trace:' . $br . $this->getTrace();
            reportarErro('Falha ao executar SQL', $msg);
            die('<script>alert("Desculpe, ocorreu um erro. Nossa equipe já foi alertada e corrigirá o erro assim que possível.")</script>');
        }
        $this->last_insert = $this->link->insert_id;
        $this->link->commit();
        return $res;
    }
    
    public function queryDados($sql = false) {
//        $sql = mysql_escape_string($sql);
//
//            echo die_json(!$res  = $this->link->query($sql));exit;
        if (!$res  = $this->link->query($sql)) {

            $br   = '<br /><br />' . PHP_EOL . PHP_EOL;
            $msg  = 'Erro:'  . $br . $this->link->error . $br;
            $msg .= 'ERRNO:' . $br . $this->link->errno . $br;
            $msg .= 'SQL:'   . $br . $sql . $br;
            $msg .= 'Stack Trace:' . $br . $this->getTrace();
            reportarErro('Falha ao executar SQL', $msg);
            die('<script>alert("Desculpe, ocorreu um erro. Nossa equipe já foi alertada e corrigirá o erro assim que possível.")</script>');
            //die('Desculpe, ocorreu um erro. Nossa equipe já foi alertada e corrigirá o erro assim que possível.');
        }
    	$rows = 0;
       	while($dados[] = $res->fetch_assoc()) {
        	$rows++;
        }
        unset($dados[$rows]);
        unset($sql);
        return $dados;
    }

    private function getTrace() {
        $tiposIncludes  = array(
            'include',
            'include_once',
            'require',
            'require_once'
        );

        $backtrace = '';
        foreach(debug_backtrace() as $k => $v) {
            if(in_array($v['function'], $tiposIncludes)) {
            $backtrace .= '#' . $k . ' ' . $v['function'];
            $backtrace .= '(' . $v['args'][0] . ') called at [';
            $backtrace .= $v['file'] . ':' . $v['line'] . ']' . PHP_EOL;
            } else {
            $backtrace .= '#' . $k . ' ' . $v['function'] . '() called at [';
            $backtrace .= $v['file'] . ':' . $v['line'] . ']' . PHP_EOL;
            }
        }
        return nl2br($backtrace);
    }
    
    public function getLastId()
    {
    	return $this->last_insert;
    	//return $this->link->insert_id;
    }
    
	/*
	 * Infos Banco
	 */
	public function infosBanco()
	{
		$this->infoBanco['serverProducao']   = "localhost";
		$this->infoBanco['usernameProducao'] = 'saom';
 		$this->infoBanco['passwordProducao'] = "-7>+:M*';62_F&h";
 		$this->infoBanco['dbProducao']       = 'saom';
		
		//local
		$this->infoBanco['serverHomologacao'] = "localhost";
		$this->infoBanco['usernameHomologacao'] = "saom";
		$this->infoBanco['passwordHomologacao'] = "saom";
		$this->infoBanco['dbHomologacao'] = "vodanet_online";
		//$this->infoBanco['dbHomologacao'] = "vodanet_producao";
		
		return $this->infoBanco;
	}
	
	public function autocommit( $mode )
	{
		$this->link->autocommit( $mode );
	}
	
	public function rollback()
	{
		$this->link->rollback();
	}

}

?>
