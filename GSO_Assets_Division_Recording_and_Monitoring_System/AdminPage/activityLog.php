<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');

if (!isset($_SESSION["employeeID"])) {
    header('Location: ../loginPage/login.php');
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
                <h1><i class="fa fa-book"></i>LOGS
                    <small>Manage your Logs</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Logs</li>
                </ol>
            </section>

            <section class="content container-fluid">
                <br>
                <div class="box">
                    <div class="box-header bg-blue" align="center">
                        <h4 class="box-title">Activity Logs</h4>
                    </div><br>
                    <form method="POST">
                        <button name="clear" id="clear" class="btn btn-gray pull-right" onClick="return confirm('Are you sure you want to clear logs?')" style="margin-right: 20px">
                            <span class="fa fa-trash">&nbsp</span>Clear Logs
                        </button>
                    </form>
                    <br>
                    <br>
                    <table id="logs" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Employee ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                             $pre_stmt = $connect->prepare("SELECT * FROM activity_log ORDER BY time_log DESC")or die(mysqli_error()); 
                             $pre_stmt->execute();                 
                             $result = $pre_stmt->get_result();
                            while($row = mysqli_fetch_array($result)){

                             date_default_timezone_set('Asia/Manila');
                               $time=$row['time_log'];
                               $time_log= date('h:i:s a ', strtotime($time)); ?>

                                <tr>
                                    <td><?php echo $row['date_log']; ?> </td>
                                    <td><?php echo $row['employeeID']; ?> </td>
                                    <td><?php echo $row['firstName']; ?> </td>
                                    <td><?php echo $time_log; ?> </td>
                                    <td><?php echo $row['action']; ?> </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <?php

    if (isset($_POST['clear'])) {
        $queryLOG = 'TRUNCATE TABLE activity_log';
        $pre_stmt = $connect->prepare($queryLOG) or die(mysqli_error());
        $pre_stmt->execute();

        echo '<script type="text/javascript">window.location = "activityLog.php"</script>';
    }

    ?>

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
        $(function() {
            $('#logs').DataTable({
                responsive: true,
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [25, 50, 100, 200]
            })
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                "lengthMenu": [25, 50, 100, 200]
            })
        })
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