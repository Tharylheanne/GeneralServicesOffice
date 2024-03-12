<?php
    require('./../database/connection.php');
    
    $barangayID = $_GET['barangayID'];
    // Get ID from Database
    if (isset($barangayID)) {
        $pre_stmt = $connect->prepare("SELECT * FROM barangay WHERE barangayID = ?") or die(mysqli_error());
        $pre_stmt->bind_param('i', $barangayID);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
    }
    
    // Update Information
    if (isset($_POST['btn-updateBarangay'])) {
        $barangay = $_POST['barangayName'];
        
        $pre_stmt = $connect->prepare("UPDATE barangay SET barangayName = ? WHERE barangayID = ?");
        $pre_stmt->bind_param('si', $barangay, $barangayID);
        
        if ($pre_stmt->execute()) {
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated a barangay';
            $employeeid = $_SESSION['employeeid'];
            
            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            
            if ($stmt->execute()) {
                echo "Barangay updated successfully";
                echo '<div id="update-success-modal" class="modal-background">
                        <div class="modal-content">
                            <div class="message">Barangay is updated successfully</div>
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
                        <div class="message">Barangay is updated successfully</div>
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