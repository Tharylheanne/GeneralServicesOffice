<?php

$connect = mysqli_connect("localhost", "root", "", "gso_asset") or die(mysql_error());

if (!$connect) {
	die("Connection Failed").mysqli_connect_error();
}
?>