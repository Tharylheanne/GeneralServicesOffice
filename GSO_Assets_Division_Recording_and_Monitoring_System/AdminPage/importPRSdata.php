<?php

// Include PHPExcel library
/*require 'PHPExcel/PHPExcel.php';*/
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

// Function to display a modal dialog with a message and then redirect
function displayModalWithRedirect($message, $redirectPage)
{
    echo '<style>
          /* Style the modal background */
          .modal-background {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
          }

          /* Style the modal content for both modals */
          .modal-content {
            background-color: #ffffff; /* White background */
            color: black;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            z-index: 2;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
          }

          /* Style the OK button */
          .ok-button {
            background-color: #0074E4; /* Blue background color for OK button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px; /* Add margin to separate the message and the button */
          }
        </style>';

    echo '<div class="modal-background">';
    echo '<div class="modal-content">';
    echo '<div class="modal-message">' . $message . '</div>';
    echo '<button class="ok-button" onclick="redirectToPage(\'' . $redirectPage . '\')">OK</button>';
    echo '</div>';
    echo '</div>';
}

if (isset($_POST['importPRS'])) {
    if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // Validate file format (you can add more checks here)
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext === 'xlsx' || $file_ext === 'xls') {
            // Specify the directory where you want to save the file
            $uploadDirectory = './UPLOADS/WMR/'; // You can change this path

            // Check if the directory exists; if not, create it
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Generate a unique file name to avoid overwriting existing files
            $uniqueFileName = uniqid() . '_' . $file_name;

            // Move the uploaded file to the specified directory
            $destinationPath = $uploadDirectory . $uniqueFileName;

            if (move_uploaded_file($file_tmp, $destinationPath)) {
                try {
                    // Load the Excel file using PhpSpreadsheet
                    $spreadsheet = IOFactory::load($destinationPath);
                    $worksheet = $spreadsheet->getActiveSheet();

                    // Establish PDO connection
                    $dsn = 'mysql:host=localhost;dbname=gso_asset';
                    $username = 'root';
                    $password = '';
                    $pdo = new PDO($dsn, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Start a transaction
                    $pdo->beginTransaction();

                    // Loop through rows starting from row 8 and extract data, save to database, etc.
                    for ($row = 8; $row <= $worksheet->getHighestRow(); $row++) {
                        // Extract data from specific columns and process/save as needed
                        $generalPropertiesData = [
                            'article' => $worksheet->getCell('D' . $row)->getValue(),
                            'brand' => $worksheet->getCell('E' . $row)->getValue(),
                            'serialNo' => $worksheet->getCell('F' . $row)->getValue(),
                            'particulars' => $worksheet->getCell('G' . $row)->getValue(),
                            'eNGAS' => $worksheet->getCell('I' . $row)->getValue(),
                            'acquisitionDate' => !empty($worksheet->getCell('J' . $row)->getValue()) ? ExcelDate::excelToDateTimeObject($worksheet->getCell('J' . $row)->getValue())->format('Y-m-d') : null,
                            'acquisitionCost' => $worksheet->getCell('K' . $row)->getFormattedValue(),
                            'propertyNo' => $worksheet->getCell('L' . $row)->getValue(),
                            'accountNumber' => $worksheet->getCell('M' . $row)->getValue(),
                            'estimatedLife' => $worksheet->getCell('N' . $row)->getValue(),
                            'unitOfMeasure' => $worksheet->getCell('O' . $row)->getValue(),
                            'unitValue' => $worksheet->getCell('P' . $row)->getFormattedValue(),
                            'quantity' => $worksheet->getCell('Q' . $row)->getValue(),
                            'officeName' => $worksheet->getCell('U' . $row)->getValue(),
                            'accountablePerson' => $worksheet->getCell('V' . $row)->getValue(),
                            'gpremarks' => $worksheet->getCell('W' . $row)->getValue()
                        ];

                        //Modify office name if needed
                        if ($generalPropertiesData['officeName'] === "unidentified") {
                            $generalPropertiesData['officeName'] = null;
                        }
                        if ($generalPropertiesData['officeName'] === "City Accountant's Office") {
                            $generalPropertiesData['officeName'] = "City Accounting Office";
                        }
                        if ($generalPropertiesData['officeName'] === "City Building and Architecture Office" || $generalPropertiesData['officeName'] === "City Building And Architecture Office") {
                            $generalPropertiesData['officeName'] = "City Building & Architecture Office";
                        }

                        if ($generalPropertiesData['officeName'] === "City Engineer's Office") {
                            $generalPropertiesData['officeName'] = "City Engineering Office";
                        }
                        if ($generalPropertiesData['officeName'] === "City Environment and Parks Management Office" || $generalPropertiesData['officeName'] === "City Environment & Parks Management Officer" || $generalPropertiesData['officeName'] === "City Environment and Parks Management Officer") {
                            $generalPropertiesData['officeName'] = "City Environment & Parks Management Office";
                        }
                        if ($generalPropertiesData['officeName'] === "City Human Resource Management Officer") {
                            $generalPropertiesData['officeName'] = "City Human Resource Management Office";
                        }
                        if ($generalPropertiesData['officeName'] === "Office of the City Planning & Development Officer") {
                            $generalPropertiesData['officeName'] = "City Planning & Development Office";
                        }
                        if ($generalPropertiesData['officeName'] === "Office of the City Social Welfare & Development Officer") {
                            $generalPropertiesData['officeName'] = "City Social Welfare Development Office";
                        }

                        if ($generalPropertiesData['officeName'] === "City Treasurer's Office") {
                            $generalPropertiesData['officeName'] = "City Treasury Office";
                        }
                        if ($generalPropertiesData['officeName'] === "City Veterinary Office") {
                            $generalPropertiesData['officeName'] = "City Veterinary and Agriculture Office";
                        }

                        if ($generalPropertiesData['officeName'] === "Sangguniang Panglungsod") {
                            $generalPropertiesData['officeName'] = "Sangguniang Panlungsod";
                        }

                        // Insert into generalproperties table
                        $stmt = $pdo->prepare("INSERT INTO generalproperties
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
                                    gpremarks)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
                        $stmt->execute([
                                $generalPropertiesData['article'],
                                $generalPropertiesData['brand'],
                                $generalPropertiesData['serialNo'],
                                $generalPropertiesData['particulars'],
                                $generalPropertiesData['eNGAS'],
                                $generalPropertiesData['acquisitionDate'],
                                $generalPropertiesData['acquisitionCost'],
                                $generalPropertiesData['propertyNo'],
                                $generalPropertiesData['accountNumber'],
                                $generalPropertiesData['estimatedLife'],
                                $generalPropertiesData['unitOfMeasure'],
                                $generalPropertiesData['unitValue'],
                                $generalPropertiesData['quantity'],
                                $generalPropertiesData['officeName'],
                                $generalPropertiesData['accountablePerson'],
                                $generalPropertiesData['gpremarks']
                        ]);

                        // Get the auto-incremented propertyID
                        $propertyID = $pdo->lastInsertId();

                        // Insert into other tables using propertyID as foreign key
                        // Insert into are_ics_gen_properties table
                        $areIcsGenPropertiesData = [
                            'propertyID' => $propertyID,
                            'onhandPerCount' => $worksheet->getCell('R' . $row)->getValue(),
                            'soQty' => $worksheet->getCell('S' . $row)->getFormattedValue(),
                            'soValue' => $worksheet->getCell('T' . $row)->getFormattedValue()
                        ];
                        // Insert into are_ics_gen_properties table
                        $stmt = $pdo->prepare("INSERT INTO are_ics_gen_properties
                            (
                                propertyID,
                                onhandPerCount,
                                soQty,
                                soValue)
                            VALUES (?, ?, ?, ?)");
                        $stmt->execute([
                            $areIcsGenPropertiesData['propertyID'],
                            $areIcsGenPropertiesData['onhandPerCount'],
                            $areIcsGenPropertiesData['soQty'],
                            $areIcsGenPropertiesData['soValue']
                        ]);

                        // Get the auto-incremented propertyID
                        $ARE_ICS_id = $pdo->lastInsertId();

                        $arePropertiesData = [
                            'propertyID' =>$propertyID,
                            'ARE_ICS_id' =>$ARE_ICS_id,
                            'AREno' =>$worksheet->getCell('H' .$row)->getValue()
                        ];
                        // Insert into are_ics_gen_properties table
                        $stmt = $pdo->prepare("INSERT INTO are_properties
                            (
                                propertyID,
                                ARE_ICS_id,
                                AREno)
                            VALUES (?, ?, ?)");
                        $stmt->execute([
                            $arePropertiesData['propertyID'],
                            $arePropertiesData['ARE_ICS_id'],
                            $arePropertiesData['AREno']
                        ]);

                        $prsWmrGenPropertiesData = [
                            'propertyID' =>$propertyID,
                            'dateReturned' => !empty($worksheet->getCell('A' . $row)->getValue()) ? ExcelDate::excelToDateTimeObject($worksheet->getCell('A' . $row)->getValue())->format('Y-m-d') : null,
                            'itemNo' =>$worksheet->getCell('B' .$row)->getValue(),
                            'withAttachment' =>$worksheet->getCell('X' .$row)->getValue(),
                            'withCoverPage' =>$worksheet->getCell('Y' .$row)->getValue(),
                            'iirup' =>$worksheet->getCell('Z' .$row)->getValue(),
                        ];
                        // Insert into are_ics_gen_properties table
                        $stmt = $pdo->prepare("INSERT INTO prs_wmr_gen_properties
                            (
                                propertyID,
                                dateReturned,
                                itemNo,
                                withAttachment,
                                withCoverPage,
                                iirup)
                            VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([
                            $prsWmrGenPropertiesData['propertyID'],
                            $prsWmrGenPropertiesData['dateReturned'],
                            $prsWmrGenPropertiesData['itemNo'],
                            $prsWmrGenPropertiesData['withAttachment'],
                            $prsWmrGenPropertiesData['withCoverPage'],
                            $prsWmrGenPropertiesData['iirup']
                        ]);
                                        
                        // Get the auto-incremented PRS_WMR_id
                        $PRS_WMR_id = $pdo->lastInsertId();

                        $prsPropertiesData = [
                            'propertyID' => $propertyID,
                            'PRS_WMR_id' => $PRS_WMR_id,
                            'prsNo' => $worksheet->getCell('C' . $row)->getValue(),
                        ];

                        // Insert into prs_properties table
                        $stmt = $pdo->prepare("INSERT INTO prs_properties
                            (
                                propertyID,
                                PRS_WMR_Id,
                                prsNo
                            )
                            VALUES (?, ?, ?)");

                        $stmt->execute([
                            $prsPropertiesData['propertyID'],
                            $prsPropertiesData['PRS_WMR_id'],
                            $prsPropertiesData['prsNo']
                        ]);

                    }/*for ($row = 8; $row <= $worksheet->getHighestRow(); $row++)*/

                    // Commit the transaction
                    $pdo->commit();

                    // Show a modal dialog with the message and redirect to PRS.php
                    displayModalWithRedirect("Data is imported successfully.", "PRS.php");
                } catch (PDOException $e) {
                    // Roll back the transaction on error
                    $pdo->rollBack();
                    echo "Error: " . $e->getMessage();
                }
            } else {
                // Error moving the file
                displayModalWithRedirect("Error saving the uploaded file.", "PRS.php");
            }
        } else {
            displayModalWithRedirect("Invalid file format. Please upload an Excel file (xlsx or xls).", "PRS.php");
        }
    } else {
        displayModalWithRedirect("Please choose a file to upload.", "PRS.php");
    }
}
// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';