<?php
require('./../database/connection.php');

if (isset($_GET['propertyID'])) {
    $propertyID = $_GET['propertyID'];

    $sql = "SELECT gp.*, agp.*, ap.*, icsp.*
            FROM generalproperties gp
            LEFT JOIN are_ics_gen_properties agp ON gp.propertyID = agp.propertyID
            LEFT JOIN are_properties ap ON agp.ARE_ICS_id = ap.ARE_ICS_id
            LEFT JOIN ics_properties icsp ON ap.ARE_ICS_id = icsp.ARE_ICS_id
            WHERE ap.propertyID = ?";

    $pre_stmt = $connect->prepare($sql);
    $pre_stmt->bind_param('i', $propertyID);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        header("Location: activePPE.php");
        exit();
    }
}

// Check if the form is submitted
if (isset($_POST['updateARE'])) {

    // Handle file upload
    if (isset($_FILES['scannedDocs']) && $_FILES['scannedDocs']['name'] !== '') {
        $file_name = $_FILES['scannedDocs']['name'];
        $file_tmp = $_FILES['scannedDocs']['tmp_name'];

        // Extract original AREno and propertyNo from the form data
        $original_AREno = $_POST['areNo'];
        $original_propertyNo = $_POST['propertyNo'];

        // Extract new AREno and propertyNo from the form data
        $new_AREno = $_POST['AREno'];
        $new_propertyNo = $_POST['propertyNo'];

        // Create the new file name based on the specified format
        $new_file_name = "ARE_" . $new_AREno . " (" . $new_propertyNo . ").pdf"; // Assuming the file is in PDF format

        $file_destination = './ARE Scans/' . $new_file_name; // Specify the destination directory

        // Check if the file already exists in the destination directory
        if (file_exists($file_destination)) {
            // Rename the existing file only if either AREno or propertyNo has changed
            if ($original_AREno !== $new_AREno || $original_propertyNo !== $new_propertyNo) {
                // Rename the existing file with the new AREno and propertyNo
                $existing_file_name = basename($file_destination, ".pdf");
                $existing_file_extension = pathinfo($file_destination, PATHINFO_EXTENSION);
                $new_existing_file_name = "ARE_" . $new_AREno . " (" . $new_propertyNo . ")_old_" . time() . "." . $existing_file_extension;
                $existing_file_path = './ARE Scans/' . $new_existing_file_name;

                // Rename the existing file
                if (!rename($file_destination, $existing_file_path)) {
                    // Handle the renaming error, e.g., display an error message
                    echo "Error renaming existing file.";
                    exit();
                }
            }
        }

        // Move the uploaded file to the destination with the new name
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $file_path = $file_destination; // Set the file path to be stored in the database
        } else {
            // Handle the file upload error, e.g., display an error message
            echo "File upload failed.";
            exit();
        }
    } else {
        // No new file uploaded, retain the existing file path
        $file_path = $row['scannedARE'];
    }

    // Get and sanitize form inputs
    $propertyID = $_GET['propertyID'];
    $dateReceived = $_POST['dateReceived'];
    $officeName = $_POST['rescenter'];
    $acquisitionDate = $_POST['acquisitionDate'];
    $acquisitionCost =$_POST['acquisitionCost'];
    $AREno = $_POST['AREno'];
    $unitValue = $_POST['unitValue'];
    $quantity = $_POST['quantity'];
    $totalValue = $_POST['acquisitionCost'];
    $article = strtoupper($_POST['article']);
    $brand = strtoupper($_POST['brand']);
    $serialNo = $_POST['serialNo'];
    $particulars = $_POST['particulars'];
    $eNGAS = $_POST['eNGAS'];
    $propertyNo = $_POST['propertyNo'];
    $accountNumber = $_POST['accountNumber'];
    $estLife = $_POST['estimatedLife'];
    $unitMeasure = $_POST['unitOfMeasure'];
    $balancePerCard = $_POST['quantity'];
    $onhandPerCount = $_POST['onhandPerCount'];
    $soQty = $_POST['soQty'];
    $soValue = $_POST['soValue'];
    $accountablePerson = $_POST['accountablePerson'];
    $previousCondition = $_POST['previousCondition'];
    $location = $_POST['location'];
    $currentConditionSelect = $_POST['current_condition_input'];
    $dateOfPhysicalInventory = $_POST['dateOfPhysicalInventory'];
    $remarks = $_POST['remarks'];
    $supplier = $_POST['supplier'];
    $PONo = $_POST['POnumber'];
    $AIRRISNo = $_POST['AIRNumber'];
    $notes = $_POST['notes'];
    $jevNo = $_POST['jevNo'];
    $yearsOfService =$_POST['yearsOfService'];
    $monthlyDepreciation = $_POST['monthlyDepreciation'];
    $accumulatedDepreciation = $_POST['accumulatedDepreciation'];
    $bookValue = $_POST['bookValue'];
    $accountCodeID = $_POST['rescenter'];
    $AREno = $_POST['AREno'];
    $ICSno = $_POST['ICSno'];

    // Check if "Other" condition is selected
    if ($currentConditionSelect === 'Other') {
        // Use the value from the "Other Condition" input
        $currentConditionInput = $_POST['other_condition_input'];

        // Insert the new condition into the 'conditions' table
        $insertConditionQuery = "INSERT INTO conditions (conditionName) VALUES (?)";
        $insertConditionStmt = $connect->prepare($insertConditionQuery);
        $insertConditionStmt->bind_param('s', $currentConditionInput);

        if ($insertConditionStmt->execute()) {
            // Retrieve the condition ID of the newly inserted condition
            //$conditionId = $insertConditionStmt->insert_id;

            // Set the newly inserted condition_name as the current condition
            $currentCondition = $currentConditionInput;

            // Close the prepared statement
            $insertConditionStmt->close();
        } else {
            // Error inserting data
            echo "Error: " . $insertConditionStmt->error;
        }
    } else {
        // Use the value from the dropdown
        $currentCondition = $currentConditionSelect;
    }

    // Insert into generalproperties table
    $sql_generalproperties = "UPDATE generalproperties
        SET
            article=?,
            brand = ?,
            serialNo = ?,
            particulars = ?,
            eNGAS = ?,
            acquisitionDate = ?,
            acquisitionCost = ?,
            propertyNo = ?,
            accountNumber = ?,
            estimatedLife = ?,
            unitOfMeasure = ?,
            unitValue = ?,
            quantity = ?,
            officeName = ?,
            accountablePerson = ?,
            scannedDocs = ?,
            yearsOfService = ?,
            monthlyDepreciation = ?,
            accumulatedDepreciation = ?,
            bookValue = ?
            WHERE propertyID = ?";

    $stmt_generalproperties = $connect->prepare($sql_generalproperties);
    $stmt_generalproperties->bind_param('ssssssssssssssssssss',
        $article,
        $brand,
        $serialNo,
        $particulars,
        $eNGAS,
        $acquisitionDate,
        $acquisitionCost,
        $propertyNo,
        $accountCode,
        $estimatedLife,
        $unitOfMeasure,
        $unitValue,
        $quantity,
        $officeID,
        $accountablePerson,
        $scannedDocs,
        $yearsOfService,
        $monthlyDepreciation,
        $accumulatedDepreciation,
        $bookValue
        );

    $stmt_generalproperties->execute();

    //get the ID of the inserted property
    $propertyID = $stmt_generalproperties->insert_id;

    //Insert into are_ics_gen_properties table
    $sql_are_ics_gen_properties = "UPDATE are_ics_gen_properties
    SET
        propertyID = ?,
        dateReceived = ?,
        onhandPerCount = ?,
        soQty = ?,
        soValue = ?,
        previousCondition = ?,
        location = ?,
        currentConditionID = ?,
        dateOfPhysicalInventory = ?,
        remarks = ?,
        supplier = ?,
        POnumber = ?,
        AIRNumber = ?,
        notes = ?,
        jevNo = ?
        WHERE propertyID = ?";

    $stmt_are_ics_gen_properties = $connect->prepare($sql_are_ics_gen_properties);
    $stmt_are_ics_gen_properties->bind_param('issssssssssssss',
        $propertyID,
        $dateReceived,
        $onhandPerCount,
        $soQty,
        $soValue,
        $previousCondition,
        $location,
        $currentCondition,
        $dateOfPhysicalInventory,
        $remarks,
        $supplier,
        $POnumber,
        $AIRNumber,
        $notes,
        $jevNo);

    $stmt_are_ics_gen_properties->execute();

        // Insert into are_properties table
        $sql_are_properties = "UPDATE are_properties (propertyID, AREno)
        VALUES (?, ?)";

        $stmt_are_properties = $connect->prepare($sql_are_properties);
        $stmt_are_properties->bind_param('is', $propertyID, $AREno);

        $stmt_are_properties->execute();

        // Insert into ics_properties table
        $sql_ics_properties = "INSERT INTO ics_properties (propertyID, ICSno)
        VALUES (?, ?)";

        $stmt_ics_properties = $connect->prepare($sql_ics_properties);
        $stmt_ics_properties->bind_param('is', $propertyID, $ICSno);

        $stmt_ics_properties->execute();

        // Execute the update query
        if ($stmt_generalproperties->execute()) {
            // Activity log entry
            date_default_timezone_set('Asia/Manila');
            $date_now = date('Y-m-d');
            $time_now = date('H:i:s');
            $action = 'Updated the ARE properties';
            $employeeid = $_SESSION['employeeid'];

            $query = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?,?,?,?,?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid, $_SESSION['firstname'], $date_now, $time_now, $action);

            if ($stmt->execute()) {
                // Success message and redirection
                echo '<div id="update-success-modal" class="modal-background">
                        <div class="modal-content">
                            <div class="message">ARE is updated successfully</div>
                            <button class="ok-button" onclick="redirectToPage(\'active_PPE.php\')">OK</button>
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
            echo "Update failed: " . $stmt_generalproperties->error;
        }

        // Close statements and database connection
        $stmt_generalproperties->close();
        $stmt_are_ics_gen_properties->close();
        $stmt_are_properties->close();
        $stmt_ics_properties->close();
        $connect->close();

        // Redirect or display success message
        // header("Location: success.php");
        // exit();
    }

?>