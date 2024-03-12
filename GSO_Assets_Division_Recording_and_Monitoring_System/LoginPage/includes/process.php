<?php 
include_once("../../database/constants.php");
include_once("logins.php");



//=====================LOGIN PROCESS======================
if(isset($_POST["idnumber"]) AND isset($_POST["password"])){


	$user = new logins();
	$result=$user->userLogin($_POST["idnumber"],$_POST["password"]);
	echo $result;
	exit();

}
//=============================================================

?>