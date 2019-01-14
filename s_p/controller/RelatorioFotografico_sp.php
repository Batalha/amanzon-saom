<?php

interface RelatorioFotograficoInterface
{
	public function view();
	
	public function upload();
	
	public function update();
}

class RelatorioFotografico_sp extends Controller implements RelatorioFotograficoInterface
{
	protected $tplDir = 's_p/tampletes/relatoriofotografico';
	
	protected $pastaDeRelatorioFotografico = 'upload/relatorio_fotografico_sp/';
	
	protected $extensoes_aceitas = array(
		'pdf', 'doc'
	);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function view()
	{
		
	}
	
	/**
	 * uploadform & upload - trata do upload do Relatório
	 */
	public function uploadForm()
	{
		$this->smarty->assign('idinstalacao',$this->dadosP['idinstalacao']);
		$this->smarty->display("{$this->tplDir}/form_relatorio_fotografico.tpl");
	}
	public function upload()
	{
	    
		$buscaDaExtencao = explode('.',$this->dadosF['relatorio_fotografico']['name']);
		

		
		if( $this->validaExtensao( $buscaDaExtencao[1] ) === false )
			die("<div id='local_relatorio_fotografico_status' class='alert alert-error'>Arquivo de extensão não válida.</div>");
		
    	$this->dadosF['relatorio_fotografico']['name'] = $this->normaliza_nome_relatorio( $buscaDaExtencao[0] ) . "." . $buscaDaExtencao[1];
    	if( $this->enviaServidor( $this->dadosF , $this->pastaDeRelatorioFotografico ) )
    	{

    		$this->insereRelatorioFotografico( $this->dadosF , $this->dadosP['id_instalacoes'] );
    		
    		$nome = explode( '.' , $this->dadosF['relatorio_fotografico']['name'] );
 		
    		$arquivo = "<a id='arquivo_novo_relatorio_fotografico' target='_blank' href='upload/relatorio_fotografico_sp/{$this->dadosF['relatorio_fotografico']['name']}'><i class='icon-file'></i><font style='color:#000;'>{$this->dadosF['relatorio_fotografico']['name']}</font></a>";
    		die($arquivo."<div id='local_relatorio_fotografico_status' class='alert alert-success'>Arquivo enviado com sucesso.</div>");
    	}
        else die("<div id='local_relatorio_fotografico_status' class='alert alert-error'>Erro ao enviar arquivo.</div>");
	}
	
	/**
	 * Função que normaliza o nome do Relatorio Fotografico
	 * @param $nome
	 */
	private function normaliza_nome_relatorio( $nome )
	{
		$nome = str_replace( " " , "_" , $nome );
		$nome = str_replace( "-" , "_" , $nome );
		$nome = strtr( $nome , 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç' , 'AAAAEEIOOOUUCaaaaeeiooouuc' );
		$nome = strtolower( $nome );
		return $nome;
	}
	
	/**
	 * Envia arquivo para o servidor
	 * 
	 * @param formulário {string}
	 * @param pasta {string}
	 */
	private function enviaServidor( $form , $pasta )
    {
    	if( !empty($form['relatorio_fotografico']) )
		{
			$move = move_uploaded_file( $form['relatorio_fotografico']['tmp_name'] , $pasta.$form['relatorio_fotografico']['name'] );
					
			if ( $move ) return true;
			else return false;
        }
        else return false;
    }
	
	private function validaExtensao( $extensao )
	{
		if( in_array( $extensao , $this->extensoes_aceitas ) )
			return true;
		else
			return false;
	}
	
	/**
	 * Insere ou Atualiza o Relatorio Fotografico no BD
	 * 
	 * @param Array $dadosF
	 * @param $id_instalacoes
	 */
	public function insereRelatorioFotografico( $dadosF , $id_instalacoes )
	{
		$dados = array();
		$dados['nome'] = $dadosF['relatorio_fotografico']['name'];
		$dados['endereco'] = $this->pastaDeRelatorioFotografico;
		$dados['data_envio'] = date('Y-m-d H:i:s');
		$dados['status'] = 0;
		
		$this->RelatorioFotografico_sp->getRelatorioFotografico( new Integer($id_instalacoes) ); // busca relatorio pre existente

		if( $this->RelatorioFotografico_sp->relatorio != false ) // havendo pre existência
		{
			if( $this->RelatorioFotografico_sp->updateRelatorioFotografico( $dados , new Integer($this->RelatorioFotografico_sp->relatorio['id_relatorio_fotografico']) ) == false )
				die("<div id='local_relatorio_fotografico_status' class='alert alert-error'>Houve um erro ao atualizar no BD.</div>");
		}
		else // novo relatorio fotografico
		{
			$dados['id_instalacoes'] = $id_instalacoes;
			
			if( $this->RelatorioFotografico_sp->insertRelatorioFotografico( $dados ) == false )
				die("<div id='local_relatorio_fotografico_status' class='alert alert-error'>Houve um erro ao gravar no BD.</div>");
		}	
	}
	
	public function update()
	{
		// TODO: usuario aprova ou nao, e faz ou não comentário
	}
	
	public function aprovar()
	{
		if( $this->RelatorioFotografico_sp->aprova( new Integer($this->dadosP['idRelatorio']) ) === true )
			die("<span class='alert alert-success' style='position: relative; float: left; margin-left: 35%; margin-top: 10px;'>Relatório Fotográfico Aprovado com sucesso.</span>");
		else
			die("<span class='alert alert-error' style='position: relative; float: left; margin-left: 35%; margin-top: 10px;'>Erro ao aprovar Relatório Fotográfico.</span>");
	}
	
	public function desaprovar()
	{
		$this->RelatorioFotografico_sp->getRelatorioFotografico( new Integer($this->dadosP['idRelatorio']) );
		if( 
			$this->RelatorioFotografico_sp->desaprova( new Integer($this->dadosP['idRelatorio']) ) === true
			|| $this->RelatorioFotografico_sp->relatorio['status'] == 2
		)
		{
			$this->RelatorioFotografico_sp->getRelatorioFotografico( new Integer($this->dadosP['idRelatorio']) );
			
			$this->smarty->assign( 'relatorio' , $this->RelatorioFotografico_sp->relatorio );
			$this->smarty->display("{$this->tplDir}/formObservacao.tpl");
		}
		else
			die("<span class='alert alert-error'>Erro ao desaprovar Relatório Fotográfico.</span>");
	}
	
	public function justificaDesaprovacao()
	{
		if( $this->RelatorioFotografico_sp->justificaDesaprovacao( new Integer($this->dadosP['id_relatorio_fotografico']) , $this->dadosP['comentario'] ) )
			die("<span class='alert alert-success' style='position: relative; float: left; margin-left: 20%; margin-top: 10px;'>Relatório Fotográfico teve desaprovação justificada com sucesso.</span>");
		else
			die("<span class='alert alert-error' style='position: relative; float: left; margin-left: 20%; margin-top: 10px;'>Erro ao justificar desaprovação Relatório Fotográfico.</span>");
	}
	
	/**
	 * Apaga o relatorio fotografico
	 */
	public function apagarRelatorioFotografico()
	{
		$id_relatorio_fotografico = $this->dadosP['id_relatorio_fotografico'];
		
		$this->RelatorioFotografico_sp->getRelatorioFotografico( new Integer($id_relatorio_fotografico) );
		
		$arquivo = $this->RelatorioFotografico_sp->relatorio['endereco'].$this->RelatorioFotografico_sp->relatorio['nome'];
		unset($arquivo);
		
		if( $this->RelatorioFotografico_sp->deleteRelatorioFotografico( new Integer($this->RelatorioFotografico_sp->relatorio['id_relatorio_fotografico']) ) )
			die("<span class='alert alert-success'>Relatorio Fotográfico apagado com sucesso.</span>");
		else
			die("<span class='alert alert-error'>Erro ao apagar Relatório Fotográfico.</span>");
	}
	
	/**
	 * Aplica botao para apagar relatorio fotografico recém enviado
	 */
	public function btnApagarRelatorioFotografico()
	{
		$id_instalacoes = $this->dadosP['id_instalacoes'];
		
		$this->smarty->assign('id_instalacoes',$id_instalacoes);
		$this->smarty->display("{$this->tplDir}/btn_apagar_relatorio_fotografico.tpl");
	}
	
	/**
	 * Apaga relatorio fotografico pelo id_instalacoes
	 */
	public function apagarRelatorioFotograficoPeloIdInstalacoes()
	{
		$id_instalacoes = $this->dadosP['id_instalacoes'];
		
		if( $this->RelatorioFotografico_sp->deleteRelatorioFotograficoPeloIdInstalacao( new Integer($id_instalacoes) ) )
			die("<span class='alert alert-success'>Relatório Fotográfico apagado com sucesso.</span>");
		else
			die("<span class='alert alert-error'>Erro ao apagar Relatório Fotográfico.</span>");
	}
	
}