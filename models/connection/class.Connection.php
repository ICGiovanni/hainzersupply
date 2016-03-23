<?php
date_default_timezone_set("America/Mexico_City");

class Connection
{
	public $db;

	function __construct($host='localhost', $dbname='hainzers_control', $user='hainzers_admin',$pass='kFJUsNO7WQ7V4waM')
	//function __construct($host='db614233235.db.1and1.com', $dbname='db614233235', $user='dbo614233235',$pass='BDG_2016')
	{
        $this->dbhost = $host;
        $this->dbname = $dbname;
        $this->dbuser = $user;
        $this->dbpass = $pass;
		
		try
		{
			$this->db=new PDO('mysql:dbname='.$this->dbname.';host='.$this->dbhost, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			echo 'Connection failed: ' . $e->getMessage();
		}		
    }
	
	function __destruct()
	{
		/*try
		{
            $this->db=null;
        }
		catch (PDOException $e)
		{
            die($e->getMessage());
        }*/
   	} 
	
}
?>