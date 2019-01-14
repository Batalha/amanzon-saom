<?php

require_once 'model/EquipamentosModel.php';

class EquipamentosBO extends EquipamentosModel
{
	protected $nomes_equipamento = array(
		'nsmodem_comiss' => 'Número de Série do Modem',
		'nsodu_comiss' => 'Número de Série do ODU'
	);
	

	public function verifica_existencia_mac( $mac_comiss )
	{
		$where = " mac = '{$mac_comiss}' ";
        $mac = $this->fetchAll( $where )->toArray();
        if( count($mac) < 1 )
        {
        	$arrReturn['status'] = 'erro';
	       	$arrReturn['msg']    = 'MAC não consta entre os equipamentos.';
	       	die_json($arrReturn);
        }
        else
        {
        	return $mac;
        }
	}
	
	
	// ---------------------------------------------------------------------------------
	// ------------------- VALIDACAO DE NUMEROS DE SERIE PARA COMISSIONAMENTO ----------
	// ---------------------------------------------------------------------------------
	public function valida_campo_equipamento_comissionamento_vazio( $campo , $equipamento )
	{
		if( $campo == '' )
		{
			$arrReturn['status'] = 'erro';
	       	$arrReturn['msg']    = "{$equipamento} não pode ficar em branco.";
	       	die_json($arrReturn);
		}
	}
        															
	public function valida_ns( 
								$ns , 
								Zend_Db_Table_Row $instalacao , 
								$equipamento , 
								EquipamentosLocaisBO $equipamentosLocais 
								)
	{
		$where = " sno = '{$ns}' ";
		$ns_carregado = $this->fetchAll( $where );
		if( count($ns_carregado) < 1 )
		{
			$arrReturn['status'] = 'erro';
		    $arrReturn['msg']    = "{$this->nomes_equipamento[$equipamento]} não consta no entre os equipamentos.";
		    die_json($arrReturn);
		}
		else
		{
			$this->verifica_status_equipamento_invocado( 
														$ns_carregado , 
														$instalacao , 
														$equipamento , 
														$equipamentosLocais 
														);
			
			return $ns_carregado;
		}
	}
	
	public function verifica_status_equipamento_invocado( 
														Zend_Db_Table_Rowset $ns_carregado , 
														Zend_Db_Table_Row $instalacao , 
														$equipamento , 
														EquipamentosLocaisBO $equipamentosLocais 
														)
	{
		$local_equipamento = $this->carrega_local_equipamento( $ns_carregado , $equipamentosLocais , $equipamento );
		
		if( count($local_equipamento) > 0 )
		{
			// verifica se o sno atual é referente a essa instalacao
			if( $local_equipamento[0]->idlocais_equipamentos != $instalacao->idinstalacoes )
			{
				// por último verifica se o status está realmente 'em uso'
				if( $ns_carregado[0]->status == 2 )
				{
					$arrReturn['status'] = 'erro';
			    	$arrReturn['msg']    = "Erro ao atualizar status do {$this->nomes_equipamento[$equipamento]}. É provável que esse equipamento esteja em uso, caso não, reporte para o Webmaster.";
			    	die_json($arrReturn);
				}
			}
		}
	}
	
	
	// ----------------------------------------------------------------------------------------------
	// ------------------ ATUALIZA STATUS EQUIPAMENTOS ----------------------------------------------
	// ----------------------------------------------------------------------------------------------
	public function atualiza_status_equipamento( 
												Zend_Db_Table_Rowset $ns_carregado , 
												EquipamentosLocaisBO $equipamentosLocais , 
												$status , 
												Zend_Db_Table_Row $instalacao ,
												$equipamento
												)
	{	
		
		// ---------- atualiza status do equipamento anterior
			$where = " 
				tabela_localidade = 'instalacoes' AND 
				idlocais_equipamentos = '{$instalacao->idinstalacoes}' AND 
				idequipamentos != '{$ns_carregado[0]->idequipamentos}' AND
				tipo_associacao = '{$equipamento}'
			";
			$associacao_equipamento_anterior = $equipamentosLocais->fetchAll( $where );
			if( count($associacao_equipamento_anterior) > 0 )
			{
				$this->muda_equipamento_para_status_rma( $associacao_equipamento_anterior , $equipamento );
				$this->apaga_equipamento_local( $associacao_equipamento_anterior , $equipamento , $equipamentosLocais );
			}
			
		// ---------- atualiza status do equipamento novo
			//busca id do equipamento
			$where = " sno = '{$ns_carregado[0]->sno}' ";
			$equipamento_carregado = $this->fetchAll( $where );
			if( count($equipamento_carregado) > 0 )
			{
				$this->atualiza_status_do_equipamento( $status , $ns_carregado[0]->sno , $equipamento );
				
				//verifica pré existencia de associacao
				$where = " idequipamentos = '{$equipamento_carregado[0]->idequipamentos}' ";
				$equipamento_locais = $equipamentosLocais->fetchAll( $where );
				if( count($equipamento_locais) > 0 )
					$this->atualiza_dados_local_equipamento( $instalacao->idinstalacoes , $equipamento , $equipamento_locais , $equipamentosLocais );
					
				else
					$this->insere_dados_local_equipamento( $equipamento_carregado[0]->idequipamentos , $instalacao->idinstalacoes , $equipamento , $equipamentosLocais );
			}
	}
	
	public function apaga_equipamento_local( 
											Zend_Db_Table_Rowset $associacao_equipamento , 
											$equipamento , 
											EquipamentosLocaisBO $equipamentosLocais 
											)
	{
		$where = " idequipamentos_locais = '{$associacao_equipamento[0]->idequipamentos_locais}' ";
		if( !$equipamentosLocais->delete( $where ) )
		{
			$arrReturn['status'] = 'erro';
	    	$arrReturn['msg']    = "Erro ao apagar local do {$this->nomes_equipamento[$equipamento]}. Erro na linha 136 de equipamentosBO.";
	    	die_json($arrReturn);
		}
	}
	
	public function muda_equipamento_para_status_rma( 
													Zend_Db_Table_Rowset $associacao_equipamento , 
													$equipamento 
													)
	{
		$data = array(
			'status' => '2'
		);
		$where = " idequipamentos = '{$associacao_equipamento[0]->idequipamentos}' ";
		if( !$this->update($data, $where) )
		{
			$arrReturn['status'] = 'erro';
	    	$arrReturn['msg']    = "Erro ao mudar status do {$this->nomes_equipamento[$equipamento]}. Erro na linha 154 de equipamentosBo.";
	    	die_json($arrReturn);
		}
	}
	
	public function atualiza_status_do_equipamento( $status , $ns , $equipamento )
	{
		$data = array(
			'status' => $status
		);
		$where = " sno = '{$ns}' ";
		//TODO: está retornando 0 mesmo quadno query é executada
		$this->update( $data , $where );
		/*if( !$this->update( $data , $where ) )
		{
			$arrReturn['status'] = 'erro';
	    	$arrReturn['msg']    = "Erro ao atualizar status do {$this->nomes_equipamento[$equipamento]}. Erro na linha 180 de equipamentosBo.";
	    	die_json($arrReturn);
		}*/
	}
	
	public function atualiza_dados_local_equipamento( $idinstalacoes , $equipamento , Zend_Db_Table_Rowset $equipamento_local , EquipamentosLocaisBO $equipamentos_locais )
	{
		if( 
			$equipamento_local[0]->tabela_localidade != 'instalacoes' ||
			( $equipamento_local[0]->tabela_localidade == 'instalacoes' && $equipamento_local[0]->idlocais_equipamentos != $idinstalacoes )
		)
		{
			$data = array(
				'tabela_localidade' => 'instalacoes',
				'idlocais_equipamentos' => $idinstalacoes,
				'tipo_associacao' => $equipamento
			);
			$where = " idequipamentos_locais = '{$equipamento_local[0]->idequipamentos_locais}' ";
			if( !$equipamentos_locais->update( $data , $where ) )
			{
				$arrReturn['status'] = 'erro';
		    	$arrReturn['msg']    = "Erro ao atualizar dados do local do {$this->nomes_equipamento[$equipamento]}. Erro na linha 196 de equipamentosBo.";
		    	die_json($arrReturn);
			}
		}
	}
	
	public function insere_dados_local_equipamento( $idequipamentos , $idinstalacoes , $equipamento , EquipamentosLocaisBO $equipamentos_locais )
	{
		$data = array(
			'idequipamentos' => $idequipamentos,
			'idlocais_equipamentos' => $idinstalacoes,
			'tabela_localidade' => 'instalacoes',
			'tipo_associacao' => $equipamento
		);
		if( !$equipamentos_locais->insert($data) )
		{
			$arrReturn['status'] = 'erro';
	    	$arrReturn['msg']    = "Erro ao inserir dados do local do {$this->nomes_equipamento[$equipamento]}. Erro na linha 173 de equipamentosBo.";
	    	die_json($arrReturn);
		}
	}
	
	
	// --
	
	public function carrega_local_equipamento( 
											Zend_Db_Table_Rowset $ns_carregado , 
											EquipamentosLocaisBO $equipamentosLocais ,
											$equipamento
											)
	{
		$where = " idequipamentos = '{$ns_carregado[0]->idequipamentos}' AND tabela_localidade = 'instalacoes' AND tipo_associacao = '{$equipamento}' ";
		return $equipamentosLocais->fetchAll( $where );
	}
	
	public function buscaODUdeNSODU( $nsodu )
	{
		$where = " sno = '{$nsodu}' ";
		$busca = $this->fetchAll( $where );
		if( count($busca) > 0 ) return $busca->toArray();
		else return array();
	}
	
}