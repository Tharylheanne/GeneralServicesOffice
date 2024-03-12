<?php
require_once('../database/connection.php');

$account_code_id = $_GET['account_code_id'];

// Get ID from Database
if (isset($account_code_id)) {
    $pre_stmt = $connect->prepare("SELECT * FROM account_codes WHERE account_code_id = ?") or die(mysqli_error());
    $pre_stmt->bind_param('i', $account_code_id);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();
    $row = mysqli_fetch_array($result);
}

// Update Information
if (isset($_POST['btn-accountupdate'])) {
    $account_title = $_POST['account_title'];
    $account_number = $_POST['account_number'];

    $pre_stmt = $connect->prepare("UPDATE account_codes SET account_title = ?, account_number = ? WHERE account_code_id = ?");
    $pre_stmt->bind_param('ssi', $account_title, $account_number, $account_code_id);

    if ($pre_stmt->execute()) {
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $action = 'Updated the account codes';
        $employeeid = $_SESSION['employeeid'];

        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
        
        if ($stmt->execute()) {
            // Redirect to table users
            echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">Account code is updated successfully</div>
                        <button class="ok-button" onclick="redirectToPage(\'others.php\')">OK</button>
                    </div>
                </div>';
            echo '<script type="text/javascript">
                    function redirectToPage(page) {
                        window.location.href = page;
                    }
                  </script>';
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $pre_stmt->error;
    }
}
?>