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
		$timeStamp = time();
		$createDate = date("Y-m-d",$timeStamp);
        $sql = "INSERT INTO `login` (firstName, lastName, profile_id, email, password, created_date, created_timestamp, modify_date, modify_timestamp, status_id) VALUES (:firstName, :lastName, :profile, :email, :password, '".$createDate."', '".$timeStamp."', '".$createDate."', '".$timeStamp."', '2')";

        $statement = $this->db->prepare($sql);

        $password = base64_encode($this->encrypt($password,md5($email.$password)));

		$statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
		$statement->bindParam(':profile', $profile, PDO::PARAM_STR);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $statement->execute();
		die("success insert ");
        
		return(!empty($result))?true:false;
    }
	
	function users_list(){
		$this->connect();
		$sql = "SELECT login_id, firstName, lastName, email, status_name, profile_name, login.profile_id, created_date, login.status_id  FROM `login`
				INNER JOIN status on login.status_id = status.status_id
				INNER JOIN profile on login.profile_id = profile.profile_id";
		
		$statement = $this->db->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
		return(!empty($result))?$result:false;
	}
	
	function user_update($loginId, $firstName, $lastName, $profile, $email, $password, $status){
		$this->connect();
		$timeStamp = time();
		$modifyDate = date("Y-m-d",$timeStamp);
		
		$sql_pwd="";
		if(!empty($password)){
			$sql_pwd = "
			password = :password,";
			$password = base64_encode($this->encrypt($password,md5($email.$password)));
			$statement->bindParam(':password', $password, PDO::PARAM_STR);
		}
		$sql = "UPDATE login SET
			firstName = :firstName,
			lastName = :lastName,
			profile_id = :profile,$sql_pwd
			email = :email,
			status_id = :status,
			modify_date = '".$modifyDate."',
			modify_timestamp = '".$timeStamp."'
			WHERE
				login_id = :login_id";
				
		$statement = $this->db->prepare($sql);

		$statement->bindParam(':login_id', $loginId, PDO::PARAM_STR);
		$statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
		$statement->bindParam(':profile', $profile, PDO::PARAM_STR);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
		$statement->bindParam(':status', $status, PDO::PARAM_STR);
       

        $statement->execute();
		die("success update ");
	}
	
	function user_delete($loginId){
		$this->connect();
		$sql = "DELETE FROM login WHERE login_id = :login_id LIMIT 1;";
		$statement = $this->db->prepare($sql);
		
		$statement->bindParam(':login_id', $loginId, PDO::PARAM_STR);
		
		$statement->execute();
		die("success delete ");		
	}
	
	function getProfiles(){
		$this->connect();
		$sql = "SELECT profile_id, profile_name FROM profile;";

		$statement = $this->db->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$assoc_result = array();
		while(list(,$data)=each($result)){
			$assoc_result[$data['profile_id']]=$data['profile_name'];
		}
		
		return(!empty($assoc_result))?$assoc_result:false;
	}
	
	function getStatus(){
		$this->connect();
		$sql = "SELECT status_id, status_name FROM status;";

		$statement = $this->db->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$assoc_result = array();
		while(list(,$data)=each($result)){
			$assoc_result[$data['status_id']]=$data['status_name'];
		}

		return(!empty($assoc_result))?$assoc_result:false;
	}
	
	function selectProfiles(){
		$selectProfiles = '<select id="profile" name="profile" class="form-control"><option >--Select Profile--</option>';
		
		$options_profile = '';
		$opt_profiles_value = array();
		$opt_profiles_value = $this->getProfiles();
		
		while(list($profile_id, $profile_name) = each($opt_profiles_value) ){
			$options_profile.='<option value="'.$profile_id.'">'.$profile_name.'</option>';
		}
		
		$selectProfiles.=$options_profile.'</select>';
		return $selectProfiles;
	}
	
	function selectStatus(){
		
		$selectStatus = '<select id="status" name="status" class="form-control"><option >--Select Status--</option>';

		$options_status = '';
		$opt_status_value = array();
		$opt_status_value = $this->getStatus();
		
		while(list($status_id, $status_name) = each($opt_status_value) ){
			$options_status.='<option value="'.$status_id.'">'.$status_name.'</option>';
		}

		$selectStatus.=$options_status.'</select>';
		return $selectStatus;
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