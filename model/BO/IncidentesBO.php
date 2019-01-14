<?php

include_once "model/IncidentesModel.php";

class IncidentesBO extends IncidentesModel
{
	protected $_name = 'incidentes';
	protected $_primary = 'idincidentes';
	
	protected $statusIncidente;
	protected $finaTarefa;
	
	public function getstatusIncidente()
	{
		return $this->statusIncidente;
	}
	
	public function getfinaTarefa()
	{
		return $this->finaTarefa;
	}
	
	/*
	 * Regras para Status dos Incidentes:
	 * 
	 *  | Aberto -> com mais de 0 atendimentos abertos
	 *  | Em atendimento -> com mais de 0 atendimentos com status 2
	 *  | Finalizado -> com mais de  0 atendimentos com status 3
	 *  V Sem atendimento -> nenhum atendimento registrado
	 */
	public function aplicaStatusIncidente( AtendVsatBO $atendimentos )
	{
		$atendimentos->getStatusAtendimentos();
		$listaStatusAtendimentos = $atendimentos->getlistaAtendimentosSatus();
		if( count($listaStatusAtendimentos) > 0 )
		{
			if( count($listaStatusAtendimentos['Aberto']) > 0 )
			{
				$this->statusIncidente = 'Aberto';
			}
			else if( count($listaStatusAtendimentos['Em Atendimento']) > 0 )
			{
				$this->statusIncidente = 'Em atendimento';
			}
			else if( count($listaStatusAtendimentos['Finalizado']) > 0 )
			{
				$this->statusIncidente = 'Finalizado';
			}
			else
			{
				$this->statusIncidente = 'Sem atendimento';
			}
		}
	}
	
	
	public function getUltimoIncidentePeloIdProdemge()
	{
		$where = " idprodemge = '{$this->idprodemge}' ";
		$order = " idincidentes DESC ";
		$lista = $this->fetchAll( $where , $order );
		if( count($lista) > 0 )
		{
			$lista = $lista->toArray();
			$this->setidincidentes( new Integer( $lista[0]['idincidentes'] ) );
			$this->getIncidente();
			return true;
		}else return false;
	}
	
	
	public function limpaObjeto()
	{
		$this->setidincidentes( new Integer(0) );
		foreach ( $this->campos as $chave => $campo )
		{
			$this->{'set'.$campo}( '' );
		}
	} 
	
	// busca incidente que esteja aberto para a designacao passada
	public function buscaIncidenteAbertoParaDesignacao( $designacao )
	{
		$db = $this->getAdapter();
		
		$sql = "
			SELECT 
				COUNT(*) as total
			FROM incidentes inci
			LEFT JOIN instalacoes inst ON inst.idinstalacoes = inci.instalacoes_idinstalacoes
			WHERE 
				inst.nome = '{$designacao}' AND
				(
					SELECT COUNT(*)   
					FROM atend_vsat a
					LEFT JOIN cronometro c ON 
						c.idreferencia = a.idatend_vsat AND
						c.tabelareferencia = 'atend_vsat'
					WHERE 
						a.incidentes_idincidentes = inci.idincidentes AND
						(
							SELECT COUNT(*)
							FROM cronometro
							WHERE
								idreferencia = a.idatend_vsat AND
								tabelareferencia = 'atend_vsat' AND 
								final_tarefa IS NULL
						) > 0
				) > 0
		";
		$total = $db->fetchAll( $sql );
		//print_b($total,true);
		if( count($total['total']) > 0 ) return true;
		else return false;
	}
	
	public function buscaIncidentesFechadosDeDesignacao( $designacao )
	{
		$db = $this->getAdapter();
		
		$sql = "
			SELECT 
				inci.idincidentes as idincidentes
			FROM {$this->_name} inci
			LEFT JOIN instalacoes inst ON inst.idinstalacoes = inci.instalacoes_idinstalacoes
			WHERE 
				inst.nome = '{$designacao}' AND
				(
					SELECT COUNT(*)   
					FROM atend_vsat a
					LEFT JOIN cronometro c ON 
						c.idreferencia = a.idatend_vsat AND
						c.tabelareferencia = 'atend_vsat'
					WHERE 
						a.incidentes_idincidentes = inci.idincidentes AND
						(
							SELECT COUNT(*)
							FROM cronometro
							WHERE
								idreferencia = a.idatend_vsat AND
								tabelareferencia = 'atend_vsat' AND 
								final_tarefa IS NOT NULL
						) > 0
				) > 0
		";
		$lista = $db->fetchAll($sql);
		if( count($lista) > 0 )
			return $lista;
		else 
			return false;
	}
	
	public function buscaMaiorDataAlteracao( $limit )
	{

        $db = $this->getAdapter();

        $sql = " SELECT MAX(data_modificacao) as maior_data FROM incidentes {$limit} ";
        $maiorValor = $db->fetchAll( $sql );

        return $maiorValor[0]['maior_data'];
	}

    public function getListaId($retorno = false) {
        $select = $this->select()
                       ->distinct()
                       ->from(array('i' => $this->_name), array('idincidentes'))
                       ->joinInner(
                            array('ai' => 'associacao_instalacao_incidente'),
                            'i.idincidentes = ai.idincidentes',
                            null
                        );
        //echo $select->__toString();die;
        $stmt  = $select->query();
        $lista = $stmt->fetchAll();

        $ids = array();
        foreach ($lista as $incidente) {
            $ids[] = $incidente['idincidentes'];
        }

        if ($retorno) {
            return $ids;
        }
        echo json_encode($ids);
    }
}
