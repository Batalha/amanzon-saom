<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.pagination.php
 * Type:     pagination
 * Name:     booltostr
 * Purpose:  faz paginação
 * -------------------------------------------------------------
 */

function smarty_function_pagination($params, &$smarty)
{
    $barra = "<br /><center><ul class='list_page'>";
    
    $pages = ceil($params['total']/$params['rowspage']);
    
    $count = 1;
    
    for($i=0; $i<$pages; $i++){
      
        $ini    = $params['rowspage']*$i;
        $json   = ! isset($params['orderBy'])  ? "{ajax:1,ini:".$ini.",end:".$params['rowspage']."}" : "{ajax:1,ini:".$ini.",end:".$params['rowspage'].",orderBy:'".$params['orderBy']."'}";
        
        $barra .= "<li><a href=\"javascript:getAjaxForm('".$params['url']."','conteudo',$json)\">".$count."</a></li>";
        $count++;
    }
    
    $barra .= "</ul></center>";
    
    return $barra;
}

?>
