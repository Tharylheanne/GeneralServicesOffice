<?php
require('../login/login_session.php');
include_once('../admin_page/includes/manageEditBarangay.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>GSO ASSET DIVISION - RECORDING AND MONITORING SYSTEM</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

  <!-- Favicons -->
  <link href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">

  <style>
      /* Modal background overlay */
      .modal-background {
          display: flex;
          justify-content: center;
          align-items: center;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.2);
          z-index: 999;
      }

      /* Modal content */
      .modal-content {
          background: #fff;
          border: 1px solid #ccc;
          border-radius: 5px;
          padding: 20px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
          text-align: center;
      }

      /* Modal message text */
      .modal-message {
          font-size: 18px;
          margin-bottom: 20px;
      }

      /* OK button */
      .ok-button {
          background: #007bff;
          color: #fff;
          border: none;
          padding: 10px 20px;
          border-radius: 5px;
          cursor: pointer;
          font-size: 16px;
      }

      .ok-button:hover {
          background: #0056b3;
      }
  </style>
</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
<div class="wrapper">
    <?php
    include_once("../admin_page/header/header.php");
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-plus"></i>Barangay</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"> Barangay</i></a></li>
                <li class="active">Barangay</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header bg-blue" align="center">
                    <h4 class="box-title">Edit Barangay Name</h4>
                </div>
                <div class="box-body">
                    <form id="update_barangay" method="post">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Barangay Name</label>
                                <input type="text" class="form-control" id="barangayName" name="barangayName" value="<?php echo $row['barangayName'] ?>" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" name="btn-updateBarangay" id="btn-updateBarangay">Update</button>
                            </div>
                        </div>

                        <a href="others.php" class="btn btn-primary">Back</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Required JavaScripts -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- calendar -->
<script src="../dist/js/moment.min.js"></script>
<script src="../dist/js/fullcalendar.min.js"></script>
<!-- ======================================================================================= -->
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- bootstrap color picker -->
<script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!-- page script -->
<script>
    $(function () {
        $('#example1').DataTable({responsive: true})
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })
</script>
<!-- ======================================================================================= -->
</body>
</html>