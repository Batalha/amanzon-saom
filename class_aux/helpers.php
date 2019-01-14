<?php

class Helpers
{
	
	protected $varreArray;
	
	/*
	 * Função que faz o que "array_walk" faz, mas funcionando com utf8_decode
	 */
	public function varreArray($valores, $funcao)
	{
// 		echo "<pre>";
// 		print_r($valores);
// 		echo "<pre>";
	
		foreach ($valores as $key => $valores2)//nivel 1
	    {
	    	if(is_array($valores[$key]))
	       	{
	       		foreach($valores[$key] as $key2 => $valores3)//nivel 2
	       		{
	       			if(is_array($valores[$key][$key2]))
	       			{
	       				foreach ($valores[$key][$key2] as $key3 => $valores4)//nivel 3
	       				{
	       					if(is_array($valores[$key][$key2][$key3]))
	       					{
	       						foreach ($valores[$key][$key2][$key3] as $key4 => $valores5)//nivel 4
	       						{
	       							if(is_array($valores[$key][$key2][$key3][$key4]))
	       							{
	       								foreach ($valores[$key][$key2][$key3][$key4] as $key5 => $valores6)//nivel 5
	       								{
	       									if(is_array($valores[$key][$key2][$key3][$key4][$key5]))
	       									{
	       										exit('Interacao nao prevista!');
	       									}
	       									else
	       									{
	       										$valores[$key][$key2][$key3][$key4][$key5] = $funcao($valores[$key][$key2][$key3][$key4][$key5]);
	       									}
	       								}
	       							}
	       							else
	       							{
	       								$valores[$key][$key2][$key3][$key4] = $funcao($valores[$key][$key2][$key3][$key4]);
	       							}
	       						}
	       					}
	       					else
	       					{
	       						$valores[$key][$key2][$key3] = $funcao($valores[$key][$key2][$key3]);
	       					}
	       				}
	       			}
	       			else
	       			{
	       				$valores[$key][$key2] = $funcao($valores[$key][$key2]);
	       			}
	       		}
	       	}
	       	else
	       	{
	       		$valores[$key] = $funcao($valores[$key]);
	       	}
		}
		
		return $valores;
		
	}
}