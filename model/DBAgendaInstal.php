<?php


/**
 * Description of DBOS
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBAgendaInstal extends DBModel 
{
    
    protected $idagenda_instal;
    protected $data;
    protected $contato;
    protected $tel;
    protected $cel;
    protected $obs;
    protected $usuarios_idusuario;
    protected $instalacoes_idinstalacoes;
    protected $usuario_confirm;
//     protected $para_teste;

    protected $tabela = 'agenda_instal';
    protected $rel    = array('os');
    protected $fgk    = array('os_idos');
    protected $prk    = 'idagenda_instal';
    protected $cmpData= array('data');
    
    protected $cmpCheckBox = array(
    							'para_teste'
    							);
    
    /*
     * retirado o campo data da obrigatoriedade ('data') - será obrigatório
     * somente mediante não marcação de 'para_teste'
     */
    protected $cmpReq = array('contato','tel','observacoes');
    
    protected $pag = array('ini'=>0,'end'=>30,'rowspage'=>30);
    
    protected $camposForm = array(
        						'data',
        						'contato',
        						'tel',
        						'cel',
        						'contato_2',
        						'tel_2',
        						'ce	l_2', 
        						'confirm',
        						'nsmodem',
        						'mac',
        						'odu',
        						'nsodu',
        						'antena',
        						'antena_tam', 
        						'antena_ns',
        						'os_idos',
        						'observacoes',
        						'data_temp',
        						'usuarios_idusuarios',
        						'para_teste',	
        						'saom'
    							);
    
    protected $sendMail = array(
	    						'create'=>array(
	    										'assunto'=>'Agendamento criado para OS ',
	    										'msg'=>''
	    										),
	    						'edit'=>array(
	    									'assunto'=>'',
	    									'msg'=>''
	    									)
	    						);
    
    public function  __construct() 
    {
        parent::__construct();    
    }
    
    
    //SETS
    
    //SETS
    
    
    //GETS
    	public function getTabela()
    	{
    		return $this->tabela;
    	}
    //GETS
    
    
    /* ENVIA EMAIL PARA CREATE */
    public function setEmailMsg($dados)
    {
        $this->sendMail['create']['assunto'] = 'Instalação Agendada - '.$dados['rel']['os']['numOS'].' - '.$dados['rel']['os']['cidade'].' ';
        $this->sendMail['create']['msg'] .= 'Uma instalação foi agendada para a OS N° <b>'.$dados['rel']['os']['numOS']."</b>, para a data  <b>".$dados['data']."</b><br><br>";
        $this->sendMail['create']['msg'] .= 'SAOM - Sistema de Apoio à Operação e Manutenção';
    }
    
    /* ENVIA EMAIL PARA EDIT */
	public function setEmailMsgEdit($dados)
    {
    	$this->sendMail['edit']['assunto'] = 'Agendamento Confirmado - '.$dados['rel']['os']['numOS'].' - '.$dados['rel']['os']['cidade'].' ';
        $this->sendMail['edit']['msg'] .= 'Uma instalação foi confirmada por <b>'.$dados['usuario_confirm'].'</b> para a OS N° <b>'.$dados['rel']['os']['numOS']."</b>, para a data  <b>".$dados['data']."</b><br/><br/>";
        $this->sendMail['edit']['msg'] .= 'Localidade: '.$dados['rel']['os']['cidade'].'.<br/>Endereço: '.$dados['rel']['os']['enderecoInstal'].'.<br/> ';
        $this->sendMail['edit']['msg'] .= 'SAOM - Sistema de Apoio à Operação e Manutenção';
        return $this->sendMail;
    }
    
    // ENVIA EMAIL PARA EDICAO DE AGENDAMENTO
	public function setEmailMsgEdit2($dados)
    {
    	$this->sendMail['edit']['assunto'] = 'Agendamento Modificado - '.$dados['rel']['os']['numOS'].' - '.$dados['rel']['os']['cidade'].' ';
        $this->sendMail['edit']['msg'] .= 'OS N° <b>'.$dados['rel']['os']['numOS']."</b>, data  <b>".$dados['data']."</b><br/><br/>";
        $this->sendMail['edit']['msg'] .= 'Localidade: '.$dados['rel']['os']['cidade'].'.<br/>Endereço: '.$dados['rel']['os']['enderecoInstal'].'.<br/> ';
        $this->sendMail['edit']['msg'] .= 'SAOM - Sistema de Apoio à Operação e Manutenção';
        return $this->sendMail;
    }
    
    public function cancelConfirmAgend()
    {
        $sql = "UPDATE ".$this->tabela." SET confirm = '0' WHERE ".$this->tabela.".idagenda_instal =".$this->getPrkValue();
        return $this->query($sql);
    }
    
    public function setaUsuarioQueConfirmou($idAgendaInstal,$idusuario)
    {
    	$sql = "UPDATE agenda_instal SET usuario_confirm = '{$idusuario}' WHERE idagenda_instal = {$idAgendaInstal} ";
    	return $this->query($sql);
    }
    
	public function carrega($idAgenda)
    {
    	$sql = "SELECT * FROM {$this->tabela} WHERE {$this->prk} = '{$idAgenda}' ";
    	//exit($sql);
    	$dados = $this->queryDados($sql);
    	return $dados[0];
    } 
}
?>
