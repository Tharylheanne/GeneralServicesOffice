<?php
/*require('../login/login_session.php');*/
require_once('../database/connection.php');

if (isset($_GET['idnumber'])) {
    $idnumber = $_GET['idnumber'];

    $query = "SELECT * FROM employees WHERE idnumber = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $idnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }
} else {
    echo "Employee ID not provided.";
    exit();
}


// Update Information
if (isset($_POST['btn-employeeupdate'])) {
    $employeeName = $_POST['employeeName'];
    $tinNo = $_POST['tinNo'];
    $employeeID = $_POST['employeeID'];
    $office = $_POST['rescenter'];
    $remarks = $_POST['remarks'];

    $pre_stmt = $connect->prepare("UPDATE employees SET employeeName = ?, tinNo = ?, employeeID = ?, office = ?, remarks = ? WHERE idnumber = ?");
    $pre_stmt->bind_param('sssssi', $employeeName, $tinNo, $employeeID, $office, $remarks, $idnumber);

    if ($pre_stmt->execute()) {
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $action = 'Updated data in the employee information';
        $employeeid = $_SESSION['employeeid'];

        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
        
        if ($stmt->execute()) {
            // Redirect to table users
            echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">Employee information is updated successfully</div>
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