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

                // Define the columns to extract data from
                $columnsToExtract = ['B', 'C', 'D', 'E', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'S', 'T', 'Y'];

                // Initialize an array to hold the extracted data
                $data = [];

                // Start from row 8 and loop through each row in the worksheet
                foreach ($worksheet->getRowIterator(8) as $row) {
                    $rowData = [];
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even if they are empty

                    $hasData = false; // Flag to check if any cell in the row contains data

                    // Loop through each cell in the row
                    foreach ($cellIterator as $cell) {
                        // Check if the column is one of the columns to extract
                        $column = $cell->getColumn();
                        if (in_array($column, $columnsToExtract)) {
                            // Extract the cell value
                            if ($column == 'H') {
                                // Get the date value (numeric)
                                $dateValue = $cell->getValue();
                                // Check if the value is numeric
                                if (is_numeric($dateValue)) {
                                    // Convert Excel date value to PHP DateTime object
                                    $acquisitionDate = ExcelDate::excelToDateTimeObject($dateValue)->format('Y-m-d');
                                } else {
                                    // If the value is not numeric, set it to null
                                    $acquisitionDate = null;
                                }
                                // Add the acquisition date to the row data
                                $rowData[] = $acquisitionDate;
                            } elseif ($column == 'I' || $column == 'N') {
                                // Get formatted value if the column is I or N
                                $value = $cell->getFormattedValue();
                                $rowData[] = $value;
                            } else {
                                $value = $cell->getValue();
                                $rowData[] = $value;
                            }
                            if ($value !== null && $value !== '') {
                                $hasData = true; // Set flag if cell contains data
                            }
                        }
                    }

                    // Add the row data to the main data array if any cell in the row contains data
                    if ($hasData) {
                        $data[] = $rowData;
                    } else {
                        break; // Stop extracting data if all cells in the row are empty
                    }
                }

                // Prepare SQL statement for inserting into generalproperties table
                $sql = "INSERT INTO generalproperties (article, brand, serialNo, particulars, eNGAS, acquisitionDate, acquisitionCost, propertyNo, accountNumber, estimatedLife, unitOfMeasure, unitValue, quantity, officeName, accountablePerson, gpremarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtGeneral = $mysqli->prepare($sql);

                // Bind parameters and execute the statement for each row of data
                foreach ($data as $row) {
                    $stmtGeneral->bind_param('ssssssssssssssss', ...$row);
                    $stmtGeneral->execute();
                }

                // Close the prepared statement
                $stmtGeneral->close();

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