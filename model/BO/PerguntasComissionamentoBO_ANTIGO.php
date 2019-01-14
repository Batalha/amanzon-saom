<?php


include_once "model/PerguntasComissionamentoModel.php";

class PerguntasComissionamentoBO extends PerguntasComissionamentoModel
{
	
	public function getPerguntasComissionamentoPelaInstalacao( $idinstalacao )
	{
		$where = " id_instalacoes = '{$idinstalacao}' ";
		$listaPerguntas = $this->fetchAll( $where );
		if( count($listaPerguntas) > 0 )
			$this->perguntasArray = $listaPerguntas->toArray();
		else
			$this->perguntasArray = array();
	}
	
	public function atualizaPerguntasPelaInstalacao( $formPerguntasComissionamento )
	{
		$where = " id_instalacoes = '{$formPerguntasComissionamento['id_instalacoes']}' ";
		unset($formPerguntasComissionamento['id_instalacoes']);
		
		$formPerguntasComissionamento = $this->converteOnEmNumerico( $formPerguntasComissionamento );
		
		if( $this->update( $formPerguntasComissionamento , $where )  ) return true;
		else return false;
	}
	
	private function converteOnEmNumerico( $formPerguntasComissionamento )
	{
		foreach ( $formPerguntasComissionamento as $chave => $item )
			if( $chave != 'confirmacao_endereco_instalacao' )
			{
				if( $item ) $formPerguntasComissionamento[ $chave ] = 1;
				else $formPerguntasComissionamento[ $chave ] = 0;
			}
		
		return $formPerguntasComissionamento;
	}
	 
}