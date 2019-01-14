<?php

/**
 * Description of Controller
 *
 * @author Daniel
 */

// namespace controller;
// use DOMPDF;
// use Helpers;
// use DB;
// use Smarty;

date_default_timezone_set('America/Sao_Paulo');

require_once('libs/Smarty.class.php');
require_once('helpers.php');
require_once('model/DBModel.php');
require_once('s_p/model/DBModel_sp.php');
require_once 'helpers.class.php';
require_once "model/BO/SaomBO.php";
require_once "s_p/model/BO/Saom_spBO.php";
require_once 'helpers/AdapterZend.php';

include_once ("libs/DOMPDF/dompdf/dompdf_config.inc.php");
require_once ("libs/dompdf1/autoload.inc.php");
// ini_set ('display_errors', false);

//zend
require_once 'model/BO/LogBO.php';
require_once 's_p/model/BO/Log_spBO.php';

require_once 'model/BO/InstalacoesBO.php';
require_once 's_p/model/BO/Instalacoes_spBO.php';

require_once 'model/BO/ProdemgeBO.php';
//require_once 's_p/model/BO/Prodemge_spBO.php';

require_once "model/BO/OSBO.php";
require_once "s_p/model/BO/OSSPBO.php";

require_once "s_p/model/BO/PedidoOSBO.php";

require_once "model/BO/EquipamentosBO.php";
require_once "s_p/model/BO/Equipamentos_spBO.php";

require_once "model/BO/EquipamentosLocaisBO.php";
require_once "s_p/model/BO/EquipamentosLocais_spBO.php";

require_once "model/TipoEquipamentosModel.php";
require_once "s_p/model/TipoEquipamentos_spModel.php";

require_once "model/BO/UsuariosBO.php";
require_once "s_p/model/BO/Usuarios_spBO.php";

require_once "s_p/model/BO/Solicitacao_spBO.php";

require_once "model/BO/IncidentesBO.php";
require_once "s_p/model/BO/Incidentes_spBO.php";

require_once "model/PreIncidentesModel.php";
require_once "s_p/model/PreIncidentes_spModel.php";

require_once "model/PreIncidentesNagiosModel.php";
require_once "s_p/model/PreIncidentesNagios_spModel.php";

require_once "model/CronometroModel.php";
require_once "s_p/model/Cronometro_spModel.php";

require_once "model/BO/AtendVsatBO.php";
require_once "s_p/model/BO/AtendVsat_spBO.php";

require_once "model/PerfisModel.php";
require_once "s_p/model/Perfis_spModel.php";

require_once "model/AcompanhamentoModel.php";
require_once "s_p/model/Acompanhamento_spModel.php";

require_once "model/CompartilhamentoModel.php";
require_once "s_p/model/Compartilhamento_spModel.php";

require_once "model/BO/AssociacaoInstalacaoIncidenteBO.php";
require_once "s_p/model/BO/AssociacaoInstalacaoIncidente_spBO.php";

require_once "model/BO/StatusAtendimentoBO.php";
require_once "s_p/model/BO/StatusAtendimento_spBO.php";

require_once "model/BO/TipoAtendimentoBO.php";
require_once "s_p/model/BO/TipoAtendimento_spBO.php";

require_once "model/BO/MunicipiosBO.php";
require_once "s_p/model/BO/Municipios_spBO.php";

require_once "model/BO/TelefonemasParaIncidentesBO.php";
require_once "s_p/model/BO/TelefonemasParaIncidentes_spBO.php";

require_once "model/BO/LicencaAnatelBO.php";
require_once "s_p/model/BO/LicencaAnatel_spBO.php";

require_once "model/BO/MotivoAtendimentoBO.php";
require_once "s_p/model/BO/MotivoAtendimento_spBO.php";

require_once "model/BO/ResponsavelAtendimentoBO.php";
require_once "s_p/model/BO/ResponsavelAtendimento_spBO.php";

require_once "model/BO/AssociacaoAtendimentoMotivoBO.php";
require_once "s_p/model/BO/AssociacaoAtendimentoMotivo_spBO.php";

require_once "model/BO/PerguntasComissionamentoBO.php";
require_once "s_p/model/BO/PerguntasComissionamento_spBO.php";

require_once "model/CacheIncidentesModel.php";
require_once "s_p/model/CacheIncidentes_spModel.php";

require_once "model/BO/TermoResponsabilidadeBO.php";
require_once "s_p/model/BO/TermoResponsabilidade_spBO.php";

require_once "s_p/model/BO/AtendArquivo_spBO.php";

require_once "s_p/model/BO/ContratoSPBO.php";

require_once "model/BO/RelatorioFotograficoBO.php";
require_once "s_p/model/BO/RelatorioFotografico_spBO.php";


// include "libs/DOMPDF/dompdf/dompdf_config.inc.php";

class Controller 
{   
    protected $smarty;
    protected $sistema;
    protected $dadosP;
    protected $dadosG;
    protected $dadosF;
    protected $dadosV;
    protected $DB;
    protected $passagemLivreAtualizacao;
    protected $adapter;
//    protected $atualiza;
    protected $Dompdf;
    
    protected $cumprimento;
    protected $assinaturaSAOM = "
    	SAOM<br/>
		Vodanet Telecomunicações Ltda.<br/>
		http://www.vodanet-telecom.com<br/>
		<img src='http://saom.vodanet-telecom.com/public/imagens/logo_vodanet.jpg'>
    ";
    
    protected $Log;
    protected $Log_sp;

    protected $Instalacao;
    protected $Instalacao_sp;

    protected $Prodemge;
//    protected $Prodemge_sp;

    protected $OS;
    protected $OSSP;

    protected $PedidoOs;

    protected $Equipamento;
    protected $Equipamento_sp;

    protected $TipoEquipamentos;
    protected $TipoEquipamentos_sp;

    protected $EquipamentosLocais;
    protected $EquipamentosLocais_sp;

    protected $Usuarios;
    protected $Usuarios_sp;

    protected $Solicitacao_sp;

    protected $Incidentes;
    protected $Incidentes_sp;

    protected $Cronometro;
    protected $Cronometro_sp;

    protected $Atendimento;
    protected $Atendimento_sp;

    protected $Perfil;
    protected $Perfil_sp;

    protected $Empresa;
    protected $Empresa_sp;

    protected $Saom;
    protected $Saom_sp;

    protected $Acompanhamento;
    protected $Acompanhamento_sp;

    protected $Compartilhamento;
    protected $Compartilhamento_sp;

    protected $StatusAtendimento;
    protected $StatusAtendimento_sp;

    protected $Municipio;
    protected $Municipio_sp;

    protected $TelefonemasParaIncidentes;
    protected $TelefonemasParaIncidentes_sp;

    protected $AssociacaoInstalacaoIncidente;
    protected $AssociacaoInstalacaoIncidente_sp;

    protected $LicencaAnatel;
    protected $LicencaAnatel_sp;

    protected $MotivoAtendimento;
    protected $MotivoAtendimento_sp;

    protected $ResponsavelAtendimento;   			//foi alterado MotivoAtendimentoTipo para $ResponsavelAtendimento
    protected $ResponsavelAtendimento_sp;   			//foi alterado MotivoAtendimentoTipo para $ResponsavelAtendimento

    protected $AssociacaoAtendimentoMotivo;
    protected $AssociacaoAtendimentoMotivo_sp;

    protected $PerguntasComissionamento;
    protected $PerguntasComissionamento_sp;

    protected $CacheIncidentesModel;
    protected $CacheIncidentesModel_sp;

    protected $TermoResponsabilidade;
    protected $TermoResponsabilidade_sp;

    protected $AtendArquivo_sp;

    protected $ContratoSP;

    protected $RelatorioFotografico;
    protected $RelatorioFotografico_sp;

    
    public function __construct() 
    {	
    	// -------------------------------------------------------------------------
    	// ----------------- DEFAULT -----------------------------------------------
    	// -------------------------------------------------------------------------
    	
        $this->smarty = new Smarty();
        
        $this->aplicaCumprimento();
        
        //atribui a variavel de login para todos os templates
        if(isset($_SESSION['login']))
            $this->smarty->assign('login',$_SESSION['login']);
        
        //global SAOM para todos os templates
        if( isset($_SESSION['SAOM']) )
        	$this->smarty->assign('SAOM',$_SESSION['SAOM']);
        
        $this->dadosP  = $_POST;
        $this->dadosG  = $_GET;
        
        if(isset($_FILES))
            $this->dadosF  = $_FILES;

        
        if ( ! empty($this->dadosP['form']))
            $this->dadosP['form'] = $this->trataForm($this->dadosP['form']);
            
            
    	// -------------------------------------------------------------------------
    	// ----------------- OBJETOS REQUISITOS ------------------------------------
    	// -------------------------------------------------------------------------
    	
        $this->Dompdf = new Dompdf\Dompdf();

//        $this->Dompdf = new DOMPDF();
        
    	$this->Helpers = new Helpers();
    	
    	$this->DBPadrao = new DB();

        $this->adapter  = new AdapterZend();

//        $this->atualiza  =  new CampoAtualiza();
        // zend
    	$this->Log                             = new LogBO( $this->adapter->getAdapterZend() );
    	$this->Log_sp                             = new Log_spBO( $this->adapter->getAdapterZend() );

        $this->Instalacao                      = new InstalacoesBO( $this->adapter->getAdapterZend() );
    	$this->Instalacao_sp                      = new Instalacoes_spBO( $this->adapter->getAdapterZend() );

    	$this->Prodemge                        = new ProdemgeBO( $this->adapter->getAdapterZend() );
//    	$this->Prodemge_sp                        = new Prodemge_spBO( $this->adapter->getAdapterZend() );

    	$this->OS                              = new OSBO( $this->adapter->getAdapterZend() );
    	$this->OSSP                              = new OSSPBO( $this->adapter->getAdapterZend() );

    	$this->PedidoOs                        = new PedidoOSBO($this->adapter->getAdapterZend() );

        $this->Equipamento                     = new EquipamentosBO( $this->adapter->getAdapterZend() );
        $this->Equipamento_sp                     = new Equipamentos_spBO( $this->adapter->getAdapterZend() );

        $this->TipoEquipamentos                = new TipoEquipamentosBO( $this->adapter->getAdapterZend() );
        $this->TipoEquipamentos_sp                = new TipoEquipamentos_spBO( $this->adapter->getAdapterZend() );

        $this->EquipamentosLocais              = new EquipamentosLocaisBO( $this->adapter->getAdapterZend() );
        $this->EquipamentosLocais_sp              = new EquipamentosLocais_spBO( $this->adapter->getAdapterZend() );

        $this->Usuarios                        = new UsuariosBO( $this->adapter->getAdapterZend() );
        $this->Usuarios_sp                        = new Usuarios_spBO( $this->adapter->getAdapterZend() );

        $this->Solicitacao_sp                  = new Solicitacao_spBO($this->adapter->getAdapterZend());

        $this->Incidentes                      = new IncidentesBO( $this->adapter->getAdapterZend() );
        $this->Incidentes_sp                      = new Incidentes_spBO( $this->adapter->getAdapterZend() );

        $this->PreIncidentes                   = new PreIncidentesModel( $this->adapter->getAdapterZend() );
        $this->PreIncidentes_sp                   = new PreIncidentes_spModel( $this->adapter->getAdapterZend() );

        $this->PreIncidentesNagios             = new PreIncidentesNagiosModel( $this->adapter->getAdapterZend() );
        $this->PreIncidentesNagios_sp             = new PreIncidentesNagios_spModel( $this->adapter->getAdapterZend() );

        $this->Cronometro                      = new CronometroBO( $this->adapter->getAdapterZend() );
        $this->Cronometro_sp                      = new Cronometro_spBO( $this->adapter->getAdapterZend() );

        $this->Atendimento                     = new AtendVsatBO( $this->adapter->getAdapterZend() );
        $this->Atendimento_sp                     = new AtendVsat_spBO( $this->adapter->getAdapterZend() );

        $this->Perfil                          = new PerfisModel( $this->adapter->getAdapterZend() );
        $this->Perfil_sp                          = new PerfisModel( $this->adapter->getAdapterZend() );

        $this->Empresa                         = new EmpresasModel( $this->adapter->getAdapterZend() );
        $this->Empresa_sp                         = new Empresas_spModel( $this->adapter->getAdapterZend() );

        $this->Saom                            = new SaomBO( $this->adapter->getAdapterZend() );
        $this->Saom_sp                            = new Saom_spBO( $this->adapter->getAdapterZend() );

        $this->Acompanhamento                  = new AcompanhamentoModel( $this->adapter->getAdapterZend() );
        $this->Acompanhamento_sp                  = new Acompanhamento_spModel( $this->adapter->getAdapterZend() );

        $this->Compartilhamento                = new CompartilhamentoModel( $this->adapter->getAdapterZend() );
        $this->Compartilhamento_sp                = new Compartilhamento_spModel( $this->adapter->getAdapterZend() );

        $this->Municipio                       = new MunicipiosBO( $this->adapter->getAdapterZend() );
        $this->Municipio_sp                       = new Municipios_spBO( $this->adapter->getAdapterZend() );

        $this->AssociacaoInstalacaoIncidente   = new AssociacaoInstalacaoIncidenteBO( $this->adapter->getAdapterZend() );
        $this->AssociacaoInstalacaoIncidente_sp   = new AssociacaoInstalacaoIncidente_spBO( $this->adapter->getAdapterZend() );

        $this->StatusAtendimento               = new StatusAtendimentoBO( $this->adapter->getAdapterZend() );
        $this->StatusAtendimento_sp               = new StatusAtendimento_spBO( $this->adapter->getAdapterZend() );

        $this->TipoAtendimento                 = new TipoAtendimentoBO( $this->adapter->getAdapterZend() );
        $this->TipoAtendimento_sp                 = new TipoAtendimento_spBO( $this->adapter->getAdapterZend() );

        $this->TelefonemasParaIncidentes       = new TelefonemasParaIncidentesBO( $this->adapter->getAdapterZend() );
        $this->TelefonemasParaIncidentes_sp       = new TelefonemasParaIncidentes_spBO( $this->adapter->getAdapterZend() );

        $this->LicencaAnatel                   = new LicencaAnatelBO( $this->adapter->getAdapterZend() );
        $this->LicencaAnatel_sp                   = new LicencaAnatel_spBO( $this->adapter->getAdapterZend() );

        $this->MotivoAtendimento               = new MotivoAtendimentoBO( $this->adapter->getAdapterZend() );
        $this->MotivoAtendimento_sp               = new MotivoAtendimento_spBO( $this->adapter->getAdapterZend() );

        $this->ResponsavelAtendimento          = new ResponsavelAtendimentoBO( $this->adapter->getAdapterZend() );            //foi alterado MotivoAtendimentoTipo para ResponsavelAtendimento
        $this->ResponsavelAtendimento_sp          = new ResponsavelAtendimento_spBO( $this->adapter->getAdapterZend() );            //foi alterado MotivoAtendimentoTipo para ResponsavelAtendimento

        $this->AssociacaoAtendimentoMotivo     = new AssociacaoAtendimentoMotivoBO( $this->adapter->getAdapterZend() );
        $this->AssociacaoAtendimentoMotivo_sp     = new AssociacaoAtendimentoMotivo_spBO( $this->adapter->getAdapterZend() );

        $this->PerguntasComissionamento        = new PerguntasComissionamentoBO( $this->adapter->getAdapterZend() );
        $this->PerguntasComissionamento_sp        = new PerguntasComissionamento_spBO( $this->adapter->getAdapterZend() );

        $this->CacheIncidentesModel            = new CacheIncidentesModel();
        $this->CacheIncidentesModel_sp            = new CacheIncidentes_spModel();

        $this->TermoResponsabilidade           = new TermoResponsabilidadeBO( $this->adapter->getAdapterZend() );
        $this->TermoResponsabilidade_sp           = new TermoResponsabilidade_spBO( $this->adapter->getAdapterZend() );

        $this->AtendArquivo_sp                 = new AtendArquivo_spBO( $this->adapter->getAdapterZend() );

        $this->ContratoSP                      = new ContratoSPBO( $this->adapter->getAdapterZend() );

        $this->RelatorioFotografico            = new RelatorioFotograficoBO( $this->adapter->getAdapterZend() );
        $this->RelatorioFotografico_sp            = new RelatorioFotografico_spBO( $this->adapter->getAdapterZend() );
    }
    
    //SETS
    	public function setDadosV($novoDadoV)
    	{
    		$this->dadosV = $novoDadoV;
    	}
    //SETS
    
    //GETS
    	public function getDadosV()
    	{
    		return $this->dadosV;
    	}
    //GETS
    
    public function create()
    {
       
		if (empty($this->dadosP['form'])) 
       	{
           
        	if ( ! empty($this->dadosP['param']))
            {
            	$this->smarty->assign('param',$this->dadosP['param']);
            }        
            $this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
            $this->smarty->display("{$this->tplDir}/create.tpl");
       	}
       	else 
       	{
       		//print_b($this->dadosP['form'],true);
       		$return  = $this->DB->create($this->dadosP['form']);
            //print_b($return,true);
       		
            if(count($return['erros'])) 
            {
                $arrReturn['status'] = 'erro';
                $arrReturn['msg']    = implode("<hr>", $return['erros']);
            }
            else 
            {
            	$arrReturn['status']  = 'ok';
                $arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
                //envia email de notificação
                $sendMail = $this->DB->getSendMail();
                //die_r($sendMail);
                if(array_key_exists('create', $sendMail))
                {
                    $this->DB->setPrkValue($return); 
                    $this->DB->setEmailMsg($this->DB->view());
                    $sendMail = $this->DB->getSendMail();
                   
                    sendMail($sendMail['create']['assunto'], $sendMail['create']['msg']);
                }
            }
            die_json($arrReturn);
       	}
    }
    
    public function view() 
    {
        if ( ! empty($this->dadosP['param'])) 
        {
            $this->DB->setPrkValue($this->dadosP['param']);
            $dados = $this->DB->view();
            //print_b($dados,true);
            
            $this->smarty->assign('obj',$dados);
            $this->smarty->display("{$this->tplDir}/view.tpl");
        }
    }
    
    public function view_compact() 
    {
        if ( ! empty($this->dadosP['param'])) 
        {
            $this->DB->setPrkValue($this->dadosP['param']);
            $dados = $this->DB->view();
            
            $this->smarty->assign('obj',$dados);
            $this->smarty->display("{$this->tplDir}/view_compact.tpl");
        }
    }
    
    
    /**
     * Método de edição de Controllers em geral
     */
    public function edit() 
    {
        if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form'])) 
        {
            $this->DB->setPrkValue($this->dadosP['param']);
            $dados = $this->DB->view();
            
            $this->smarty->assign('obj',$dados);
            $this->smarty->display("{$this->tplDir}/edit.tpl");
        }
        elseif ( ! empty($this->dadosP['form']))
        {
        	$return  = $this->DB->edit($this->dadosP['form']);
            
        	if(count($return['erros'])) 
            {    
                $arrReturn['status'] = 'erro';
                $arrReturn['msg']    = implode("<hr>", $return['erros']);
            }
            else 
            {
                $arrReturn['status']  = 'ok';
                $arrReturn['msg']     = 'Edição realizada com sucesso!';
                //EMAIL DE RETORNO
                	if($this->dadosP['form']['confirm']==1)
                	{
		            	$sendMail = $this->DB->getSendMailEdit();
		                if(array_key_exists('edit', $sendMail))
		                {
		                	$this->DB->setPrkValue($this->dadosP['form']['idagenda_instal']);
		                    $this->DB->setEmailMsgEdit($this->DB->view());
		                    $sendMail = $this->DB->getSendMailEdit();
		                    sendMail($sendMail['edit']['assunto'], $sendMail['edit']['msg']);
	                	}
                	}
                //EMAIL DE RETORNO - FIM
            }
            die_json($arrReturn);
        }
    }
    
    public function liste()
    {
	      if ( ! empty($this->dadosP['ini']))
	      {
	          $pag = $this->DB->getPag();
	          $pag['ini'] = $this->dadosP['ini'];
	          $pag['end'] = $this->dadosP['end'];
	          $this->DB->setPag($pag);
	      }  
	      if( isset($this->dadosP['orderBy']))
	      {    
	          $this->DB->setOrderBy($this->dadosP['orderBy']);
	          $this->DB->setDefaultOrder('ASC');
	          
	          $this->smarty->assign('orderBy',$this->dadosP['orderBy']);
	      }
	      
	      $arr = ! empty($this->dadosP['param']) ? $this->DB->liste($this->dadosP['param']) : $this->DB->liste() ;
	      $arr['pag']['url']   = get_class($this)."/liste";
	      
	      $this->smarty->assign('pag',$arr['pag']);
	      unset($arr['pag']);
	      $this->smarty->assign('arr',$arr);
	      //print_b($arr,true);
	      $this->smarty->display("{$this->tplDir}/list.tpl");
	      
    }
    
    public function uploadImg()
    {
    	$this->DB->setPrkValue($this->dadosP['id']);
        
        if( $this->DB->uploadImg($this->dadosF) )
        {        
        	if( $this->dadosP['tipo'] == 'file' )
        		die('<div class="tdGreen">Arquivo anexado com sucesso.</div>');
        	
        	else
        		die('<div class="tdGreen">Imagem anexada com sucesso.</div>');
        	
        }
        else
        {   
        	if( $this->dadosP['tipo'] == 'file' ) 
        		die('<div class="tdRed">Erro ao anexar arquivo.</div>');
        	
        	else
        		die('<div class="tdRed">Erro ao anexar imagem.</div>');
        	
        }
    }
    
    private function trataForm($form)
    {

        $form = addslashes($form);
        parse_str($form, $params);

        return $params;        
    }
    
    //TODO: metodo tem como otimizar e generalizar mais
	public function verificaPreExistenciaDado()
    {
    	if(isset($this->dadosV['campo']))
    	{
    		$dados = $this->dadosV;
    	}
    	else
    	{
    		$dados = $_REQUEST;
    	}
    	
    	//PARA CAMPOS VAZIOS
	    	if($dados['valor']=='')
	    	{
	    		$retorno = false;
	    		exit($retorno);
	    	}
    	
	    $resgate = $this->DB->liste("{$dados['campo']} LIKE '%{$dados['valor']}%'");
	    	
	    if($this->DB->getTabela()=='instalacoes' || $this->DB->getTabela()=='instalacoes_sp')//INSTALACOES
	    {
		    if( count($resgate) > 0 )
	    	{
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}
	    }
	    else if($this->DB->getTabela()=='agenda_instal' || $this->DB->getTabela()=='agenda_instal_sp')//AGENDA INSTAL
	    {
		    if( $resgate['pag']['total'] != 0 && isset($resgate['pag']) )
	    	{
	    		$retorno = true;//'encontrado';
	    		exit($retorno);
	    	}
	    	else
	    	{
	    		$retorno = false;//exit('nenhum');
	    		exit($retorno);
	    	}
	    }
    }
    
    
    //AUTOCOMPLETE DE SNODU's
		public function buscaODU()
	    {
	    	$nsodu = $_POST['odu'];
	    	
	    	$dados = $this->DBEquipamento->liste("sno LIKE '%{$nsodu}%'");

	    	
	    	$html = '';
	    	
	    	for($i=0;$i<count($dados);$i++)
	    	{
	    		$html .= "<div class='elementoAutoComplete' onmouseover='javascript:mouseOverBuscaODU($(this))' onmouseout='javascript:mouseOutBuscaODU($(this))' onclick=\"javascript:onclickBuscaODU('{$dados[$i]['sno']}');\">{$dados[$i]['sno']}</div>";
	    	}
	    	
	    	echo $html;
	    }
    
	    public function resgataODUdeNSODU()
	    {
	    	$nsodu = $_POST['nsodu'];
	    	//$nsodu = '10654604020308090134';
	    	
	    	//print_b($dados,true);
	    	$dados = $this->DB->resgataNomeTipoEquipamentoDeSNOdeEquipamento($nsodu);


	    	echo $dados[0]['idtipo_equipamentos'];exit;
	    }
	    
	    public function verificaExistenciaSNODU()
	    {
	    	$sql = "SELECT e.idequipamentos, e.sno FROM equipamentos e WHERE e.sno = '{$_POST['nsodu']}'";
//                print_r($sql);
	    	$dados = $this->DB->queryDados($sql);
//            echo die_json('teste');
	    	if(count($dados)>0)
	    	{
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}
	    }
	//AUTOCOMPLETE DE SNODU's - fim
	
	    
	/**
	 * Método que atualiza campo no BD de acordo com:
	 * 	1.tabela
	 * 	2.linha(id) 
	 * 	3.campo 
	 * 	4.valor
	 */
    public function atualizaCampo()
    {

        $dados = $this->dadosP;

//        print_r();
//        var_dump($dados['valor']);
//        echo die_json($dados['valor']);
//        echo $dados['valor'];exit;

        $dados = $this->implementaCasosEspecificosDeCamposDeDiferentesTabelas( $dados );
        $valor = addslashes($dados['valor']);

        $linha = addslashes($dados['linha']);

        $sql = "
	    	UPDATE {$dados['tabela']}
	    	SET {$dados['campo']} = '{$valor}'

	    	WHERE {$dados['campo_id']} = '{$linha}';
	    ";
        $this->DB = new DBModel();
        echo $this->DB->query($sql);

    }

    public function atualizaCampo_sp()
    {

        $dados = $this->dadosP;
        $dados = $this->implementaCasosEspecificosDeCamposDeDiferentesTabelasDeSP( $dados );
        $valor = addslashes($dados['valor']);

        $linha = addslashes($dados['linha']);

        $sql = "
	    	UPDATE {$dados['tabela']}
	    	SET {$dados['campo']} = '{$valor}'
	    	WHERE {$dados['campo_id']} = '{$linha}';
	    ";
//        echo $sql;exit

        $this->DB = new DBModel_sp();
        echo $this->DB->query($sql);

    }

    private function implementaCasosEspecificosDeCamposDeDiferentesTabelas( $dados )
    {
        if( $dados['tabela'] == 'instalacoes' )
        {
            if( $dados['campo'] == 'os_ipdvb' )
            {
                $this->Instalacao->setidinstalacoes( $dados['linha'] );
                $this->Instalacao->getInstalacao();

                $dados['campo'] = 'ipdvb';
                $dados['tabela'] = 'os';
                $dados['linha'] = $this->Instalacao->getos_idos();
                $dados['campo_id'] = 'idos';
            }

            if( $dados['campo'] == 'os_iplan' )
            {
                $this->Instalacao->setidinstalacoes( $dados['linha'] );
                $this->Instalacao->getInstalacao();

                $dados['campo'] = 'iplan';
                $dados['tabela'] = 'os';
                $dados['linha'] = $this->Instalacao->getos_idos();
                $dados['campo_id'] = 'idos';
            }
        }

        return $dados;
    }

    private function implementaCasosEspecificosDeCamposDeDiferentesTabelasDeSP( $dados )
    {
        if( $dados['tabela'] == 'instalacoes_sp' )
        {
            if( $dados['campo'] == 'os_ipdvb' )
            {
                $this->Instalacao_sp->setidinstalacoes_sp( $dados['linha'] );
                $this->Instalacao_sp->getInstalacao();

                $dados['campo'] = 'ipdvb';
                $dados['tabela'] = 'os_sp';
                $dados['linha'] = $this->Instalacao_sp->getos_idos();
                $dados['campo_id'] = 'idos';
            }

            if( $dados['campo'] == 'os_iplan' )
            {
                $this->Instalacao_sp->setidinstalacoes_sp($dados['linha'] );
                $this->Instalacao_sp->getInstalacao();

                $dados['campo'] = 'iplan';
                $dados['tabela'] = 'os_sp';
                $dados['linha'] = $this->Instalacao_sp->getos_sp_idos();
                $dados['campo_id'] = 'idos';
            }
        }

        return $dados;
    }
    
    
    
    // -----------------------------------------------------------------
    // ---------------- TRATAMENTO DE FORMULARIOS ----------------------
    // -----------------------------------------------------------------
    
    // metodo que converte valores "on" em 1
    public function trataCheckBox()
    {
    	foreach( $this->form AS $chave => $valor )
    		if( $valor == 'on' || $valor == 1 )
    			$this->form[$chave] = 1;
    }
    
    public function getSaomAtual()
    {
    	$saom = new SaomModel( $this->adapter->getAdapterZend() );
		$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");
		
		return $saom_row->id_saom;
    }

    public function getSaom_spAtual()
    {
    	$saom = new Saom_spModel( $this->adapter->getAdapterZend() );
		$saom_row = $saom->fetchRow("nome = '{$_SESSION['SAOM']}'");

		return $saom_row->id_saom;
    }
    
    // --
    
    
    
    public function aplicaCumprimento()
    {
    	$agora = date('H');
    	if($agora > 00 && $agora < 12)
    		$this->cumprimento = "Bom Dia";
    	
    	else if($agora >= 12 && $agora < 18)
    		$this->cumprimento = "Boa Tarde";
    	
    	else if($agora >= 18)
    		$this->cumprimento = "Boa Noite";
    }

}

?>
