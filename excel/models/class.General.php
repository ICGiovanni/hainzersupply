<?php
class General
{
	function NameToURL($cadena)
	{
		$arr_busca = array('    ','   ','  ',' ','á','à','â','ã','ª','Á','À',
				'Â','Ã', 'é','è','ê','É','È','Ê','í','ì','î','Í',
				'Ì','Î','ò','ó','ô', 'õ','º','Ó','Ò','Ô','Õ','ú',
				'ù','û','Ú','Ù','Û','ç','Ç','Ñ','ñ','.','ö','/','&','(',')','\'');
		$arr_susti = array('-','-','-','-','a','a','a','a','a','a','a',
				'a','a','e','e','e','e','e','e','i','i','i','i','i',
				'i','o','o','o','o','o','o','o','o','o','u','u','u',
				'u','u','u','c','c','n','n','-','o','','','','','');
		$nom_archivo = strtolower (trim(str_replace($arr_busca, $arr_susti, $cadena)));
		return preg_replace('/[^A-Za-z0-9\_\.\-]/', '',$nom_archivo);
	}
	
	function CleanName($nombre)
	{
		$arr_busca = array('/','    ','   ','  ',' ');
		$arr_susti = array('&','-','-','-','-','-');
		
		$nom_archivo=str_replace($arr_busca, $arr_susti, $nombre);
		
		return $nom_archivo;
		
	}
	
	function QuitBlankSpace($nombre)
	{
		$nombre=trim($nombre);
		$arr_busca = array('/','    ','   ','  ',' ','.');
		$arr_susti = array('','-','-','-','-','-');
	
		$result=str_replace($arr_busca,$arr_susti,$nombre);
	
		return $result;
	
	}
	
	function ReplaceSlash($nombre)
	{
		$arr_busca = array('/');
		$arr_susti = array('&');
		
		$nom_archivo=str_replace($arr_busca, $arr_susti, $nombre);
		
		return $nom_archivo;
	}
}
?>