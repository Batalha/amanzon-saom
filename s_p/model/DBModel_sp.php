<?php


/**
 * Description of DBOS
 *
 * @author Daniel
 */
include_once 'helpers/DB.php';

class DBModel_sp extends DB {
    
    protected $fgk          = array();
    protected $cmpData      = array();
    protected $cmpCheckBox  = array();
    protected $cmpRadio		= array();
    protected $cmpImg       = array();
    protected $cmpReq       = array();
    protected $rel          = array();
    protected $depends      = array();
    protected $defaultOrder = "DESC";
    protected $orderBy      = '';
    protected $pag          = array();
    
    protected $where;
    protected $ascdesc;
    protected $select = '';
    protected $leftJoin = '';
    
    protected $sendMail = array();
    
	public function  __construct() 
    {
        parent::__construct();
//        $arrReturn['msg'] = $this->tabela;
//        die_json($arrReturn);

    }
    
    // ### SETS ###
    
	    public function setPag($pag)
	    {
	        $this->pag = $pag;
	    }
	    
	    public function setOrderBy($orderBy)
	    {
	        $this->orderBy = $orderBy;
	    }
	    
	    public function setWhere($where)
	    {
	    	$this->where = $where;
	    }
	    
		public function setASCDESC($asc_desc)
	    {
	    	$this->ascdesc = $asc_desc;
	    }
	    
	    public function setSelect($selectNovo)
	    {
	    	$this->select = $selectNovo;
	    }
	    
		public function setLeftJoin($noboLeftJoin)
    	{
    		$this->leftJoin = $noboLeftJoin;
    	}
	    
    // ### SETS - fim ###
    
	    
    // ### GETS ###
    
    	public function getTabela()
    	{
    		return $this->tabela;
    	}
    
		public function getSendMail()
	    {
	        return $this->sendMail;
	    }
	    
	    public function getSendMailEdit()
	    {
	    	return $this->sendMail;
	    }
	    
	    public function getPag()
	    {
	        return $this->pag;
	    }
	    public function getOrderBy()
	    {
	        return $this->orderBy;
	    }
	    
	    public function getDefaultOrder() 
	    {
	        return $this->defaultOrder;
	    }
	    
	    public function getWhere()
	    {
	    	return $this->where;
	    }
	    
	    public function getASCDESC()
	    {
	    	return $this->ascdesc;
	    }
	    
	    public function getSelect()
	    {
	    	return $this->select;
	    }
	    
		public function getLeftJoin()
    	{
    		return $this->leftJoin;
    	}
    	
	// ### GETS - fim ###
	

    public function setDefaultOrder($defaultOrder) 
    {
        $this->defaultOrder = $defaultOrder;
    }
    
    public function getPrkValue()
    {
        $prk = $this->prk;
        return $this->$prk;
    }
    
    public function setPrkValue($val)
    {

        $prk = $this->prk;
        $this->$prk = $val;
    }
    
    //metodo generico de insert
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

             
            	$this->$campo  = $form[$campo];
             
            	if(in_array($campo, $this->cmpReq) && empty($this->$campo)) 
            	{
                	$erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
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
                    $values[]      = empty($this->$campo) ? '0' :  "'{$this->$campo}'"; 
                	$strCampos[] = $campo;
                }            
            }
        }
        if(count($erros['erros'])){

        	return $erros;
        }
        
        $strCampos = implode(",",$strCampos);
        $values = implode(",",$values);
        $sql    = "$str($strCampos)VALUES($values)";
        //exit($sql);

        if($this->query($sql)) {
            return $this->getLastId();

        }else {
            return false;
        }
    }
    
    public function edit($form)
    {
        $str = 'UPDATE '.$this->tabela." SET ";
        $this->camposForm[] = $this->prk;
        $erros['erros'] = array();

//         $arrReturn['msg']     =  $this->prk;
//         die_json($arrReturn);
//        exit($sql);
        foreach ($this->camposForm as $campo) 
        {

            if( array_key_exists($campo,$form)) 
            {
                if(in_array($campo, $this->cmpReq) &&  $form[$campo] == '')
                {
                	$erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
                }
                

                //trata data para salvar no BD
                $form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
                //--

                //trata check box
                $form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
                //--
                
                $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$form[$campo]."'";
             
                $values[]       = "$campo = {$this->$campo}";
            }
            else if(in_array($campo, $this->cmpCheckBox)) //checkbox desmarcado (não vem no $form)
            {
            	$values[] = "$campo = 1";
            }
        }
        
        if(count($erros['erros'])) 
        {    
        	return $erros;
        }

        $where = " WHERE $this->prk = ".$this->getPrkValue();
        $values = implode(",",$values);
        $sql    = "$str $values $where";
//         $arrReturn['msg']     = $sql;
//         die_json($arrReturn);
//        exit($sql);
        
        
        return $this->query($sql);
    }
    
    
    public function edit_comiss($form, $teste)
    {

        $str = 'UPDATE '.$this->tabela." SET ";
        $this->camposForm[] = $this->prk;
        $erros['erros'] = array();

       	//print_b($form,true);
        foreach ($this->camposForm as $campo) 
        {
            if( array_key_exists($campo,$form)) 
            {
                $form[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($form[$campo]) : $form[$campo];
                //--
                
                //trata check box
                $form[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $form[$campo];
                //--
                
                $this->$campo  = empty($form[$campo]) ? 'NULL' : "'".$form[$campo]."'";
             
                $values[]       = "$campo = {$this->$campo}";
            }
            else if(in_array($campo, $this->cmpCheckBox)) //checkbox desmarcado (não vem no $form)
            {
            	$values[] = "$campo = 0";
            }
        }
        $where = " WHERE $this->prk = ".$this->getPrkValue();
        $values = implode(",",$values);
        $sql    = "$str $values $where";

        return $this->query($sql);
    }
    
    
    public function liste($filtro = 1)
    {



	    //filtro de '$filtro'
			if($filtro == 1)
				$filtro_sql = '';
			else
				$filtro_sql = 'WHERE '.$filtro;

		$this->orderBy = $this->orderBy ? $this->orderBy : $this->prk;

		//selects especificos
			if($this->select!='')
				$sql = "SELECT {$this->select} FROM {$this->tabela} $filtro_sql ORDER BY {$this->orderBy} {$this->defaultOrder}";
			else
				$sql = "SELECT * FROM {$this->tabela} $filtro_sql ORDER BY {$this->orderBy} {$this->defaultOrder}";

    	$sqlC = "SELECT COUNT(*) as total FROM {$this->tabela} $filtro_sql ORDER BY {$this->prk} {$this->defaultOrder}";
    	$dadosC = $this->queryDados($sqlC);
    	$sql = count($this->pag) ? $sql." LIMIT ".$this->pag['ini'].",".$this->pag['end']: $sql;

    	$dados = $this->queryDados($sql);


//

		for( $i=0; $i<count($dados); $i++)
       	{
        	$dados[$i] = $this->initObj($dados[$i]);
        	$dados[$i]['rel'] = $this->loadRel();

       	}
//        $arrReturn['msg'] = $dados ;
//        die_json($arrReturn);



//
       	if(count($this->pag))
       	{
			$dados['pag'] = array('total'=>$dadosC[0]['total'],'ini'=>$this->pag['ini'],'lim'=>$this->pag['end'],'rowspage'=>$this->pag['rowspage']);

       	}

        return $dados;
    }
    
	public function liste_total($filtro = 1)
    {

	    //filtro de '$filtro'
			if($filtro == 1)
			{
				$filtro_sql = '';
			}
			else
			{
				$filtro_sql = 'WHERE '.$filtro;
			}
			
		$this->orderBy = $this->orderBy ? $this->orderBy : $this->prk;
		
		//selects especificos
			if($this->select!='')
			{
				$sql = "SELECT {$this->select} FROM {$this->tabela} $filtro_sql ORDER BY {$this->orderBy} {$this->defaultOrder}";
			}
			else
			{
				$sql = "SELECT * FROM {$this->tabela} $filtro_sql ORDER BY {$this->orderBy} {$this->defaultOrder}";
			}
	//exit($sql);
			
    	$dados = $this->queryDados($sql);

		for( $i=0; $i<count($dados); $i++) 
       	{
        	$dados[$i] = $this->initObj($dados[$i]);
        	$dados[$i]['rel'] = $this->loadRel();

       	}
       	
       	//print_b($dados,true);
       	return $dados;
    }
    
    public function view()
	{


		$prk = $this->prk;
    	$value = $this->$prk;
    	$sql = "SELECT * FROM {$this->tabela} WHERE {$this->prk} = $value";

		$dados = $this->queryDados($sql);

    	if(isset($dados[0]))
    	{
    		$dados = $dados[0];
    	}


		//carrega dependências
		$dados = $this->initObj($dados);
       	$dados['rel'] = $this->loadRel();




       	return $dados;
    }
    
    //carrega os relacionamentos 
	public function loadRel()
	{
		$dadosRel = false;
    	//se houver relacionamentos




    	if (count($this->rel))
    	{
    		//percorre o array de relacionamentos

        	foreach($this->rel as $rel)
        	{

            	$fgkExist = false;
            	$fgkLoop;


            	foreach($this->fgk as $f)
            	{
                	//verifica se o relacionamento atual possui uma fgk
                    $a = strpos($f, $rel);

                	if(is_int($a))
                	{
                		if( $a >= 0)
                		{
                       		$fgkExist    = true;
                       		$fgkLoop     =   $f;

                   		}

                	}

                   	if($fgkExist)
                   	{
                   		break;
                   	}
               	}

               	$flag = false;


               	if (count($this->depends))
               	{
               		$dps = $this->depends;

                	$campoAtual;


                    foreach($dps as $dp)
                    {


                    	$campoAtual = $dp;
                    	$ifDps = strpos($dp, $rel);

                        if (is_int($ifDps))
                        {
                        	$flag = true;
                           	$prktmp = 'id'.$rel;

                           	$valDps = $this->$campoAtual;

                           	if($valDps >= 0) 
                           	{
								$sqlDps     = "SELECT * FROM {$rel} WHERE {$prktmp} = $valDps";

                            	$dadosDps   = $this->queryDados($sqlDps);
                               
                            	if($dadosDps)
                            	{
									$dadosRel[$campoAtual] =  $dadosDps[0];
                               	}
                           	}
                       	}
                   	}

               	}



              	if ( ! $fgkExist && ! $flag){

                	$tmp     =  $rel;
                	$fgk     = "{$this->tabela}_{$this->prk}";
                	$prk     = $this->prk;
                	$value   = $this->$prk;
                	$sql     = "SELECT * FROM {$rel} WHERE {$fgk} = $value";

                	$dados   = $this->queryDados($sql);
                	//echo $sql;
                	if ($dados)
                	{
                		$dadosRel["$rel"] =  $dados[0];
                	}

               	}else if($fgkExist && ! $flag){
                	$tmp     = $rel."_";

                	$prk     = str_replace($tmp, "", $fgkLoop);
					$value   = $this->$fgkLoop;

                	$sql     = "SELECT * FROM {$rel} WHERE {$prk} = $value";
                	$dados   = $this->queryDados($sql);

                	if ($dados)
                	{
                    	$dadosRel["$rel"] =  $dados[0];
                	}
               	}

            }


         	return $dadosRel;
      	}
      	else
	  	{	
			return false;
	  	}
	}
    
    public function initObj($dados)
    {
        $allCampos      = $this->camposForm;
        $allCampos[]    = $this->prk;
        foreach ($allCampos as $campo)
        {
			if(isset($dados[$campo]))
			{
            	$dados[$campo] = in_array($campo, $this->cmpData) ? $this->bdToData($dados[$campo]) : $dados[$campo];
			}
            $this->$campo = empty($dados[$campo]) ? 'NULL' : "{$dados[$campo]}";
        }


        return $dados;
    }
    
    public function dataToBD($data) 
    {
        if( ! empty($data))  
        {
//             $data = str_replace("/",$data);
         $data = explode("/",$data);
         $data = $data[2]."-".$data[1]."-".$data[0];
           
        }
        return $data;
    }
    
    
    public function bdToData($data) 
    {
        if( ! empty($data))  
        {
            $data = explode("-",$data);
            $data = $data[2]."/".$data[1]."/".$data[0];
        }
        return $data;
    }
    
    //upload com pasta padrao de instalacoes
    //TODO: APLICAR CASO DE USO BASEADO NO SUCESSO DE ENVIO DE UPLOAD
    public function uploadImg($form)
    {
    	$str = 'UPDATE '.$this->tabela." SET ";
        
    	//trata imagens
      	foreach($form as $campo => $val) 
      	{
        	if(in_array($campo,$this->cmpImg))
        	{
				if( ! empty($form[$campo]))
				{
					$move = move_uploaded_file($form[$campo]['tmp_name'], 'public/imagens/instalacoes/'.$form[$campo]['name']);
					
					if ( $move )
                    	$values = "$campo = 'public/imagens/instalacoes/".$form[$campo]['name']."'";
            	}   
        	}
      	}  
        //--
        
      	$where = " WHERE $this->prk = ".$this->getPrkValue();
      	$sql    = "$str $values $where";
      	return $this->query($sql);
    }   
    
}

?>
