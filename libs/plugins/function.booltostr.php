<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.booltostr.php
 * Type:     function
 * Name:     booltostr
 * Purpose:  humaniza um valor booleano
 * -------------------------------------------------------------
 */

function smarty_function_booltostr($params, &$smarty)
{
    if($params['valor'] == 1)
        
        $output = "Sim";
    else
        
        $output = "Não";
   
    return $output;
}

?>
