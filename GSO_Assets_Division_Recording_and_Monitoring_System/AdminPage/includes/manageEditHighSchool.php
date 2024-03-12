<?php
    require('./../database/connection.php');
    
    $highSchoolID = $_GET['highSchoolID'];
    // Get ID from Database
    if (isset($highSchoolID)) {
        $pre_stmt = $connect->prepare("SELECT * FROM highschool WHERE highSchoolID = ?") or die(mysqli_error());
        $pre_stmt->bind_param('i', $highSchoolID);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
        $row = mysqli_fetch_array($result);
    }
    
    // Update Information
    if (isset($_POST['btn-updateHighSchool'])) {
        $highSchoolName = $_POST['highSchoolName'];
        
        $pre_stmt = $connect->prepare("UPDATE highschoolList SET highSchoolName = ? WHERE highSchoolID = ?");
        $pre_stmt->bind_param('si', $highSchoolName, $highSchoolID);
        
        if ($pre_stmt->execute()) {
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated a high school name';
            $employeeid = $_SESSION['employeeid'];
            
            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);
            
            if ($stmt->execute()) {
                /*echo "High School is updated successfully";*/
                echo '<div id="update-success-modal" class="modal-background">
                        <div class="modal-content">
                            <div class="message">High school is updated successfully</div>
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
                        <div class="message">High school is updated successfully</div>
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