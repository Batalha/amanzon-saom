<?php

/* 
 * TODO: na apresentacao na view os botoes de aprovacao quando o 
 *     	 supervisor/noc enviam e atualiza o arquivo dinamicamente
 *     
 *     	 Obs.: fazer o mesmo para o Relatório fotográfico
 */

interface ContratoSPInterface
{
	public function view();
	
	public function upload();
	
	public function update();
}

class ContratoSP extends Controller implements ContratoSPInterface
{
	protected $tplDir = 's_p/tampletes/contratosp';
	protected $pastaContratoSP = 'upload/contrato_sp/';
	
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
// 				$arrReturn['msg'] = $this->dadosP['idpedido_os'];
// 				die_json($arrReturn);
		$this->smarty->assign('idpedido_os',$this->dadosP['idpedido_os']);
		$this->smarty->display("{$this->tplDir}/form_contrato_sp.tpl");
	}
	public function upload()
	{
		$buscaDaExtencao = explode('.',$this->dadosF['contrato']['name']);
		if( $this->validaExtensao( $buscaDaExtencao[1] ) === false )
			die("<div id='local_contrato_sp_status' class='alert alert-error'>Arquivo de extensão não válida.</div>");
		
    	$this->dadosF['contrato']['name'] = $this->normaliza_nome_termo( $buscaDaExtencao[0] ) . "." . $buscaDaExtencao[1];

    	if( $this->enviaServidor( $this->dadosF , $this->pastaContratoSP ) )
    	{

    		$this->insereContratoSP( $this->dadosF , $this->dadosP['contrato_idpedido_os'] );
    		
    		$nome = explode( '.' , $this->dadosF['contrato']['name'] );

    		$arquivo = "<a id='arquivo_novo_contrato' target='_blank' href='upload/contrato_sp/{$this->dadosF['contrato']['name']}'><i class='icon-file'></i><font style='color:#000;'>{$this->dadosF['contrato']['name']}</font></a>";
    		die($arquivo."<div id='local_contrato_sp_status' class='alert alert-success'>Arquivo enviado com sucesso.</div>");
    	}
        else die("<div id='local_contrato_sp_status' class='alert alert-error'>Erro ao enviar arquivo.</div>");
	}
	
	/**
	 * Função que normaliza o nome do Termo de Responsabilidade
	 * @param $nome
	 */
	private function normaliza_nome_termo( $nome )
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
    	if( !empty($form['contrato']) )
		{
			$move = move_uploaded_file( $form['contrato']['tmp_name'] , $pasta.$form['contrato']['name'] );
					
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
	 * @param $idpedido_os
	 */
	public function insereContratoSP( $dadosF , $idpedido_os )
	{
		
		$dados = array();
		
		
		$dados['nome'] = $dadosF['contrato']['name'];
		$dados['endereco'] = $this->pastaContratoSP;
		$dados['data_envio'] = date('Y-m-d H:i:s');
// 		$dados['status'] = 0;

		$this->ContratoSP->getContratoSP( new Integer($idpedido_os) ); // busca termo pre existente
		
		if( $this->ContratoSP->termo != false ) // havendo pre existência
		{
			if( $this->ContratoSP->updateContratoSP( $dados , new Integer($this->ContratoSP->termo['id_contrato_sp']) ) == false )
				die("<div id='local_contrato_sp_status' class='alert alert-error'>Houve um erro ao atualizar no BD.</div>");
		}
		else // novo termo de responsabilidade
		{
			$dados['contrato_idpedido_os'] = $idpedido_os;
			
			if( $this->ContratoSP->insertContratoSP( $dados ) == false )
				die("<div id='local_contrato_sp_status' class='alert alert-error'>Houve um erro ao gravar no BD.</div>");
		}	
	}
	
	public function update()
	{
		// TODO: usuario aprova ou nao, e faz ou não comentário
	}
	
// 	public function aprovar()
// 	{
// 		if( $this->TermoResponsabilidade->aprova( new Integer($this->dadosP['idTermo']) ) === true )
// 			die("<span class='alert alert-success' style='position: relative; float: left; margin-left: 35%; margin-top: 10px;'>Termo de Responsabilidade Aprovado com sucesso.</span>");
// 		else
// 			die("<span class='alert alert-error' style='position: relative; float: left; margin-left: 35%; margin-top: 10px;'>Erro ao aprovar Termo de Responsabilidade.</span>");
// 	}
	
// 	public function desaprovar()
// 	{
// 		$this->TermoResponsabilidade->getTermoResponsabilidade( new Integer($this->dadosP['idTermo']) );
// 		if( 
// 			$this->TermoResponsabilidade->desaprova( new Integer($this->dadosP['idTermo']) ) === true
// 			|| $this->TermoResponsabilidade->termo['status'] == 2 
// 		)
// 		{
// 			$this->TermoResponsabilidade->getTermoResponsabilidade( new Integer($this->dadosP['idTermo']) );
			
// 			$this->smarty->assign( 'termo' , $this->TermoResponsabilidade->termo );
// 			$this->smarty->display("{$this->tplDir}/formObservacao.tpl");
// 		}
// 		else
// 			die("<span class='alert alert-error'>Erro ao desaprovar Termo de Responsabilidade.</span>");
// 	}
	
// 	public function justificaDesaprovacao()
// 	{
// 		if( $this->TermoResponsabilidade->justificaDesaprovacao( new Integer($this->dadosP['id_termo_responsabilidade']) , $this->dadosP['comentario'] ) )
// 			die("<span class='alert alert-success' style='position: relative; float: left; margin-left: 20%; margin-top: 10px;'>Termo de Responsabilidade teve desaprovação justificada com sucesso.</span>");
// 		else
// 			die("<span class='alert alert-error' style='position: relative; float: left; margin-left: 20%; margin-top: 10px;'>Erro ao justificar desaprovação Termo de Responsabilidade.</span>");
// 	}
	
	/**
	 * Apaga o termo de responsabilidade
	 */
	public function apagarContratoSP()
	{
		$id_contrato_sp = $this->dadosP['id_contrato_sp'];
		
		$this->ContratoSP->getContratoSP( new Integer($id_contrato_sp) );
		
		$arquivo = $this->ContratoSP->termo['endereco'].$this->ContratoSP->termo['nome'];
		unset($arquivo);
		
		if( $this->ContratoSP->deleteContratoSP( new Integer($this->ContratoSP->termo['id_contrato_sp']) ) )
			die("<span class='alert alert-success'>Contrato apagado com sucesso.</span>");
		else
			die("<span class='alert alert-error'>Erro ao apagar Contrato.</span>");
	}
	
	/**
	 * Aplica botao para apagar termo de responsabilidade recém enviado
	 */
	public function btnApagarContratoSP()
	{
		$contrato_idpedido_os = $this->dadosP['contrato_idpedido_os'];

		
		
		$this->smarty->assign('contrato_idpedido_os', $contrato_idpedido_os);
		$this->smarty->display("{$this->tplDir}/btn_apagar_contrato_sp.tpl");
	}
	
	/**
	 * Apaga termo de responsabilidade pelo id_instalacoes
	 */
	public function apagarContratoSPPeloIdPedidoOs()
	{
		$contrato_idpedido_os = $this->dadosP['contrato_idpedido_os'];
		
		if( $this->ContratoSP->deleteContratoSPPeloIdPedidoOs( new Integer($contrato_idpedido_os) ) )
			die("<span class='alert alert-success'>Contrato apagado com sucesso.</span>");
		else
			die("<span class='alert alert-error'>Erro ao apagar Contrato.</span>");
	}
}