<?php
class General
{
	function NameToURL($nombre)
	{
		$arr_busca = array(' ','�','�','�','�','�','�','�',
				'�','�', '�','�','�','�','�','�','�','�','�','�',
				'�','�','�','�','�', '�','�','�','�','�','�','�',
				'�','�','�','�','�','�','�','�','�','.',';',',',':','�','�','?','�');
		$arr_susti = array('-','a','a','a','a','a','A','A',
				'A','A','e','e','e','E','E','E','i','i','i','I',
				'I','I','o','o','o','o','o','O','O','O','O','u',
				'u','u','U','U','U','c','C','N','n','','','','','O','o','','o');
		$nom_archivo = strtolower (trim(str_replace($arr_busca, $arr_susti, $nombre)));
		return preg_replace('/[^A-Za-z0-9\_\.\-]/', '',$nom_archivo);
	}
}
?>