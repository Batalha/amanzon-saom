<?php

require_once "model/AssociacaoAtendimentoMotivoModel.php";

class AssociacaoAtendimentoMotivoBO extends AssociacaoAtendimentoMotivoModel
{

	protected $motivosDeAtendimento;
	
	public function setmotivosDeAtendimento( $motivosDeAtendimento )
	{
		$this->motivosDeAtendimento = $motivosDeAtendimento;
	}
	
	public function getmotivosDeAtendimento()
	{
		return $this->motivosDeAtendimento;
	}
	
	private function buscaListaAssociacoesParaAtendimento( $idatendimento )
	{
		// busca pelo tipo do motivo e o atendimento
// 		$sql = "
// 			SELECT
// 				a.idassociacao_atendimento_motivo,
// 				a.idatendimento as idatendimento,
//  			a.idmotivo as idmotivo,
// 				m.tipo_motivo as tipo_motivo,
// 				m.motivo as motivo,
// 				mt.tipo as tipo_motivo_str
// 			FROM associacao_atendimento_motivo a
// 			LEFT JOIN motivo_atendimento m ON m.idmotivo_atendimento = a.idmotivo
// 			LEFT JOIN motivo_atendimento_tipo mt ON mt.idmotivo_atendimento_tipo = m.tipo_motivo
// 			WHERE a.idatendimento = '{$idatendimento}';
// 		";
		
		$sql = "
		SELECT
			a.idatendimento_motivo_responsavel,
			a.idatendimento as idatendimento,
			a.idmotivo as idmotivo,
			a.idresponsavel as idresponsavel,
			m.motivo as motivo,
			ra.responsavel as responsavel
		FROM atendimento_motivo_responsavel a
		LEFT JOIN motivo_atendimentoteste m ON m.idmotivo_atendimento = a.idmotivo
		LEFT JOIN responsavel_atendimento ra ON ra.idresponsavel_atendimento = a.idresponsavel
		WHERE a.idatendimento = '{$idatendimento}';
		";
		
		return $this->DBPadrao->queryDados( $sql );
	}
	
	public function verificaExistenciaAssociacaoPeloTipoMotivo( $idatendimento )
	{
		$lista = $this->buscaListaAssociacoesParaAtendimento( $idatendimento );
		
// 		foreach( $lista as $chave => $associacao )
// 		{
			if($lista)
			{
				return true;
			}
// 		}
		return false;
	}
	
	public function atualizaAssociacoesDeAtendimentoPeloTipo( $motivo , $responsavel , $idatendimento )
	{
		$lista = $this->buscaListaAssociacoesParaAtendimento( $idatendimento );
		foreach( $lista as $chave => $associacao )
		{
// 			if( $associacao['tipo_motivo'] == $tipo_motivo )
// 			{
				$sql = "
					UPDATE atendimento_motivo_responsavel 
					SET idmotivo = '{$motivo}', idresponsavel = '{$responsavel}' 
					WHERE idatendimento_motivo_responsavel = '{$associacao['idatendimento_motivo_responsavel']}'
				";
				if( !$this->DBPadrao->query($sql) ) return false;
// 			}
		}
		return true;
	}
	
	public function criaAssociacaoDeAtendimentoComMotivo($idresponsavel, $idmotivo , $idatendimento )
	{
		$data = array(
			'idatendimento' => $idatendimento,
			'idmotivo' => $idmotivo,
			'idresponsavel' => $idresponsavel
		);
		return $this->insert( $data );
	}
	
	public function buscaMotivosDeAtendimentoOrganizadoPeloTipoDoMotivo( $idatendimento )
	{
		$lista = $this->buscaListaAssociacoesParaAtendimento( $idatendimento );
		
// 		$array = array();
// 		foreach( $lista as $chave => $item )
// 		{
// 			echo "<pre>";
// 			print_r($item);
// 			echo "<pre>";
			
// 			$array[ $item['tipo_motivo'] ] = array(
// 				'idmotivo' => $item['idmotivo'],
// 				'motivo' => $item['motivo'],
// 				'idatendimento_motivo_responsavel' => $item['idatendimento_motivo_responsavel'],
// 				'motivo_str' => $item['motivo'],
// 				'tipo_motivo_str' => $item['tipo_motivo_str']
// 			);
// 		}
// 			echo "<pre>";
// 			print_r($array);
// 			echo "<pre>";
		
// 		$this->setmotivosDeAtendimento( $array );
		$this->setmotivosDeAtendimento( $lista );
	}
	
	public function buscaMotivosDeAtendimentos( Array $listaIncidentesDeDesignacao )
	{
		$db = $this->getAdapter();
		
		foreach ( $listaIncidentesDeDesignacao as $chave => $incidente )
		{
			foreach ( $incidente['atendimentos'] as $chaveAtendimento => $atendimento )
			{
				$sql = "
					SELECT 
						a.idmotivo as idmotivo,
						m.motivo as motivo
					FROM associacao_atendimento_motivo a
					LEFT JOIN motivo_atendimento m ON m.idmotivo_atendimento = a.idmotivo
					WHERE a.idatendimento = '{$atendimento['idatend_vsat']}'
				";
				$motivo = $db->fetchAll($sql);
				if( count($motivo) > 0 )
					$listaIncidentesDeDesignacao[$chave]['atendimentos'][ $chaveAtendimento ]['motivo'] = $motivo;
				else
					$listaIncidentesDeDesignacao[$chave]['atendimentos'][ $chaveAtendimento ]['motivo'] = array();
			}
		}
		
		return ;$listaIncidentesDeDesignacao;
	}
}