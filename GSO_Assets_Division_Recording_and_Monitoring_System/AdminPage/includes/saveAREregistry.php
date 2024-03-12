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

    //Dynamic fields
    $accountablePersons = isset($_POST["accountablePerson"]) ? $_POST["accountablePerson"] : [];
    $serialNos = isset($_POST['serialNo']) ? $_POST['serialNo'] : [];
    $propertyNos = isset($_POST["propertyNo"]) ? $_POST["propertyNo"] : [];
    $AREnos = isset($_POST["AREno"]) ? $_POST["AREno"] : [];
    $locations = isset($_POST["location"]) ? $_POST["location"] : [];


    foreach ($accountablePersons as $key => $accountablePerson) {
        //for generalproperties table
        $article = isset($_POST["article"]) ? strtoupper($_POST["article"]) : '';
        $brand = isset($_POST["brand"]) ? strtoupper($_POST["brand"]) : '';
        $particulars = isset($_POST["particulars"]) ? $_POST["particulars"] : '';
        $eNGAS = isset($_POST['eNGAS']) ? $_POST['eNGAS'] : '';
        $acquisitionDate = isset($_POST["acquisitionDate"]) ? $_POST["acquisitionDate"] : '';
        $totalValue = isset($_POST["acquisitionCost"]) ? $_POST["acquisitionCost"] : '';
        $accountNumber = isset($_POST['accountNumber']) ? $_POST['accountNumber'] : '';
        $estimatedLife = isset($_POST["estimatedLife"]) && $_POST["estimatedLife"] !== '' ? $_POST["estimatedLife"] : null;
        $unitOfMeasure = isset($_POST["unitOfMeasure"]) ? $_POST["unitOfMeasure"] : '';
        $unitValue = isset($_POST["unitValue"]) ? $_POST["unitValue"] : '';
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
        $officeName = isset($_POST['officeName']) ? $_POST['officeName'] : '';
        $gpremarks = isset($_POST["gpremarks"]) ? $_POST["gpremarks"] : '';
        $yearsOfService = isset($_POST["yearsOfService"]) ? $_POST["yearsOfService"]:'';
        $monthlyDepreciation = isset($_POST["monthlyDepreciation"]) ? $_POST["monthlyDepreciation"]:'';
        $accumulatedDepreciation = isset($_POST["accumulatedDepreciation"]) ? $_POST["accumulatedDepreciation"]:'';
        $bookValue = isset($_POST["bookValue"]) ? $_POST["bookValue"]:'';


        //For are_ics_gen_properties table
        $dateReceived = isset($_POST["dateReceived"]) ? $_POST["dateReceived"]:'';
        $onhandPerCount = isset($_POST["onhandPerCount"]) ? $_POST["onhandPerCount"]:'';
        $soQty = isset($_POST["soQty"]) ? $_POST["soQty"]:'';
        $soValue = isset($_POST["soValue"]) ? $_POST["soValue"]:'';
        $previousCondition = isset($_POST["previousCondition"]) ? $_POST["previousCondition"]:'';
        $currentCondition = isset($_POST["currentCondition"]) ? $_POST["currentCondition"]:'';
        $dateOfPhysicalInventory = isset($_POST["dateOfPhysicalInventory"]) ? $_POST["dateOfPhysicalInventory"]:'';
        $remarks = isset($_POST["remarks"]) ? $_POST["remarks"]:'';
        $supplier = isset($_POST["supplier"]) ? strtoupper($_POST["supplier"]) : '';
        $POnumber = isset($_POST["POno"]) ? $_POST["POno"]:'';
        $AIRnumber = isset($_POST["AIRnumber"]) ? $_POST["AIRnumber"]:'';
        $notes = isset($_POST["notes"]) ? $_POST["notes"]:'';
        $jevNo = isset($_POST["jevNo"]) ? $_POST["jevNo"]:'';

        // Insert data into generalproperties table
        $insertGeneralPropertiesQuery = "INSERT INTO generalproperties (
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
            bookValue
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($insertGeneralPropertiesQuery);
        $stmt->bind_param("ssssssssssssssssssss",
            $article, 
            $brand, 
            $serialNos[$key], 
            $particulars, 
            $eNGAS, 
            $acquisitionDate, 
            $totalValue, 
            $propertyNos[$key], 
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
            $bookValue);
        $stmt->execute();
        $propertyID = $stmt->insert_id;
        $stmt->close();

        // Insert data into are_ics_gen_properties table
        $insertAREICSGENPropertiesQuery = "INSERT INTO are_ics_gen_properties (
            propertyID, 
            dateReceived, 
            onhandPerCount, 
            soQty, 
            soValue, 
            previousCondition, 
            location, 
            currentCondition, 
            dateOfPhysicalInventory,
            remarks, 
            supplier, 
            POnumber, 
            AIRnumber, 
            notes, 
            jevNo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($insertAREICSGENPropertiesQuery);
        $stmt->bind_param("issssssssssssss",
            $propertyID, 
            $dateReceived, 
            $onhandPerCount, 
            $soQty, 
            $soValue, 
            $previousCondition, 
            $locations[$key], 
            $currentCondition, 
            $dateOfPhysicalInventory,
            $remarks,
            $supplier, 
            $POnumber, 
            $AIRnumber, 
            $notes, 
            $jevNo);
        $stmt->execute();
        $ARE_ICS_id = $stmt->insert_id;
        $stmt->close();

        // Insert data into are_properties table
        $insertAREPropertiesQuery = "INSERT INTO are_properties (propertyID, ARE_ICS_id, AREno) VALUES (?, ?, ?)";
        $stmt = $connect->prepare($insertAREPropertiesQuery);
        $stmt->bind_param("iis", $propertyID, $ARE_ICS_id, $AREnos[$key]);
        $stmt->execute();
        $stmt->close();

        //Insert data to the activity Log
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');
        $action = 'Added ARE Properties: Article - ' .$article. 'with Accountable Person - ' . $accountablePerson;
        $query = "INSERT INTO activity_log (employeeID, firstName, date_log, time_log, action) VALUES(?,?,?,?,?)";
        $stmtLog = $connect->prepare($query);
        $stmtLog->bind_param('issss', $_SESSION['employeeID'], $_SESSION['firstName'], $date_now, $time_now, $action);
        $stmtLog->execute();
        //Display message after successful execution
        displayModalWithRedirect("Added an ARE Property", "activePPE.php");
    }/*foreach*/
    // Close database connection
    $connect->close();
}
// Function to display modal with redirect
function displayModalWithRedirect($message, $redirectPage) {
    echo '<div class="modal-background">';
    echo '<div class="modal-content">';
    echo '<div class="modal-message">' . $message . '</div>';
    echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
    echo '</div>';
    echo '</div>';
}

// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
 ?>
