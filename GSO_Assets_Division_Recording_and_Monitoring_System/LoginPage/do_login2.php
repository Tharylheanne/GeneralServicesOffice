<?php
require('./../database/connection.php');

session_start();
date_default_timezone_set('Asia/Manila');
$date_now=date('Y-m-d');
$time_now=date('H:i:s');
$login_action='Login';

/*Getting input value*/
if (isset($_POST['btn-login'])) {
	$employeeid=msqli_real_escape_string($connect, $_POST['employeeid']);
	$password=msqli_real_escape_string($connect, $_POST['password']);
	$password=md5($password);

	/*Check if the user is existing in the database or not */
	$query="SELECT * FROM user WHERE employeeid=? and password=?";

	/*user prepared statement*/
	$stmt=$connect->prepare($query);
	$stmt->bind_param('is', $employeeid, $password);
	$stmt->execute();
	$result=$stmt->get_result();

	if ($result->num_rows!=0) {
		/*Fetch user from the database*/
		$user=$result->fetch_assoc();

		/*check if the user is an administrator*/
		if ($user['permission']=="Administrator") {
			$_SESSION['employeeid']=$employeeid;
			$_SESSION['firstname']=$user['firstname']." ".$user['lastname'];
			$_SESSION['permission']=$user['permission'];

			if ($password==md5('pass')) {
				header('Location: ../admin_page/change_password.php');/*Administrator change password change*/
			}else{
				header('Location: ../admin_page/dashboard.php'); /*Administrator dashboard page*/
			}
		}else{
			echo "<script>alert('Cannot Login') </script>";
			echo "<script>alert('Account is Blocked') </script>";
			echo "<script>window.open('login.php','_self') </script>";
		}

		/*check if the user is an employee*/
		if ($user['permission']=="Employee") {
			$_SERVER['employeeid']==$employeeid;
			$_SESSION['firstname']=$user['firstname']." ".$user['lastname'];
			$_SESSION['permission']=$user['permission'];

			if ($password==md5('pass')) {
				header('Location: ../user_page/change_password.php')/*User change password*/
			}else{
				header('Location: ../user_page/change_password.php')/*User dashboard page*/
			}
		}else{
			echo "<script>alert('Cannot Login') </script>";
			echo "<script>alert('Account is Blocked') </script>";
			echo "<script>window.open('login.php','_self') </script>";
		}
	}
	$stmt->close();

}

?>
