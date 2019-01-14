<?php

date_default_timezone_set('Brazil/East');

require_once('s_p/model/DBModel_sp.php');
require_once 'helpers.class.php';
require_once 'helpers/AdapterZend.php';

//zend
require_once 's_p/model/BO/Log_spBO.php';
require_once 's_p/model/BO/Instalacoes_spBO.php';
require_once "s_p/model/BO/OSSPBO.php";
require_once "s_p/model/BO/Equipamentos_spBO.php";
require_once "s_p/model/BO/EquipamentosLocais_spBO.php";
require_once "s_p/model/TipoEquipamentos_spModel.php";
require_once "s_p/model/BO/Usuarios_spBO.php";
require_once "s_p/model/Incidentes_spModel.php";
require_once "s_p/model/Cronometro_spModel.php";
require_once "s_p/model/AtendVsat_spModel.php";
require_once "s_p/model/Perfis_spModel.php";
require_once "s_p/model/Acompanhamento_spModel.php";
require_once "s_p/model/Compartilhamento_spModel.php";

/**
 *
 * Classe InformaPrazos
 *
 * @author: Sávio Resende - lotharthesavior@gmail.com
 *
 * Classe criada para infromar usuários do SAOM sobre prazos das OS's, avisando e informando.
 *
 * Obs.: a ser usada em Cron.
 *
 */

##################################################################################
###############  PRAZOS  #########################################################
##################################################################################

/*
 * Informa Prazos
 */
class InformaPrazos
{
	// -------------------------------- prazosOS

	private $grupos_buscas = array(
	    'grupo1' => array( '-7' , '0' ) ,
	    'grupo2' => array( '-1' , '-6' ) ,
	    'grupo3' => 0 ,
		'grupo4' => array( '5' , '0' ) ,
		'grupo5' => array( '15' , '6' ) ,
	);


	public function passa_buscas( $busca )
	{
		$this->{"busca_$busca"}();
	}


	// ----------------------------------- BUSCAS DE PRAZOS DAS OS's
	private function busca_prazosOS()
	{
		// -------------------------------------------------- busca OS's
		$prazosModel = new PrazosModel();
		$prazosModel->buscaGruposDePrazosDeOSs( $this->grupos_buscas );


		// -------------------------------------------------- constroi Email
		$emailInformativo = new InformaPrazoTextoEmail();
		$emailInformativo->conteudo_email_listaPrazosOSs( $prazosModel->getListaOS() );


		// -------------------------------------------------- envia Email
		$email = new InformaPrazoEmail();
		if( $email->envia_email( $emailInformativo->getMsg() , 'informeOSs' ) )
		$resultado =  "Procedimento de informe de prazos das OS's concluído com sucesso.";
		else
		$resultado = "Erro ao efetuar procedimento de informe de prazos das OS's";
			

		// ------------------------------------------------- registra Log
		InformaPrazoLog::registraLog( $emailInformativo->getMsgSemHtml() );


		echo $resultado;
	}

	private function busca_AtrasosAdiantamentos()
	{
		// ------------------------------------------------ busca Comissionamentos
		$prazosModel = new PrazosModel();
		$prazosModel->buscaComissionamentosFinalizadosTrintaDias();


		// ------------------------------------------------ prepara Texto Email
		$textoEmail = new InformaPrazoTextoEmail();
		$textoEmail->conteudo_email_InstalacoesFinalizadasMesAnterior( $prazosModel->getListaInstalacoes() );


		// ------------------------------------------------ envia Email
		$email = new InformaPrazoEmail();
		if( $email->envia_email( $textoEmail->getMsg() , 'informeInstalacoesMesPassado' ) )
		$resultado =  "Procedimento de informe das Instalações Comissionadas no último mês concluído com sucesso.";
		else
		$resultado = "Erro ao efetuar procedimento de informe das Instalações Comissionadas no último mês";
			
			
		// ----------------------------------------------- registra Log
		InformaPrazoLog::registraLog( $textoEmail->getMsgSemHtml() );
			
			
		echo $resultado;
	}
}

// classe que cuida dos acessos
class PrazosModel extends Controller
{
	private $arrayListasOS = array();
	private $listaOS;
	private $listaInstalacao;

	public function buscaGruposDePrazosDeOSs( Array $grupos )
	{
		foreach( $grupos as $chave => $grupo )
		{
			if( is_array($grupo) ) // LISTA QUANDO ARRAY ( diferente de '0' )
			{
				if( $grupo[0] > 0 ) // grupo positivo
				{
					$this->busca_para_prazo( $grupo[0] , $grupo[1] );
						
					if( count($this->listaOS) > 0 )
					$this->arrayListasOS[ $chave ] = $this->listaOS;
					else
					$this->arrayListasOS[ $chave ] = array();
						
					//echo "Grupo {$chave}: ".count($this->listaOS).'resultados<br/>';
				}
				else // grupo negativo
				{
					if( $grupo[1] == 0 ) // para mais de 7 dias vencidos
					$this->busca_para_prazo( 'maisDe7dias' );
					else
					$this->busca_para_prazo( $grupo[0] , $grupo[1] );

					if( count($this->listaOS) > 0 )
					$this->arrayListasOS[ $chave ] = $this->listaOS;
					else
					$this->arrayListasOS[ $chave ] = array();
						
					//echo "Grupo {$chave}: ".count($this->listaOS).'resultados<br/>';
				}
			}
			else // LISTA QUANDO NÃO ARRAY ( igual a '0' )
			{
				$this->busca_para_prazo( 0 , 'vazio' );

				if( count($this->listaOS) > 0 )
				$this->arrayListasOS[ $chave ] = $this->listaOS;
				else
				$this->arrayListasOS[ $chave ] = array();

				//echo "Grupo {$chave}: ".count($this->listaOS).'resultados<br/>';
			}
				
			$this->zeraVariaveis( "listaOS" );
		}
	}

	public function getListaOS()
	{
		return $this->arrayListasOS;
	}

	public function buscaComissionamentosFinalizadosTrintaDias()
	{
		$this->buscaComissionamentosFinalizados();
	}

	public function getListaInstalacoes()
	{
		return $this->listaInstalacao;
	}

	private function busca_para_prazo( $dias , $diasFim = 'vazio' )
	{
		// busca OS
		if( $dias === 'maisDe7dias' )
		$this->buscaOSMaisDe7dias();
		else
		{
			if( $diasFim === 'vazio' )
			$this->buscaOS( $dias );
			else
			$this->buscaOSPrazo( $dias , $diasFim );
		}

		// busca Instalacao
		$this->buscaInstalacao();

		// busca cidade
		$this->buscaCidade();

		// busca prazo
		$this->buscaPrazo();

		// busca empresa
		$this->buscaEmpresa();
	}

	// ----------------------------------------------------------------------
	// -----------------------------  OS  -----------------------------------
	// ----------------------------------------------------------------------

	private function buscaOS( $dias )
	{
		$hoje = date('Y-m-d');

		$where = "
			DATEDIFF( prazoInstal , '{$hoje}' ) = {$dias} AND 
			( 
				( SELECT instalacoes_sp.termo_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) = '' OR
				( SELECT instalacoes_sp.termo_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) IS NULL
			) AND
			( -- ----------- tira com data aceite
				( SELECT instalacoes_sp.data_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) = '' OR
				( SELECT instalacoes_sp.data_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) IS NULL
			) AND
			( -- ----------- tira paralisadas
				SELECT COUNT(*)
				FROM pausas
				WHERE
					tabela = 'OS' AND
					chaveextrangeira = os.idos AND
					(
						pausa_fim IS NULL OR
						pausa_fim = '0000-00-00'
					)
			) < 1 AND
			os_status_idos_status != 2
		";
		$order = " prazoInstal ASC ";

		$this->listaOS = $this->OSSP->fetchAll( $where , $order );
	}

	private function buscaOSPrazo( $diasInicio , $diasFim )
	{
		$hoje = date('Y-m-d');

		$where = "
			DATEDIFF( prazoInstal , '{$hoje}' ) < {$diasInicio} AND 
			DATEDIFF( prazoInstal , '{$hoje}' ) > {$diasFim} AND
			( 
				( SELECT instalacoes_sp.termo_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) = '' OR
				( SELECT instalacoes_sp.termo_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) IS NULL
			) AND
			( -- ----------- tira com data aceite
				( SELECT instalacoes_sp.data_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) = '' OR
				( SELECT instalacoes_sp.data_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) IS NULL
			) AND
			( -- ----------- tira paralisadas
				SELECT COUNT(*)
				FROM pausas
				WHERE
					tabela = 'OS' AND
					chaveextrangeira = os.idos AND
					(
						pausa_fim IS NULL OR
						pausa_fim = '0000-00-00'
					)
			) < 1 AND
			os_status_idos_status != 2
		";
		$order = " prazoInstal ASC ";

		$this->listaOS = $this->OSSP->fetchAll( $where , $order );
	}

	private function buscaOSMaisDe7dias()
	{
		$hoje = date('Y-m-d');

		$where = "
			DATEDIFF( prazoInstal , '{$hoje}' ) < -6 AND 
			( -- ----------- tira com termo aceite
				( SELECT instalacoes_sp.termo_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) = '' OR
				( SELECT instalacoes_sp.termo_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) IS NULL
			) AND
			( -- ----------- tira com data aceite
				( SELECT instalacoes_sp.data_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) = '' OR
				( SELECT instalacoes_sp.data_aceite FROM instalacoes_sp WHERE instalacoes_sp.os_sp_idos = os_sp.idos ) IS NULL
			) AND
			( -- ----------- tira paralisadas
				SELECT COUNT(*)
				FROM pausas
				WHERE
					tabela = 'OS' AND
					chaveextrangeira = os.idos AND
					(
						pausa_fim IS NULL OR
						pausa_fim = '0000-00-00'
					)
			) < 1 AND
			os_status_idos_status != 2
		";
		$order = " prazoInstal ASC ";

		$this->listaOS = $this->OSSP->fetchAll( $where , $order );
	}

	// ----------------------------------------------------------------------
	// -----------------------------  INSTALACOES  --------------------------
	// ----------------------------------------------------------------------

	private function buscaComissionamentosFinalizados()
	{
		$datasMesAnterior = Helpers::resgataPrimeiroEUltimoDiaMesAnterior();
		
		$where = "
			( -- DATA ACEITE
				data_aceite != '0000-00-00' AND
				data_aceite IS NOT NULL AND
				data_aceite != '' AND
				data_aceite > '{$datasMesAnterior[0]}'
			) AND
			( -- DATA FINAL COMISS
				data_final_comiss != '0000-00-00' AND
				data_final_comiss IS NOT NULL AND
				data_final_comiss != '' AND
				data_final_comiss >= '{$datasMesAnterior[0]}' AND
				data_final_comiss <= '{$datasMesAnterior[1]}'
			)
		";
		$order = " data_final_comiss ASC ";

		$this->listaInstalacao = $this->Instalacao_sp->fetchAll( $where , $order );
		if( $this->listaInstalacao instanceof Zend_Db_Table_Rowset )
			$this->listaInstalacao = $this->listaInstalacao->toArray();
		else
			$this->listaInstalacao = array();

		$this->buscaOSDasInstalacoes();

		$this->calculaIntervaloDataFinalDataAceite();
	}

	// ----------------------------------------------------------------------
	// -----------------------------  IMPLEMENTAÇÕES  -----------------------
	// ----------------------------------------------------------------------

	private function buscaInstalacao()
	{
		if( $this->listaOS instanceof Zend_Db_Table_Rowset )
		{
			$this->listaOS = $this->listaOS->toArray();
			foreach ( $this->listaOS as $chave => $os )
			{
				$where = "
					os_sp_idos = '{$os['idos']}'
				";
				$instalacao = $this->Instalacao_sp->fetchAll( $where );
				if( $instalacao instanceof Zend_Db_Table_Rowset )
				$this->listaOS[$chave]['instalacao'] = $instalacao->toArray();
				else
				$this->listaOS[$chave]['instalacao'] = array();
			}
		}
	}

	private function buscaCidade()
	{
		if( count($this->listaOS) > 0 )
		{
			foreach ( $this->listaOS as $chave => $os )
			{
				$where = "
					idmunicipios = '{$os['municipios_idcidade']}'
				";
				$municipio = $this->Municipio->fetchAll( $where );
				if( $municipio instanceof Zend_Db_Table_Rowset )
				$this->listaOS[$chave]['municipio'] = $municipio->toArray();
				else
				$this->listaOS[$chave]['municipio'] = array();
			}
		}
	}

	private function buscaPrazo(  )
	{
		if( count($this->listaOS) > 0 )
		{
			foreach ( $this->listaOS as $chave => $os )
			{
				$hoje = date('Y-m-d');

				$sql = "
					SELECT DATEDIFF( prazoInstal , '{$hoje}' ) as diasPrazo 
					FROM os_sp
					WHERE idos = '{$os['idos']}';
				";
				$prazo_os = $this->DBPadrao->queryDados( $sql );
				if( count($prazo_os) > 0 )
				$this->listaOS[$chave]['diasPrazo'] = ( $prazo_os[0]['diasPrazo'] >= 0 )?$prazo_os[0]['diasPrazo']:$prazo_os[0]['diasPrazo']*-1;
				else
				$this->listaOS[$chave]['diasPrazo'] = '';
			}
		}
	}

	private function buscaEmpresa( )
	{
		if( count($this->listaOS) > 0 )
		{
			foreach ( $this->listaOS as $chave => $os )
			{
				$sql = "
					SELECT empresa
					FROM empresas
					WHERE idempresas  = '{$os['empresas_idempresas']}';
				";
				$empresaNome = $this->DBPadrao->queryDados( $sql );
				if( count($empresaNome) > 0 )
				$this->listaOS[$chave]['empresa'] = $empresaNome[0]['empresa'];
			}
		}
	}

	private function calculaIntervaloDataFinalDataAceite()
	{
		foreach( $this->listaInstalacao as $chave => $instalacao )
		{
			$dataUm = new DateTime( substr( $instalacao['data_final_comiss'] , 0 , 10 ) );
			$dataDois = new DateTime( $instalacao['os_sp']['prazoInstal'] );
			$intervaloUm = $dataUm->diff( $dataDois );
			$this->listaInstalacao[ $chave ]['intervalo_dt_final_comiss_prazo_instal'] = (
			( $intervaloUm->format('%R') == '-' )? $intervaloUm->format('%a').' dia(s)' : 'Ok'
			);
				
			$dataTres = new DateTime( $instalacao['data_aceite'] );
			$dataQuatro = new DateTime( $instalacao['os_sp']['prazoInstal'] );
			$intervaloDois = $dataTres->diff( $dataQuatro );
			$this->listaInstalacao[ $chave ]['intervalo_data_aceite_prazo_instal'] = (
			( $intervaloDois->format('%R') == '-' )? $intervaloDois->format('%a').' dia(s)' : 'Ok'
			);
		}
	}

	private function buscaOSDasInstalacoes()
	{
		foreach ( $this->listaInstalacao as $chave => $instalacao )
		{
			$where = " idos = '{$instalacao['os_sp_idos']}' ";
			$os = $this->OSSP->fetchAll( $where );
			$osArray = $os->toArray();
			$this->listaInstalacao[ $chave ]['os_sp'] = $osArray[0];
		}
	}

	// ----------------------------------------------------------------------
	// -----------------------------  EXTRAS  -------------------------------
	// ----------------------------------------------------------------------

	private function zeraVariaveis( $variavel )
	{
		unset($this->{"$variavel"});
	}

}

class InformaPrazoTextoEmail
{
	private $msg;
	private $msgSemHtml = "\r\n##################################################";

	private $email_grupo1 = "
		<br/><h2>OS's vencidas há 7 dias ou mais: </h2>
	";
	private $email_nenhumaos_grupo1 = "
		<br/><h2>Nenhuma OS vencida há 7 dias ou mais. </h2>
	";
	private $email_grupo2 = "
		<br/><h2>OS's vencidas de 1 a 6 dias: </h2>
	";
	private $email_nenhumaos_grupo2 = "
		<br/><h2>Nenhuma OS vencida entre 1 e 6 dias. </h2>
	";
	private $email_grupo3 = "
		<br/><h2>OS's que vencem hoje: </h2>
	";
	private $email_nenhumaos_grupo3 = "
		<br/><h2>Nenhuma OS vence hoje. </h2>
	";
	private $email_grupo4 = "
		<br/><h2>OS's que vencerão entre 1 e 5 dias: </h2>
	";
	private $email_nenhumaos_grupo4 = "
		<br/><h2>Nenhuma OS vencerá entre 1 e 5 dias. </h2>
	";
	private $email_grupo5 = "
		<br/><h2>OS's que vencerão entre 6 e 15 dias: </h2>
	";
	private $email_nenhumaos_grupo5 = "
		<br/><h2>Nenhuma OS vencerá entre 6 e 15 dias. </h2>
	";
	
	private $contagemInstalacaoForaDoPrazo = 0;
	private $contagemInstalacaoNoPrazo = 0;

	private $assinaturaSAOM = "
    	SAOM<br/>
		Vodanet Telecomunicações Ltda.<br/>
		http://www.vodanet-telecom.com<br/>
		<img src='http://saom.vodanet-telecom.com/public/imagens/logo_vodanet.jpg'>
    ";

	public function conteudo_email_listaPrazosOSs( Array $listaOS )
	{
		$cumprimento = Helpers::getCumprimento();

		$this->msg .= "
		{$cumprimento},<br/><br/>
			Seguem os prazos mais próximos das OS's atrasados e próximo de encerramento.<br/><br/>
		";
		$this->msgSemHtml .= date('Y-m-d')." - Prazos OS\r\n";

		foreach ( $listaOS as $chave => $listaGrupo )
		{
			if( count($listaGrupo) > 0 )
			{
				$this->msg .= $this->{"email_$chave"};
				$this->msg .= "
					<br/><table style='border:1px solid #000;padding:3px;'>
					<tr>
						<td style='padding:4px;border:1px solid #000;'>Número da OS</td>
						<td style='padding:4px;border:1px solid #000;'>Instalação</td>
						<td style='padding:4px;border:1px solid #000;'>Município</td>
						<td style='padding:4px;border:1px solid #000;'>Número de dias</td>
						<td style='padding:4px;border:1px solid #000;'>Empresa</td>
					</tr>
				";
				$this->msgSemHtml .= "Número da OS / Instalaçlão / Município / Nº dias \r\n";
			}
			else
			$this->msg .= $this->{"email_nenhumaos_$chave"};
				
			$this->formaStringOs( $listaGrupo );
				
			$this->msgSemHtml .= "\r\n";

			$this->msg .= "</table>";
		}
			
		$this->msg .= "<br/><br/>".$this->assinaturaSAOM;
		$this->msgSemHtml .= "\r\n";
	}

	public function conteudo_email_InstalacoesFinalizadasMesAnterior( Array $listaInstalacoes )
	{
		$cumprimento = Helpers::getCumprimento();

		$this->msg .= "
		{$cumprimento},<br/><br/>
			Seguem os Comissionamentos finalizados no mês anterior.<br/><br/>
		";
		$this->msgSemHtml .= date('Y-m-d')." - Instalações Finalizadas\r\n";

		$this->msg .= "
			<br/><table style='border:1px solid #000;padding:3px;'>
			<tr>
				<td style='padding:4px;border:1px solid #000;'>OS</td>
				<td style='padding:4px;border:1px solid #000;'>Nome Instalação</td>
				<td style='width:15px;'>&nbsp;</td>
				<td style='padding:4px;border:1px solid #000;'>Data final do Comissionamento</td>
				<td style='padding:4px;border:1px solid #000;'>Prazo da Instalação</td>
				<td style='padding:4px;border:1px solid #000;'>Dias de Atraso</td>
				<td style='width:15px;'>&nbsp;</td>
				<td style='padding:4px;border:1px solid #000;'>Data de Aceite</td>
				<td style='padding:4px;border:1px solid #000;'>Prazo da Instalação</td>
				<td style='padding:4px;border:1px solid #000;'>Dias de Atraso</td>
			</tr>
		";
		$this->msgSemHtml .= "OS / Nome da Instalaçlão / Data final do Comissionamento / Prazo da Instalação / Intervalo / Data de Aceite / Prazo da Instalação / Intervalo \r\n";

		$this->formaStringInstalacoes( $listaInstalacoes );

		$this->msgSemHtml .= "\r\n";

		$this->msg .= "
			</table><br/>
			Contagem de Instalações Dentro do Prazo: {$this->contagemInstalacaoNoPrazo}<br/>
			Contagem de Instalações Fora do Prazo: {$this->contagemInstalacaoForaDoPrazo}<br/>
		";
			
		$this->msg .= "<br/><br/>".$this->assinaturaSAOM;
		$this->msgSemHtml .= "\r\n";
	}

	public function getMsg()
	{
		return $this->msg;
	}

	public function getMsgSemHtml()
	{
		return $this->msgSemHtml;
	}

	private function formaStringOs( $listaGrupo )
	{
		foreach ( $listaGrupo as $os )
		{
			$this->msg .= "
				<tr>
					<td style='padding:4px;border:1px solid #000;'>{$os['numOS']}</td>
					<td style='padding:4px;border:1px solid #000;'>{$os['instalacao'][0]['nome']}</td>
					<td style='padding:4px;border:1px solid #000;'>{$os['municipio'][0]['municipio']}</td>
					<td style='padding:4px;border:1px solid #000;'>{$os['diasPrazo']} dia(s)</td>
					<td style='padding:4px;border:1px solid #000;'>{$os['empresa']}</td>
				</tr>
			";
			$this->msgSemHtml .= "{$os['numOS']} / {$os['instalacao'][0]['nome']} / {$os['municipio'][0]['municipio']} / {$os['diasPrazo']} / {$os['empresa']} \r\n";
		}
	}
	
	private function formaStringInstalacoes( Array $listaInstalacoes )
	{
		foreach ( $listaInstalacoes as $chave => $instalacao )
		{
			if( $instalacao['intervalo_dt_final_comiss_prazo_instal'] == 'Ok' )
			{
				$cor = 'green';
				$this->contagemInstalacaoForaDoPrazo++;
			}
			else
			{
				$cor = 'red';
				$this->contagemInstalacaoNoPrazo++; 
			}
			
			$this->msg .= "
				<tr>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['os_sp']['numOS']}</td>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['nome']}</td>
					<td style='width:15px;'>&nbsp;</td>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['data_final_comiss']}</td>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['os_sp']['prazoInstal']}</td>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['intervalo_dt_final_comiss_prazo_instal']}</td>
					<td style='width:15px;'>&nbsp;</td> 
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['data_aceite']}</td>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['os_sp']['prazoInstal']}</td>
					<td style='padding:4px;border:1px solid {$cor};'>{$instalacao['intervalo_data_aceite_prazo_instal']}</td>
				</tr>
			";
			$this->msgSemHtml .= "{$instalacao['os_sp'][0]['numOS']} / {$instalacao['nome']} / {$instalacao['data_final_comiss']} / {$instalacao['os_sp']['prazoInstal']} / {$instalacao['intervalo_dt_final_comiss_prazo_instal']} / {$instalacao['data_aceite']} / {$instalacao['os_sp']['prazoInstal']} / {$instalacao['intervalo_data_aceite_prazo_instal']} \r\n";
		}
	}
}

class InformaPrazoEmail
{
	private $helpers;

	private $assunto_pazosOss = "SAOM - Prazo das OS's";

	private $assunto_instalacoes_mes_passado = "SAOM - Instalações Comissionadas no Último mês";

	private $caixas_destinatarias_informe_pazosOss = array(
		'cbatalha@emc-corp.net',
		'hernan@vodanet-telecom.com',
		'acastillo@stmi.com',
	);

	private $caixas_destinatarias_informe_instalacoes_mes_passado = array(
		'mwergles@vodanet-telecom.com',
		'acastillo@stmi.com',
		'cdantas@vodanet-telecom.com'
	);

	public function __construct()
	{
		$this->helpers = new Helpers();
	}

	public function envia_email( $msg , $informe )
	{
		switch( $informe )
		{
			case 'informeOSs':
				$caixas = $this->caixas_destinatarias_informe_pazosOss;
				$assunto = $this->assunto_pazosOss;
				break;
			case 'informeInstalacoesMesPassado':
				$caixas = $this->caixas_destinatarias_informe_instalacoes_mes_passado;
				$assunto = $this->assunto_instalacoes_mes_passado;
				break;
		}

		if(
			$this->helpers->sendMail(
				$assunto,
				( AMBIENTE == 'producao' )?$caixas:'mwergles@vodanet-telecom.com',
				$msg
			)
		)
		return true;
		else
		return false;
	}

}

class InformaPrazoLog
{
	public static function registraLog( $msg )
	{
		$arquivo_log = fopen("log/log_informe_prazos.txt", "a");

		$log = fwrite( $arquivo_log , $msg );

		fclose( $arquivo_log );
	}

}
