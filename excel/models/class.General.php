<?php
class General
{
	function NameToURL($cadena)
	{
		$arr_busca = array('  ',' ','á','à','â','ã','ª','Á','À',
				'Â','Ã', 'é','è','ê','É','È','Ê','í','ì','î','Í',
				'Ì','Î','ò','ó','ô','õ','º','Ó','Ò','Ô','Õ','ú',
				'ù','û','Ú','Ù','Û','ç','Ç','Ñ','ñ','.',';',',',':','Ø','ø','?','ö','/');
		$arr_susti = array('-','-','a','a','a','a','a','A','A',
				'A','A','e','e','e','E','E','E','i','i','i','I',
				'I','I','o','o','o','o','o','O','O','O','O','u',
				'u','u','U','U','U','c','C','N','n','','','','','O','o','','o','&');
		$nom_archivo = strtolower (trim(str_replace($arr_busca, $arr_susti, $cadena)));
		return preg_replace('/[^A-Za-z0-9\_\.\-]/', '',$nom_archivo);
	}
	
	function CleanName($nombre)
	{
		/*$arr_busca = array(' ','á','à','â','ã','ª','Á','À',
				'Â','Ã', 'é','è','ê','É','È','Ê','í','ì','î','Í',
				'Ì','Î','ò','ó','ô', 'õ','º','Ó','Ò','Ô','Õ','ú',
				'ù','û','Ú','Ù','Û','ç','Ç','Ñ','ñ','.',';',',',':','Ø','ø','?','ö','/');
		$arr_susti = array(' ','a','a','a','a','a','A','A',
				'A','A','e','e','e','E','E','E','i','i','i','I',
				'I','I','o','o','o','o','o','O','O','O','O','u',
				'u','u','U','U','U','c','C','N','n','','','','','O','o','','o','&');
		$nom_archivo = str_replace($arr_busca, $arr_susti, $nombre);
		
		return preg_replace('/[^A-Za-z0-9\_\.\-]/', '',$nom_archivo);*/
		$arr_busca = array('/',' ');
		$arr_susti = array('&','-');
		
		$nom_archivo=str_replace($arr_busca, $arr_susti, $nombre);
		
		return $nom_archivo;
		
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