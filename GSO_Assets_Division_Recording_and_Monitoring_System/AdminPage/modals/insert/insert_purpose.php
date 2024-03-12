<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "db_gso");

if (!empty($_POST)) {
    $purposeName = mysqli_real_escape_string($connect, $_POST['purposeName']);

    // Check if the Clearance purpose name already exists
    $query1 = "SELECT COUNT(purposeName) AS num FROM clearancepurpose WHERE purposeName = ?";
    $pre_stmt = $connect->prepare($query1) or die(mysqli_error());
    $pre_stmt->bind_param("s", $purposeName);
    $pre_stmt->execute();
    $result1 = $pre_stmt->get_result();
    $row1 = mysqli_fetch_array($result1);

    if ($row1['num'] == 0) {
        // High school name doesn't exist, so insert it
        $query = "INSERT INTO clearancepurpose (purposeName) VALUES (?)";
        $pre_stmt = $connect->prepare($query) or die(mysqli_error());
        $pre_stmt->bind_param('s', $purposeName);
        $pre_stmt->execute();

        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $login = 'Added a clearance purpose';
        $employeeid = $_SESSION['employeeid'];
        $firstname = $_SESSION['firstname'];

        // Corrected query for inserting into the activity log
        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $firstname, $date_now, $time_now, $login);
        $stmt->execute();

        echo "Clearance purpose is successfully inserted.";
    } else {
        echo "Clearance purpose already exists";
    }
}
?>