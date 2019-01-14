<?php

require_once 'model/ZendModel.php';

class PerguntasComissionamentoModel extends ZendModel
{
	protected $_name = 'perguntas_comissionamento';
	protected $_primary = 'id_perguntas_comissionamento';
	
	// atributos 
	protected $id_perguntas_comissionamento;
	protected $id_instalacoes;
  	protected $test_notificacao_inicio;
  	protected $test_f_termo_aceite;
  	protected $test_info_rx_tx;
  	protected $test_prtg;
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
  	
  	protected $campos = array(
  		'id_perguntas_comissionamento',
		'id_instalacoes',
	  	'test_notificacao_inicio',
	  	'test_f_termo_aceite',
	  	'test_info_rx_tx',
	  	'test_prtg',
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
	  	'confirmacao_endereco_instalacao'
  	);
  	
  	// outros
  	protected $perguntasArray;
  	
  	// set --
  	
  	public function setid_perguntas_comissionamento( $id_perguntas_comissionamento )
  	{
  		$this->id_perguntas_comissionamento = $id_perguntas_comissionamento;
  	}
	public function setid_instalacoes( $id_instalacoes )
	{
		$this->id_instalacoes = $id_instalacoes;
	}
  	public function settest_notificacao_inicio( $test_notificacao_inicio )
  	{
  		$this->test_notificacao_inicio = $test_notificacao_inicio;
  	}
  	public function settest_f_termo_aceite( $test_f_termo_aceite )
  	{
  		$this->test_f_termo_aceite  = $test_f_termo_aceite;
  	}
  	public function settest_info_rx_tx( $test_info_rx_tx )
  	{
  		$this->test_info_rx_tx = $test_info_rx_tx;
  	}
  	public function settest_prtg( $test_prtg )
  	{
  		$this->test_prtg = $test_prtg;
  	}
  	public function settest_clima( $test_clima )
  	{
  		$this->test_clima = $test_clima;
  	}
  	public function settest_cabo( $test_cabo )
  	{
  		$this->test_cabo  = $test_cabo;
  	}
  	public function settest_calibrate( $test_calibrate )
  	{
  		$this->test_calibrate = $test_calibrate;
  	}
  	public function settest_tx( $test_tx )
  	{
  		$this->test_tx = $test_tx;
  	}
  	public function settest_buc( $test_buc )
  	{
  		$this->test_buc = $test_buc;
  	}
  	public function settest_antena( $test_antena )
  	{
  		$this->test_antena = $test_antena;
  	}
  	public function settest_software( $test_software )
  	{
  		$this->test_software = $test_software;
  	}
  	public function setautocomiss( $autocomiss )
  	{
  		$this->autocomiss = $autocomiss;
  	}
  	public function settest_sl2000( $test_sl2000 )
  	{
  		$this->test_sl2000 = $test_sl2000;
  	}
  	public function setconectores_crimpados( $conectores_crimpados )
  	{
  		$this->conectores_crimpados = $conectores_crimpados;
  	}
  	public function setconectores_odu_isolados( $conectores_odu_isolados )
  	{
  		$this->conectores_odu_isolados = $conectores_odu_isolados;
  	}
  	public function setantena_travada( $antena_travada )
  	{
  		$this->antena_travada = $antena_travada;
  	}
  	public function setconfirmacao_endereco_instalacao( $confirmacao_endereco_instalacao )
  	{
  		$this->confirmacao_endereco_instalacao = $confirmacao_endereco_instalacao;
  	} 
  	
  	// get --
  	
  	public function getid_perguntas_comissionamento( )
  	{
  		return $this->id_perguntas_comissionamento;
  	}
	public function getid_instalacoes( )
	{
		return $this->id_instalacoes;
	}
  	public function gettest_notificacao_inicio( )
  	{
  		return $this->test_notificacao_inicio;
  	}
  	public function gettest_f_termo_aceite( )
  	{
  		return $this->test_f_termo_aceite;
  	}
  	public function gettest_info_rx_tx( )
  	{
  		return $this->test_info_rx_tx;
  	}
  	public function gettest_prtg( )
  	{
  		return $this->test_prtg;
  	}
  	public function gettest_clima( )
  	{
  		return $this->test_clima;
  	}
  	public function gettest_cabo( )
  	{
  		return $this->test_cabo;
  	}
  	public function gettest_calibrate( )
  	{
  		return $this->test_calibrate;
  	}
  	public function gettest_tx( )
  	{
  		return $this->test_tx;
  	}
  	public function gettest_buc( )
  	{
  		return $this->test_buc;
  	}
  	public function gettest_antena( )
  	{
  		return $this->test_antena;
  	}
  	public function gettest_software( )
  	{
  		return $this->test_software;
  	}
  	public function getautocomiss( )
  	{
  		return $this->autocomiss;
  	}
  	public function gettest_sl2000( )
  	{
  		return $this->test_sl2000;
  	}
  	public function getconectores_crimpados( )
  	{
  		return $this->conectores_crimpados;
  	}
  	public function getconectores_odu_isolados( )
  	{
  		return $this->conectores_odu_isolados;
  	}
  	public function getantena_travada( )
  	{
  		return $this->antena_travada;
  	}
  	public function getconfirmacao_endereco_instalacao( )
  	{
  		return $this->confirmacao_endereco_instalacao;
  	} 
  	
  	// --
  	
  	public function getperguntasArray()
  	{
  		return $this->perguntasArray;
  	} 
  	
  	public function getPerguntasComissionamento()
  	{
  		if( empty($this->idos) )
			return "Id das Perguntas não declarado.";

		$where = " id_perguntas_comissionamento = '{$this->id_perguntas_comissionamento}' ";
		$os = $this->fetchAll( $this->select()->where( $where ) );
		
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