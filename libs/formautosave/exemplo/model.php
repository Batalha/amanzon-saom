<?php

$dados = $this->dadosP;
	    
$sql = "
   	UPDATE {$dados['tabela']}
   	SET {$dados['campo']} = '{$dados['valor']}'
 	WHERE {$dados['campo_id']} = '{$dados['linha']}';
";
    
$this->DB = new DBModel();
echo $this->DB->query($sql);