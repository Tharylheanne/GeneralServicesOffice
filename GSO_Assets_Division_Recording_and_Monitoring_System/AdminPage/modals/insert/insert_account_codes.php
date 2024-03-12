<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "gso_asset");

if (!empty($_POST)) {
    $accountTitle = mysqli_real_escape_string($connect, $_POST['accounttitle_name']);
    $account_number_code = mysqli_real_escape_string($connect, $_POST['accountcode_number']);

    // Check if the account code already exists
    $query1 = "SELECT count(accountTitle) as num FROM account_codes WHERE accountTitle = ?";
    $pre_stmt = $connect->prepare($query1) or die(mysqli_error());
    $pre_stmt->bind_param("s", $accountTitle);
    $pre_stmt->execute();
    $result1 = $pre_stmt->get_result();
    $row1 = mysqli_fetch_array($result1);

    if ($row1['num'] == 0) {
        // Account code doesn't exist, so insert it
        $query = "INSERT INTO `accountCodeID` (`accountTitle`, `accountNumber`) VALUES (?, ?)";
        $pre_stmt = $connect->prepare($query) or die(mysqli_error());
        $pre_stmt->bind_param('ss', $account_title_name, $account_number_code);
        $pre_stmt->execute();

        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $login = 'Added an account code';
        $employeeID = $_SESSION['employeeid'];
        $firstName = $_SESSION['firstname'];

        // Corrected query for inserting into the activity log
        $query = "INSERT INTO activity_log (employeeID, firstName, date_log, time_log, action) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $firstname, $date_now, $time_now, $login);
        $stmt->execute();

        echo "Account Code for Equipment is successfully inserted.";
    } else {
        echo "Account Code for equipment already exists";
    }
}
?>