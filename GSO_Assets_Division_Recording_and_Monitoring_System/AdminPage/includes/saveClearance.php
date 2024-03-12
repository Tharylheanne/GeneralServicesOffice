<?php
require('./../database/connection.php');

// Initialize variables
$purpose_input = isset($_POST['purpose_input']) ? $_POST['purpose_input'] : '';
$otherPurpose_input = isset($_POST['otherPurpose_input']) ? $_POST['otherPurpose_input'] : '';
$employeeName = isset($_POST['accountablePerson']) ? $_POST['accountablePerson'] : '';
$classification = isset($_POST['classification']) ? $_POST['classification'] : '';
$responsibilityCenter = isset($_POST["rescenter"]) ? $_POST["rescenter"] : null; // Get the responsibility center

$purpose_id = null;

// Determine the purpose_id to be saved
if (!empty($otherPurpose_input) && $purpose_input === "Other") {
    $newPurpose = $otherPurpose_input;

    $insertPurposeQuery = "INSERT INTO clearancepurpose (purposeName) VALUES (?)";
    $insertPurposeStmt = $connect->prepare($insertPurposeQuery);
    $insertPurposeStmt->bind_param('s', $newPurpose);

    if ($insertPurposeStmt->execute()) {
        $purpose_id = $insertPurposeStmt->insert_id;

        $insertPurposeStmt->close();
    } else {
        echo "Error: " . $insertPurposeStmt->error;
    }
} elseif (!empty($purpose_input)) {
    $purposeIdQuery = "SELECT purposeID, purposeName FROM clearancepurpose WHERE purposeName = ?";
    $purposeIdStmt = $connect->prepare($purposeIdQuery);
    $purposeIdStmt->bind_param('s', $purpose_input);
    $purposeIdStmt->execute();
    $purposeIdResult = $purposeIdStmt->get_result();

    if ($purposeIdResult->num_rows > 0) {
        $purposeIdRow = $purposeIdResult->fetch_assoc();
        $purposeName = $purposeIdRow['purposeName'];
    }

    $purposeIdStmt->close();
}

// Check if the employee name exists in the employees table
$checkEmployeeQuery = "SELECT employeeName FROM employees WHERE employeeName = ?";
$checkEmployeeStmt = $connect->prepare($checkEmployeeQuery);
$checkEmployeeStmt->bind_param('s', $employeeName);
$checkEmployeeStmt->execute();
$checkEmployeeResult = $checkEmployeeStmt->get_result();

if ($checkEmployeeResult === false) {
    die("Error in SQL query: " . $checkEmployeeStmt->error);
}

if ($checkEmployeeResult->num_rows === 0) {
    // Employee name doesn't exist, insert a new row
    if (!empty($employeeName)) { // Check if the employeeName is not empty
        $insertEmployeeQuery = "INSERT INTO employees (employeeName";
        
        if (($classification === "City Office" || $classification === "National Office") && !empty($responsibilityCenter)) {
            $insertEmployeeQuery .= ", office"; // Include the "office" column
            $insertEmployeeQuery .= ") VALUES (?, ?)"; // Add another placeholder for "office"
        } else {
            $insertEmployeeQuery .= ") VALUES (?)"; // Use only one placeholder
        }
        
        $insertEmployeeStmt = $connect->prepare($insertEmployeeQuery);
        
        if (($classification === "City Office" || $classification === "National Office") && !empty($responsibilityCenter)) {
            $insertEmployeeStmt->bind_param('ss', $employeeName, $responsibilityCenter); // Two parameters: employeeName and office
        } else {
            $insertEmployeeStmt->bind_param('s', $employeeName); // Only one parameter: employeeName
        }
        
        $insertEmployeeStmt->execute();
        
        $insertEmployeeStmt->close();
    }
}

if (isset($_POST['btn_clearanceSave'])) {
    // Check if the uploaded field is not empty and there are no errors
    if (isset($_FILES['scannedDocs']) && $_FILES['scannedDocs']['error'] == 0) {
        $targetDirectory = './CLEARANCE SCANS/';
        $targetFile = $targetDirectory . basename($_FILES['scannedDocs']['name']);

        // Check if the file already exists in the target directory
        if (file_exists($targetFile)) {
            echo "The file already exists. Please choose another file or rename the file and try again.";
        } else {
            if (move_uploaded_file($_FILES['scannedDocs']['tmp_name'], $targetFile)) {
                echo "The scanned document has been uploaded successfully.";
                $scannedClearance = $targetFile;
            } else {
                echo "Error in uploading the scanned document.";
            }
        }
    }

    // Retrieve form data
    $dateCleared = $_POST["dateCleared"];
    $controlNo = $_POST["controlNo"];
    $accountablePerson = $employeeName;
    $position = $_POST["position"];
    $classification = $_POST["classification"];
    $rescenter = $_POST["rescenter"];
    $purpose = $purposeName;
    $effectivityDate = $_POST["effectivityDate"];
    $remarks = $_POST["remarks"];
    $clearedBy = $_POST["clearedBy"];

    $check = "SELECT COUNT(*) as ID FROM clearance WHERE clearanceID=?";
    $pre_stmt = $connect->prepare($check) or die(mysqli_error($connect));
    $pre_stmt->bind_param('i', $_POST['clearanceID']);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();
    $row = mysqli_fetch_array($result);

    if ($row['ID'] == 0) {
        $sql = "INSERT INTO `clearance` (
            `dateCleared`,
            `controlNo`,
            `employeeName`,
            `position`,
            `classification`,
            `office`,
            `purpose`,
            `effectivityDate`,
            `remarks`,
            `clearedBy`,
            `scannedDocs`
        ) VALUES(?,?,?,?,?,?,?,?,?,?,?)";

        $pre_stmt = $connect->prepare($sql) or die (mysqli_error($connect));
        $pre_stmt->bind_param('sssssssssss',
            $dateCleared,
            $controlNo,
            $accountablePerson,
            $position,
            $classification,
            $rescenter,
            $purpose,
            $effectivityDate,
            $remarks,
            $clearedBy,
            $scannedClearance
        );

        if ($pre_stmt->execute()) {
            // Data inserted successfully
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Added a new clearance';

            $query = "INSERT INTO activity_log (employeeID, firstName, date_log, time_log, action) VALUES(?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $_SESSION['employeeID'], $_SESSION['firstName'], $date_now, $time_now, $action);
            $stmt->execute();

            function displayModalWithRedirect($message, $redirectPage)
            {
                echo '<div class="modal-background">';
                echo '<div class="modal-content">';
                echo '<div class="modal-message">' . $message . '</div>';
                echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
                echo '</div>';
                echo '</div>';
            }

            // Show a modal dialog with the message and redirect to clearance.php
            displayModalWithRedirect("Added a new clearance", "clearance.php");
        } else {
            echo "Error: " . $pre_stmt->error;
        }
    } else {
        // Clearance already exists
        displayModalWithRedirect("Clearance already exists", "addClearance.php");
    }
    $pre_stmt->close();
}

// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
?>