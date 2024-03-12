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
        <h1><i class="fa fa archive"></i>Inventory Custodian Slip (ICS) Reports</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard">ICS Reports</i></a></li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <div class="box">
          <div class=" box-header bg-blue">
            <h4 class="box-title"><!-- ACKNOWLEDGEMENT FOR RECEIPT OF EQUIPMENT(ARE) PRINTABLE REPORTS --></h4>
          </div>
          <div class="box-body">
            <div class="row">
              <a href="ICSperAccountablePerson.php">
                <div class="col-md-4 col-sm-6 col-sx-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fa fa-print"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-number"> PER ACCOUNTABLE EMPLOYEE</span>
                      <a href="ICSperAccountablePerson.php" class="small-box-footer"></a>
                    </div><!-- info-box-content -->
                  </div><!-- info-box -->
                </div><!-- col-md-4 col-sm-6 col-sx-12 -->
              </a>

              <a href="ICSperYear.php">
                <div class="col-md-4 col-sm-6 col-sx-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fa fa-print"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-number"> PER YEAR</span>
                      <a href="ICSperYear.php" class="small-box-footer"></a>
                    </div><!-- info-box-content -->
                  </div><!-- info-box -->
                </div><!-- col-md-4 col-sm-6 col-sx-12 -->
              </a>

              <a href="ICSperOffice.php">
                <div class="col-md-4 col-sm-6 col-sx-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fa fa-print"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-number"> PER OFFICE/DEPARTMENT</span>
                      <a href="ICSperOffice.php" class="small-box-footer"></a>
                    </div><!-- info-box-content -->
                  </div><!-- info-box -->
                </div><!-- col-md-4 col-sm-6 col-sx-12 -->
              </a>

              <a href="ICSperAccountCode.php">
                <div class="col-md-4 col-sm-6 col-sx-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fa fa-print"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-number"> PER ACCOUNT CODE</span>
                      <a href="ICSperAccountCode.php" class="small-box-footer"></a>
                    </div><!-- info-box-content -->
                  </div><!-- info-box -->
                </div><!-- col-md-4 col-sm-6 col-sx-12 -->
              </a>


              <!-- End of Accountable Person -->
              

            </div><!-- row -->
          </div><!-- box-body -->
        </div><!-- box -->
      
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

    <!-- script for the table -->
    <!-- <script>
      $(document).ready(function() {
          // Initialize DataTable
          var table = $('#activePPE').DataTable({
              "paging": true, // Enable pagination
              "lengthChange": true, // Enable the Show Entry dropdown menu
              "searching": true, // Enable search bar
              "info": true, // Enable info display
              "autoWidth": false, // Disable auto width calculation
              "responsive": true, // Enable responsiveness
              "order": [], // Disable initial sorting
              "columnDefs": [{ // Add filters to each column
                  "targets": 'no-filter',
                  "searchable": false,
              }],
              "dom": 'Bfrtip',
              "buttons": ['colvis'] // Add column visibility button
          });

          /*// Add event listener for cell editing
          $('#activePPE').on('dblclick', 'td', function() {
              var cell = table.cell(this);
              cell.data('<input type="text" class="editable-cell" value="' + cell.data() + '">').draw();
              $('.editable-cell').focus();
          });

          // Update data when cell editing is finished
          $('#activePPE').on('blur', '.editable-cell', function() {
              var value = $(this).val();
              var cell = table.cell($(this).parent());
              cell.data(value).draw();
          });*/
      });
    </script> -->

    <!-- <script>
      $(document).ready(function() {
        // Initialize DataTable with Column Visibility extension
        var table = $('#activeSemi').DataTable({
          "paging": true, // Enable pagination
          "lengthChange": true, // Enable the Show Entry dropdown menu
          "lengthMenu": [50, 100, 200, 300, 400, 500], // Define the entries per page options
          "searching": true, // Enable search bar
          "info": true, // Enable info display
          "autoWidth": false, // Disable auto width calculation
          "responsive": true, // Enable responsiveness
          "order": [], // Disable initial sorting
          "columnDefs": [{ // Add filters to each column
            "targets": 'no-filter',
            "searchable": false,
          }],
          "dom": 'Blfrtip', // Include the length menu and other buttons
          "buttons": [
            {
              extend: 'colvis',
              text: 'Hide/Show Columns' // Change the button text
            }
          ] 
        });
      });
    </script> -->


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