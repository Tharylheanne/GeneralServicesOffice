<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
           require('./../database/connection.php');

           // Check if an accountable person parameter is provided in the URL
           if (isset($_GET['officeName'])) {
               $officeName = urldecode($_GET['officeName']);
               echo "<title style='text-align: center;'>Office/Department: $officeName</title>";
           } else {
               echo "<title>ARE Properties By Accountable Person Report</title>";
           }
       ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="../dist/css/AdminLTE.min.css"> -->
    <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
    <link href="../dist/img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    
    
    <!-- Add custom CSS for the search bar -->
    <style>
        #searchInput {
            margin-bottom: 10px;
        }
        .additional-details{

        }
        #AREperYearTable th{
            text-align: center;
        }
        #AREperYearTable td{
            text-align: center;
        }
        @media print{
            $AREperYearTable th{
                text-align: center;
            }
        }
        .btn-show-details{
            margin-top: 3.5px;
        }
        .dateRecorded{

        }
        th{
            text-align: center;
        }
        
    </style>
    <!-- <script src="../plugins/datatables/jquery.dataTables.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>

    
    <!-- Add custom JavaScript for the search bar and table functionality -->
    <script>
        //Define the table variable in a broader scope
        var table;
        // Initialize DataTable with Print and Buttons extensions
        $(document).ready(function() {
            $.fn.dataTable.ext.pager.numbers_length = 10;
            table = $('#AREperYearTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn-print',
                        
                        customize: function (win) {
                            // Remove additional details columns if hidden
                            if (isAdditionalDetailsHidden()) {
                                $(win.document.body).find('.additional-details').remove();
                            }

                            $(win.document.body).find('table thead th').css('text-align', 'center');
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        exportOptions: {
                            columns: ':visible'
                        },
                        
                    },
                    {
                        extend: 'colvis',
                        text: 'Hide/Show Columns'
                    }
                ],
                autoFill: {
                        columns: ':not(.additional-details)'
                    },
                    lengthMenu: [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]], // Specify the options for "Show X entries" dropdown
                });

            // Add universal search bar functionality
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });


        });

        //Function to check if additional details columns are hidden
        function isAdditionalDetailsHidden(){
            var additionalDetailsColumn = document.querySelectorAll('.additional-details');
            for (var i = 0; i < additionalDetailsColumn.length; i++) {
                if (additionalDetailsColumn[i].style.display !== 'none') {
                    return false;
                }   
            }
            return true;
        }
        
        // Function to export table data to CSV
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll('table tr');
            
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll('td, th');
                
                for (var j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }
                
                csv.push(row.join(','));
            }
            
            // Download CSV file
            downloadCSV(csv.join('\n'), filename);
        }
        
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;
            
            // Create CSV file
            csvFile = new Blob([csv], {type: 'text/csv'});
            
            // Create a download link
            downloadLink = document.createElement('a');
            
            // Set the file name
            downloadLink.download = filename;
            
            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);
            
            // Trigger the download
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Function to toggle the visibility of the additional details column
        function toggleAdditionalDetails() {
            var additionalDetailsColumn = document.querySelectorAll('.additional-details');
            var button = document.getElementById('toggleAdditionalDetails');

            for (var i = 0; i < additionalDetailsColumn.length; i++) {
                if (additionalDetailsColumn[i].style.display === 'none') {
                    additionalDetailsColumn[i].style.display = '';
                } else {
                    additionalDetailsColumn[i].style.display = 'none';
                }
            }

            // Update the button text
            if (button.innerText === 'Show Additional Details') {
                button.innerText = 'Hide Additional Details';
            } else {
                button.innerText = 'Show Additional Details';
            }
        }
        function toggleDateRecorded(){
            var dateRecordedColumn = table.column('.dateRecorded');
            dateRecordedColumn.visible(!dateRecordedColumn.visible());

            //update the button text based on column visibility
            var button = document.getElementById('toggleDateRecorded');
            if (dateRecordedColumn.visible()) {
                button.innerText = 'Hide Date Recorded';
            }else{
                button.innerText = 'Show Date Recorded';
            }
        }
    </script>

    <!-- Add CSS for printing -->
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                font-size: 11pt;
            }
        }
    </style>
</head>
<body>
    <div class="content container-fluid">
    <?php
    require('./../database/connection.php');
    /*require('../login/login_session.php');*/

    // Check if an accountable person parameter is provided in the URL
    if (isset($_GET['officeName'])) {
        $officeName = urldecode($_GET['officeName']);

        // SQL query to retrieve property information
        $sql = "SELECT ap.*, gp.*, agp.*, ac.accountNumber AS classification,
                COALESCE(co.officeName, no.officeName) AS officeName,
                c.conditionName AS currentCondition
                FROM are_properties ap
                LEFT JOIN are_ics_gen_properties agp ON ap.ARE_ICS_id = agp.ARE_ICS_id
                LEFT JOIN generalproperties gp ON ap.propertyID = gp.propertyID
                LEFT JOIN account_codes ac ON gp.accountNumber = ac.accountNumber
                LEFT JOIN cityoffices co ON gp.officeName = co.officeName
                LEFT JOIN nationaloffices no ON gp.officeName = no.officeName
                LEFT JOIN conditions c ON agp.currentCondition = c.conditionName
                WHERE gp.officeName = ?
                    AND (gp.gpremarks IS NULL
                    OR (gp.gpremarks NOT LIKE '%with prs%' AND gp.gpremarks NOT LIKE '%with wmr%'))
                    AND (agp.currentCondition <> 'Returned' OR agp.currentCondition IS NULL)";

        $stmt = $connect->prepare($sql);

        if ($stmt) {
                $stmt->bind_param("s", $officeName);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check for errors in query execution
                if (!$result) {
                    echo "Error in query execution: " . mysqli_error($connect);
                    exit;
                }

            // Fetch and display the ARE properties
            if ($result->num_rows > 0) {
                echo "<h3 id='printTitle' style='text-align: center; line-height: 2em;'>Report on Physical Count of Property, Plant, and Equipment<br>Office/Department: <span style='text-decoration: underline;'>$officeName</span></h3>";

                // Display the table
                echo "<div class = 'table-responsive'>";
                echo "<div style ='max-height:200%; overflow-y:auto;'>";
                echo "<table id='AREperYearTable' class='table table-bordered table-striped'>";
                echo "<thead>
                        <tr>
                            <th class='dateRecorded' rowspan='2' class='additional-details'>DATE RECEIVED</th>
                            <th rowspan='2'>ARTICLE</th>
                            <th class='subcolumn' colspan='4'>DESCRIPTION</th>
                            <th rowspan='2'>eNGAS PROPERTY NUMBER</th>
                            <th rowspan='2' style='white-space: nowrap;'>ACQUISITION DATE</th>
                            <th rowspan='2' style='white-space: nowrap;'>ACQUISITION COST</th>
                            <th rowspan='2'>PROPERTY NO.</th>
                            <th rowspan='2'>CLASSIFICATION</th>
                            <th rowspan='2'>EST. USEFUL LIFE</th>
                            <th rowspan='2'>UNIT OF MEASURE</th>
                            <th rowspan='2'>UNIT VALUE</th>
                            <th rowspan='2'>BALANCE PER CARD QTY</th>
                            <th rowspan='2'>ON HAND PER COUNT QTY</th>
                            <th class='subcolumn' colspan='2'>SHORTAGE/OVERAGE</th>
                            <th rowspan='2'>RESPONSIBILITY CENTER</th>
                            <th rowspan='2'>ACCOUNTABLE PERSON</th>
                            <th rowspan='2'>PREVIOUS CONDITION</th>
                            <th rowspan='2'>LOCATION</th>
                            <th rowspan='2'>CURRENT CONDITION</th>
                            <th rowspan='2'>DATE OF PHYSICAL INVENTORY</th>
                            <th rowspan='2'>REMARKS</th>
                            <th class='subcolumn additional-details' colspan='5'>ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</th>
                        </tr>
                        <tr>
                            <th class='subcolumn'>BRAND/MODEL</th>
                            <th class='subcolumn'>SERIAL NUMBER</th>
                            <th class='subcolumn'>PARTICULARS</th>
                            <th class='subcolumn' style='white-space: nowrap;'>MR/ARE NUMBER</th>
                            <th class='subcolumn'>SHORTAGE /OVERAGE QTY</th>
                            <th class='subcolumn'>SHORTAGE /OVERAGE VALUE</th>
                            <th class='subcolumn additional-details'>SUPPLIER</th>
                            <th class='subcolumn additional-details'>PO NO.</th>
                            <th class='subcolumn additional-details'>AIR/RIS NO.</th>
                            <th class='subcolumn additional-details'>NOTES</th>
                            <th class='subcolumn additional-details'>JEV NUMBER</th>
                        </tr>
                    </thead>";
                echo "<tbody>";
                echo "</div>";
                echo "</div>";

                while ($row = $result->fetch_assoc()) {
                    echo '

                     <tr>
                         <td class="dateRecorded">' . (empty($row['dateReceived']) || $row['dateReceived'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['dateReceived']))) . '</td>
                         <td>' . $row['article'] . '</td>
                         <td>' . $row['brand'] . '</td>
                         <td>' . $row['serialNo'] . '</td>
                         <td>' . $row['particulars'] . '</td>
                         <td "style=white-space: nowrap;">' . $row['AREno'] . '</td>
                         <td>' . $row['eNGAS'] . '</td>
                         <td>' . (empty($row['acquisitionDate']) || $row['acquisitionDate'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['acquisitionDate']))) . '</td>
                         <td>' . $row['acquisitionCost'] . '</td>
                         <td>' . $row['propertyNo'] . '</td>
                         <td>' . $row['accountNumber'] . '</td>
                         <td>' . $row['estimatedLife'] . '</td>
                         <td>' . $row['unitOfMeasure'] . '</td>
                         <td>' . $row['unitValue'] . '</td>
                         <td>' . $row['quantity'] . '</td>
                         <td>' . $row['onhandPerCount'] . '</td>
                         <td>' . $row['soQty'] . '</td>
                         <td>' . $row['soValue'] . '</td>
                         <td style="white-space: nowrap;">' . $row['officeName'] . '</td>
                         <td style="white-space: nowrap;">' . $row['accountablePerson'] . '</td>
                         <td>' . $row['previousCondition'] . '</td>
                         <td>' . $row['location'] . '</td>
                         <td>' . $row['currentCondition'] . '</td>
                         <td>' . (empty($row['dateOfPhysicalInventory']) || $row['dateOfPhysicalInventory'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['dateOfPhysicalInventory']))) . '</td>
                         <td>' . $row['gpremarks'] . '</td>
                         <td class="additional-details">' . $row['supplier'] . '</td>
                         <td class="additional-details">' . $row['POnumber'] . '</td>
                         <td class="additional-details">' . $row['AIRNumber'] . '</td>
                         <td class="additional-details">' . $row['notes'] . '</td>
                         <td class="additional-details">' . $row['jevNo'] . '</td>
                     </tr>';
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No ARE properties found for Office/Department: $officeName";
            }
            
            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $connect->error;
        }

    } else {
        echo "Accountable Person parameter not provided.";
    }
    ?>
    </div>
</body>
</html>