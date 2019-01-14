<?php

/**
 * DBincidenteArquivado
 * 
 * A fim de tornar as operações na tabela de incidentes, foi solicitado que
 * os incidentes anteriores à 2013-01-01 fossem movidos para uma outra tabela.
 * 
 * @author Marcelo Wergles
 */
include_once 'DBIncidente.php';

class DBIncidenteArquivado extends DBIncidente 
{

    protected $tabela = 'incidentes_arquivados';
    
}
?>
