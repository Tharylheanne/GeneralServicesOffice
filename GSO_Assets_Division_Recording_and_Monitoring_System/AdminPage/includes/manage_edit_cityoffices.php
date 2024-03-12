<?php
    require('./../database/connection.php');
    
    $cofficeid = $_GET['office_id'];
    // Get ID from Database
    if (isset($cofficeid)) {
        $pre_stmt = $connect->prepare("SELECT * FROM city_offices WHERE office_id = ?") or die(mysqli_error());
        $pre_stmt->bind_param('i', $cofficeid);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
    }
    
    // Update Information
    if (isset($_POST['btn-cityupdate'])) {
        $coffice_name = $_POST['cityoffice_name'];
        $coffice_code = $_POST['cityoffice_code'];
        
        $pre_stmt = $connect->prepare("UPDATE city_offices SET office_name = ?, ocode_number = ? WHERE office_id = ?");
        $pre_stmt->bind_param('ssi', $coffice_name, $coffice_code, $cofficeid);
        
        if ($pre_stmt->execute()) {
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated A City Office';
            $employeeid = $_SESSION['employeeid'];
            
            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            
            if ($stmt->execute()) {
                echo "City Office updated successfully";
                echo '<div id="update-success-modal" class="modal-background">
                        <div class="modal-content">
                            <div class="message">Local office is updated successfully</div>
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
                        <div class="message">Local Office is updated successfully</div>
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