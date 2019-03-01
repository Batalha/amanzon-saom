<?php

/* 
 * TODO: na apresentacao na view os botoes de aprovacao quando o 
 *     	 supervisor/noc enviam e atualiza o arquivo dinamicamente
 *     
 *     	 Obs.: fazer o mesmo para o RelatÃ³rio fotogrÃ¡fico
 */

//    echo die_json('teste');
interface AtendArquivoInterface
{
	public function view();

	public function upload();

	public function update();
}

class AtendArquivo_sp extends Controller implements AtendArquivoInterface
{
	protected $tplDir = 's_p/tampletes/atendarquivo';
	protected $pastaDeAtendArquivo = 'upload/atend_arquivo_sp/';
	
	protected $extensoes_aceitas = array(
		'pdf','jpeg','png','jpg','rar','doc','docx','xls','xlsx','zip','msg','txt','ppp','pppx',
		'PDF','JPEG','PNG','JPG','RAR','DOC','DOCX','XLS','XLSX','ZIP','MSG','TXT','PPP','PPPX'
	);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function view()
	{
		
	}
	
	/**
	 * uploadform & upload - trata do upload do Termo
	 */
	public function uploadForm()
	{

		$this->smarty->assign('idatend_vsat',$this->dadosP['idatend_vsat']);
		$this->smarty->display("{$this->tplDir}/form_atend_arquivo.tpl");
	}

	public function upload()
	{

        $numfile = count(array_filter($this->dadosF['atend_arquivo']['name']));
        if(!$numfile)
            die("<div id='local_atend_arquivo_status' class='alert alert-error' align='center' style='margin-bottom: -5px; width: 60%;'>Selecione um Arquivo.</div>");



        for($i=0; $i<$numfile; $i++){
            $nome = $this->dadosF['atend_arquivo']['name'][$i];
            $buscaDaExtencao = explode('.',$nome);
            if( $this->validaExtensao( $buscaDaExtencao[1] ) === false ){
                die("<div id='local_atend_arquivo_status' class='alert alert-error'>Arquivo de extensao nao valida.</div>");

            }

            $nome = $this->normaliza_nome_termo( $buscaDaExtencao[0] ) . "." . $buscaDaExtencao[1];

            $enviaServer = move_uploaded_file( $this->dadosF['atend_arquivo']['tmp_name'][$i] , $this->pastaDeAtendArquivo.$nome );
            if($enviaServer){

                $dadosAtend = Array();
                $dadosAtend['atend_arquivo']['name'] = $nome;
                $dadosAtend['atend_arquivo']['type'] = $this->dadosF['atend_arquivo']['type'][$i];
                $dadosAtend['atend_arquivo']['tmp_name'] = $this->dadosF['atend_arquivo']['tmp_name'][$i];
                $dadosAtend['atend_arquivo']['error'] = $this->dadosF['atend_arquivo']['error'][$i];
                $dadosAtend['atend_arquivo']['size'] = $this->dadosF['atend_arquivo']['size'][$i];


                $this->insereAtendArquivo( $dadosAtend , $this->dadosP['id_atendimento'] );

            }

        }
        die("<div id='local_atend_arquivo_status' class='alert alert-success'>Arquivo enviado com sucesso.</div>");

	}
	
	/**
	 * FunÃ§Ã£o que normaliza o nome do Termo de Responsabilidade
	 * @param $nome
	 */
	private function normaliza_nome_termo( $nome )
	{
		$nome = str_replace( " " , "_" , $nome );
		$nome = str_replace( "-" , "_" , $nome );
		$nome = strtr( $nome , 'Ã€Ã�ÃƒÃ‚Ã‰ÃŠÃ�Ã“Ã•Ã”ÃšÃœÃ‡Ã Ã¡Ã£Ã¢Ã©ÃªÃ­Ã³ÃµÃ´ÃºÃ¼Ã§' , 'AAAAEEIOOOUUCaaaaeeiooouuc' );
		$nome = strtolower( $nome );
		return $nome;
	}
	private function validaExtensao( $extensao )
	{
//            var_dump($extensao);
		if( in_array( $extensao , $this->extensoes_aceitas ) ){
                return true;

        }
		else{

			return false;
        }

	}

	public function insereAtendArquivo( $dadosF , $id_atendimento )
	{
		$dados = array();
    	$dados['nome'] = $dadosF['atend_arquivo']['name'];
		$dados['endereco'] = $this->pastaDeAtendArquivo;
		$dados['data_envio'] = date('Y-m-d H:i:s');
		$dados['status'] = 0;
        $dados['atendente'] = $_SESSION['login']['nome'];

		$dados['id_atendimento'] = $id_atendimento;

			if( $this->AtendArquivo_sp->insertAtendArquivo( $dados ) == false )
				die("<div id='local_atend_arquivo_status' class='alert alert-error'>Houve um erro ao gravar no BD.</div>");
	}
//
	public function update()
	{
		// TODO: usuario aprova ou nao, e faz ou nÃ£o comentÃ¡rio
	}

}