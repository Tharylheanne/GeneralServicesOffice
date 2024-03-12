<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1, shrink-to-fit=no">
        <title>GSO ASSET DIVISION - RECORDING AND MONITORING SYSTEM</title>
        <meta content="" name="keywords">
        <meta content="" name="description">
        
        <!-- Favicons -->
        <link  href="img/baguiologo.png" rel="icon">
        <link rel="apple-touch-icon" href="img/baguiologo.png">
        
        <meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">
        
        <!-- Add DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!-- Include DataTables Export Button CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
        
        <!-- Add custom CSS for the search bar -->
        <style>
            #searchInput {
                margin-bottom: 10px;
            }
            .additional-details{

            }
            #PRStable th{
                text-align: center;
            }
            #PRStable td{
                text-align: center;
            }
            @media print{
                $PRStable th{
                    text-align: center;
                }
            }
            .btn-show-details{
                margin-top: 3.5px;
            }
            .dateRecorded{

            }
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
            
        </style>
        <!-- Include jQuery and DataTables JavaScript libraries -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        
        <!-- Include DataTables Print and Buttons extensions -->
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
        
        <!-- Include DataTables AutoFill extension -->
        <script src="https://cdn.datatables.net/autofill/2.3.7/js/dataTables.autoFill.min.js"></script>

        <!-- Script to format date from yyyy-mm-dd to mm-dd-yyyy -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        
        <!-- Add custom JavaScript for the search bar and table functionality -->
        <script>
            //Define the table variable in a broader scope
            var table;
            // Initialize DataTable with Print and Buttons extensions
            $(document).ready(function() {
                $.fn.dataTable.ext.pager.numbers_length = 10;
                table = $('#PRStable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'btn-print',
                            exportOptions: {
                            columns: ':visible',// Export only visible columns

                            },
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Export to Excel',
                            filename: function() {
                                return 'Clearance Master List ' + getCurrentDate();
                            },
                            exportOptions: {
                                columns: ':visible',
                            },
                        },
                    ],
                    autoFill: {
                            columns: ':not(.additional-details)'
                        },
                        lengthMenu: [[50, 100, 250, 500], [50, 100, 250, 500]], // Specify the options for "Show X entries" dropdown
                    });

                // Add universal search bar functionality
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Add event listener to the Print button to handle scanned copy printing
                $('#PRStable').on('click', '.btn-print-scanned-copy', function () {
                    var row = table.row($(this).closest('tr')).data();
                    var scannedCopyPath = row['scannedCopy']; // Assuming 'scannedCopy' is the column name in your database

                    // Open a new window or tab for printing the scanned copy
                    var printWindow = window.open(scannedCopyPath, '_blank');
                    printWindow.onload = function () {
                        printWindow.print(); // Trigger the print dialog
                    };
                });
            });
            
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
            function formatDates(win, className){
                $(win.document.body).find(className).each(function (){
                    var originalDate = $(this).text();
                    if (originalDate) {
                        var formattedDate = moment(originalDate, 'MM-DD-YYYY').format('MM-DD-YYYY');
                        $(this).text(formattedDate);
                    }
                });
            }
            function getCurrentDate() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                var yyyy = today.getFullYear();

                return mm + '-' + dd + '-' + yyyy;
            }
        </script>
</head>
<body>
    <?php
    $connect = mysqli_connect('localhost','root','','db_gso');

    $sql = "SELECT
          c.*,
          cp.purposeName,
          UPPER(CASE
                  WHEN c.classification IN ('City Office', 'National Office') THEN COALESCE(co.office_name, no.noffice_name)
                  ELSE COALESCE(co.office_name, no.noffice_name, elem.elemName, high.highSchoolName, b.barangayName)
              END) AS responsibilityCenter,
          e.employeeName
          FROM
              clearance c
          LEFT JOIN
              clearancepurpose cp ON c.purpose = cp.purposeName
          LEFT JOIN
              city_offices co ON c.responsibilityCenter = co.office_name
          LEFT JOIN
              national_offices no ON c.responsibilityCenter = no.noffice_name
          LEFT JOIN
              barangay b ON c.responsibilityCenter = b.barangayName
          LEFT JOIN
              elementary elem ON c.responsibilityCenter = elem.elemName
          LEFT JOIN
              highschool high ON c.responsibilityCenter = high.highSchoolName
          LEFT JOIN
              employees e ON c.employeeName = e.employeeName
          ORDER BY
              controlNo";
        
        $stmt = $connect->prepare($sql);

        if ($stmt) {
            $stmt = $connect->prepare($sql) or die(mysqli_error());
            $stmt->execute();
            $result = $stmt->get_result();

            //Check for errors in the query execution
            if (!$result) {
                echo "Error in query execution:" .mysqli_error($connect);
                exit;
            }

            if ($result->num_rows > 0) {
                echo "<h3 style='text-align: center; line-height: 2em;'> Clearance Master List</h3>";

                //Display the table headers

                echo "<div class = 'table-responsive'>";
                echo "<div style ='max-height:200%; overflow-y:auto;'>";
                echo "<table id='PRStable' class='table table-bordered table-striped'>";
                echo "<thead>
                        <tr>
                            <th>DATE CLEARED BY GSO</th>
                            <th>CONTROL NO.</th>
                            <th>NAME</th>
                            <th>POSITION</th>
                            <th>CLASSIFICATION</th>
                            <th>SPECIFIC LOCATION/ RESPONSIBILITY CENTER</th>
                            <th>PURPOSE</th>
                            <th>EFFECTIVITY DATE</th>
                            <th>REMARKS/ CONDITIONS</th>
                            <th>CLEARED BY</th>
                        </tr>
                    </thead>";

                echo "<tbody>";
                echo "</div>";
                echo "</div>";

                while ($row = $result->fetch_assoc()) {
                    echo '
                        <tr>
                            <td>' . ($row['dateCleared'] != '0000-00-00' && !empty($row['dateCleared']) ? date('m-d-Y', strtotime($row['dateCleared'])) : '') . '</td>
                            <td>' . $row['controlNo'] . '</td>
                            <td>' . $row['employeeName'] . '</td>
                            <td>' . $row['position'] . '</td>
                            <td>' . $row['classification'] . '</td>
                            <td>' . $row['responsibilityCenter'] . '</td>
                            <td>' . $row['purpose'] . '</td>
                            <td>' . $row['effectivityDate'] . '</td>
                            <td>' . $row['remarks'] . '</td>
                            <td>' . $row['clearedBy'] . '</td>
                        </tr>
                    ';
                }

            }
            else{
                // No data to print or export, display a modal dialog
                echo '<div class="modal-background" id="modalBackground" style="display: flex;">';
                echo '<div class="modal-content">';
                echo '<div class="modal-message">NO DATA TO PRINT OR EXPORT.</div>';
                echo '<button class="ok-button" onclick="closeTabAndRedirect(\'dashboard.php\')">OK</button>';
                echo '</div>';
                echo '</div>'; 
            }
        }
    ?>
    <!-- JavaScript function to redirect to a page -->
    <script type="text/javascript">
        function closeTabAndRedirect(page) {
            window.close(); // Close the current tab
            window.location.href = page; // Redirect to the specified page
        }
    </script>
</body>
</html>