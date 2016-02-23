<?php
/*
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `profile` tinyint(4) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `firstName`, `lastName`, `profile`, `email`, `password`) VALUES
(1, '', '', 0, 'admin@admin.com', 'LbO9DUk9nylTjTS2I3v5uWM7vPwlzl/yDTY4E7MDVbY=');
password:wicked
*/
class user_login{

    private $db;

    function __construct($host = 'db614036781.db.1and1.com', $dbname='db614036781', $user='dbo614036781',$pass='Desarrollo2016*'){
        $this->dbhost = $host;
        $this->dbname = $dbname;
        $this->dbuser = $user;
        $this->dbpass = $pass;
    }

    private function connect(){
        if (!$this->db instanceof PDO){
            $this->db = new PDO('mysql:dbname='.$this->dbname.';host='.$this->dbhost, $this->dbuser, $this->dbpass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
    function auth($email,$password){
        $this->connect();
        $sql = "SELECT 1 FROM `login` WHERE email = :email AND password = :password";

        $statement = $this->db->prepare($sql);

        $password = base64_encode($this->encrypt($password,md5($email.$password)));

		$statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
		return(!empty($result))?true:false;
    }

	function sign_up($firstName, $lastName, $profile, $email, $password){
        $this->connect();
        $sql = "INSERT INTO `login` (firstName, lastName, profile, email, password) VALUES (:firstName, :lastName, :profile, :email, :password)";

        $statement = $this->db->prepare($sql);

        $password = base64_encode($this->encrypt($password,md5($email.$password)));

		$statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
		$statement->bindParam(':profile', $profile, PDO::PARAM_STR);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $statement->execute();
		die("success insert ");
        //$result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
		return(!empty($result))?true:false;
    }
	
    function logout($email,$password){
        unset($_SESSION['logged_in']);
        session_destroy();
        session_regenerate_id();
    }

    function encrypt($value,$salt){
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $value, MCRYPT_MODE_ECB, $iv);
    }

}
?>