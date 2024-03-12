<?php
require('./../database/connection.php');

$nofficeid = $_GET['noffice_id'];
// Get ID from Database
if (isset($nofficeid)) {
    $pre_stmt = $connect->prepare("SELECT * FROM national_offices WHERE noffice_id = ?") or die(mysqli_error());
    $pre_stmt->bind_param('i', $nofficeid);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();
    $row = mysqli_fetch_array($result);
}

// Update Information
if (isset($_POST['btn-nationalupdate'])) {
    $noffice_name = $_POST['nationaloffice_name'];
    $noffice_code = $_POST['nationaloffice_code'];
    
    $pre_stmt = $connect->prepare("UPDATE national_offices SET noffice_name = ?, ncode_number = ? WHERE noffice_id = ?");
    $pre_stmt->bind_param('ssi', $noffice_name, $noffice_code, $nofficeid);
    
    if ($pre_stmt->execute()) {
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $action = 'Updated A National Office';
        $employeeid = $_SESSION['employeeid'];
        
        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
        
        if ($stmt->execute()) {
            echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">National office is updated successfully</div>
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
    
    // Redirect to table users
    echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">National office is updated successfully</div>
                        <button class="ok-button" onclick="redirectToPage(\'others.php\')">OK</button>
                    </div>
                </div>';
            echo '<script type="text/javascript">
                    function redirectToPage(page) {
                        window.location.href = page;
                    }
                  </script>';
}
?>