<?php
require('../database/connection.php');
session_start();

if (isset($_POST['btn_login'])) {
    $employeeid = mysqli_real_escape_string($connect, $_POST['employeeid']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $password = md5($password);

    $query = "SELECT * FROM users WHERE employeeID = ? AND password = ?";
    $stmt = $connect->prepare($query);
    
    $stmt->bind_param('is', $employeeid, $password);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 0) {
        $user = $result->fetch_assoc();
        $permission = $user['permission'];
        $firstname = $user['firstName'];
        $lastname = $user['lastName'];

        $_SESSION['employeeID'] = $employeeid;
        $_SESSION['firstName'] = $firstname . " " . $lastname;
        $_SESSION['permission'] = $permission;

        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);

        // Bind the values for the INSERT query
        $stmt_date = date('Y-m-d');
        $stmt_time = date('H:i:s');
        $stmt_action = 'Login';

        $stmt->bind_param('issss', $employeeid, $_SESSION['firstName'], $stmt_date, $stmt_time, $stmt_action);
        $stmt->execute();

        $last_login = date('Y-m-d h:i:s a');
        $query = "UPDATE users SET last_login = ? WHERE employeeID = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('si', $last_login, $employeeid);
        $stmt->execute();

        if ($password === md5('pass') && $permission === "Administrator") {
            header("Location: ../AdminPage/dashboard.php");
        } /*elseif ($permission === "ViewOnly") {
            header("Location: ../user_page1/dashboard.php");
        } elseif ($permission === "EditPRSandWMR") {
            header("Location: ../user_page2/dashboard.php");
        } elseif ($permission === "EditRegistryAndInventory") {
            header("Location: ../user_page3/dashboard.php");
        } else {
            // Handle other permission levels or errors
            header("Location: some_other_page.php");
        }*/
    } else {
        echo "<script>alert('Username or Password is incorrect.')</script>";
        echo "<script>window.open('login.php', '_self')</script>";
    }

    $stmt->close();
}
?>