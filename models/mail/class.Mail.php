<?php

class Mail
{
	public function sendMail($destinatarios,$cabeceras,$titulo,$mensaje)
	{
		$contador=0;
		$cabeceraE='';
		$destinatario='';
		foreach($destinatarios as $d)
		{
			if($contador==0)
			{
				$destinatario.=$d;
				$cabeceraE.='D'.($contador+1).'<'.$d.'>';
			}
			else
			{
				$destinatario.=','.$d;
				$cabeceraE.=',D'.($contador+1).'<'.$d.'>';
			}
			$contador++;
		}
	
		return $status=mail($destinatario, $titulo, $mensaje,$cabeceras);
	}
}


?>