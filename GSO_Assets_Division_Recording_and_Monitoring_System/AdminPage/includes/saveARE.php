<?php
// Include database connection
require('./../database/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // File upload handling

    // Check if the uploaded file is not empty
    if (isset($_FILES['scannedDocs']) && $_FILES['scannedDocs']['error'] == 0) {
        $targetDirectory = './ARE SCANNED DOCUMENTS/';
        
        // Extract AREno and propertyNo from the form data
        $AREno = $_POST['AREno'];
        $propertyNo = $_POST['propertyNo'];

        // Create the new file name based on the specified format
        $newFileName = "ARE_" . $AREno . " (" . $propertyNo . ")";
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
    $serialNo = isset($_POST['serialNo']) ? $_POST['serialNo'] : array();
    $particulars = isset($_POST["particulars"]) ? $_POST["particulars"] : '';
    $eNGAS = isset($_POST['eNGAS']) ? $_POST['eNGAS'] : '';
    $acquisitionDate = isset($_POST["acquisitionDate"]) ? $_POST["acquisitionDate"] : '';
    $totalValue = isset($_POST["acquisitionCost"]) ? $_POST["acquisitionCost"] : '';
    $propertyNo = isset($_POST["propertyNo"]) ? $_POST["propertyNo"] : array();
    $accountNumber = isset($_POST['accountNumber']) ? $_POST['accountNumber'] : '';
    $estimatedLife = isset($_POST["estimatedLife"]) && $_POST["estimatedLife"] !== '' ? $_POST["estimatedLife"] : null;
    $unitOfMeasure = isset($_POST["unitOfMeasure"]) ? $_POST["unitOfMeasure"] : '';
    $unitValue = isset($_POST["unitValue"]) ? $_POST["unitValue"] : '';
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
    $officeName = isset($_POST['officeName']) ? $_POST['officeName'] : '';
    $accountablePerson = isset($_POST["accountablePerson"]) ? $_POST["accountablePerson"] : array();
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

    // Loop through each input and execute the statement for each set of data
    for ($i = 0; $i < count($accountablePerson); $i++) {
        $accountablePersons = $accountablePerson[$i];
        $AREnos = $AREno[$i];
        $serialNos = $serialNo[$i];
        $propertyNos = $propertyNo[$i];

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
        $remarks = isset($_POST["gpremarks"]) ? $_POST["gpremarks"]:'';
        $supplier = isset($_POST["supplier"]) ? $_POST["supplier"]:'';
        $POnumber = isset($_POST["POnumber"]) ? $_POST["POnumber"]:'';
        $AIRnumber = isset($_POST["AIRnumber"]) ? $_POST["AIRnumber"]:'';
        $notes = isset($_POST["notes"]) ? $_POST["notes"]:'';
        $jevNo = isset($_POST["jevNo"]) ? $_POST["jevNo"]:'';

        // Retrieve the last inserted propertyID
        $propertyID = $connect->insert_id;

        // Prepare and bind SQL statement for are_ics_gen_properties table
        $stmtAre = $connect->prepare("INSERT INTO are_ics_gen_properties (
            propertyID, 
            dateReceived, 
            onhandPerCount, 
            soQty, 
            soValue, 
            previousCondition, 
            location, 
            currentCondition, 
            dateOfPhysicalInventory, 
            supplier, 
            POnumber, 
            AIRnumber, 
            notes, 
            jevNo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtAre->bind_param("isssssssssssss", 
            $propertyID, 
            $dateReceived, 
            $onhandPerCount, 
            $soQty, 
            $soValue, 
            $previousCondition, 
            $location, 
            $currentCondition, 
            $dateOfPhysicalInventory,
            $supplier, 
            $POnumber, 
            $AIRnumber, 
            $notes, 
            $jevNo);
        
        // Execute the statement for are_ics_gen_properties
        if ($stmtAre->execute()) {

            $AREno = isset($_POST["AREno"]) ? $_POST["AREno"]: array();

            // Retrieve the last inserted ARE_ICS_id
            $ARE_ICS_id = $connect->insert_id;

            // Prepare and bind SQL statement for inserting into are_properties table
            $stmtAreProperties = $connect->prepare("INSERT INTO are_properties (propertyID, ARE_ICS_id, AREno) VALUES (?, ?, ?)");
            $stmtAreProperties->bind_param("iis", $propertyID, $ARE_ICS_id, $AREno);

            
            // Execute the statement for are_properties
            if ($stmtAreProperties->execute()) {
                // Data inserted successfully
                date_default_timezone_set('Asia/Manila');
                $date_now = date('Y-m-d');
                $time_now = date('H:i:s');
                $action = 'Added ARE Properties: Article - ' .$article. ', ARE No - ' . $AREno . ', Serial No - ' . $serialNo . ', Accountable Person - ' . $accountablePerson . ', Property No - ' . $propertyNo;
                $query = "INSERT INTO activity_log (employeeID, firstName, date_log, time_log, action) VALUES(?,?,?,?,?)";
                $stmtLog = $connect->prepare($query);
                $stmtLog->bind_param('issss', $_SESSION['employeeID'], $_SESSION['firstName'], $date_now, $time_now, $action);
                $stmtLog->execute();

                function displayModalWithRedirect($message, $redirectPage) {
                    echo '<div class="modal-background">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-message">' . $message . '</div>';
                    echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
                    echo '</div>';
                    echo '</div>';
                }

                // Show modal dialog with the message and redirect
                displayModalWithRedirect("Added an ARE Property", "activePPE.php");
            } else {
                // Error occurred
                echo "Error: " . $stmtAreProperties->error;
            }
            
            // Close are_properties statement
            $stmtAreProperties->close();
        } else {
            // Error occurred
            echo "Error: " . $stmtAre->error;
        }
        
        // Close are_ics_gen_properties statement
        $stmtAre->close();
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
}
?>