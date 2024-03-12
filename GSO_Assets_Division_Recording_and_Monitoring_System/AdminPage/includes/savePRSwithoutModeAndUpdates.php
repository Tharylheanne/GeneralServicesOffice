<?php 
//Include database connection
require('./../database/connection.php');

//Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Check if the uploaded file is not empty
    if (isset($_FILES['scannedDocs']) && $_FILES['scannedDocs']['error'] == 0) {
        $targetFile = './ARE SCANNED DOCUMENTS/';

        //Extract prsNo and propertyNo from the form data
        $prsNo = $_POST['prsNo'];
        $propertyNo = $_POST['propertyNo'];

        // Create the new file name based on the specified format
        $newFileName = "PRS_" . $prsNo . " (" . $propertyNo . ")";
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
                $scannedPRS = $targetFile;
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


    // Prepare and bind SQL statement for generalproperties table
    $stmtGen = $connect->prepare("INSERT INTO generalproperties (
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
        gpremarks)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmtGen->bind_param("sssssssssssssssss",
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
        $scannedPRS, 
        $gpremarks);

    if ($stmtGen->execute()) {
        
        $onhandPerCount = isset($_POST["onhandPerCount"]) ? $_POST["onhandPerCount"]:'';
        $soQty = isset($_POST["soQty"]) ? $_POST["soQty"]:'';
        $soValue = isset($_POST["soValue"]) ? $_POST["soValue"]:'';

        // Retrieve the last inserted propertyID
        $propertyID = $connect->insert_id;

        // Prepare and bind SQL statement for are_ics_gen_properties table
        $stmtAre = $connect->prepare("INSERT INTO are_ics_gen_properties (
            propertyID, 
            onhandPerCount, 
            soQty, 
            soValue) 
        VALUES (?, ?, ?, ?)");
        $stmtAre->bind_param("isss", 
            $propertyID, 
            $onhandPerCount, 
            $soQty, 
            $soValue);

        if ($stmtAre->execute()) {
            
            $AREno = isset($_POST["AREno"]) ? $_POST["AREno"]:'';

            // Retrieve the last inserted ARE_ICS_id
            $ARE_ICS_id = $connect->insert_id;

            // Prepare and bind SQL statement for inserting into are_properties table
            $stmtAreProperties = $connect->prepare("INSERT INTO are_properties (propertyID, ARE_ICS_id, AREno) VALUES (?, ?, ?)");
            $stmtAreProperties->bind_param("iis", $propertyID, $ARE_ICS_id, $AREno);

            if ($stmtAreProperties->execute()) {
                
                $dateReturned = isset($_POST["dateReturned"]) ? $_POST["dateReturned"]:'';
                $itemNo = isset($_POST['itemNo']) ? $_POST['itemNo']: '';
                $iirup = isset($_POST['iirup']) ? $_POST['iirup']: '';
                $iirupDate = isset($_POST['iirupDate']) ? $_POST['iirupDate']: '';
                $withAttachment = isset($_POST['withAttachment']) ? "YES" : "NONE";
                $withCoverPage = isset($_POST['withCoverPage']) ? "YES" : "NONE";

                //Retrieve the last inserted propertyID
                $AREid = $connect->insert_id;

                //Prepare and bind SQL statement for inserting into prs_wmr_gen_properties table
                $stmtPrsProperties = $connect->prepare("INSERT INTO prs_wmr_gen_properties (
                    propertyID,
                    dateReturned,
                    itemNo,
                    iirup,
                    iirupDate,
                    withAttachment,
                    withCoverPage
                )
                VALUES(?, ?, ?, ?, ?, ?, ?)");

                $stmtPrsProperties->bind_param("issssss",
                    $propertyID,
                    $dateReturned,
                    $itemNo,
                    $iirup,
                    $iirupDate,
                    $withAttachment,
                    $withCoverPage);

                if ($stmtPrsProperties) {
                    $prsNo = isset($_POST['prsNo']) ? $_POST['prsNo']: '';

                    $PRS_WMR_id = $connect->insert_id;

                    $stmtPRS = $connect->prepare("INSERT INTO prs_properties (
                        propertyID,
                        PRS_WMR_Id,
                        AREid,
                        prsNo)
                    VALUES (?,?,?,?)");

                    $stmtPRS->bind_param("iiis",
                        $propertyID,
                        $PRS_WMR_id,
                        $AREid,
                        $prsNo);

                    if ($stmtPRS->execute()) {
                        
                        function displayModalWithRedirect($message, $redirectPage){
                            echo '<div class="modal-background">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-message">' . $message . '</div>';
                            echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
                            echo '</div>';
                            echo '</div>';
                        }/*function displayModalWithRedirect*/
                        //Show modal dialog with the message and redirect
                        displayModalWithRedirect("Added a PRS", "PRS.php");
                    }/*stmtPRS*/ else {
                        //Error occured
                        echo "Error: " .$stmtPRS->error;
                    }
                    //Close the prs_properties statment
                    $stmtPRS->close();

                }/*stmtPrsProperties*/ else {
                    //Error occured
                    echo "Error: " .$stmtPrsProperties->error;
                }

                //Close the prs_wmr_gen_properties
                $stmtPrsProperties->close();

            }/*stmtAreProperties*/ else {
                //Error occured
                echo "Error: " .$stmtAreProperties->error;
            }

            //Close the are_properties
            $stmtAreProperties->close();

        }/*stmtARE*/ else {
            //Error occured
            echo "Error: " .$stmtARE->error;
        }

        //Close the are_ics_gen_properties
        $stmtAre->close();

    }/*stmtGen*/ else {
        //Error occured
        echo "Error: " .$stmtGen->error;
    }

    //Close the generalproperties
    $stmtGen->close();

    //Close the database connection
    $connect->close();

    //Redirect the page
    echo '<script type="text/javascript">
            function redirectToPage(page) {
                window.location.href = page;
            }
        </script>';


}/*if ($_SERVER['REQUEST_METHOD'] == "POST")*/

 ?>