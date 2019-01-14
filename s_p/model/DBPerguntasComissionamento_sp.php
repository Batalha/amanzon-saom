<?php

include_once 's_p/model/DBModel_sp.php';

class DBPerguntasComissionamento_sp extends DBModel_sp{
    
    
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
    
    

    
//     //SETS
//     public function setIdinstalacoes($idinstalacoesnovo)
//     {
//         $this->idinstalacoes = $idinstalacoesnovo;
//     }
//     //SETS - fim
    
//     //GETS
//     public function getIdinstalacoes()
//     {
//         return $this->idinstalacoes;
//     }
//     public function getTabela()
//     {
//         return $this->tabela;
//     }
//     //GETS - fim
    
    
//     public function  __construct()    {
//         parent::__construct();
//     }   
    
//     public function getperguntasArray()
//     {
//       		return $this->perguntasArray;
//     }
     
//     public function getPerguntasComissionamento()
//     {
//       		if( empty($this->idos) )
//       		    return "Id das Perguntas não declarado.";
    
//       		$where = " id_perguntas_comissionamento = '{$this->id_perguntas_comissionamento}' ";
//       		$os = $this->fetchAll( $this->select()->where( $where ) );
    
//       		if( count($os) > 0 )
//       		{
//       		    $linha = $os->toArray();
//       		    $this->perguntasArray = $linha[0];
//       		    foreach ( $linha[0] as $chave => $atributo )
//       		    {
//       		        if( $chave != 'id_perguntas_comissionamento' )
//       		            $this->{"set".$chave}( $atributo );
//       		    }
//       		}
//     }   
    
    
//     public function carrega($idInstalacao)
//     {
//         $sql = "SELECT * FROM {$this->tabela} WHERE {$this->prk} = '{$idInstalacao}' ";
//         $dados = $this->queryDados($sql);
//         return $dados[0];
//     }  
    
    
}

?>