<?php
// Include database connection
require('./../database/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // File upload handling

    // Check if the uploaded file is not empty
    if (isset($_FILES['scannedDocs']) && $_FILES['scannedDocs']['error'] == 0) {
        $targetDirectory = './ICS SCANNED DOCUMENTS/';
        
        // Extract ICSno and propertyNo from the form data
        $ICSno = $_POST['ICSno'];
        $propertyNo = $_POST['propertyNo'];

        // Create the new file name based on the specified format
        $newFileName = "ICS_" . $ICSno . " (" . $propertyNo . ")";
        $fileExtension = pathinfo($_FILES['scannedDocs']['name'], PATHINFO_EXTENSION);
        $targetFile = $targetDirectory . $newFileName . "." . $fileExtension;

        // Check if the file already exists in the target directory
        if (file_exists($targetFile)) {
            echo "The file already exists. Please rename the file and try again.";
        } else {
            // Attempt to move the uploaded file to the target directory with the new name
            if (move_uploaded_file($_FILES['scannedDocs']['tmp_name'], $targetFile)) {
                echo "The scanned document has been uploaded successfully.";
                // Store the file path in the database
                $scannedARE = $targetFile;
            } else {
                echo "Error in uploading the scanned document.";
            }
        }
    }

    $article = isset($_POST["article"]) ? strtoupper($_POST["article"]) : '';
    $brand = isset($_POST["brand"]) ? strtoupper($_POST["brand"]) : '';
    $serialNo = isset($_POST['serialNo']) ? $_POST['serialNo'] : '';
    $particulars = isset($_POST["particulars"]) ? $_POST["particulars"] : '';
    $eNGAS = isset($_POST['eNGAS']) ? $_POST['eNGAS'] : '';
    $acquisitionDate = isset($_POST["acquisitionDate"]) ? $_POST["acquisitionDate"] : '';
    $totalValue = isset($_POST["acquisitionCost"]) ? $_POST["acquisitionCost"] : '';
    $propertyNo = isset($_POST["propertyNo"]) ? $_POST["propertyNo"] : '';
    $accountNumber = isset($_POST['accountNumber']) ? $_POST['accountNumber'] : '';
    $estimatedLife = isset($_POST["estimatedLife"]) && $_POST["estimatedLife"] !== '' ? $_POST["estimatedLife"] : null;
    $unitOfMeasure = isset($_POST["unitOfMeasure"]) ? $_POST["unitOfMeasure"] : '';
    $unitValue = isset($_POST["unitValue"]) ? $_POST["unitValue"] : '';
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
    $officeName = isset($_POST['officeName']) ? $_POST['officeName'] : '';
    $accountablePerson = isset($_POST["accountablePerson"]) ? $_POST["accountablePerson"] : '';
    $gpremarks = isset($_POST["gpremarks"]) ? $_POST["gpremarks"] : '';
    $yearsOfService = isset($_POST["yearsOfService"]) ? $_POST["yearsOfService"]:'';
    $monthlyDepreciation = isset($_POST["monthlyDepreciation"]) ? $_POST["monthlyDepreciation"]:'';
    $accumulatedDepreciation = isset($_POST["accumulatedDepreciation"]) ? $_POST["accumulatedDepreciation"]:'';
    $bookValue = isset($_POST["bookValue"]) ? $_POST["bookValue"]:'';


    // Prepare and bind SQL statement for generalproperties table
    $stmt = $connect->prepare("INSERT INTO generalproperties (
        article, 
        brand, 
        serialNo, 
        particulars, 
        eNGAS, 
        acquisitionDate, 
        acquisitionCost, 
        propertyNo, 
        accountNumber, 
        estimatedLife, 
        unitOfMeasure, 
        unitValue, 
        quantity, 
        officeName, 
        accountablePerson,
        scannedDocs, 
        yearsOfService, 
        monthlyDepreciation, 
        accumulatedDepreciation, 
        bookValue,
        gpremarks)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssssssssssss",
        $article, 
        $brand, 
        $serialNo, 
        $particulars, 
        $eNGAS, 
        $acquisitionDate, 
        $totalValue, 
        $propertyNo, 
        $accountNumber, 
        $estimatedLife, 
        $unitOfMeasure, 
        $unitValue, 
        $quantity, 
        $officeName, 
        $accountablePerson,
        $scannedARE, 
        $yearsOfService, 
        $monthlyDepreciation, 
        $accumulatedDepreciation, 
        $bookValue,
        $gpremarks);

    // Execute the statement
    if ($stmt->execute()) {

        $dateReceived = isset($_POST["dateReceived"]) ? $_POST["dateReceived"]:'';
        $onhandPerCount = isset($_POST["onhandPerCount"]) ? $_POST["onhandPerCount"]:'';
        $soQty = isset($_POST["soQty"]) ? $_POST["soQty"]:'';
        $soValue = isset($_POST["soValue"]) ? $_POST["soValue"]:'';
        $previousCondition = isset($_POST["previousCondition"]) ? $_POST["previousCondition"]:'';
        $location = isset($_POST["location"]) ? $_POST["location"]:'';
        $currentCondition = isset($_POST["currentCondition"]) ? $_POST["currentCondition"]:'';
        $dateOfPhysicalInventory = isset($_POST["dateOfPhysicalInventory"]) ? $_POST["dateOfPhysicalInventory"]:'';
        $remarks = isset($_POST["remarks"]) ? $_POST["remarks"]:'';
        $supplier = isset($_POST["supplier"]) ? $_POST["supplier"]:'';
        $POnumber = isset($_POST["POnumber"]) ? $_POST["POnumber"]:'';
        $AIRnumber = isset($_POST["AIRnumber"]) ? $_POST["AIRnumber"]:'';
        $notes = isset($_POST["notes"]) ? $_POST["notes"]:'';
        $jevNo = isset($_POST["jevNo"]) ? $_POST["jevNo"]:'';

        // Retrieve the last inserted propertyID
        $propertyID = $connect->insert_id;

        // Prepare and bind SQL statement for are_ics_gen_properties table
        $stmtIcs = $connect->prepare("INSERT INTO are_ics_gen_properties (
            propertyID, 
            dateReceived, 
            onhandPerCount, 
            soQty, 
            soValue, 
            previousCondition, 
            location, 
            currentCondition, 
            supplier, 
            POnumber, 
            AIRnumber, 
            notes, 
            jevNo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtIcs->bind_param("issssssssssss", 
            $propertyID, 
            $dateReceived, 
            $onhandPerCount, 
            $soQty, 
            $soValue, 
            $previousCondition, 
            $location, 
            $currentCondition,
            $supplier, 
            $POnumber, 
            $AIRnumber, 
            $notes, 
            $jevNo);
        
        // Execute the statement for are_ics_gen_properties
        if ($stmtIcs->execute()) {

            $ICSno = isset($_POST["ICSno"]) ? $_POST["ICSno"]:'';

            // Retrieve the last inserted ARE_ICS_id
            $ARE_ICS_id = $connect->insert_id;

            // Prepare and bind SQL statement for inserting into are_properties table
            $stmtIcsProperties = $connect->prepare("INSERT INTO ics_properties (propertyID, ARE_ICS_id, ICSno) VALUES (?, ?, ?)");
            $stmtIcsProperties->bind_param("iis", $propertyID, $ARE_ICS_id, $ICSno);

            // Execute the statement for are_properties
            if ($stmtIcsProperties->execute()) {
                function displayModalWithRedirect($message, $redirectPage) {
                    echo '<div class="modal-background">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-message">' . $message . '</div>';
                    echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
                    echo '</div>';
                    echo '</div>';
                }

                // Show modal dialog with the message and redirect
                displayModalWithRedirect("Added an ARE Property", "activeSemiPPE.php");
            } else {
                // Error occurred
                echo "Error: " . $stmtIcsProperties->error;
            }
            
            // Close are_properties statement
            $stmtIcsProperties->close();
        } else {
            // Error occurred
            echo "Error: " . $stmtIcs->error;
        }
        
        // Close are_ics_gen_properties statement
        $stmtIcs->close();
    } else {
        // Error occurred
        echo "Error: " . $stmt->error;
    }

    // Close generalproperties statement
    $stmt->close();

    // Close database connection
    $connect->close();

    // JavaScript function to redirect to a page
    echo '<script type="text/javascript">
        function redirectToPage(page) {
            window.location.href = page;
        }
    </script>';
}
?>