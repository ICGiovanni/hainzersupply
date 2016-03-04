<?php
class Upload
{
	public function UploadFile($file,$route)
	{
		move_uploaded_file($file,$route);
	}
}

?>