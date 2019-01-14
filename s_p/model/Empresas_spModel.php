<?php

require_once 's_p/model/Zend_spModel.php';
require_once 's_p/model/Empresas_spModel.php';
include_once 'helpers/Utilitarios.php';

class Empresas_spModel extends Zend_spModel
{

    protected $_name = 'empresas';
    protected $_primary = 'idempresas';


    protected $empresa;
    protected $prefixo;
    protected $local;
    protected $tipo;
    protected $usuario_idusuario;
    protected $contatoFaturamento;
    protected $cnpjFaturamento;
    protected $enderecoFaturamento;
    protected $paisFaturamento;
    protected $cidadeFaturamento;
    protected $estadoFaturamento;
    protected $cepFaturamento;
    protected $emailFaturamento;

    protected $clienteArray = array();

    protected $campos = array(
        'empresa',
        'prefixo',
        'local',
        'tipo',
        'usuario_idusuario',
        'contatoFaturamento',
        'cnpjFaturamento',
        'enderecoFaturamento',
        'paisFaturamento',
        'cidadeFaturamento',
        'estadoFaturamento',
        'cepFaturamento',
        'subperfil_idsubperfil',
        'emailFaturamento'
    );

    /**
     * @return mixed
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param mixed $empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * @return mixed
     */
    public function getPrefixo()
    {
        return $this->prefixo;
    }

    /**
     * @param mixed $prefixo
     */
    public function setPrefixo($prefixo)
    {
        $this->prefixo = $prefixo;
    }



    /**
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $local
     */
    public function setLocal($local)
    {
        $this->local = $local;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getUsuarioIdusuario()
    {
        return $this->usuario_idusuario;
    }

    /**
     * @param mixed $usuario_idusuario
     */
    public function setUsuarioIdusuario($usuario_idusuario)
    {
        $this->usuario_idusuario = $usuario_idusuario;
    }



    /**
     * @return mixed
     */
    public function getContatoFaturamento()
    {
        return $this->contatoFaturamento;
    }

    /**
     * @param mixed $contatoFaturamento
     */
    public function setContatoFaturamento($contatoFaturamento)
    {
        $this->contatoFaturamento = $contatoFaturamento;
    }

    /**
     * @return mixed
     */
    public function getCnpjFaturamento()
    {
        return $this->cnpjFaturamento;
    }

    /**
     * @param mixed $cnpjFaturamento
     */
    public function setCnpjFaturamento($cnpjFaturamento)
    {
        $this->cnpjFaturamento = $cnpjFaturamento;
    }

    /**
     * @return mixed
     */
    public function getEnderecoFaturamento()
    {
        return $this->enderecoFaturamento;
    }

    /**
     * @param mixed $enderecoFaturamento
     */
    public function setEnderecoFaturamento($enderecoFaturamento)
    {
        $this->enderecoFaturamento = $enderecoFaturamento;
    }

    /**
     * @return mixed
     */
    public function getPaisFaturamento()
    {
        return $this->paisFaturamento;
    }

    /**
     * @param mixed $paisFaturamento
     */
    public function setPaisFaturamento($paisFaturamento)
    {
        $this->paisFaturamento = $paisFaturamento;
    }

    /**
     * @return mixed
     */
    public function getCidadeFaturamento()
    {
        return $this->cidadeFaturamento;
    }

    /**
     * @param mixed $cidadeFaturamento
     */
    public function setCidadeFaturamento($cidadeFaturamento)
    {
        $this->cidadeFaturamento = $cidadeFaturamento;
    }

    /**
     * @return mixed
     */
    public function getEstadoFaturamento()
    {
        return $this->estadoFaturamento;
    }

    /**
     * @param mixed $estadoFaturamento
     */
    public function setEstadoFaturamento($estadoFaturamento)
    {
        $this->estadoFaturamento = $estadoFaturamento;
    }

    /**
     * @return mixed
     */
    public function getCepFaturamento()
    {
        return $this->cepFaturamento;
    }

    /**
     * @param mixed $cepFaturamento
     */
    public function setCepFaturamento($cepFaturamento)
    {
        $this->cepFaturamento = $cepFaturamento;
    }

    /**
     * @return mixed
     */
    public function getEmailFaturamento()
    {
        return $this->emailFaturamento;
    }

    /**
     * @param mixed $emailFaturamento
     */
    public function setEmailFaturamento($emailFaturamento)
    {
        $this->emailFaturamento = $emailFaturamento;
    }

    public function getativacao()
    {
        return $this->ativacao;
    }


    public function getUsuarioArray()
    {
        return $this->usuarioArray;
    }


    public function getCliente()
    {
        if( empty($this->idcliente) )
            return "Id do cliente não declarado.";

        $where = " idcliente = '{$this->idcliente}' ";
        $clientes = $this->fetchAll( $this->select()->where( $where ) );

        if( count($clientes) > 0 )
        {
            $linha = $clientes->toArray();
            $this->clienteArray = $linha[0];
            foreach ( $linha[0] as $chave => $atributo )
            {
                if( $chave != 'idcliente' )
                    $this->{"set".$chave}( $atributo );
            }
        }
    }

}