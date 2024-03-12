<?php
// Include database connection
require('./../database/connection.php');

// Step 1: Extract data from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Extract data from the form
    $article = strtoupper($_POST["article"]);
    $brand = strtoupper($_POST["brand"]);
    $serialNo = $_POST["serialNo"];
    $particulars = $_POST["particulars"];
    $eNGAS = $_POST["eNGAS"];
    $acquisitionDate = $_POST["acquisitionDate"];
    $acquisitionCost = $_POST["acquisitionCost"];
    $propertyNo = $_POST["propertyNo"];
    $accountNumber = $_POST["accountNumber"];
    $estimatedLife = $_POST["estimatedLife"];
    $unitOfMeasure = $_POST["unitOfMeasure"];
    $unitValue = $_POST["unitValue"];
    $quantity = $_POST["quantity"];
    $officeName = $_POST["officeName"];
    $accountablePerson = $_POST["accountablePerson"];
    $scannedDocs = $_POST["scannedDocs"];
    $yearsOfService = $_POST["yearsOfService"];
    $monthlyDepreciation = $_POST["monthlyDepreciation"];
    $accumulatedDepreciation = $_POST["accumulatedDepreciation"];
    $bookValue = $_POST["bookValue"];
    $gpremarks = $_POST['gpremarks'];
    
    
    // data to be inserted to the are_ics_gen_properties
    $dateReceived = $_POST["dateReceived"];
    $onhandPerCount = $_POST["onhandPerCount"];
    $soQty = $_POST["soQty"];
    $soValue = $_POST["soValue"];
    $previousCondition = $_POST["previousCondition"];
    $location = $_POST["location"];
    $currentCondition = $_POST["currentCondition"];
    $dateOfPhysicalInventory = $_POST["dateOfPhysicalInventory"];
    $remarks = $_POST["remarks"];
    $supplier = strtoupper($_POST["supplier"]);
    $POno = $_POST["POno"];
    $AIRnumber = $_POST["AIRnumber"];
    $notes = $_POST["notes"];
    $jevNo = $_POST["jevNo"];

    //Data to be inserted to the are_properties table
    $AREno = $_POST['AREno'];

    // Step 2: Insert data into the database
    // Insert data into the generalproperties table
    $insertGeneralProperties = $connect->prepare("INSERT INTO generalproperties
        (
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
    $insertGeneralProperties->bind_param("sssssssssssssssssssss",
        $article,
        $brand,
        $serialNo,
        $particulars,
        $eNGAS,
        $acquisitionDate,
        $acquisitionCost,
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
    $insertGeneralProperties->execute();
    $propertyID = $insertGeneralProperties->insert_id;

    // Insert data into the are_ics_gen_properties table
    $insertAREICSProperties = $connect->prepare("INSERT INTO are_ics_gen_properties (propertyID, dateReceived, onhandPerCount, soQty, soValue, previousCondition, location, currentCondition, dateOfPhysicalInventory, remarks, supplier, POno, AIRnumber, notes, jevNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertAREICSProperties->bind_param("issssssssssssss", $propertyID, $dateReceived, $onhandPerCount, $soQty, $soValue, $previousCondition, $location, $currentCondition, $dateOfPhysicalInventory, $remarks, $supplier, $POno, $AIRnumber, $notes, $jevNo);
    $insertAREICSProperties->execute();
    $AREICSID = $insertAREICSProperties->insert_id;

    // Insert data into the are_properties table
    $insertAREProperties = $connect->prepare("INSERT INTO are_properties (propertyID, AREno, ARE_ICS_id) VALUES (?, ?, ?)");
    $insertAREProperties->bind_param("iis", $propertyID, $AREno, $AREICSID);

    foreach ($AREno as $are) {
        $AREno = $are;
        $insertAREProperties->execute();
    }

    // Close prepared statements
    $insertGeneralProperties->close();
    $insertAREICSProperties->close();
    $insertAREProperties->close();

    // Close database connection
    $connect->close();
}
?>