<?php
    require('./../database/connection.php');
    
    $elemID = $_GET['elemID'];
    // Get ID from Database
    if (isset($elemID)) {
        $pre_stmt = $connect->prepare("SELECT * FROM elementary WHERE elemID = ?") or die(mysqli_error());
        $pre_stmt->bind_param('i', $elemID);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
    }
    
    // Update Information
    if (isset($_POST['btn-updateElem'])) {
        $elemName = $_POST['elemName'];
        
        $pre_stmt = $connect->prepare("UPDATE elementary SET elemName = ? WHERE elemID = ?");
        $pre_stmt->bind_param('si', $elemName, $elemID);
        
        if ($pre_stmt->execute()) {
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated an elementary school name';
            $employeeid = $_SESSION['employeeid'];
            
            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            
            if ($stmt->execute()) {
                echo "City Office updated successfully";
                echo '<div id="update-success-modal" class="modal-background">
                        <div class="modal-content">
                            <div class="message">Elementary school is updated successfully</div>
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
                        <div class="message">Elementary school is updated successfully</div>
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