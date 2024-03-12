<?php
session_start();
if (!$_SESSION['employeeID']) {
	header('Location:../loginPage/login.php');
	exit();
}
?>