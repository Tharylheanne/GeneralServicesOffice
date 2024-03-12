<?php 

require './../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

//Function to display a modal dialog with a message and then redirect
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

if (isset($_POST['importWMR'])) {
    if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        //Validate file format
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

                    // Establish MySQLi connection
                    $conn = new mysqli('localhost', 'root', '', 'gso_asset');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Start a transaction
                    $conn->begin_transaction();

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
                        'officeName' => $worksheet->getCell('R' . $row)->getValue(),
                        'accountablePerson' => $worksheet->getCell('S' . $row)->getValue(),
                        'gpremarks' => $worksheet->getCell('T' . $row)->getValue()
                    ];

                    // Insert into generalproperties table
                    $stmt = $conn->prepare("INSERT INTO generalproperties
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
                            officeName,
                            accountablePerson,
                            gpremarks)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
                    $stmt->bind_param("sssssssssssssss",
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
                        $generalPropertiesData['officeName'],
                        $generalPropertiesData['accountablePerson'],
                        $generalPropertiesData['gpremarks']
                    );
                    $stmt->execute();

                    // Get the auto-incremented propertyID
                    $propertyID = $stmt->insert_id;

                    // Insert into other tables using propertyID as foreign key
                    // Insert into are_ics_gen_properties table
                    $areIcsGenPropertiesData = [
                        'propertyID' => $propertyID,
                        'onhandPerCount' => $worksheet->getCell('Q' . $row)->getValue(),
                    ];
                    // Insert into are_ics_gen_properties table
                    $stmt = $conn->prepare("INSERT INTO are_ics_gen_properties
                        (
                            propertyID,
                            onhandPerCount)
                        VALUES (?, ?)");
                    $stmt->bind_param("is",
                        $areIcsGenPropertiesData['propertyID'],
                        $areIcsGenPropertiesData['onhandPerCount']
                    );
                    $stmt->execute();

                    // Get the auto-incremented propertyID
                    $ARE_ICS_id = $stmt->insert_id;

                    $icsPropertiesData = [
                        'propertyID' =>$propertyID,
                        'ARE_ICS_id' =>$ARE_ICS_id,
                        'ICSno' =>$worksheet->getCell('H' .$row)->getValue()
                    ];
                    // Insert into are_ics_gen_properties table
                    $stmt = $conn->prepare("INSERT INTO ics_properties
                        (
                            propertyID,
                            ARE_ICS_id,
                            ICSno)
                        VALUES (?, ?, ?)");
                    $stmt->bind_param("iis",
                        $icsPropertiesData['propertyID'],
                        $icsPropertiesData['ARE_ICS_id'],
                        $icsPropertiesData['ICSno']
                    );
                    $stmt->execute();

                    $prsWmrGenPropertiesData = [
                        'propertyID' =>$propertyID,
                        'dateReturned' => !empty($worksheet->getCell('A' . $row)->getValue()) ? ExcelDate::excelToDateTimeObject($worksheet->getCell('A' . $row)->getValue())->format('Y-m-d') : null,
                        'itemNo' =>$worksheet->getCell('B' .$row)->getValue(),
                        'withAttachment' =>$worksheet->getCell('U' .$row)->getValue(),
                        'withCoverPage' =>$worksheet->getCell('V' .$row)->getValue(),
                        'iirup' =>$worksheet->getCell('W' .$row)->getValue(),
                    ];
                    // Insert into are_ics_gen_properties table
                    $stmt = $conn->prepare("INSERT INTO prs_wmr_gen_properties
                        (
                            propertyID,
                            dateReturned,
                            itemNo,
                            withAttachment,
                            withCoverPage,
                            iirup)
                        VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssss",
                        $prsWmrGenPropertiesData['propertyID'],
                        $prsWmrGenPropertiesData['dateReturned'],
                        $prsWmrGenPropertiesData['itemNo'],
                        $prsWmrGenPropertiesData['withAttachment'],
                        $prsWmrGenPropertiesData['withCoverPage'],
                        $prsWmrGenPropertiesData['iirup']
                    );
                    $stmt->execute();

                    // Get the auto-incremented propertyID
                    $PRS_WMR_id = $stmt->insert_id;

                    $wmrPropertiesData = [
                        'propertyID' =>$propertyID,
                        'PRS_WMR_id' =>$PRS_WMR_id,
                        'wmrNo' =>$worksheet->getCell('C' .$row)->getValue(),
                    ];
                    // Insert into are_ics_gen_properties table
                    $stmt = $conn->prepare("INSERT INTO wmr_properties
                        (
                            propertyID,
                            PRS_WMR_Id,
                            wmrNo)
                        VALUES (?, ?, ?)");
                    $stmt->bind_param("iis",
                        $wmrPropertiesData['propertyID'],
                        $wmrPropertiesData['PRS_WMR_id'],
                        $wmrPropertiesData['wmrNo']
                    );
                    $stmt->execute();

               }/*for ($row = 8; $row <= $worksheet->getHighestRow(); $row++)*/
               // Commit the transaction
               $conn->commit();

               // Show a modal dialog with the message and redirect to PRS.php
               displayModalWithRedirect("Data is imported successfully.", "WMR.php");
           }catch (Exception $e) {
                    // Roll back the transaction on error
                    $conn->rollback();
                    echo "Error: " . $e->getMessage();
                }
            } else {
                // Error moving the file
                displayModalWithRedirect("Error saving the uploaded file.", "WMR.php");
            }
        } else {
            displayModalWithRedirect("Invalid file format. Please upload an Excel file (xlsx or xls).", "WMR.php");
        }
    } else {
        displayModalWithRedirect("Please choose a file to upload.", "WMR.php");
    }
}
// JavaScript function to redirect to a page
echo '<script type="text/javascript">
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>';