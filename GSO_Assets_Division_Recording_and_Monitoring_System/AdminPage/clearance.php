<?php
require('../loginPage/login_session.php');
if (!isset($_SESSION['employeeID'])) {
  // code...
}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GSO Assets Division | Recording and Monitoring System</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
    <link href="../dist/img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

  <!-- Style for the vertical line after each column -->
  <style>
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

    /* Add this style to create vertical lines between columns */
    .row-flex{
      display: flex;
      align-items: stretch;
    }
    .vertical-line {
      border-left: 1px solid #ddd;
      padding-left: 10px; /* Adjust the padding based on your design */
      padding-right: 10px; /* Adjust the padding based on your design */
    }
    .horizontal-line {
      border-top: 1px solid #ddd;
      margin-top: 10px; /* Adjust the margin based on your design */
      margin-bottom: 10px; /* Adjust the margin based on your design */
    /*Progress bar*/
    .progress {
        margin-top: 20px;
    }
    .import-btn {
      margin-top: 20px;
    }
    td {
      white-space: nowrap;
      text-align: center;
    }
  </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    <?php include("../AdminPage/header/header.php");?>
    <?php include("../AdminPage/sidebar/sidebar.php");?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="ion-android-checkmark-circle"></i> CLEARANCE MASTER LIST</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="ion-android-checkmark-circle"> Clearance</i></a></li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <a href="addClearance.php" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Add New Clearance</a>

        <br><br>
        <section class="">
            <form enctype="multipart/form-data" method="POST" action="importClearance.php">
                <input type="file" name="file" id="file" accept=".xlsx, .xls"><br>
                <button type="submit" name="importClearance" class="btn btn-primary" id="importClearance">IMPORT</button>
            </form>
        </section>

        <div class="progress" style="display:none;" id="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>

        <div id="importMessage" style="display:none;" class="alert alert-success" role="alert">
            File imported successfully! <button id="okButton" class="ok-button">OK</button>
        </div>
        <!-- import button -->
            <br>
            <div class="box">
              <div class="box-header bg-blue" align="center">
                <h4 class="box-title">CLEARANCE MASTER LIST
              </div><!-- box header -->
              <br>
              <div class="table-responsive">
                <table id="clearance" class="table table-hover responsive" cellpadding="0" width="100%">
                  <thead>
                    <tr>
                      <th>DATE CLEARED BY GSO</th>
                      <th>CONTROL NO.</th>
                      <th>SCANNED COPY</th>
                      <th>NAME</th>
                      <th>POSITION</th>
                      <th>CLASSIFICATION</th>
                      <th>SPECIFIC LOCATION/ RESPONSIBILITY CENTER</th>
                      <th>PURPOSE</th>
                      <th>EFFECTIVITY DATE</th>
                      <th>REMARKS/ CONDITIONS</th>
                      <th>CLEARED BY</th>
                      <th>ACTION</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php include_once("../AdminPage/includes/manageClearanceTable.php")?>
                  </tbody>
                </table>
              </div>
            </div>
            
          </section>
    </div><!-- content-wrapper -->
    </div><!-- wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>

    

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

    
    <!-- Include Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
      $(document).ready(function() {
        // Hide the progress bar initially
        $('#progress').hide();

        // Initialize DataTable with Column Visibility extension
        var table = $('#clearance').DataTable({
          "paging": true,
          "lengthChange": true,
          "lengthMenu": [50, 100, 200, 300, 400, 500],
          "searching": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "order": [],
          "columnDefs": [{
            "targets": 'no-filter',
            "searchable": false,
          }],
          "dom": 'Blfrtip',
          "buttons": [{
            extend: 'colvis',
            text: 'Hide/Show Columns'
          }]
        });

        // Handle form submission for file upload
        $('form').submit(function() {
          // Show the progress bar
          $('#progress').show();
        });
      });
    </script>

    <script>
    function importData() {
        // Display the progress bar
        $('#progress').show();
        
        // Send AJAX request to importClearance.php
        $.ajax({
            type: 'POST',
            url: 'importClearance.php',
            data: new FormData($('form')[0]),
            contentType: false,
            processData: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        // Calculate the percentage and update the progress bar
                        var percentComplete = (e.loaded / e.total) * 100;
                        $('.progress-bar').width(percentComplete + '%');
                        $('.progress-bar').html(percentComplete.toFixed(2) + '%');
                    }
                });
                return xhr;
            },
            success: function (response) {
                // Hide the progress bar and display the modal with the response
                $('#progress').hide();
                $('#importMessage').show();
                $('#importMessage').html(response);
            }
        });
    }
    </script>
    
    <script>
    $(document).ready(function() {
      // Toggle submenu on click
      $('.treeview > a').click(function(event) {
        event.preventDefault(); // Prevent the default link behavior
        $(this).next('.treeview-menu').slideToggle();
      });

      // Close other submenus when one is opened
      $('.treeview > a').click(function() {
        $('.treeview-menu').not($(this).next('.treeview-menu')).slideUp();
      });
    });
    </script>

</body>
</html>