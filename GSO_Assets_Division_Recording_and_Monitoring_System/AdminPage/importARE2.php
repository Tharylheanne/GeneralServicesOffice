<?php

// Include the database connection
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "gso_asset";

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Include the PhpSpreadsheet library
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

if (isset($_POST['importARE'])) {

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

    // Check if a file was uploaded
    if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // Validate file format (you can add more checks here)
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext === 'xlsx' || $file_ext === 'xls') {
            // Specify the directory where you want to save the file
            $uploadDirectory = './UPLOADS/ARE/'; // You can change this path

            // Check if the directory exists; if not, create it
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Generate a unique file name to avoid overwriting existing files
            $uniqueFileName = uniqid() . '_' . $file_name;

            // Move the uploaded file to the specified directory
            $destinationPath = $uploadDirectory . $uniqueFileName;

            if (move_uploaded_file($file_tmp, $destinationPath)) {
                // File moved successfully
                // Load the Excel file using PhpSpreadsheet
                $spreadsheet = IOFactory::load($destinationPath);
                $worksheet = $spreadsheet->getActiveSheet();

                // Define the columns to extract data from for each table
                $generalPropertiesColumns = ['B', 'C', 'D', 'E', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'S', 'T'];
                $areCsGenPropertiesColumns = ['A', 'P', 'Q', 'R', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AD', 'AE'];
                $arePropertiesColumns = ['F'];

                // Initialize arrays to hold the extracted data for each table
                $generalPropertiesData = [];
                $AreIcsGeneralProperties = [];
                $arePropertiesData = [];

                // Start from row 8 and loop through each row in the worksheet
                foreach ($worksheet->getRowIterator(8) as $row) {
                    $generalPropertiesRowData = [];
                    $AreIcsGenPropertiesRowData = [];
                    $arePropertiesRowData = [];

                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even if they are empty

                    // Loop through each cell in the row
                    foreach ($cellIterator as $cell) {
                        $column = $cell->getColumn();
                        $value = $cell->getCalculatedValue(); // Use getCalculatedValue() instead of getValue() to retrieve the calculated value
                        
                        // Check if the column is one of the columns to extract for each table
                        if (in_array($column, $generalPropertiesColumns)) {
                            // If column is H, parse the date
                            if ($column === 'H') {
                                // If value is empty, set to NULL
                                $value = !empty($value) ? date('Y-m-d', strtotime($value)) : null;
                            }
                            $generalPropertiesRowData[] = $value;
                        } elseif (in_array($column, $areCsGenPropertiesColumns)) {
                            // If column is A or X, parse the date
                            if (in_array($column, ['A', 'X'])) {
                                // If value is empty, set to NULL
                                $value = !empty($value) ? date('Y-m-d', strtotime($value)) : null;
                            }
                            $AreIcsGenPropertiesRowData[] = $value;
                        } elseif (in_array($column, $arePropertiesColumns)) {
                            $arePropertiesRowData[] = $value;
                        }
                    }

                    // Add row data to respective tables data arrays
                    if (!empty($generalPropertiesRowData)) {
                        $generalPropertiesData[] = $generalPropertiesRowData;
                    }
                    if (!empty($AreIcsGenPropertiesRowData)) {
                        $AreIcsGeneralProperties[] = $AreIcsGenPropertiesRowData;
                    }
                    if (!empty($arePropertiesRowData)) {
                        $arePropertiesData[] = $arePropertiesRowData;
                    }
                }

                // Prepare SQL statements for each table
                $generalPropertiesSql = "INSERT INTO generalproperties (article, brand, serialNo, particulars, eNGAS, acquisitionDate, acquisitionCost, propertyNo, accountNumber, estimatedLife, unitOfMeasure, unitValue, quantity, officeName, accountablePerson) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $AreIcsGenPropertiesSql = "INSERT INTO are_ics_gen_properties (propertyID, dateReceived, onhandPerCount, soQty, soValue, previousCondition, location, currentCondition, dateOfPhysicalInventory, remarks, supplier, POnumber, AIRNumber, notes, jevNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $arePropertiesSql = "INSERT INTO are_properties (propertyID, ARE_ICS_id, AREno) VALUES (?, ?, ?)";

                // Prepare statements
                $stmtGeneral = $mysqli->prepare($generalPropertiesSql);
                $stmtAreCsGenProperties = $mysqli->prepare($AreIcsGenPropertiesSql);
                $stmtAreProperties = $mysqli->prepare($arePropertiesSql);

                // Initialize counter for propertyIDs
                $propertyIDCounter = 0;
                $ARE_ICS_idCounter = 0;

                // Bind parameters and execute statements for generalproperties table
                foreach ($generalPropertiesData as $generalRow) {
                    $stmtGeneral->bind_param('sssssssssssssss', ...$generalRow);
                    $stmtGeneral->execute();

                    // Get the auto-generated propertyID
                    $propertyID = $mysqli->insert_id;

                    // Increment the propertyID counter
                    $propertyIDCounter++;

                    // Bind parameters and execute statements for are_cs_gen_properties table
                    $AreIcsGenPropertiesRow = $AreIcsGeneralProperties[$propertyIDCounter - 1];
                    $stmtAreCsGenProperties->bind_param('issssssssssssss', $propertyID, ...$AreIcsGenPropertiesRow);
                    $stmtAreCsGenProperties->execute();

                    // Get the auto-generated ARE_ICS_id
                    $ARE_ICS_id = $mysqli->insert_id;

                    // Bind parameters and execute statements for are_properties table
                    $arePropertiesRow = $arePropertiesData[$propertyIDCounter - 1];
                    $stmtAreProperties->bind_param('iis', $propertyID, $ARE_ICS_id, ...$arePropertiesRow);
                    $stmtAreProperties->execute();
                }

                // Close prepared statements
                $stmtGeneral->close();
                $stmtAreCsGenProperties->close();
                $stmtAreProperties->close();

                // Show a modal dialog with the message and redirect to PRS.php
                displayModalWithRedirect("Data is imported successfully.", "activePPE.php");

            } else {
                // Error moving the file
                displayModalWithRedirect("Error saving the uploaded file.", "activePPE.php");
            }
        } else {
            displayModalWithRedirect("Invalid file format. Please upload an Excel file (xlsx or xls).", "activePPE.php");
        }
    } else {
        displayModalWithRedirect("Please choose a file to upload.", "activePPE.php");
    }
}
// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';
?>