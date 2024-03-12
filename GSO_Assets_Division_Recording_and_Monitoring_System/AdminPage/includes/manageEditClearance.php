<?php
require('./../database/connection.php');

if (isset($_GET['clearanceID'])) {
    $clearanceID = $_GET['clearanceID'];

    $pre_stmt = $connect->prepare("SELECT * FROM clearance c
        LEFT JOIN clearancepurpose cp ON c.purpose = cp.purposeName
        
        WHERE c.clearanceID = ?");
    $pre_stmt->bind_param('i', $clearanceID);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        header("Location: clearance.php");
        exit();
    }
}

if (isset($_POST['btn_updateClearance'])) {
    // Handle file upload
        if (isset($_FILES['scannedCopy']) && $_FILES['scannedCopy']['name'] !== '') {
            $file_name = $_FILES['scannedCopy']['name'];
            $file_tmp = $_FILES['scannedCopy']['tmp_name'];
            $file_destination = './Clearance Scans/' . $file_name; // Specify the destination directory

            // Move the uploaded file to the destination
            if (move_uploaded_file($file_tmp, $file_destination)) {
                $file_path = $file_destination; // Set the file path to be stored in the database
            } else {
                // Handle the file upload error, e.g., display an error message
                echo "File upload failed.";
                exit();
            }
        } else {
            // No new file uploaded, retain the existing file path
            $file_path = $row['scannedCopy'];
        }
    // Retrieve and sanitize form data
    $clearanceID = $_GET['clearanceID'];
    $dateCleared = mysqli_real_escape_string($connect, $_POST['dateCleared']);
    $controlNo = mysqli_real_escape_string($connect, $_POST['controlNo']);
    $scannedCopy = mysqli_real_escape_string($connect, $_POST['saved_scanned_file']);
    $employeeName = mysqli_real_escape_string($connect, $_POST['accountable_person']);
    $position = mysqli_real_escape_string($connect, $_POST['position']);
    $classification = mysqli_real_escape_string($connect, $_POST['classification']);
    $responsibilityCenter = mysqli_real_escape_string($connect, $_POST['rescenter']);
    $purposeName = mysqli_real_escape_string($connect, $_POST['purpose_input']);
    $effectivityDate = mysqli_real_escape_string($connect, $_POST['effectivityDate']);
    $remarks = mysqli_real_escape_string($connect, $_POST['remarks']);
    $clearedBy = mysqli_real_escape_string($connect, $_POST['clearedBy']);

    // Check if "Other" purpose is selected
if ($purposeName === 'Other') {
    // Use the value from the "Other Purpose" input
    $otherPurposeInput = mysqli_real_escape_string($connect, $_POST['otherPurpose_input']);

    // Check if the purpose already exists in the database
    $checkPurposeQuery = "SELECT purposeName FROM clearancepurpose WHERE purposeName = '$otherPurposeInput'";
    $checkPurposeResult = mysqli_query($connect, $checkPurposeQuery);

    if (mysqli_num_rows($checkPurposeResult) > 0) {
        // The purpose already exists, retrieve the purposeName
        $purposeRow = mysqli_fetch_assoc($checkPurposeResult);
        $purposeName = $purposeRow['purposeName'];
    } else {
        // The purpose does not exist, insert it into the 'clearancepurpose' table
        $insertPurposeQuery = "INSERT INTO clearancepurpose (purposeName) VALUES ('$otherPurposeInput')";
        if (mysqli_query($connect, $insertPurposeQuery)) {
            // Use the newly inserted purposeName
            $purposeName = $otherPurposeInput;
        } else {
            // Error inserting data
            echo "Error: " . mysqli_error($connect);
            exit(); // You can handle the error gracefully
        }
    }
}

// Update the database with the user's input and the file path
$updateQuery = "UPDATE clearance SET
    dateCleared = ?,
    controlNo = ?,
    scannedCopy = ?,
    employeeName = ?,
    position = ?,
    classification = ?,
    responsibilityCenter = ?,
    purpose = ?,
    effectivityDate = ?,
    remarks = ?,
    clearedBy = ?
WHERE clearanceID = ?";

// Prepare the statement
$updateStmt = $connect->prepare($updateQuery);

// Bind parameters
$updateStmt->bind_param(
    "sssssssssssi",
    $dateCleared, $controlNo, $file_path, $employeeName, $position, $classification, $responsibilityCenter, $purposeName, $effectivityDate, $remarks, $clearedBy, $clearanceID
);

// Execute the query
if ($updateStmt->execute()) {
    // Insert activity log entry
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $action = 'Updated the clearance information';
        $employeeid = $_SESSION['employeeid'];

        $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);

        if ($stmt->execute()) {
            echo '<div id="update-success-modal" class="modal-background">
                    <div class="modal-content">
                        <div class="message">Clearance is updated successfully</div>
                        <button class="ok-button" onclick="redirectToPage(\'clearance.php\')">OK</button>
                    </div>
                </div>';
            echo '<script type="text/javascript">
                    function redirectToPage(page) {
                        window.location.href = page;
                    }
                  </script>';
        } else {
            // Handle the activity log insertion error
            echo "Activity log entry failed: " . $stmt->error;
        }
    } else {
        // Handle the update error, e.g., display an error message
        echo "Update failed: " . $updateStmt->error;
    }
}

?>