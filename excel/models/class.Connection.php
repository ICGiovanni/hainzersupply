<?php
date_default_timezone_set("America/Mexico_City");

class Connection
{
	public $db;
	
	//function __construct($host='127.0.0.1', $dbname='xsmarket_hainzersupply', $user='xsmarket_hainzer',$pass='frIgVCSibswZ9BnZ')
	function __construct($host='db614233235.db.1and1.com', $dbname='dbo614233235', $user='dbo614233235',$pass='Desarrollo2016*')
	{
        $this->dbhost = $host;
        $this->dbname = $dbname;
        $this->dbuser = $user;
        $this->dbpass = $pass;
		
		try
		{
			$this->db=new PDO('mysql:dbname='.$this->dbname.';host='.$this->dbhost, $user, $pass);
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