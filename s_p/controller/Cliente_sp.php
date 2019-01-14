<?php

/**
 * Created by PhpStorm.
 * User: celio
 * Date: 18/05/2017
 * Time: 11:02
 */

include_once 'helpers/AdapterZend.php';
include_once 'helpers/Controller.php';
include_once "s_p/model/DBEmpresas_sp.php";
include_once "s_p/model/DBUsuario_sp.php";
include_once 's_p/model/Clientes_spModel.php';
include_once 's_p/model/Emails_spModel.php';

class Cliente_sp extends Controller
{

    protected $tplDir = 's_p/tampletes/cliente';
    protected $form;
    protected $idTabela;


    public function __construct()
    {
        parent::__construct();
        $this->DBEmpresas = new DBEmpresas_sp();
        $this->DBEmails = new DBEmpresas_sp();
        $this->DBUsuarios = new DBUsuario_sp();
    }

    public function create(){


        if (empty($this->dadosP['form']))
        {
//            $empresas = new Empresas_spModel( $this->adapter->getAdapterZend() );
//            $lista_empresa = $empresas->lista();


//            $sql = "SELECT *
//                    FROM empresas
//                    WHERE idempresas NOT IN (select distinct empresas_idempresas from clientes_sp)";
//
//            $buscaClentes = $this->DBEmpresas->queryDados($sql);


//            echo die_json($buscaClentes);

            $listaUsuarios = $this->DBUsuarios->liste('incidentes = 1');

            $this->smarty->assign('param',!empty($this->dadosP['param'])?$this->dadosP['param']:'');
            $this->smarty->assign('listaUsuarios',$listaUsuarios);
            $this->smarty->assign('dataAtual',date('Y-m-d H:i:s'));
            $this->smarty->display("{$this->tplDir}/new.tpl");

        }
        else
        {

//            echo die_json($this->dadosP['form']);

            $this->validation($this->dadosP['form']);

            $this->dadosP['form']['local'] = 'SP';
            $this->dadosP['form']['tipo'] = 'EMP';

            $this->form = $this->dadosP['form'];

            $clientes = new Empresas_spModel($this->adapter->getAdapterZend() );

            $this->trataCheckBox();
            $id = $clientes->insert( $this->form );

            if( $id > 0 )
            {
                $arrReturn['status']  = 'ok';
                $arrReturn['msg']     = 'Cadastro efetuado com sucesso!';

               /* //envia email de notificação
                $sendMail = $this->DB->getSendMail();
                //die_r($sendMail);
                if(array_key_exists('create', $sendMail))
                {
                    $this->DB->setPrkValue($return);
                    $this->DB->setEmailMsg($this->DB->view());
                    $sendMail = $this->DB->getSendMail();

                    sendMail($sendMail['create']['assunto'], $sendMail['create']['msg']);
                }*/
            }
            else
            {
                $arrReturn['status'] = 'erro';
                $arrReturn['msg']    = 'Usuário não gravado';
            }

            die_json($arrReturn);
        }


    }

    public function validation($form)
    {
        if(
            $form['cnpjFaturamento'] == '' ||
            $form['contatoFaturamento'] == '' ||
            $form['usuario_idusuario'] == '' ||
            $form['enderecoFaturamento'] == '' ||
            $form['paisFaturamento'] == '' ||
            $form['cidadeFaturamento'] == ''||
            $form['estadoFaturamento'] == ''||
            $form['cepFaturamento'] == ''||
            $form['emailFaturamento'] == '' ||
            $form['empresa'] == ''
        ){
            $arrReturn['msg'] = 'Por Favor! Preencha os Campos Destacado.';
            die_json($arrReturn);
        }
    }

    public function liste(){
        $empresas = new Empresas_spModel( $this->adapter->getAdapterZend() );
        $lista_clientes = $empresas->fetchAll()->toArray();

        $listaUsuarios = $this->DBUsuarios->liste('incidentes = 1');

        foreach ( $lista_clientes as $chave => $cliente )
        {
            $lista_clientes[$chave]['enderecoFaturamento'] = $this->Helpers->limitaTexto(trim($lista_clientes[$chave]['enderecoFaturamento']),24);
            $lista_clientes[$chave]['cidadeFaturamento'] = $this->Helpers->limitaTexto(trim($lista_clientes[$chave]['cidadeFaturamento']),12);
            $lista_clientes[$chave]['empresa'] = $this->Helpers->limitaTexto(trim($lista_clientes[$chave]['empresa']),18);
        }

        $this->smarty->assign('arr',$lista_clientes);
        $this->smarty->display("{$this->tplDir}/lista.tpl");
    }

    public function liste_emails(){


        $emails = new Emails_spModel($this->adapter->getAdapterZend() );
        $empresas = new Empresas_spModel( $this->adapter->getAdapterZend() );
        $lista_emails = $emails->fetchAll()->toArray();
//        $teste = $empresas->fetchRow( " idempresas = '{$lista_emails['empresas_idempresas'][1]}'");
//        echo die_json($lista_emails['empresas_idempresas']);

        foreach ( $lista_emails as $chave => $cliente )
        {
            $empresaRow = $empresas->fetchRow( " idempresas = '{$cliente['empresas_idempresas']}' " );
            if( $empresaRow instanceof Zend_Db_Table_Row )
                $lista_emails[$chave]['nome_empresa'] = $empresaRow->empresa;
            else
                $lista_emails[$chave]['nome_empresa'] = '';

            $lista_clientes[$chave]['empresa'] = $this->Helpers->limitaTexto(trim($lista_clientes[$chave]['empresa']),18);
        }

        $this->smarty->assign('arr',$lista_emails);
        $this->smarty->display("{$this->tplDir}/lista_emails.tpl");
    }

    public function view()
    {
        if ( ! empty($this->dadosP['param']))
        {

            $this->DBEmpresas->setPrkValue($this->dadosP['param']);
            $dadosEmpresas =  $this->DBEmpresas->view();


            $this->smarty->assign('obj',$dadosEmpresas);
            $this->smarty->display("{$this->tplDir}/view.tpl");
        }



    }


    public function edit()
    {

        if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form']))
        {
            $cliente = new Clientes_spModel($this->adapter->getAdapterZend() );
            $listaUsuarios = $this->DBUsuarios->liste('incidentes = 1');

            $empresas = new Empresas_spModel( $this->adapter->getAdapterZend() );
            $dados = $empresas->fetchRow( " idempresas = '{$this->dadosP['param']}' " )->toArray();

            $this->smarty->assign('obj',$dados);
            $this->smarty->assign('listaUsuarios',$listaUsuarios);
            $this->smarty->display("{$this->tplDir}/edit.tpl");
        }
        elseif ( ! empty($this->dadosP['form']))
        {

//            $this->validationEdit($this->dadosP['form']);
            $this->form = $this->dadosP['form'];

            $clientes = new Empresas_spModel($this->adapter->getAdapterZend() );
            //grava no banco de dados
//            echo die_json($this->form);

            $sql = "
                UPDATE usuarios
                SET empresa = '{$this->dadosP['form']['prefixo']}'
                WHERE empresas_idempresas = '{$this->dadosP['form']['idempresas']}';
    	    ";

            $this->DBEmpresas->query($sql);

            $resultado = $clientes->update( $this->form , "idempresas = '{$this->dadosP['form']['idempresas']}'" );


            if( !$resultado )
            {
                $arrReturn['status'] = 'erro';
                $arrReturn['msg']    = "Erro ao editar dados de usuário.";
            }
            else
            {
                $arrReturn['status']  = 'ok';
                $arrReturn['msg']     = 'Edição realizada com sucesso!';
            }
            die_json($arrReturn);
        }
    }

    public function novosla(){


        $this->smarty->display("{$this->tplDir}/novosla.tpl");

    }

}

?>