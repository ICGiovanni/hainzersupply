<?php
require_once $_SERVER['REDIRECT_PATH_CONFIG'].'models/connection/class.Connection.php';

class user_login{

    private $connect;
	
	function __construct()
	{
		$c=new Connection();
		$this->connect=$c->db;
	}

    function auth($email,$password){

        $sql = "SELECT login_id, profile_id, email, firstName FROM `inv_login` WHERE email = :email AND password = :password AND status_id = 1";

        $statement = $this->connect->prepare($sql);

        $password = base64_encode($this->encrypt($password,md5($email.$password)));

		$statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		return(!empty($result))?$result[0]:false;
    }

	function sign_up($firstName, $lastName, $profile, $email, $password){

		$timeStamp = time();
		$createDate = date("Y-m-d",$timeStamp);
        $sql = "INSERT INTO `inv_login` (firstName, lastName, profile_id, email, password, created_date, created_timestamp, modify_date, modify_timestamp, status_id) VALUES (:firstName, :lastName, :profile, :email, :password, '".$createDate."', '".$timeStamp."', '".$createDate."', '".$timeStamp."', '1')";

        $statement = $this->connect->prepare($sql);

        $password = base64_encode($this->encrypt($password,md5($email.$password)));

		$statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
		$statement->bindParam(':profile', $profile, PDO::PARAM_STR);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $statement->execute();

        return "login_id=".$this->connect->lastInsertId();
    }
	
	function users_list(){

		$sql = "SELECT login_id, firstName, lastName, email, status_name, profile_name, inv_login.profile_id, created_date, inv_login.status_id  FROM `inv_login`
				INNER JOIN inv_status on inv_login.status_id = inv_status.status_id
				INNER JOIN inv_profile on inv_login.profile_id = inv_profile.profile_id ORDER BY login_id DESC";
		
		$statement = $this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
		return(!empty($result))?$result:false;
	}
	
	function user_update($loginId, $firstName, $lastName, $profile, $email, $password, $status){

		$timeStamp = time();
		$modifyDate = date("Y-m-d",$timeStamp);
		
		$sql_pwd="";
		if(!empty($password)){
			$sql_pwd = "
			password = :password,";
			
			
		}
		$sql = "UPDATE inv_login SET
			firstName = :firstName,
			lastName = :lastName,
			profile_id = :profile,$sql_pwd
			email = :email,
			status_id = :status,
			modify_date = '".$modifyDate."',
			modify_timestamp = '".$timeStamp."'
			WHERE
				login_id = :login_id";
			
		$statement = $this->connect->prepare($sql);
		
		if(!empty($password)){	
			$password = base64_encode($this->encrypt($password,md5($email.$password)));
			$statement->bindParam(':password', $password, PDO::PARAM_STR);			
		}
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

		$sql = "DELETE FROM inv_login WHERE login_id = :login_id LIMIT 1";
		$statement = $this->connect->prepare($sql);
		
		$statement->bindParam(':login_id', $loginId, PDO::PARAM_STR);
		
		$statement->execute();
		die("success delete ");		
	}
	
	function getProfiles(){

		$sql = "SELECT profile_id, profile_name FROM inv_profile";

		$statement = $this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$assoc_result = array();
		while(list(,$data)=each($result)){
			$assoc_result[$data['profile_id']]=$data['profile_name'];
		}
		
		return(!empty($assoc_result))?$assoc_result:false;
	}
	
	function getStatus(){

		$sql = "SELECT status_id, status_name FROM inv_status";

		$statement = $this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$assoc_result = array();
		while(list(,$data)=each($result)){
			$assoc_result[$data['status_id']]=$data['status_name'];
		}

		return(!empty($assoc_result))?$assoc_result:false;
	}
	
	function selectProfiles($idSelect='profile'){
		
		$selectProfiles = '<select id="'.$idSelect.'" name="'.$idSelect.'" class="form-control"><option >--Select Profile--</option>';
		
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

	public function pwd_recovery($email){
		
		$sql = "SELECT login_id FROM `inv_login` WHERE email = :email";
        $statement = $this->connect->prepare($sql);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		if(!empty($result)){
			//el correo existe, asignar nuevo pwd
			$password = $this->randomPassword();
			$originalPwd = $password;
			/////
				$timeStamp = time();
				$modifyDate = date("Y-m-d",$timeStamp);

			$sql = "UPDATE inv_login SET
				password = :password,
				modify_date = '".$modifyDate."',
				modify_timestamp = '".$timeStamp."'
				WHERE
					email = :email";
				
			$statement = $this->connect->prepare($sql);

			$password = base64_encode($this->encrypt($password,md5($email.$password)));
			$statement->bindParam(':password', $password, PDO::PARAM_STR);
			$statement->bindParam(':email', $email, PDO::PARAM_STR);
			$statement->execute();
			/////
			mail($email,"Nuevo password Hainzer Supply","Ha su solicitud le ha sido asignado un nuevo pwd: ".$originalPwd."\n\n CMS Hainzer Supply");
			
			return "true";
		} else {
			//el correo no existe
			return "false";
		}
	}
	
	public function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
	
    public function getUserDistribuidor($idUser){

        $sql = "select ud.idDistribuidor, nombre, representante, idNivel, di.correoElectronico from inv_user_distribuidor ud
                inner join inv_distribuidores di on ud.idDistribuidor = di.idDistribuidor
                where ud.login_id = ".$idUser;

        $statement = $this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);


        if(isset($result)){
            return $result[0];
        }
        else{
            return false;
        }

    }

    public function pagesProfile($idProfile){
        $sql = "SELECT page FROM inv_profile_pages
                where profile_id=".$idProfile;

        $statement = $this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
?>
