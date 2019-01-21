<?php

/**
 * Description of OS
 *
 * @author Daniel - | 16/12/2011
 * @author Sávio 16/12/2011 | -
 */

//zend
include_once "s_p/model/Saom_spModel.php";
include_once "s_p/model/Emails_spModel.php";

include_once 's_p/model/DBAtendVsat_sp.php';
include_once 's_p/controller/Cronometro_sp.php';

include_once 's_p/model/DBOS_SP.php';
include_once 's_p/model/DBUsuario_sp.php';
include_once 's_p/model/DBInstalacao_sp.php';
include_once 's_p/controller/Incidente_sp.php';
include_once 's_p/model/DBIncidente_sp.php';
include_once 's_p/model/DBCronometro_sp.php';
include_once 's_p/model/DBEmpresas_sp.php';
include_once 's_p/model/DBTipo_atendimento_sp.php';
include_once 'helpers.class.php';

include_once "s_p/controller/Log_sp.php";

class AtendVsat_sp extends Controller
{
	protected $tplDir = 's_p/tampletes/atendvsat';

	protected $atendimentoId;
	protected $incidenteId;
	protected $cronometroAtendimento;
	protected $incidente_sp;
	protected $dado;


	function __construct()
	{
		parent::__construct();
		$this->DB = new DBAtendVsat_sp();
		$this->DBIncidente = new DBIncidente_sp();
		$this->DBUsuarios = new DBUsuario_sp();
		$this->DBCronometro = new DBCronometro_sp();
		$this->DBEmpresas = new DBEmpresas_sp();
		$this->CronometroController = new Cronometro_sp();
		$this->DBTipo_atendimento = new DBTipo_atendimento_sp();
		$this->DBOs_sp = new DBOS_SP();
		$this->DBUsuario = new DBUsuario_sp();
		$this->incidente_sp = new Incidente_sp();

		$this->Helpers = new Helpers();
		$this->Log = new Log_sp();
	}

	// TODO: poutz!
	//SETS
	public function setAtendimentoId($atendimentoIdNovo)
	{
		$this->atendimentoId = $atendimentoIdNovo;
	}
	public function setIncidenteId($incidenteIdNovo)
	{
		$this->incidenteId = $incidenteIdNovo;
	}
	//SETS - fim

	//GETS
	public function getAtendimentoId()
	{
		return $this->atendimentoId;
	}
	public function getIncidenteId()
	{
		return $this->incidenteId;
	}
	//GETS - fim


	public function create()
	{
		if ( !empty($this->dadosP['param']) )
		{
			//busca incidente
			$idincidente = new Integer( $this->dadosP['param'] );
			$this->Incidentes_sp->setidincidentes( $idincidente );

//            var_dump($this->Incidentes_sp->getidInstalacao());

			$this->Usuarios_sp->getListaUsuariosIncidente();
			$idinstalacao = $this->Incidentes_sp->getidInstalacao();
			$idinstalacao = $idinstalacao[0]['instalacoes_idinstalacoes'];

			$lista_atendentes = $this->Usuarios_sp->getListaUsuarios();
//            print_b($lista_atendentes,true);
			for($i=0;$i<count($lista_atendentes);$i++)
			{
				$lista_atendentes[$i]['nome'] = $this->Helpers->limitaTexto(trim($lista_atendentes[$i]['nome']),24);
			}


			$autorizacao = $this->verificaPermissaoUsuarioAtual( $this->Atendimento_sp );

			//busca tipo_atendimento
			$lista_tipo_atendimento = $this->TipoAtendimento_sp->getListaTipoAtendimento();

//			var_dump($lista_atendentes);

			$this->smarty->assign('param',$this->dadosP['param']);
			$this->smarty->assign('lista_atendentes',$lista_atendentes);
			$this->smarty->assign('tipo_atendimento',$lista_tipo_atendimento);
			$this->smarty->assign('autorizacao',$autorizacao);
			$this->smarty->assign('instalacoes_idinstalacoes',$idinstalacao);
			$this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
			$this->smarty->display("{$this->tplDir}/new.tpl");
		}
	}

	public function insert()
	{
		if( $this->dadosP['form'] ){

			//busca saom
			$this->Saom->getsaomPeloNome( $_SESSION['SAOM'] );
			$this->dadosP['form']['saom'] = $this->Saom->getid_saom();

			//TRATAMENTO PARA ASSINATURA DE MODIFICAÇÃO ATUAL DO ATENDIMENTO
			$status_atendimento = new Integer( $this->dadosP['form']['status_atend_idstatus_atend'] );
			$novoStatus = $this->StatusAtendimento_sp->getStatusAtendimento( $status_atendimento );

			$atendimentoNovo = ( $this->dadosP['form']['atendimento'] != '' )? $this->dadosP['form']['atendimento'] : '(vazio)' ;
			$atendimento_anterior = ( isset($this->dadosP['form']['atendimento_anterior']) )? $this->dadosP['form']['atendimento_anterior'] : '' ;
//	        	$agora = date('d/m/Y H:i:s');

			$this->dadosP['form']['mensagem'] = $atendimentoNovo;

			$this->dadosP['form']['atendimento'] = "<div class='atendmensagem'><table border='1' width='100%'><tr id='tr1'><td id='td1' align='center'><div id='atenddados'><b>".$_SESSION['login']['nome']."</b></br><p>".$_SESSION['login']['funcao']."</p></br></br></div></td>".
				"<td><div id='dadosmensagem'>".$atendimentoNovo."\n".$novoStatus."\n</div></td></tr>".
				"<tr><td id='td1' height='30px'></td><td></td></tr>".
				"<div id='publicado'>&nbsp;&nbsp;Publicado em : ".date('d/m/Y H:i:s')."</div></table></div>\n".
				$atendimento_anterior;


//                    $atendimento_anterior."\n".
//	        	'<b>'.$_SESSION['login']['nome']. $agora.'</b>'."\n".
//	        	$atendimentoNovo."\n".
//                $novoStatus;

			//TRATAMENTO PARA ASSINATURA DE MODIFICAÇÃO ATUAL DO ATENDIMENTO - fim


			$this->Atendimento_sp->montaObjetoDoForm( $this->dadosP['form'] );
			$return = $this->Atendimento_sp->create();

			if( !$return )
				exit("<div class='alert alert-error'>Houve um erro ao inserir atendimento.</div>");

			else
			{
				//registra log
				$registroDeLog = $this->Log->registraLog(
					'atend_vsat_sp',
					$return,
					1,
					'Criação de atendimento.'
				);
				if(!$registroDeLog)
					exit("<div class='alert alert-error'>Erro no registro do log.</div>");

				//zera a data final de incidente
				if(!$this->DBCronometro->zeraDataFinalIncidente($this->dadosP['form']['incidentes_idincidentes'],'incidentes_sp'))
					exit("<div class='alert alert-error'>Erro: incidente não zerado.</div>");

				//cria cronometro atendimento
				$sql = "INSERT INTO cronometro_sp (idreferencia, data_inicio ,inicio_tarefa, tabelareferencia)
            				VALUES ('{$return}','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','atend_vsat_sp')";
				if(!$this->DBPadrao->query($sql))
					exit("<div class='alert alert-error'>Erro: cronometro para atendimento não gerado.</div>");

				exit("<div class='alert alert-success'>Cadastro efetuado com sucesso!</div>");
			}
		}
	}


	public function edit()
	{
		if( !empty($this->dadosP['param'] ) )
		{

			$autorizacao = 1;



			$this->Atendimento_sp->setidatend_vsat( $this->dadosP['param'] );
//            echo die_json('teste');
			$this->Atendimento_sp->getAtendimentoObject();

//            echo die_json($this->Atendimento_sp->getinstalacoes_sp_idinstalacoes_sp());

			//BUSCA tipo_atendimento
			$lista_tipo_atendimento = $this->TipoAtendimento_sp->getListaTipoAtendimento();

			//BUSCA ATENDENTES POSSIVEIS (campo)
			$this->Usuarios_sp->getListaUsuariosIncidente();
			$lista_atendentes = $this->Usuarios_sp->getListaUsuarios();
//       			print_b($lista_atendentes,true);
			for($i=0;$i<count($lista_atendentes);$i++)
			{
				$lista_atendentes[$i]['nome'] = $this->Helpers->limitaTexto(trim($lista_atendentes[$i]['nome']),24);
			}

			//VERIFICA PERMISSAO DO USUARIO ATUAL
			$autorizacao = $this->verificaPermissaoUsuarioAtual( $this->Atendimento_sp );

			//BUSCA LISTA DE MOTIVOS
			$this->MotivoAtendimento_sp->resgataListaMotivos();
			$this->smarty->assign('motivos', $this->MotivoAtendimento_sp->getlistaMotivos() );
			//BUSCA LISTA DE RESPONSAVEL
			$this->ResponsavelAtendimento_sp->resgataListaResponsavelAtendimento();
			$this->smarty->assign('responsaveis', $this->ResponsavelAtendimento_sp->getlistaResponsavelAtendimento());

			$linhas = $this->Atendimento_sp->getatendimentoArray();
			$this->incidente_sp->incidenteFacade( $linhas['incidentes_sp_idincidentes'] );
			$inicio_tarefa =  explode(" ", $this->incidente_sp->incidenteFacade['cronometro']['inicio_tarefa']);
			$hms = explode(" ", $this->incidente_sp->incidenteFacade['tempoTranscorrido']);


//			$diffHoras = (strtotime($inicio_tarefa[1]) + strtotime($hms[1]))+12500;
//			$output = date('H:i:s', $diffHoras);
//
//			$a['msg'] = $output;
//			die_json($a);


			$this->buscaAssociacoesMotivosDeAtendimento( $this->dadosP['param'] );

			$this->smarty->assign('autorizacao',$autorizacao);
			$this->smarty->assign('lista_atendentes',$lista_atendentes);
			$this->smarty->assign('tipo_atendimento',$lista_tipo_atendimento);
			$this->smarty->assign('tempo_transcorrido',$this->incidente_sp->incidenteFacade['tempoTranscorrido']);
			$this->smarty->assign('obj',$linhas);
			$this->smarty->display("{$this->tplDir}/edit.tpl");
		}
	}

	private function buscaAssociacoesMotivosDeAtendimento( $idatendimento )
	{
		$this->AssociacaoAtendimentoMotivo_sp->buscaMotivosDeAtendimentoOrganizadoPeloTipoDoMotivo( $idatendimento );
		$this->smarty->assign('motivosJaPresentes', $this->AssociacaoAtendimentoMotivo_sp->getmotivosDeAtendimento() );
	}

	private function verificaPermissaoUsuarioAtual( AtendVsat_spBO $atendimento )
	{
		// BUSCA USUARIO DE ATENDIMENTO
		$atendimentoBuscado = $atendimento->getusuarios_idusuarios();

		if(
			( $atendimentoBuscado != $_SESSION['login']['idusuarios'] ) &&
			(
				$_SESSION['login']['perfis_idperfis'] != 4 &&
				$_SESSION['login']['perfis_idperfis'] != 5 &&
				$_SESSION['login']['perfis_idperfis'] != 1
			)
		)
			return false;
		else
			return true;
	}
	public function historico_atendVsat($idatend_vsat, $perfil, $status_atend, $tempoTranscorrido, $paralisacao){


		$paralisacao = ($paralisacao == '')? 'Despausado':'Pausado';

		$historico['idatend_vsat'] = $idatend_vsat;
		$historico['idusuarios'] = $_SESSION['login']['idusuarios'];
		$historico['data'] = date('Y-m-d H:i:s');
		$historico['tempoTranscorrido'] = $tempoTranscorrido;
		$historico['perfil_ordem'] = $perfil;
		$historico['status_paralisacao'] = $paralisacao;
		$historico['status_atend'] = $status_atend;

		$sql = "INSERT INTO historico_atend_sp(atend_vsat_sp_idatend_vsat, usuarios_idusuarios, data_atend, intervalo_time, perfil_atend, paralisacao, status_atend)
            				VALUES (
            				'{$historico['idatend_vsat']}',
            				'{$historico['idusuarios']}',
            				'{$historico['data']}',
            				'{$historico['tempoTranscorrido']}',
            				'{$historico['perfil_ordem']}',
            				'{$historico['status_paralisacao']}',
            				'{$historico['status_atend']}'
            				)";
//		$a['msg'] = $sql;
//		die_json($a);
		if(!$this->DBPadrao->query($sql))
			exit("<div class='alert alert-error'>Erro: cronometro para atendimento não gerado.</div>");



	}

	public function update()
	{

		if ( ! empty($this->dadosP['form']) )
		{



			//verifica resposta agilis
			if( $this->dadosP['form']['resposta_agilis']=='' && $this->dadosP['form']['status_atend_idstatus_atend']==3 )
				exit('<div class="alert alert-error">Resposta Agilis deve estar preenchido para finalizar Atendimento.</div>');


			$this->Atendimento_sp->setidatend_vsat( $this->dadosP['form']['idatend_vsat']);
			$this->Atendimento_sp->getAtendimentoObject();
			$linhas = $this->Atendimento_sp->getatendimentoArray();

			//atendimento
			$this->Atendimento_sp->setidatend_vsat( $this->dadosP['form']['idatend_vsat'] );
			$this->Atendimento_sp->getAtendimentoObject();
//        	echo die_json($this->dadosP['form']);

			//incidente
			$idincidentes = new Integer( $this->Atendimento_sp->getincidentes_sp_idincidentes() );
			$this->Incidentes_sp->setidincidentes( $idincidentes );
			$this->Incidentes_sp->getIncidente();


			//Chamando o local do Arquivo
			$this->AtendArquivo_sp->getAtendimentoDeArquivo( $this->dadosP['form']['idatend_vsat']);
			$atendarquivos = $this->AtendArquivo_sp->getlistaAtendArquivo();

			//atualiza cronometro
			//TODO: bagunça
//         	$dataNova = null;
			$this->incidente_sp->incidenteFacade( $linhas['incidentes_sp_idincidentes'] );
			$ordem = $this->incidente_sp->incidenteFacade['cronometro']['ordem'];
			$status_paralizacao = $this->incidente_sp->incidenteFacade['cronometro']['data_pausa'];
			$tempoPercorrido = $this->incidente_sp->incidenteFacade['tempoTranscorrido'];



			if($this->dadosP['form']['status_atend_idstatus_atend'] != 3 ){
				if($_SESSION['login']['perfis_idperfis'] != 10){
					if($ordem != 'noc'){
						$dataNova = date('Y-m-d H:i:s');
						$perfil = 'noc';
						$tarefa = "inicio_tarefa = '{$dataNova}', ordem = '$perfil'" ;
					}else{
						$perfil = 'noc';
						$tarefa = "final_tarefa = NULL";
					}

					$sql = "DELETE FROM atend_vsat_envio_sp WHERE numero_ticket = '{$linhas['incidentes_sp_idincidentes']}' ";
					$this->DBPadrao->query($sql);

					$sql = "UPDATE atend_resposta_sp SET resposta = 's'
							WHERE idatend_vsat = '{$this->dadosP['form']['idatend_vsat']}'";
					$this->DBPadrao->query($sql);

				}else{
					if($ordem != 'cliente'){
						$dataNova = date('Y-m-d H:i:s');
						$perfil = 'cliente';
						$tarefa = "inicio_tarefa = '{$dataNova}', ordem = '$perfil'";
					}else{
						$perfil = 'cliente';
						$tarefa = "final_tarefa = NULL";
					}

					$sql = "DELETE FROM atend_vsat_envio_sp WHERE numero_ticket = '{$linhas['incidentes_sp_idincidentes']}' ";
					$this->DBPadrao->query($sql);

					$sql = "UPDATE atend_resposta_sp SET resposta = 's'
							WHERE idatend_vsat = '{$this->dadosP['form']['idatend_vsat']}'";
					$this->DBPadrao->query($sql);

				}

			}else{ //Finalizado
				$perfil = 'noc';
				$dataNova = date('Y-m-d H:i:s');
				$tarefa = "final_tarefa = '{$dataNova}'";

				$sql = "DELETE FROM atend_vsat_envio_sp WHERE numero_ticket = '{$linhas['incidentes_sp_idincidentes']}' ";
				$this->DBPadrao->query($sql);
			}

			$sql = "
				UPDATE cronometro_sp SET $tarefa
				WHERE
					idreferencia = '{$this->dadosP['form']['idatend_vsat']}' AND
					tabelareferencia = 'atend_vsat_sp'
			";

			if( !$this->DBPadrao->query($sql) )
				exit('<div class="alert alert-error">Erro ao modificar data final de atendimento.</div>');


			//TRATAMENTO PARA ASSINATURA DE MODIFICAÇÃO ATUAL DO ATENDIMENTO
			//TODO: bagunça

			foreach($atendarquivos as $atendarquivo ){
				if($atendarquivo['atendente'] == $_SESSION['login']['nome']){
					$arquivo = $atendarquivo['nome'];
					$tipo = explode('.', $arquivo);
					if($tipo[1] == 'pdf' || $tipo[1] == 'PDF'){
						$href = "<img src='upload/atend_arquivo_sp/icon/file_extension_pdf.png' width='12px' height='12px'><a target='_blank' href='upload/atend_arquivo_sp/$arquivo' title='$arquivo'>$arquivo</a>";
					}elseif($tipo[1] == 'jpeg' || $tipo[1] == 'JPEG'){
						$href = "<img src='upload/atend_arquivo_sp/icon/file_extension_jpeg.png' width='12px' height='12px'><a target='_blank' href='upload/atend_arquivo_sp/$arquivo' title='$arquivo'>$arquivo</a>";
					}elseif($tipo[1] == 'jpg' || $tipo[1] == 'JPG'){
						$href = "<img src='upload/atend_arquivo_sp/icon/file_extension_jpg.png' width='12px' height='12px'><a target='_blank' href='upload/atend_arquivo_sp/$arquivo' title='$arquivo'>$arquivo</a>";
					}elseif($tipo[1] == 'png' || $tipo[1] == 'PNG'){
						$href = "<img src='upload/atend_arquivo_sp/icon/file_extension_png.png' width='12px' height='12px'><a target='_blank' href='upload/atend_arquivo_sp/$arquivo' title='$arquivo'>$arquivo</a>";

					}
					$nome[] =  $href;
					$nomearquivo = implode("','", $nome);
				}
			}


			$idStatusAtendimento = new Integer( $this->dadosP['form']['status_atend_idstatus_atend'] );
			$status = $this->StatusAtendimento_sp->getStatusAtendimento( $idStatusAtendimento );

			$this->dadosP['form']['atendimento_anterior'] = $linhas['atendimento'];
			$this->dadosP['form']['atendimento_anterior_privado'] = $linhas['privado'];

			$this->dadosP['form']['data'] = $linhas['data'];

			$horas = ($this->dadosP['form']['horas'] != '')?$this->dadosP['form']['horas']:'';
			$minutos = ($this->dadosP['form']['minutos'] != '')?$this->dadosP['form']['minutos']:'';

			$resposta_agilis = $this->dadosP['form']['resposta_agilis'];

			$atendimentoNovo = ( $this->dadosP['form']['atendimento'] != '' )?$this->dadosP['form']['atendimento']:'(vazio)';

			$enviado = ($this->dadosP['form']['email'])? "Enviado para : " . $this->dadosP['form']['email']:'';

			$atendimento =  "<div class='atendmensagem'>".
				"<table border='1' width='100%'>".
				"<tr id='tr1'>".
				"<td id='td1' align='center' valign='top'>".
				"<div id='atenddados'>".
				"<b>".$_SESSION['login']['nome']."</b></br>".
				"<p>".$_SESSION['login']['funcao']."</p></br></br>".
				"</div>".
				"</td>".
				"<td valign='top' style='height: auto;'>".
				"<div id='envioEmail'>$enviado</div>".
				"<div id='arquivos1'>".$nomearquivo."</div>".
				"<div id='dadosmensagem'>".$atendimentoNovo."\n".$status."\n</div>".
				"</td>".
				"</tr>".
				"<tr>".
				"<td id='td1'>".
				"<div id='privadodados'>".
				"<b>Privado</b></br>".
				"</div>".
				"</td>".
				"<td  valign='top'>".
				"<div class='dadosprivado'>".$resposta_agilis."</div>".
				"</td>".
				"</tr>".
				"<div id='publicado'>&nbsp;&nbsp;Publicado em: " . date('d/m/Y H:i:s')."</div>".
				"</table>".
				"</div>\n".
				$this->dadosP['form']['atendimento_anterior'];
			$this->Atendimento_sp->setatendimento($atendimento);



			$privado =  "<div class='atendmensagem'>".
				"<table border='1' width='100%'>".
				"<tr id='tr1'>".
				"<td id='td1' align='center' valign='top'>".
				"<div id='atenddados'>".
				"<b>".$_SESSION['login']['nome']."</b></br>".
				"<p>".$_SESSION['login']['funcao']."</p></br></br>".
				"</div>".
				"</td>".
				"<td valign='top' style='height: auto;'>".
				"<div id='envioEmail'>$enviado</div>".
				"<div id='arquivos1'>".$nomearquivo."</div>".
				"<div id='dadosmensagem'>".$atendimentoNovo."\n".$status."\n</div>".
				"</td>".
				"</tr>".
				"<tr>".
				"<td id='td1' height='30px'></td><td></td>".
				"</tr>".
				"<div id='publicado'>&nbsp;&nbsp;Publicado em: " . date('d/m/Y H:i:s')."</div>".
				"</table>".
				"</div>\n".
				$this->dadosP['form']['atendimento_anterior_privado'];
			$this->Atendimento_sp->setprivado($privado);

			//atualiza dados restantes
			$this->Atendimento_sp->setstatus_atend_idstatus_atend( $this->dadosP['form']['status_atend_idstatus_atend'] );
			$this->Atendimento_sp->settipo_atendimento_idtipo_atendimento( $this->dadosP['form']['tipo_atendimento_idtipo_atendimento'] );
			$this->Atendimento_sp->setresposta_agilis( $this->dadosP['form']['resposta_agilis'] );


			$return = $this->Atendimento_sp->edit();

			$dataTime = date('Y-m-d H:i:s');

			$sql = "INSERT INTO atend_resposta_sp (idatend_vsat, nome_usuario, data_time, mensagem, status, tempo, horas, minutos)
                                    VALUES (
                                    '{$this->dadosP['form']['idatend_vsat']}',
                                    '{$_SESSION['login']['nome']}',
                                    '$dataTime',
                                    '{$this->dadosP['form']['atendimento']}',
									'$status',
                                    2,
                                    $horas,
                                    $minutos
                                    )
                                    ";


			$this->DBPadrao->query($sql);

			if( $return == 'erro' )
				exit('<div class="alert alert-error">Houve um erro ao editar atendimento.</div>');

			else
			{
				//registra log
				$registroDeLog = $this->Log->registraLog(
					'atend_vsat_sp',
					$this->dadosP['form']['idatend_vsat'],
					2,
					'Edição de atendimento.'
				);
				if(!$registroDeLog)
					exit('Erro no registro do log.');

				if( $this->dadosP['form']['novoResponsavel'] != '' )
				{
					$novoResponsavel = new Integer( $this->dadosP['form']['novoResponsavel'] );

					$teste = $this->repassaAtendimento( $novoResponsavel );

					if ($teste) {
						exit('<div class="alert alert-success">Esta OK!</div>');
					}
				}
				$this->Instalacao_sp->setidinstalacoes_sp( $this->dadosP['form']['instalacoes_sp_idinstalacoes_sp'] );
				$this->Instalacao_sp->getInstalacao();
				//$instalacaoDados = $instalacao->view();
				$instalacaoDados = $this->Instalacao_sp->getinstalacaoArray();
				$descricao = nl2br($this->dadosP['form']['atendimento']);

				switch($this->dadosP['form']['status_atend_idstatus_atend']){
					case 1: $status = 'Aberto'; break;
					case 2: $status = 'Em Atendimento'; break;
					case 3: $status = 'Finalizado'; break;
				}
				$listaUsuarios = $this->DBUsuarios->liste();


				$emails = '';
				foreach($listaUsuarios  as $listaUsuario){
					if ($listaUsuario['idusuarios'] == $this->dadosP['form']['novoResponsavel']){
						$tecnico = $listaUsuario['nome'];
						$idtecnico = $listaUsuario['idusuarios'];
					}
					if($listaUsuario['empresas_idempresas'] == $osspdados['empresas_idempresas']){
						if($emails!=''){
							$emails .= ','.$listaUsuario['email'];

						}else{
							$emails .= $listaUsuario['email'];
						}

					}
				}

				if($idtecnico){
					$tec = $this->alterarTecnicoResponsavel($linhas, $idtecnico);
				}

				$this->historico_atendVsat(
					$this->dadosP['form']['idatend_vsat'],
					$perfil,
					$status,
					$tempoPercorrido,
					$status_paralizacao
				);

				if($status == 'Finalizado'){

					$idatend = $this->dadosP['form']['idatend_vsat'];
					$url = "/avaliacao/index.php?idatend=$idatend";
					$tempo = date('Y-m-d');

					$sql = "INSERT INTO satisfacao (idatend, tecnico, tempo, url)
							VALUE ('$idatend','$tecnico','$tempo','$url')";

					$this->DBPadrao->query($sql);
				}


				$idincidente = $this->dadosP['form']['incidentes_sp_idincidentes'];

				$dataPublicacao = $this->dadosP['form']['data'];

				$idempresa = $this->DBOs_sp->carrega($instalacaoDados['os_sp_idos']);

				$email = new Emails_spModel($this->adapter->getAdapterZend());
				$listaEmails = $email->fetchAll()->toArray();

				$email = array();
				$email_secundario = array();
				foreach ($listaEmails as $emails){
					if($idempresa['empresas_idempresas'] == $emails['empresas_idempresas']){
						$email[] = $emails['to2'];
					}
				}
				if($this->dadosP['form']['email']){
					$email_secundario = explode(',',$this->dadosP['form']['email']);
				}
				$lista = array_merge($email, $email_secundario);
				$to = ['noc.sp@globaleagle.com'];
				$to2 = $lista;
//				$to = ['celio.batalha@globaleagle.com'];
//				$to2 = ['celio.batalha@gmail.com'];

				if(!($status == 'Finalizado')){

					$assunto = 'Atendimento - Ticket Nº:  '.$idincidente ;
					$msg = "O Ticket Nº:  ".$idincidente ."  Foi Atualizado".'<br/>'.
						"Instalação :".$instalacaoDados['nome'] .'<br/>'.
						"Usuário : ".$_SESSION['login']['nome'].'<br/>'.
						"Tecnico NOC Responsavel : " .$tecnico.'<br/>'.
//						"Acesse o Incidente: <a href='http://saom.vodanet-telecom.com/SP#listaincidentes_sp'> aqui</a>".
						'<br/>'.
						"===================================================================".
						'<br/>'.
						"Data de Envio : " . date('Y-m-d H:i:s').'<br/>'.
						"Ultima Modificação : " . $dataPublicacao.'<br/>'.
						"Status : " .$status.'</br>'.
						"===================================================================".
						'<br/>'.
						"<br/>".
						"Descrição : " .$descricao.'<br/>'.
						"</br>".
						"<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='300'/>";

					$assunto2 = 'Atendimento Enviado - Ticket Nº:  '.$idincidente ;
					$msg2 = "O Ticket Nº:  ".$idincidente ."  Foi Atualizado".'<br/>'.
						"Instalação :".$instalacaoDados['nome'] .'<br/>'.
						"Usuário : ".$_SESSION['login']['nome'].'<br/>'.
						"Tecnico NOC Responsavel : " .$tecnico.'<br/>'.
//						"Acesse o Incidente: <a href='http://saom.vodanet-telecom.com/SP#listaincidentes_sp'> aqui</a>".'<br/>'.
						"===================================================================".'<br/>'.
						"Data de Envio : " . date('Y-m-d H:i:s').'<br/>'.
						"Ultima Modificação : " . $dataPublicacao.'<br/>'.
						"Status : " .$status.'<br/>'.
						"===================================================================".'<br/>'.
						"Descrição : " .$descricao.'<br/>'.
						"</br>".
						"<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='300'/>";


				}else{
					$assunto = 'Atendimento Finalizado - SAOM';
					$msg = "O Ticket Nº:  ".$idincidente ."  Foi Atualizado".'<br/>'.
						"Instalação :   ".$instalacaoDados['nome'].'<br/>'.
						"Tecnico NOC Responsavel:  ".$tecnico.'<br/>'.
						"Status : " .$status.'</br>'.
//						"Acesse o Ticket: <a href='http://saom.vodanet-telecom.com/SP#listaincidentes_sp'> aqui</a>".'<br/>'.
						"===================================================================".'<br/>'.
						"Data de Envio : " . date('Y-m-d H:i:s').'<br/>'.
						"Ultima Modificação : " . $dataPublicacao.'<br/>'.
						"</br>".
						"===================================================================".'<br/>'.
						"Descrição : " .$descricao.'</br>'.
						"<br/><br/><br/><br/>".
						//                    "Prioridade : " .$this->dadosP['form']['prioridade'].'<br/>'.
						"<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='300'/>";

					$assunto2 = 'Atendimento Finalizado - SAOM';
					$msg2 = "O Ticket Nº:  ".$idincidente ."  Foi Atualizado".'<br/>'.
						"Instalação :".$instalacaoDados['nome'].'<br/>'.
						"Tecnico NOC Responsavel : " .$tecnico.'<br/>'.
						"Status : " .$status.'</br>'.
//						"Acesse o Ticket: <a href='http://saom.vodanet-telecom.com/SP#listaincidentes_sp'> aqui</a>".'<br/>'.
						"===================================================================".'<br/>'.
						"Data de Envio : " . date('Y-m-d H:i:s').'<br/>'.
						"Ultima Modificação : " . $dataPublicacao.'<br/>'.
						"</br>".
						"===================================================================".'<br/>'.
						"Descrição : " .$descricao.'</br>'.
						"<br/><br/>".
						"(<a href='https://saom.globaleagle.com.br/avaliacao/index.php?idatend=$idatend'>Click aqui</a>) para fazer Avaliação do nosso Atendimento.".
						"<br/><br/>".
						//                    "Prioridade : " .$this->dadosP['form']['prioridade'].'<br/>'.
						"<img src='https://saom.globaleagle.com.br/public/imagens/logo_gee.png' height='50' width='300'/>";

				}

				//Envio de Email para NOC - fim
				if(!sendMailIncidente($assunto, $to, $msg)){
					$arrReturn['status']  = 'erro';
					$arrReturn['msg']     = 'Erro ao enviar Email!';
					die_json($arrReturn);
				}elseif(!sendMailAberturaIncidente($assunto2, $to2, $msg2)){
					$arrReturn['status']  = 'erro';
					$arrReturn['msg']     = 'Erro ao enviar Email!';
					die_json($arrReturn);
				}
				exit('<div class="alert alert-success">Edição realizada com sucesso!</div>');
				$arrReturn['status']  = 'ok';
				$arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
				$arrReturn['idinserido'] = $return;

			}
		}
	}


	public function alterarTecnicoResponsavel($linhasIncidentes, $idusuario){


		$inteiro = new Integer($idusuario);
		$usuario = $inteiro->numero();

		$idincidentes = $linhasIncidentes['incidentes_sp_idincidentes'];
		$sql = "
            		UPDATE incidentes_sp
            		SET tecnicoNoc = $usuario
            		WHERE idincidentes = $idincidentes
            	";
		$this->DBPadrao->query($sql);
	}

	private function repassaAtendimento( Integer $novoResponsavel )
	{

		$atendimento_pai = $this->Atendimento_sp->getatendimento_pai();
		if( !empty($atendimento_pai) )
			$this->criaAtendimentoRepassado( $novoResponsavel );
		else


			$this->atualizaResponsavelPorAtendimento( $novoResponsavel );

		$this->Usuarios_sp->setidusuarios( $novoResponsavel );
		$this->Usuarios_sp->getUsuario();

		$idincidentes = new Integer( $this->Atendimento_sp->getincidentes_sp_idincidentes() );
		$this->Incidentes_sp->setidincidentes( $idincidentes );
		$this->Incidentes_sp->getIncidente();

		//ENVIA EMAIL PARA USUARIO CONVOCADO
// 	    $this->enviaEmailDeRepasseDeAtendimento( 
// 	    	$this->Usuarios , 
// 	    	$this->Incidentes ,
// 	    	$this->Atendimento 
// 	    );
	}

	private function enviaEmailDeRepasseDeAtendimento(
		UsuariosBO $responsavel ,
		IncidentesBO $incidente ,
		AtendVsatBO $atendimento
	)
	{
		$assunto = "Atendimento Repassado: ".$responsavel->getnome();
		$msg = "Foi repassado o seguinte atendimento do incidente {$incidente->getidincidentes()}:<br/>";
		$atendimento_texto = nl2br($atendimento->getatendimento());
		$msg .= "{$atendimento_texto} para {$responsavel->getnome()} <br/><br/>";
		$msg .= "SAOM - Sistema de Apoio à Operação e Manutenção";
		sendMailEspecifico($assunto, $msg, $responsavel->getemail());
	}

	private function criaAtendimentoRepassado( Integer $novoResponsavel )
	{
		$this->Atendimento_sp->setdata( date('Y-m-d H:i:s') );
		$this->Atendimento_sp->setstatus_atend_idstatus_atend( 1 );
		$this->Atendimento_sp->setusuarios_idusuarios( $novoResponsavel->numero() );
		$this->Atendimento_sp->setincidentes_sp_idincidentes( $this->Atendimento_sp->getincidentes_sp_idincidentes() );
		$this->Atendimento_sp->setatendimento_pai( $this->Atendimento_sp->getidatend_vsat() );
		$this->Atendimento_sp->setresposta_agilis( '' );
		$this->Atendimento_sp->setatendimento( '' );

		$respostaAtendimento = $this->Atendimento_sp->create();

		if( !$resposta )
			exit('Erro ao criar o atendimento para a ação de repassar.');
		else
		{
			$this->Cronometro_sp->setidreferencia( $respostaAtendimento );
			$this->Cronometro_sp->setinicio_tarefa( date('Y-m-d H:i:s') );
			$this->Cronometro_sp->settabelareferencia( 'atend_vsat_sp' );
			$respostaCronometro = $this->Cronometro_sp->create();

			if( !$respostaCronometro )
				exit('Erro ao cadastrar Cronômetro para Atendimento Repassado.');
		}
	}

	private function atualizaResponsavelPorAtendimento( Integer $novoResponsavel )
	{

		$this->Atendimento_sp->setusuarios_idusuarios( $novoResponsavel->numero() );
		$respostaAtendimento = $this->Atendimento_sp->edit();
		if( !$respostaAtendimento )
			exit('Erro mudar a responsabilidade do atendimento.');
	}

	public function view()
	{
		if ( ! empty($this->dadosP['param']))
		{

			$this->DB->setPrkValue($this->dadosP['param']);

			$dados = $this->DB->view();
			$this->dado = $dados['rel']['usuarios']['nome'];

//			echo die_json($dados['rel']['usuarios']['nome']);
//            print_b($dados);

			//USUARIO
			$this->smarty->assign('idusuarios',$_SESSION['login']['idusuarios']);

			$dados['atendimento'] = nl2br($dados['atendimento']);
			$dados['privado'] = nl2br($dados['privado']);
			$dados['perfil_atend'] = $_SESSION['login']['perfis_idperfis'];
//            print_r($dados['perfil_atend']);
			$this->buscaAssociacoesMotivosDeAtendimento( $this->dadosP['param'] );

			$this->AtendArquivo_sp->getAtendimentoDeArquivo( $dados['idatend_vsat']);
			$atendarquivo = $this->AtendArquivo_sp->getlistaAtendArquivo();

			$listaUsuarios = $this->DBUsuario->liste('incidentes = 1');
//            var_dump($dados);

			$this->smarty->assign('listaUsuarios',$listaUsuarios);
			$this->smarty->assign('obj',$dados);
			$this->smarty->assign('atendimentoArquivo',$atendarquivo);
			$this->smarty->display("{$this->tplDir}/view.tpl");
		}
	}

	public function trocaResponsavel(){

		$user = $this->dadosP['form']['usuarios_idusuarios'];
		$sala = ($this->dadosP['form']['sala']? $this->dadosP['form']['sala'] : '2');
		$linhasIncidentes['incidentes_sp_idincidentes'] = $this->dadosP['form']['idincidente'];

		if($this->dadosP['form']['tecnico_ticket']){
			$this->alterarTecnicoResponsavel($linhasIncidentes, $user);
		}

		$sql = "
    		UPDATE atend_vsat_sp
    		SET usuarios_idusuarios = '$user', sala = $sala
    		WHERE idatend_vsat = '{$this->dadosP['form']['idatendVsat']}';
    	";
		
		$result = $this->DB->query($sql);
		if( !$result )
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Erro ao atualizar a troca.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
//     	}

		die_json(array(
			"msg" => "<div class='alert alert-success' style='float:left;'>Responsavel atualizado com sucesso.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
			"status" => "ok"
		));


	}

	public function liste()
	{
		$this->smarty->display("{$this->tplDir}/list.tpl");
	}

	public function listeFonte()
	{
		// Get posted data
		if (isset($_POST['page']))
			$page = $_POST['page'];

		if (isset($_POST['sortname']))
			$sortname = $_POST['sortname'];

		if (isset($_POST['sortorder']))
			$sortorder = $_POST['sortorder'];

		if (isset($_POST['qtype']))
			$qtype = $_POST['qtype'];

		if (isset($_POST['query']))
			$query = $_POST['query'];

		$rp = 20;
		if (isset($_POST['rp']))
			$rp = $_POST['rp'];


		if($_SESSION['login']['perfis_idperfis'] == '10') {
			$empresas = $this->DBEmpresas->listaEmpresas();
			foreach( $empresas AS $chave => $empresa )
			{
				if( $_SESSION['login']['empresas_idempresas'] == $empresa['idempresas']){
					$query = $empresa['empresa'];
					$qtype = 'nome_vsat';
//					if($query == 'Telefonica'){
//						$query = 'VIVO';
//					}else if($query == 'OI-Operacoes'){
//						$query = 'HUB-OI';
//					}
				}
			}
		}

		// Setup sort and search SQL using posted data
		$sortSql = "order by $sortname $sortorder";
		$searchSql = ($qtype != '' && $query != '') ? "where $qtype LIKE '%$query%'" : '';


		// Get total count of records
		$sql = "select count(*) as total
					from listatendimentossp
					{$searchSql}";

		$result = $this->DB->queryDados($sql);
		$total = $result[0]['total'];

		// Setup paging SQL
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";

		// Return JSON data
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();

		$sql = "select *
				from listatendimentossp
				{$searchSql}
				{$sortSql}
				{$limitSql}";

		$results = $this->DB->queryDados($sql);


		$empresaId = $_SESSION['login']['empresas_idempresas'];
		$busca = "(empresas_idempresas = '$empresaId')";
		$osspId =  $this->OSSP->fetchAll($busca);

		$osspId = $osspId->toArray();


		foreach( $results AS $row )
		{

			if($_SESSION['login']['perfis_idperfis']==10) {
				foreach ($osspId as $osspIds) {
					$surch = "(os_sp_idos =" . $osspIds['idos'] . ")";
					if ($install = $this->Instalacao_sp->fetchRow($surch)) {
						if ($install['idinstalacoes_sp'] == $row['idinstalacoes']) {
							$data['rows'][] = array(
								'id' => $row['idatend_vsat'],
								'cell' => array(
									$row['idatend_vsat'],
									$row['idincidentes'],
									utf8_decode(utf8_encode($row['localidade'])),
									utf8_decode(utf8_encode($row['nome_vsat'])),
									//					utf8_decode(utf8_encode($row['hub'])),
									utf8_decode(utf8_encode($row['usuario'])),
									($row['pausa']!='')?'Pausado':$row['status'],
									$row['inicio'],
									$row['fim'],
									$row['tempo_passado']
								)
							);
						}
					}
				}
			}else{
				$data['rows'][] = array(
					'id' => $row['idatend_vsat'],
					'cell' => array(
						$row['idatend_vsat'],
						$row['idincidentes'],
						utf8_decode(utf8_encode($row['localidade'])),
						utf8_decode(utf8_encode($row['nome_vsat'])),
						//					utf8_decode(utf8_encode($row['hub'])),
						utf8_decode(utf8_encode($row['usuario'])),
						($row['pausa']!='')?'Pausado':$row['status'],
						$row['inicio'],
						$row['fim'],
						$row['tempo_passado']
					)
				);
			}
		}
		//print_b($data,true);
//

		echo json_encode($data);
	}

	public function listeFonteFiltro()
	{
		// Get posted data
		if (isset($_POST['page']))
			$page = $_POST['page'];

		if (isset($_POST['sortname']))
			$sortname = $_POST['sortname'];

		if (isset($_POST['sortorder']))
			$sortorder = $_POST['sortorder'];

		if (isset($_POST['qtype']))
			$qtype = $_POST['qtype'];

		if (isset($_POST['query']))
			$query = $_POST['query'];

		if (isset($_POST['rp']))
			$rp = $_POST['rp'];


		$empresas = $this->DBEmpresas->listaEmpresas();
		foreach( $empresas AS $chave => $empresa )
		{
			if( $_SESSION['login']['empresas_idempresas'] == $empresa['idempresas']){
				$vsat = $empresa['empresa'];
//				if($vsat == 'Telefonica'){
//					$vsat = 'VIVO';
//				}else if($vsat == 'OI-Operacoes'){
//					$vsat = 'HUB-OI';
//				}
			}
		}

		if($_SESSION['login']['perfis_idperfis'] == '10' && $query == '') {
			$query = 'nome_vsat LIKE '."'%$vsat%'";
		}else if($_SESSION['login']['perfis_idperfis'] == '10'){
			$campo = explode(" ",$query);
			$nome = explode("%", $campo[2]);
			if($campo[0] != 'nome_vsat'){
				$query .= "AND ".'nome_vsat LIKE '."'%$vsat%'";
			}
			if(stristr($nome[1], $vsat) == false){
				$query = 'nome_vsat LIKE '."'%$vsat%'";;
			}
		}



		// Setup sort and search SQL using posted data
		$sortSql = "order by $sortname $sortorder";
		$searchSql = ($query != '') ? "where $query" : '';



		//FILTRA PELO SAOM
		$saom = ($_SESSION['SAOM'] == 'PRODEMGE')?'1':'2';//ajusta pada o id do saom
		if($saom != 1){
			if($searchSql!='')
				$searchSql .= " AND saom = '{$saom}'";
			else
				$searchSql .= " WHERE saom = '{$saom}'";
		}

		// Get total count of records
		$sql = "select count(*) as total
					from listatendimentossp
					{$searchSql}";
		$result = $this->DB->queryDados($sql);
		$total = $result[0]['total'];

		// Setup paging SQL
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";

		// Return JSON data
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();

		$sql = "select *
				from listatendimentossp
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		$results = $this->DB->queryDados($sql);

		foreach( $results AS $row )
		{
			$data['rows'][] = array(
				'id' => $row['idatend_vsat'],
				'cell' => array(
					$row['idatend_vsat'],
					$row['idincidentes'],
					utf8_decode(utf8_encode($row['localidade'])),
					utf8_decode(utf8_encode($row['nome_vsat'])),
//					utf8_decode(utf8_encode($row['hub'])),
					utf8_decode(utf8_encode($row['usuario'])),
					($row['pausa']!='')?'Pausado':$row['status'],
					$row['inicio'],
					$row['fim'],
					$row['tempo_passado']
				)
			);
		}
		//print_b($data,true);

		echo json_encode($data);
	}

	public function listeAtendsIncidente()
	{
		if( $this->dadosP['param'] )
		{
			$idincidentes = new Integer( $this->dadosP['param'] );
			$this->Atendimento_sp->getAtendimentosDeIncidente( $idincidentes );
			$this->Atendimento_sp->carregaRelacionamentos();
			//print_b($this->Atendimento_sp->getListaAtendimentosComDependenciasArray(),true);
			$atendimentos = $this->Atendimento_sp->getListaAtendimentosComDependenciasArray();
			//print_b($atendimentos,true);
			foreach ( $atendimentos as $chave => $atendimento )
			{
				$atendimentos[$chave]['atendimento'] = substr( $atendimento['atendimento'] , 0 , 100 );
				$atendimentos[$chave]['resposta_agilis'] = substr( $atendimento['resposta_agilis'] , 0 , 100 );
			}

//            var_dump($atendimentos[0]['status']);

			$this->smarty->assign( 'atendimentos' , $atendimentos );
			$this->smarty->assign('incidente',$this->dadosP['param']);
			$this->smarty->assign('login',$_SESSION['login']);
			$this->smarty->display("{$this->tplDir}/listeAtendsIncidente.tpl");
		}
	}

	public function insereMotivoParaAtendimentoFechado()
	{



//     	foreach ( $this->dadosP['form']['motivos'] as $tipo_motivo => $motivo )
//     	{

		if($this->dadosP['form']['idatendimento']['idmotivo'] == '' || $this->dadosP['form']['idresponsavel'] == ''){
//			$arrReturn['msg'] = 'Selecione todos os campos.';
//			die_json($arrReturn);
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Selecione todos os campos!</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
		}


		if( $this->AssociacaoAtendimentoMotivo_sp->verificaExistenciaAssociacaoPeloTipoMotivo( $this->dadosP['form']['idatendimento'] ) ) {
			$atualizacaoMotivo = $this->AssociacaoAtendimentoMotivo_sp->atualizaAssociacoesDeAtendimentoPeloTipo($this->dadosP['form']['idmotivo'], $this->dadosP['form']['idresponsavel'], $this->dadosP['form']['idatendimento']);
		}else {
			$atualizacaoMotivo = $this->AssociacaoAtendimentoMotivo_sp->criaAssociacaoDeAtendimentoComMotivo($this->dadosP['form']['idresponsavel'], $this->dadosP['form']['idmotivo'], $this->dadosP['form']['idatendimento']);
		}

		if( !$atualizacaoMotivo )
			die_json(array(
				"msg" => "<div class='alert alert-error' style='float:left'>Erro ao atualizar motivo.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
				"status" => "erro"
			));
//     	}

		die_json(array(
			"msg" => "<div class='alert alert-success' style='float:left;'>Motivo atualizado com sucesso.</div><img src='public/imagens/loading.gif' style='margin-left:15px;height:26px;width:100px;float:left'/>",
			"status" => "ok"
		));
	}

}

?>
