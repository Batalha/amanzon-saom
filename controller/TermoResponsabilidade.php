<?php

/* 
 * TODO: na apresentacao na view os botoes de aprovacao quando o 
 *     	 supervisor/noc enviam e atualiza o arquivo dinamicamente
 *     
 *     	 Obs.: fazer o mesmo para o RelatÃ³rio fotogrÃ¡fico
 */

interface TermoResponsabilidadeInterface
{
	public function view();
	
	public function upload();
	
	public function update();
}

class TermoResponsabilidade extends Controller implements TermoResponsabilidadeInterface
{
	protected $tplDir = 'termoresponsabilidade';
	protected $pastaDeTermoResponsabilidade = 'upload/termo_responsabilidade/';
	
	protected $extensoes_aceitas = array(
		'pdf'
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
		$this->smarty->assign('idinstalacao',$this->dadosP['idinstalacao']);
		$this->smarty->display("{$this->tplDir}/form_termo_responsabilidade.tpl");
	}
	public function upload()
	{

	    $buscaDaExtencao = explode('.',$this->dadosF['termo_responsabilidade']['name']);
		if( $this->validaExtensao( $buscaDaExtencao[1] ) === false )
			die("<div id='local_termo_responsabilidade_status' class='alert alert-error'>Arquivo de extensÃ£o nÃ£o vÃ¡lida.</div>");
		
    	$this->dadosF['termo_responsabilidade']['name'] = $this->normaliza_nome_termo( $buscaDaExtencao[0] ) . "." . $buscaDaExtencao[1];
    	if( $this->enviaServidor( $this->dadosF , $this->pastaDeTermoResponsabilidade ) )
    	{
    		$this->insereTermoDeResponsabilidade( $this->dadosF , $this->dadosP['id_instalacoes'] );
    		
    		$nome = explode( '.' , $this->dadosF['termo_responsabilidade']['name'] );

    		$arquivo = "<a id='arquivo_novo_termo_responsabilidade' target='_blank' href='upload/termo_responsabilidade/{$this->dadosF['termo_responsabilidade']['name']}'><i class='icon-file'></i><font style='color:#000;'>{$this->dadosF['termo_responsabilidade']['name']}</font></a>";
    		die($arquivo."<div id='local_termo_responsabilidade_status' class='alert alert-success'>Arquivo enviado com sucesso.</div>");
    	}
        else die("<div id='local_termo_responsabilidade_status' class='alert alert-error'>Erro ao enviar arquivo.</div>");
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
	
	/**
	 * Envia arquivo para o servidor
	 * 
	 * @param formulÃ¡rio {string}
	 * @param pasta {string}
	 */
	private function enviaServidor( $form , $pasta )
    {
    	if( !empty($form['termo_responsabilidade']) )
		{
			$move = move_uploaded_file( $form['termo_responsabilidade']['tmp_name'] , $pasta.$form['termo_responsabilidade']['name'] );
					
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
	 * Insere ou Atualiza o Termo de Responsabilidade no BD
	 * 
	 * @param Array $dadosF
	 * @param $id_instalacoes
	 */
	public function insereTermoDeResponsabilidade( $dadosF , $id_instalacoes )
	{
	    
		$dados = array();
		
		
		$dados['nome'] = $dadosF['termo_responsabilidade']['name'];
		$dados['endereco'] = $this->pastaDeTermoResponsabilidade;
		$dados['data_envio'] = date('Y-m-d H:i:s');
		$dados['status'] = 0;
		
		$this->TermoResponsabilidade->getTermoResponsabilidade( new Integer($id_instalacoes) ); // busca termo pre existente
		
		if( $this->TermoResponsabilidade->termo != false ) // havendo pre existÃªncia
		{
			if( $this->TermoResponsabilidade->updateTermoResponsabilidade( $dados , new Integer($this->TermoResponsabilidade->termo['id_termo_responsabilidade']) ) == false )
				die("<div id='local_termo_responsabilidade_status' class='alert alert-error'>Houve um erro ao atualizar no BD.</div>");
		}
		else // novo termo de responsabilidade
		{
			$dados['id_instalacoes'] = $id_instalacoes;
			
			if( $this->TermoResponsabilidade->insertTermoResponsabilidade( $dados ) == false )
				die("<div id='local_termo_responsabilidade_status' class='alert alert-error'>Houve um erro ao gravar no BD.</div>");
		}	
	}
	
	public function update()
	{
		// TODO: usuario aprova ou nao, e faz ou nÃ£o comentÃ¡rio
	}
	
	public function aprovar()
	{
		if( $this->TermoResponsabilidade->aprova( new Integer($this->dadosP['idTermo']) ) === true )
			die("<span class='alert alert-success' style='position: relative; float: left; margin-left: 35%; margin-top: 10px;'>Termo de Responsabilidade Aprovado com sucesso.</span>");
		else
			die("<span class='alert alert-error' style='position: relative; float: left; margin-left: 35%; margin-top: 10px;'>Erro ao aprovar Termo de Responsabilidade.</span>");
	}
	
	public function desaprovar()
	{
		$this->TermoResponsabilidade->getTermoResponsabilidade( new Integer($this->dadosP['idTermo']) );
		if( 
			$this->TermoResponsabilidade->desaprova( new Integer($this->dadosP['idTermo']) ) === true
			|| $this->TermoResponsabilidade->termo['status'] == 2 
		)
		{
			$this->TermoResponsabilidade->getTermoResponsabilidade( new Integer($this->dadosP['idTermo']) );
			
			$this->smarty->assign( 'termo' , $this->TermoResponsabilidade->termo );
			$this->smarty->display("{$this->tplDir}/formObservacao.tpl");
		}
		else
			die("<span class='alert alert-error'>Erro ao desaprovar Termo de Responsabilidade.</span>");
	}
	
	public function justificaDesaprovacao()
	{
		if( $this->TermoResponsabilidade->justificaDesaprovacao( new Integer($this->dadosP['id_termo_responsabilidade']) , $this->dadosP['comentario'] ) )
			die("<span class='alert alert-success' style='position: relative; float: left; margin-left: 20%; margin-top: 10px;'>Termo de Responsabilidade teve desaprovaÃ§Ã£o justificada com sucesso.</span>");
		else
			die("<span class='alert alert-error' style='position: relative; float: left; margin-left: 20%; margin-top: 10px;'>Erro ao justificar desaprovaÃ§Ã£o Termo de Responsabilidade.</span>");
	}
	
	/**
	 * Apaga o termo de responsabilidade
	 */
	public function apagarTermoDeResponsabilidade()
	{
		$id_termo_responsabilidade = $this->dadosP['id_termo_responsabilidade'];
		$arrReturn['msg'] = $id_termo_responsabilidade;
		die_json($arrReturn);
		
		$this->TermoResponsabilidade->getTermoResponsabilidade( new Integer($id_termo_responsabilidade) );
		
		$arquivo = $this->TermoResponsabilidade->termo['endereco'].$this->TermoResponsabilidade->termo['nome'];
		unset($arquivo);
		
		if( $this->TermoResponsabilidade->deleteTermoResponsabilidade( new Integer($this->TermoResponsabilidade->termo['id_termo_responsabilidade']) ) )
			die("<span class='alert alert-success'>Termo de Responsabilidade apagado com sucesso.</span>");
		else
			die("<span class='alert alert-error'>Erro ao apagar Termo de Responsabilidade.</span>");
	}
	
	/**
	 * Aplica botao para apagar termo de responsabilidade recÃ©m enviado
	 */
	public function btnApagarTermoDeResponsabilidade()
	{
		$id_instalacoes = $this->dadosP['id_instalacoes'];
		
		$this->smarty->assign('id_instalacoes',$id_instalacoes);
		$this->smarty->display("{$this->tplDir}/btn_apagar_termo_responsabilidade.tpl");
	}
	
	/**
	 * Apaga termo de responsabilidade pelo id_instalacoes
	 */
	public function apagarTermoDeResponsabilidadePeloIdInstalacoes()
	{
		$id_instalacoes = $this->dadosP['id_instalacoes'];

		
		if( $this->TermoResponsabilidade->deleteTermoResponsabilidadePeloIdInstalacao( new Integer($id_instalacoes) ) )
			die("<span class='alert alert-success'>Termo de Responsabilidade apagado com sucesso.</span>");
		else
			die("<span class='alert alert-error'>Erro ao apagar Termo de Responsabilidade.</span>");
	}
}