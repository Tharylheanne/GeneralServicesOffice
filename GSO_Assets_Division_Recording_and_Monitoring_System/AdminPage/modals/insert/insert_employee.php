<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "db_gso");

if (!empty($_POST)) {
    // Check if the keys exist in the $_POST array
    if (isset($_POST["employeeName"]) && isset($_POST["rescenter"])) {
        $employeeName = rtrim(stripslashes($_POST["employeeName"])); // Remove spaces at the end
        $employeeName = str_replace('. ', '.', $employeeName); // Remove spaces after middle initial dot
        $tinNo = stripslashes($_POST["tinNo"]);
        $employeeID = stripslashes($_POST["employeeID"]);
        $rescenter = stripslashes($_POST["rescenter"]);
        $remarks = stripslashes($_POST["remarks"]);

        // Check if the combination of employeeName and office already exists
        $query = "SELECT COUNT(*) as num FROM employees WHERE employeeName=? AND office=?";
        $pre_stmt = $connect->prepare($query) or die(mysqli_error());
        $pre_stmt->bind_param("ss", $employeeName, $rescenter);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);

        if ($row['num'] == 0) {
            $query = "INSERT INTO `employees`(`employeeName`,`office`, `tinNo`, `employeeID`, `remarks` ) VALUES (?,?,?,?,?)";
            $pre_stmt = $connect->prepare($query) or die(mysqli_error());
            $pre_stmt->bind_param("sssss", $employeeName, $rescenter, $tinNo, $employeeID, $remarks);
            $pre_stmt->execute();

            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Added an employee';
            $employeeid = $_SESSION['employeeid'];
            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            $stmt->execute();

            echo "Employee Successfully Inserted";
        } else {
            echo "Employee with the same name and office already exists";
        }
    } else {
        echo "Missing POST data"; // Handle missing POST data gracefully
    }
}
?>