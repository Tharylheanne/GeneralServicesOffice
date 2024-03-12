<?php
require('./../database/connection.php');

session_start();

date_default_timezone_set('Asia/Manila');
$date_now =date('Y-m-d');
$time_now=date('H:i:s');
$logout_action='Logout';
$employeeid = $_SESSION['employeeID'] ;
$user['firstName'] = $_SESSION['firstName'];


    $query ="INSERT INTO activity_log (employeeid,firstname,date_log,time_log,action) values
                    (?,?,?,?,?)";        
    $stmt = $connect->prepare($query);
    $stmt->bind_param('issss', $employeeid,$_SESSION['firstName'],$date_now,$time_now,$logout_action);
    $stmt->execute();


    /*$permission=$_SESSION['permission'];
    $output=$_SESSION['firstname'].' has Logout';
    $query ="INSERT INTO notification (notify_output,notify_user) values(?,?)"; 
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ss', $output,$permission);
    $stmt->execute();*/

	// Display a modal alert using JavaScript
    echo '<script>
        alert("You have Logged Out");
        window.location.href = "login.php";
    </script>';
?>