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
                        $value = $cell->getValue();

                        // Check if the column is one of the columns to extract for each table
                        if (in_array($column, $generalPropertiesColumns)) {
                            $generalPropertiesRowData[] = $value;
                        } elseif (in_array($column, $areCsGenPropertiesColumns)) {
                            $AreIcsGenPropertiesRowData[] = $value;
                        } elseif (in_array($column, $arePropertiesColumns)) {
                            $arePropertiesRowData[] = $value;
                        }
                        
                        // Handle specific columns for formatting
                        switch ($column) {
                            case 'H': // acquisitionDate
                            case 'A': // dateReceived
                            case 'X': // dateOfPhysicalInventory
                                // Check if the cell value is empty or non-numeric before conversion
                                if (!empty($value) && is_numeric($value)) {
                                    // Convert Excel date value to PHP DateTime object
                                    $dateTimeObject = ExcelDate::excelToDateTimeObject($value);
                                    // Format the date as needed (e.g., Y-m-d)
                                    $value = $dateTimeObject->format('Y-m-d');
                                } else {
                                    // Handle non-date values here, if needed
                                    // For example, you can set $value to null or a default date
                                    $value = null; // or $value = '1970-01-01';
                                }
                                break;
                            case 'I': // acquisitionCost
                            case 'N': // unitValue
                            case 'Q': // soQty
                            case 'R': // soValue
                                // Get the formatted value instead of the formula
                                $value = $cell->getFormattedValue();
                                break;
                            default:
                                break;
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

                // Bind parameters and execute statements for generalproperties table
                foreach ($generalPropertiesData as $row) {
                    // Insert into generalproperties table
                    $stmtGeneral->bind_param('sssssssssssssss', ...$row);
                    $stmtGeneral->execute();

                    // Get the auto-generated propertyID
                    $propertyID = $mysqli->insert_id;

                    // Insert into are_ics_gen_properties table
                    $areIcsGenPropertiesRow = array_shift($AreIcsGeneralProperties);
                    $stmtAreCsGenProperties->bind_param('issssssssssssss', $propertyID, ...$areIcsGenPropertiesRow);
                    $stmtAreCsGenProperties->execute();

                    // Get the auto-generated ARE_ICS_id
                    $ARE_ICS_id = $mysqli->insert_id;

                    // Get AREno from the F column of the Excel file
                    $arePropertyValue = array_shift($arePropertiesData);

                    // Insert into are_properties table with AREno obtained from F column
                    $stmtAreProperties->bind_param('iis', $propertyID, $ARE_ICS_id, $arePropertyValue);
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