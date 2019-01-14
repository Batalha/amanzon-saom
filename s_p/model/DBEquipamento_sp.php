<?php


/**
 * Description of DBEquipamento
 *
 * @author Daniel
 * @author Sávio - lotharthesavior@gmail.com 
 */
    include_once 's_p/model/DBModel_sp.php';


class DBEquipamento_sp extends DBModel_sp 
{
    
    protected $idequipamentos;
	protected $sno;
	protected $mac;
	protected $tipo_equipamentos_sp_idtipo_equipamentos;
	protected $instalacoes_sp_idinstalacoes_sp;
	protected $status;
	protected $observacoes;
	protected $local;
	
	protected $vsat;
    
    protected $tabela = 'equipamentos_sp';
    protected $prk    = 'idequipamentos_sp';
    protected $rel    = array(
    						'tipo_equipamentos_sp',
    						'instalacoes_sp'
    						);
    protected $fgk    = array(
    						'tipo_equipamentos_sp_idtipo_equipamentos_sp',
    						'instalacoes_sp_idinstalacoes_sp'
    						);
    protected $camposForm = array(
        						'sno',
        						'mac',
        						'tipo_equipamentos_sp_idtipo_equipamentos_sp',
    							'instalacoes_sp_idinstalacoes_sp',
        						'status',
        						'observacoes',
        						'local',
        						'vsat'
    							);
      
    public function  __construct() 
    {
        parent::__construct();
    }

    public function findByNS()
    {

       $sql = "SELECT COUNT(*) as total FROM {$this->tabela} WHERE sno LIKE '{$this->sno}'";
       $result = $this->queryDados($sql);
       return $result[0]['total'];
    }

    public function setSno($sno)
    {
        $this->sno = $sno;
    }

    public function atualizaLocalEVsatEmEquipamentos( $idinstalacoes , $nsodu_comiss , $mac )
    {

    	//TODO: 4033 e 4035 so tem numero de serie, nao tem mac
    	//		sl2000 tem mac
    	/*$sql = "
    		UPDATE equipamentos_sp e
    		SET 
		        -- e.vsat = (
		        --		SELECT i.nome 
		        --		FROM instalacoes_sp i
		        -- 		WHERE i.idinstalacoes = {$idinstalacoes}
		        -- ),
		        e.local = (
		        	SELECT m.municipio 
		        	FROM municipios_sp m
		        	WHERE m.idmunicipios = (
		        		SELECT o.municipios_idcidade 
		        		FROM os_sp o
		        		WHERE o.idos = (
		        			SELECT inst.os_idos 
		        			FROM instalacoes_sp inst
		        			WHERE inst.idinstalacoes = {$idinstalacoes}	
		        		)	
		        	)
		        ),
		        -- e.mac = IF( 
		        -- 	(
		        -- 		e.tipo_equipamentos_idtipo_equipamentos = 2 OR 
		        -- 		e.tipo_equipamentos_idtipo_equipamentos = 3 OR 
		        -- 		e.tipo_equipamentos_idtipo_equipamentos = 4
		        -- 	) AND (e.mac = '') , 
		        -- 	'',
		        -- 	'{$mac}' 
		        -- ),
		        e.status = 2
			WHERE e.sno = '{$nsodu_comiss}';
		";*/
    	//exit($sql);
//    	return $this->query($sql);
    }
    
}

?>
