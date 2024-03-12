<?php
    require('./../database/connection.php');
    
    $purposeID = $_GET['purposeID'];
    // Get ID from Database
    if (isset($purposeID)) {
        $pre_stmt = $connect->prepare("SELECT * FROM clearancepurpose WHERE purposeID = ?") or die(mysqli_error());
        $pre_stmt->bind_param('i', $purposeID);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
    }
    
    // Update Information
    if (isset($_POST['btn-updatePurpose'])) {
        $purposeName = $_POST['purposeName'];
        
        $pre_stmt = $connect->prepare("UPDATE clearancepurpose SET purposeName = ? WHERE purposeID = ?");
        $pre_stmt->bind_param('si', $purposeName, $purposeID);
        
        if ($pre_stmt->execute()) {
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated the clearance purpose';
            $employeeid = $_SESSION['employeeid'];
            
            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            
            if ($stmt->execute()) {
                echo "Clearance purpose updated successfully";
                echo '<div id="update-success-modal" class="modal-background">
                        <div class="modal-content">
                            <div class="message">Clearance purpose is updated successfully</div>
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
                        <div class="message">Clearance purpose is updated successfully</div>
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