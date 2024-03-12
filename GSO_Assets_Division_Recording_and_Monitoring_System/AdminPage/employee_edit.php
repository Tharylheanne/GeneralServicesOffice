<?php
require('../loginPage/login_session.php');
include_once('../AdminPage/includes/manage_edit_employee.php');

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GSO Assets Division | Recording and Monitoring System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
  <!-- Favicons -->
  <link  href="../dist/img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

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
          background: rgba(0, 0, 0, 0.7);
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
<body class="hold-transition skin-blue-light sidebar-mini fixed">
    <div class="wrapper">
        <?php include("../AdminPage/header/header.php");?>
        <?php include("../AdminPage/sidebar/sidebar.php");?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-plus"></i> Employees</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"> Employees</i></a></li>
                    <li class="active"> Employees</li>
                </ol>
            </section>
            <section class="content container-fluid">
                <div class="box">
                    <div class="box-header bg-blue" align="center">
                        <h4 class="box-title">List of Employees</h4>
                    </div><br>
                    <div class="card-body">
                        <form id="update_employee" method="post">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <input type="text" class="form-control" id="employeeName" name="employeeName" value="<?php echo $row['employeeName']?>" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>TIN Number</label>
                                    <input type="text" class="form-control" id="tinNo" name="tinNo" value="<?php echo $row['tinNo']?>" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" id="employeeID" name="employeeID" value="<?php echo $row['employeeID'] ?>" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rescenter">Responsibility Center</label>
                                    <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" value="<?php echo $row['office']; ?>" autocomplete="off">
                                    <datalist id="rescenter_options">
                                        <?php
                                        $rescenter_query = $connect->query("SELECT co.office_id, co.office_name, co.ocode_number FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name, no.ncode_number FROM national_offices no");
                                        while ($rescenter_row = $rescenter_query->fetch_assoc()) {
                                            $selected = ($rescenter_row['office_name'] === $row['office']) ? 'selected' : '';
                                            echo '<option value="' . $rescenter_row['office_name'] . '" ' . $selected . '>' . $rescenter_row['office_name'] . '</option>';
                                        }
                                        ?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea type="text" class="form-control" id="remarks" name="remarks"><?php echo $row['remarks'] ? $row['remarks'] : ''; ?></textarea>
                                </div>
                            </div>
                                <button type="btn-submit" class="btn btn-success" name="btn-employeeupdate" id="btn-employeeupdate">Update</button>
                                <a href="others.php" class="btn btn-primary">Back</a>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Required JavaScripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>

    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <!-- page script -->
    <script>
      $(function () {
        $('#example1').DataTable({responsive:true})
        $('#example2').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        })
      })
    </script>
</body>
</html>