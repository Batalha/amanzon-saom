<?php

include_once 's_p/model/DBModel_sp.php';
// include_once "model/DBPerguntasComissionamento.php";
// include_once "model/PerguntasComissionamentoModel.php";

class PerguntasComissionamento_spBO extends DBModel_sp//PerguntasComissionamentoModel////
{
    
    protected $id_perguntas_comissionamento;
    protected $id_instalacoes;
//    protected $test_notificacao_inicio;
    protected $test_f_termo_aceite;
    protected $test_info_rx_tx;
//    protected $test_prtg;
    protected $test_clima;
    protected $test_cabo;
    protected $test_calibrate;
    protected $test_tx;
    protected $test_buc;
    protected $test_antena;
    protected $test_software;
    protected $autocomiss;
    protected $test_sl2000;
    protected $conectores_crimpados;
    protected $conectores_odu_isolados;
    protected $antena_travada;
    protected $confirmacao_endereco_instalacao;
    
    protected $perguntasArray;
    
    protected $tabela = 'perguntas_comissionamento_sp';
    protected $prk    = 'id_perguntas_comissionamento';
    
    protected $camposForm = array(
                                'id_perguntas_comissionamento',
                                'id_instalacoes',
//                                'test_notificacao_inicio',
                                'test_f_termo_aceite',
                                'test_info_rx_tx',
//                                'test_prtg',
                                'test_clima',
                                'test_cabo',
                                'test_calibrate',
                                'test_tx',
                                'test_buc',
                                'test_antena',
                                'test_software',
                                'autocomiss',
                                'test_sl2000',
                                'conectores_crimpados',
                                'conectores_odu_isolados',
                                'antena_travada',
                                'confirmacao_endereco_instalacao',
    );
    
    public function __construct()
    {
        
        parent::__construct();
   
//         $this->DBPerguntasComissiona = new DBPerguntasComissionamento();
        // 		$this->UsuariosBO =  new UsuariosBO( $adapter );
    }
	
	public function getPerguntasComissionamentoPelaInstalacao( $idinstalacao )
	{
		$where = " id_instalacoes = '{$idinstalacao}' ";
		
// 		$listaPerguntas = $this->fetchAll( $where );
		$listaPerguntas = $this->liste_total( $where );
		
//         $arrReturn['msg']     =count($listaPerguntas) > 0;
//         die_json($arrReturn);
		
		if( count($listaPerguntas) > 0 ){

			$this->perguntasArray = $listaPerguntas;//$listaPerguntas->toArray();
		}else
			$this->perguntasArray = array();
	}
	
	public function atualizaPerguntasPelaInstalacao( $formPerguntasComissionamento )
	{
	    
// 		$where = " id_instalacoes = '{$formPerguntasComissionamento['id_instalacoes']}' ";
		
		$this->setPrkValue($formPerguntasComissionamento['id_instalacoes']);
		
		
		unset($formPerguntasComissionamento['id_instalacoes']);
		
		$formPerguntasComissionamento = $this->converteOnEmNumerico( $formPerguntasComissionamento );

// 		if( $this->edit( $formPerguntasComissionamento, $where)  ) 
    
		$str = 'UPDATE '.$this->tabela." SET ";
		$this->camposForm[] = $this->prk;
		$erros['erros'] = array();
		
		//print_b($form,true);
		foreach ($this->camposForm as $campo)
		{
		    
		
		    if( array_key_exists($campo,$formPerguntasComissionamento))
		    {
		        //                 if(in_array($campo, $this->cmpReq) &&  $form[$campo] == '')
		            //                 {
		            //                 	$erros['erros'][$campo] = "O campo <b>$campo</b> não pode estar em branco";
		            //                 }
		
		        //trata data para salvar no BD
		        $formPerguntasComissionamento[$campo]  = in_array($campo, $this->cmpData) ? $this->dataToBD($formPerguntasComissionamento[$campo]) : $formPerguntasComissionamento[$campo];
		        //--
		
		        //trata check box
		        $formPerguntasComissionamento[$campo]  = in_array($campo, $this->cmpCheckBox) ? '1' : $formPerguntasComissionamento[$campo];
		        //--
		
		        $this->$campo  = empty($formPerguntasComissionamento[$campo]) ? '0' : "'".$formPerguntasComissionamento[$campo]."'";
		         
		        $values[]       = "$campo = {$this->$campo}";
		    }
		    else if(in_array($campo, $this->cmpCheckBox)) //checkbox desmarcado (não vem no $form)
		    {
		        $values[] = "$campo = 0";
		    }
		}
		
		//         if(count($erros['erros']))
		    //         {
		    //         	return $erros;
		    //         }
		
		$where = " WHERE id_instalacoes = ".$this->getPrkValue();
// 		            $arrReturn['msg']     =$where;
// 		            die_json($arrReturn);
		$values = implode(",",$values);
		$sql    = "$str $values $where";

		//exit($sql);
		
		
		$retornoPerguntaComiss =  $this->query($sql);
    
		
		if( $retornoPerguntaComiss ) 
		    return true;
		else 
		    return false;
	}
	
	private function converteOnEmNumerico( $formPerguntasComissionamento )
	{
		foreach ( $formPerguntasComissionamento as $chave => $item )
			if( $chave != 'confirmacao_endereco_instalacao' )
			{
				if( $item )
				     $formPerguntasComissionamento[ $chave ] = 1;
				else 
				    $formPerguntasComissionamento[ $chave ] = 0;
			}
		
		return $formPerguntasComissionamento;
	}
	
	public function getperguntasArray()
	{

	  		return $this->perguntasArray;
	}
	
	public function getPerguntasComissionamento()
	{
	  		if( empty($this->idos) )
	  		    return "Id das Perguntas não declarado.";
	
	  		$where = " id_perguntas_comissionamento = '{$this->id_perguntas_comissionamento}' ";
// 	  		$os = $this->fetchAll( $this->select()->where( $where ) );
	  		$os = $this->liste( $this->select()->where( $where ) );
	
	  		if( count($os) > 0 )
	  		{
	  		    $linha = $os->toArray();
	  		    $this->perguntasArray = $linha[0];
	  		    foreach ( $linha[0] as $chave => $atributo )
	  		    {
	  		        if( $chave != 'id_perguntas_comissionamento' )
	  		            $this->{"set".$chave}( $atributo );
	  		    }
	  		}
	}
	 
}