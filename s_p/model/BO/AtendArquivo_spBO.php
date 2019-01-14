<?php

include_once "s_p/model/AtendArquivo_spModel.php";

class AtendArquivo_spBO extends AtendArquivo_spModel
{
	/**
	 * Resgata Termo de Responsabilidade pelo Id da Instalação do mesmo
	 *
	 * @param Integer $instalacao
	 */
    protected $listaAtendArquivo = array();

//    public function __construct( $adapter )
//    {
//        parent::__construct( $adapter );
//    }

    public function getlistaAtendArquivo()
    {
        return $this->listaUsuarios;
    }

	public function getAtendimentoDeArquivo($atendimento )
	{
//echo die_json('testesss');
		$where = " id_atendimento = '{$atendimento}' ";
        $usuarios = $this->fetchAll( $where );
        $this->listaUsuarios = $usuarios->toArray();
		
//		$linha = $this->fetchAll( $where );
//
//		if( $linha instanceof Zend_Db_Table_Row ) // resultados positivos
//			$this->termo = $linha->toArray();
//		else
//			$this->termo = false;
	}

}