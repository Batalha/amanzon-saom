<?php

require_once "model/TelefonemasParaIncidentesModel.php";

class TelefonemasParaIncidentesBO extends TelefonemasParaIncidentesModel
{
	
	public function getTelefonemasParaIncidentesPeloIncidenteEOrdem()
	{
		if( empty($this->idassociacao_instalacao_incidente) )
			return "Id da Associação não declarada.";
			
		if( empty($this->order_telefonema) )
			return "O número do telefonema deve estar preenchido.";
			
		$where = " 
			idassociacao_instalacao_incidente = '{$this->idassociacao_instalacao_incidente}' AND
			order_telefonema  = '{$this->order_telefonema}' 
		";
		$telefonemasParaIncidentes = $this->fetchAll( $where );
		
		if( count($telefonemasParaIncidentes) > 0 )
		{
			$linha = $telefonemasParaIncidentes->toArray();
			$this->telefonemasParaIncidentesArray = $linha[0];
			foreach ( $linha[0] as $chave => $atributo )
			{
				if( $chave != 'idtelefonemas_para_incidentes' )
					$this->{"set".$chave}( $atributo );
			}
		}
	}
	
	public function zeraObjeto()
	{
		foreach( $this->campos as $chave => $atributo )
		{
			$atributo_vazio = '';
			$this->{"set".$atributo}( $atributo_vazio );
		}
	}
	
	public function liberaTelefonemaDeIncidente()
	{	
		$where = "
			idassociacao_instalacao_incidente = '{$this->getidassociacao_instalacao_incidente()}' AND
			order_telefonema = '{$this->getorder_telefonema()}'
		";
		$telefonemaDeIncidente = $this->fetchAll( $where );
		//print_b($telefonemaDeIncidente,true);
		if( count($telefonemaDeIncidente) > 0 )
		{
			foreach ( $telefonemaDeIncidente[0] as $chave => $valor )
			{
				if( $chave != 'idtelefonemas_para_incidentes' )
					$this->{"set".$chave}( $valor );
				else
				{
					$id = new Integer( $valor );
					$this->{"set".$chave}( $id );
				}
			}
		}
		else return false;
		
		$this->setfinalizado( 1 );
		$dataAtual = date('Y-m-d H:i:s');
		if(
			$this->getdata_finalizacao() == '0000-00-00 00:00:00' ||
			$this->getdata_finalizacao() == '' ||
			$this->getdata_finalizacao() == NULL
		)
			$this->setdata_finalizacao( $dataAtual );
		
		if( $this->edit() == 'ok' ) return true;
		else return false;
		
	}
	
}