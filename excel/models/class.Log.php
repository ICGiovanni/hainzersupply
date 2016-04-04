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
		session_start();
		if(isset($_SESSION['login_user']['login_id']))
		{
			$loginId=$_SESSION['login_user']['login_id'];
		}
		else
		{
			$loginId=34;
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
	
	public function GetDataTable($table,$nameFile)
	{
		$sql="SELECT *
				FROM $table";
		
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		$content="";
		foreach($result as $r)
		{
			$values="";
			$cont=0;
			foreach($r as $k=>$c)
			{
				
				$c=str_replace('\'','´',$c);
				$c=mysql_escape_string($c);
				
				if($cont==0)
				{
					$values.="'$c'";
				}
				else
				{
					$values.=",'$c'";
				}
				$cont++;
			}
			$content.="INSERT INTO $table VALUES($values);\n";
		}
		
		if(!file_exists($_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'))
		{
			mkdir($_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/',0775,true);
		}
		
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$f=fopen($file,"w");
		fwrite($f,$content);
		fclose($f);
	}
	
	public function GetRestore($name)
	{
		$nameFile=$name.'_'.'wp_posts.sql';
		$this->GetDataTable('wp_posts',$nameFile);
		
		$nameFile=$name.'_'.'wp_postmeta.sql';
		$this->GetDataTable('wp_postmeta',$nameFile);
		
		$nameFile=$name.'_'.'wp_term_relationships.sql';
		$this->GetDataTable('wp_term_relationships',$nameFile);
		/*
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
		
		$nameFile=$name.'_'.'wp_term_relationships.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$sql="SELECT * INTO OUTFILE '$file' FROM wp_term_relationships";
		$statement=$this->connect->prepare($sql);
		$statement->execute();*/
	}
	
	public function RestoreDataTable($table,$nameFile)
	{
		$sql="DELETE FROM $table";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		
		$f=fopen($file, "r");
		
		while(($sql=fgets($f))!==false)
		{
			if($sql)
			{
				$statement=$this->connect->prepare($sql);
				
				try
				{
					$statement->execute();
				}
				catch (Exception $e)
				{
					$date=date("Y-m-d H:i:s");
					file_put_contents('sql/Error.log',$date." ".$nameFile."\n",FILE_APPEND);
					file_put_contents('sql/Error.log',$sql."\n",FILE_APPEND);
				}
			}
		}
		
		fclose($f);
	}
	
	public function Restore($name)
	{
		$nameFile=$name.'_'.'wp_posts.sql';
		$this->RestoreDataTable('wp_posts',$nameFile);
		
		$nameFile=$name.'_'.'wp_postmeta.sql';
		$this->RestoreDataTable('wp_postmeta',$nameFile);
		
		$nameFile=$name.'_'.'wp_term_relationships.sql';
		$this->RestoreDataTable('wp_term_relationships',$nameFile);
		
		/*$sql="DELETE FROM wp_posts";
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
		
		
		$sql="DELETE FROM wp_term_relationships";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		
		$nameFile=$name.'_'.'wp_term_relationships.sql';
		$file=$_SERVER["REDIRECT_PATH_CONFIG"].'/excel/sql/'.$nameFile;
		$sql="LOAD DATA INFILE '$file' INTO TABLE wp_term_relationships";
		$statement=$this->connect->prepare($sql);
		$statement->execute();*/
		
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
			$where="WHERE DATE_ADD(NOW(),INTERVAL -90 DAY)>il.date";
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
				
		$nameFile=$restore.'_'.'wp_term_relationships.sql';
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
		
			$this->DeleteLog($logId);
		}
	}
	
	function mres($value)
	{
		$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	
		return str_replace($search, $replace, $value);
	}
}

?>