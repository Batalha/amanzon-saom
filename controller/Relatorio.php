<?php

/*
 * Classe que pretende 
 * 
 * TODO: fazer o primeiro relatorio a ser gerado por ela
 * TODO: criar a tabela baseada no DBRelatorios ou na query em 'documentos'
 */

include_once 'model/DBRelatorio.php';

class Relatorio extends Controller
{
	
	protected $tplDir = 'relatorio';
	
	//para edicao da data final
	protected $statusAtendimento;
	protected $prk;
	
	//TODO: variaveis a ir para subclasse de relatorio de incidentes por instalação
	private $listaIncidentesPorInstalacao; 
	private $caixasDestinatarias = array(
		'savio@vodanet-telecom.com',
		'hernan@vodanet-telecom.com',
		'acastillo@stmi.com'
	);
	
	function __construct() 
	{
        parent::__construct();
        $this->DB = new DBRelatorio();
    }
    
	/*
	 * lista de relatórios disponíveis
	 */
	public function index()
	{
		$this->smarty->display("{$this->tplDir}/index.tpl");
	}
	
	/*
	 * metodo que busca estrutura para relatorio de ativacao de vsats
	 * baseado em datas
	 */
	public function ativacaoVsatsDia()
	{	
		$sql = "
			SELECT 
		        i.nome AS nome,
		        i.data_ativacao AS data_ativacao,
		        (
		        	SELECT data
		        	FROM agenda_instal
		        	WHERE os_idos = i.os_idos 
		        ) AS data_agendamento,
		        i.data_aceite AS aceite_prodemge
		    FROM instalacoes i
		    WHERE i.data_ativacao = '".date('Y-m-d')."';
		";
		$lista = $this->DB->queryDados($sql);
		//print_b($lista,true);
		
		$this->smarty->assign('data_parametro',date('Y-m-d'));
		$this->smarty->assign('lista',$lista);
		$this->smarty->display("{$this->tplDir}/ativacaoVsats.tpl");
	}
	
	/*
	 * metodo que busca nova lista com nova data
	 */
	public function novaListaAtivacaoVsatsDia()
	{
		$data_parametro = (isset($this->dadosP['data']))?$this->dadosP['data']:date('Y-m-d');


		$sql = "
			SELECT 
		        i.nome AS nome,
		        i.data_ativacao AS data_ativacao,
		        (
		        	SELECT data
		        	FROM agenda_instal
		        	WHERE os_idos = i.os_idos 
		        ) AS data_agendamento,
		        i.data_aceite AS aceite_prodemge
		    FROM instalacoes i
		    WHERE i.data_ativacao = '".$data_parametro."';
		";
		$lista = $this->DB->queryDados($sql);
		//print_b($lista,true);
		
		$this->smarty->assign('data_parametro',$data_parametro);
		$this->smarty->assign('lista',$lista);
		$this->smarty->display("{$this->tplDir}/ativacaoVsats_listaNova.tpl");
	}
	
	/*
	 * metodo que busca nova lista com novo periodo
	 */
	public function novaListaAtivacaoVsatsPeriodo()
	{
		$data_parametro = (isset($this->dadosP['data']))?$this->dadosP['data']:date('Y-m-d');
		
		$sql = "
			SELECT 
		        i.nome AS nome,
		        i.data_ativacao AS data_ativacao,
		        (
		        	SELECT data
		        	FROM agenda_instal
		        	WHERE os_idos = i.os_idos 
		        ) AS data_agendamento,
		        i.data_aceite AS aceite_prodemge
		    FROM instalacoes i
		    WHERE i.data_ativacao = '".$data_parametro."';
		";
		$lista = $this->DB->queryDados($sql);
		//print_b($lista,true);
		
		$this->smarty->assign('data_parametro',$data_parametro);
		$this->smarty->assign('lista',$lista);
		$this->smarty->display("{$this->tplDir}/ativacaoVsats_listaNova.tpl");
	}
	
	
	/*
	 * metodo que gera csv e envia para o cliente
	 */
	public function geraCSV()
	{
		$nome_arquivo = 'relatorios/relatorio_acompanhamento_'.date('d').'_'.date('m').'_'.date('Y').'_-_'.date('H').'_'.date('i').'_'.date('s').'_-_'.normaliza(str_replace(' ','_',trim($_SESSION['login']['nome']))).'.csv';
    	$arquivo = fopen($nome_arquivo,'w');
    	
    	fputcsv($arquivo, $titulos, ';');
    	
    	for($i=0;$i<count($lista);$i++)
    	{
    		$arrayNovo = array();
    		foreach($lista[$i] as $item)
    		{
    			$arrayNovo[] = utf8_decode($item);
    		}
    		fputcsv($arquivo, $arrayNovo, ';');
    	}
    	
    	fclose($arquivo);
    	
    	header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"');
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($nome_arquivo));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');
		 
		// Envia o arquivo para o cliente
		readfile($nome_arquivo);
	}
	
	
	// ##################################################################################
	// ############ RELATORIO INCIDENTES ################################################
	// ##################################################################################
	//TODO: separar em subclasse
	
	public function incidentesPorInstalacao( $dataInicial = '' , $dataFinal = '' )
	{
		$diasPeriodo = Helpers::resgataPrimeiroEUltimoDiaMesAnterior();
		$mesAnterior = substr( $diasPeriodo[0] , 5 , 2 );
		
		if( $dataInicial == '' )
			$dataInicial = $diasPeriodo[0];
		if( $dataFinal == '' )
			$dataFinal = $diasPeriodo[1];
		
		$this->buscaInicidentesPorInstalacoes( array( $dataInicial , $dataFinal ) );
		
		$respostaCriacaoCSV = $this->fazCSVIncidentesPorInstalacao( $this->listaIncidentesPorInstalacao , $mesAnterior );
		$respostaEnvioEmail = $this->fazEmailIncidentesPorInstalacao( $this->listaIncidentesPorInstalacao , $respostaCriacaoCSV );
	}
	
	// ------------------------------- emissão dos relatórios
	
	private function fazCSVIncidentesPorInstalacao( Array $listaIncidentesPorInstalacao , $mesAnterior )
	{
		$hoje = date('dmY');
		
		$lista = array(
			"Instalação;Nº de Incidentes;Incidentes"
		);
		
		foreach( $listaIncidentesPorInstalacao as $chave => $item )
		{
			$nIncidentes = count($item['incidentes']);
			
			$incidentes = "";
			foreach ( $item['incidentes'] as $incidente )
				$incidentes .= "{$incidente['idincidentes']}, ";
			$incidentes = substr($incidentes, 0, -2);
			
			array_push( 
				$lista , 
				" {$item['instalacao'][0]['nome']} ; {$nIncidentes} ; {$incidentes} " 
			);
		}
		
		//$nomeArquivo = BASE_PATH."/SAOM/relatorios/incidentesPorInstalacao/relatorio{$hoje}.csv";
		$nomeArquivo = "relatorios/incidentesPorInstalacao/relatorio_mes{$mesAnterior}_{$hoje}.csv";
		$fp = fopen($nomeArquivo, 'w');
		
		foreach ($lista as $linha) {
		    fputcsv( $fp , split(';', $linha) , ';' );
		}
		
		fclose($fp);
		
		return $nomeArquivo;
	}
	
	private function fazEmailIncidentesPorInstalacao( Array $listaIncidentesPorInstalacao , $respostaCriacaoCSV )
	{
		$assunto = "Lista de Incidentes Por Instalação do Último mês";
		$cumprimento = Helpers::getCumprimento();
		$endereco = BASE_PATH.'/'.$respostaCriacaoCSV;
		
		$msg = "
			{$cumprimento},<br/>
			Seguem os incidentes de suas respectivas instalações do último mês.<br/>
		";
		$msg .= $this->montaTabelaIncidentesPorInstalacao( $listaIncidentesPorInstalacao );
		$msg .= "
			<br/>Arquivo CSV: <a href='{$endereco}'>Arquivo CSV</a><br/> 
		";
		$msg .= Helpers::assinaturaSAOM();
		
		if( $this->Helpers->sendMail( $assunto , $this->caixasDestinatarias , $msg ) )
			return true;
		else
			return false;
	}
	
	private function montaTabelaIncidentesPorInstalacao( Array $listaIncidentesPorInstalacao )
	{
		$msg = "
			<br/><table style='border:1px solid #000;padding:3px;'>
			<tr>
				<td style='padding:4px;border:1px solid #000;'>Instalação</td>
				<td style='padding:4px;border:1px solid #000;'>Nº de Incidentes</td>
				<td style='padding:4px;border:1px solid #000;'>Incidentes</td>
			</tr>
		";
		
		foreach( $listaIncidentesPorInstalacao as $chave => $linha )
		{
			$nIncidentes = count($linha['incidentes']);
			
			$incidentes = "";
			foreach ( $linha['incidentes'] as $incidente )
				$incidentes .= "{$incidente['idincidentes']}, ";
			$incidentes = substr($incidentes, 0, -2);
			
			$msg .= "
				<tr>
					<td style='padding:4px;border:1px solid #000;'>{$linha['instalacao'][0]['nome']}</td>
					<td style='padding:4px;border:1px solid #000;'>{$nIncidentes}</td>
					<td style='padding:4px;border:1px solid #000;'>{$incidentes}</td>
				</tr>
			";
		}
		
		$msg .= "
			</table><br/>
		";
		
		return $msg;
	}
	
	// ------------------------------- construcao da lista
	
	private function buscaInicidentesPorInstalacoes( Array $datas )
	{
		$Incidentes = $this->buscaTodosIncidentes( $datas );
		
		$listaInstalacoes = $this->reservaInstalacoesDeIncidentes( $Incidentes );
		
		$listaInstalacoesRowSet = $this->buscaInstalacoes( $listaInstalacoes );
		
		$listaInstalacoesComSeusIncidentes = $this->buscaIncidentesDeCadaInstalacao( $listaInstalacoesRowSet );
		
		$this->listaIncidentesPorInstalacao = $listaInstalacoesComSeusIncidentes;
	}
	
	private function buscaTodosIncidentes( Array $datas )
	{
		$where = " 
			data >= '{$datas[0]}' AND 
			data <= '{$datas[1]}'
		";
		return $this->Incidentes->fetchAll($where);
	}
	
	private function reservaInstalacoesDeIncidentes( Zend_Db_Table_Rowset $listaIncidentes )
	{
		$lista = $listaIncidentes->toArray();
		$lista_instalacoes = array();
		
		foreach ( $lista as $chave => $linha )
			array_push( $lista_instalacoes , $linha['instalacoes_idinstalacoes'] );
		
		return array_unique( $lista_instalacoes );
	}
	
	private function buscaInstalacoes( Array $listaInstalacoes )
	{
		foreach ( $listaInstalacoes as $chave => $instalacao )
		{
			$where = "
				idinstalacoes = '{$instalacao}'
			";
			$listaInstalacoes[ $chave ] = $this->Instalacao->fetchAll( $where );
		}
		
		return $listaInstalacoes;
	}
	
	private function buscaIncidentesDeCadaInstalacao( Array $listaInstalacoesRowSet )
	{
		$listaInstalacoesComSeusIncidentes = array();
		
		foreach ( $listaInstalacoesRowSet as $chave => $instalacao )
		{
			if( $instalacao instanceof Zend_Db_Table_Rowset )
			{
				$where = "
					instalacoes_idinstalacoes = '{$instalacao[0]->idinstalacoes}'
				";
				$incidentes = $this->Incidentes->fetchAll( $where );
				
				array_push( 
					$listaInstalacoesComSeusIncidentes , 
					array(
						'instalacao' => $instalacao->toArray(),
						'incidentes' => $incidentes->toArray()
					) 
				);
			}
		}
		
		return $listaInstalacoesComSeusIncidentes;
	}
	
	// --
}
