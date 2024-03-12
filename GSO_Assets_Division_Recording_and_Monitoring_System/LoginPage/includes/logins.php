<?php

/**
 * user class add user
 */
class logins 
{
	private $con;

	function __construct()
	{
		# code...
		include_once("../../database/db.php");
		$db = new Database();
		$this->con = $db->connect();
}

//=========================Login============================================

public function userLogin($idnumber,$password){
	$pre_stmt = $this->con->prepare("SELECT * FROM user WHERE idnumber =?");
	$pre_stmt ->bind_param("i",$idnumber);
	$pre_stmt->execute() or die($this->con->error);
	$result = $pre_stmt->get_result();


	if ($result->num_rows<1) {
		return "NOT_REGISTERED";
		# code...
	}else{
		$row = $result->fetch_assoc();
		if (password_verify($password,$row["password"])) {
			# code...
			$_SESSION["idnumber"]=$row["idnumber"];
			$_SESSION["password"]=$row["password"];
			$_SESSION["last_login"]=$row["last_login"];
			$_SESSION["permission"]=$row["permission"];
			$_SESSION["status"]=$row["status"];

			//updating user last login 
			date_default_timezone_set('Asia/Manila');
			$last_login =date('Y-m-d h:i:s a');
			$pre_stmt=$this->con->prepare("UPDATE user SET last_login =? WHERE idnumber =? ");
			$pre_stmt->bind_param("si",$last_login,$idnumber);
			$result = $pre_stmt->execute() or die($this->con->error);

			if ($result) 
			{
				return 1; 
			}
			else{
				return 0; 
			}
			



		}
			}
		else{ return "PASSWORD_NOT_MATCHED";}
	}
}

}

//========================================================

//$user = new logins();
// echo $user->createUserAcc(1501093,"Ventura","Danilo Jr","12345","Admin");


//echo $user->userLogin(1501093,"1234");

?>