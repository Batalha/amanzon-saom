<?php


/**
 * Description of DBEquipamento
 *
 * @author Daniel
 * @author Sávio - lotharthesavior@gmail.com 
 */
    include_once 'DBModel.php';

class DBEquipamento extends DBModel 
{
    
    protected $idequipamentos;
	protected $sno;
	protected $mac;
	protected $tipo_equipamentos_idtipo_equipamentos;
	protected $instalacoes_idinstalacoes;
	protected $status;
	protected $observacoes;
	protected $local;
	
	protected $vsat;
    
    protected $tabela = 'equipamentos';
    protected $prk    = 'idequipamentos';
    protected $rel    = array(
    						'tipo_equipamentos',
    						'instalacoes'
    						);
    protected $fgk    = array(
    						'tipo_equipamentos_idtipo_equipamentos',
    						'instalacoes_idinstalacoes'
    						);
    protected $camposForm = array(
        						'sno',
        						'mac',
        						'tipo_equipamentos_idtipo_equipamentos',
    							'instalacoes_idinstalacoes',
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
    		UPDATE equipamentos e 
    		SET 
		        -- e.vsat = (
		        --		SELECT i.nome 
		        --		FROM instalacoes i 
		        -- 		WHERE i.idinstalacoes = {$idinstalacoes}
		        -- ),
		        e.local = (
		        	SELECT m.municipio 
		        	FROM municipios m 
		        	WHERE m.idmunicipios = (
		        		SELECT o.municipios_idcidade 
		        		FROM os o 
		        		WHERE o.idos = (
		        			SELECT inst.os_idos 
		        			FROM instalacoes inst 
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
    	return $this->query($sql);
    }
    
}

?>
