<?php
set_time_limit(0);
require_once($_SERVER["REDIRECT_PATH_CONFIG"].'models/connection/class.Connection.php');

class Log
{
	private $connect;
	
	function __construct()
	{
		$c=new Connection();
		$this->connect=$c->db;
	}
	
	public function InsertLogInventory($file,$status,$total)
	{
		if(isset($_SESSION['login_user']['login_id']))
		{
			$loginId=$_SESSION['login_user']['login_id'];
		}
		else
		{
			$loginId=1;
		}
		
		$date=date('Y-m-d H:i:s');
		$restore=date('YmdHis');
		$sql = "INSERT INTO inv_log VALUES('',:loginId,:status,:total,:file,:restore,:date)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':loginId',$loginId,PDO::PARAM_STR);
		$statement->bindParam(':status',$status,PDO::PARAM_STR);
		$statement->bindParam(':total',$total,PDO::PARAM_STR);
		$statement->bindParam(':file',$file,PDO::PARAM_STR);
		$statement->bindParam(':restore',$restore,PDO::PARAM_STR);
		$statement->bindParam(':date',$date,PDO::PARAM_STR);
		
		$statement->execute();
		
		$this->GetRestore($restore);
		$this->CleanLog();
	}
	
	public function GetRestore($name)
	{
		$nameFile=$name.'_'.'wp_posts.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$sql="SELECT * INTO OUTFILE '$file' FROM wp_posts";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		
		$nameFile=$name.'_'.'wp_postmeta.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$sql="SELECT * INTO OUTFILE '$file' FROM wp_postmeta";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
	}
	
	public function Restore($name)
	{
		$sql="DELETE FROM wp_posts";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		
		$nameFile=$name.'_'.'wp_posts.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$sql="LOAD DATA INFILE '$file' INTO TABLE wp_posts";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		
		$sql="DELETE FROM wp_postmeta";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		
		$nameFile=$name.'_'.'wp_postmeta.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$sql="LOAD DATA INFILE '$file' INTO TABLE wp_postmeta";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
	}
	
	public function GetLog($logId='',$delete=false)
	{
		$where="";
		
		if($logId)
		{
			$where="WHERE il.log_id='$logId'";
		}
		else if($delete)
		{
			$where="WHERE DATE_ADD(NOW(),INTERVAL -1 DAY)>il.date";
		}
		
		$sql="SELECT il.log_id,CONCAT(ilo.firstName,' ',ilo.lastName)  AS Name,
				ilo.email,il.status,il.total,il.file,il.restore,
				il.date
				FROM inv_log il
				INNER JOIN inv_login ilo USING(login_id)
				$where";
		
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		return $result;
	}
	
	public function DeleteLog($logId)
	{
		$r=$this->GetLog($logId,'');
		
		$file=$r[0]['file'];
		$restore=$r[0]['restore'];
		
		unlink($file);
		
		$nameFile=$restore.'_'.'wp_posts.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		unlink($file);
		
		$nameFile=$restore.'_'.'wp_postmeta.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		unlink($file);
		
		$sql="DELETE FROM inv_log WHERE log_id=:logId";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':logId',$logId,PDO::PARAM_STR);
		$statement->execute();
		
	}
	
	function CleanLog()
	{
		$result=$this->GetLog('',true);
		foreach($result as $r)
		{
			$logId=$r['log_id'];
		
			$log->DeleteLog($logId);
		}
	}
}

?>