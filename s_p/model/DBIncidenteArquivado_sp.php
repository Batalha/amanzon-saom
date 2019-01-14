<?php

/**
 * DBincidenteArquivado
 * 
 * A fim de tornar as operações na tabela de incidentes, foi solicitado que
 * os incidentes anteriores à 2013-01-01 fossem movidos para uma outra tabela.
 * 
 * @author Marcelo Wergles
 */
include_once 's_p/model/DBIncidente_sp.php';

class DBIncidenteArquivado_sp extends DBIncidente_sp
{

    protected $tabela = 'incidentes_arquivados_sp';
    
}
?>
