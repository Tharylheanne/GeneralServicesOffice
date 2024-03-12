<?php
require('./../database/connection.php');
require('../login/login_session.php');
?>
<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GSO ASSET DIVISION - RECORDING AND MONITORING SYSTEM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="../dist/css/fullcalendar.min.css">
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/skins/skin-blue-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->

  <!-- Favicons -->
  <link  href="img/baguiologo.png" rel="icon">
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

<body class="hold-transition skin-blue-light sidebar-mini  fixed ">
<div class="wrapper">

<?php include_once("../admin_page/header/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->  
    <section class="content-header">
      <h1><i class="fa fa-plus"></i> 
        DATA LIST
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>

        <li class="active">Data List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
 <!-- ===========================================================================================================================--> 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_barangay_modal">
    <span class="fa fa-fw fa-plus" aria-hidden="true"></span> Add Barangay
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_elementary_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
Add Elementary School
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_highschool_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
Add High School
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_clearancePurpose_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
Add Clearance Purpose
</button>


<div class="box">
    <div class="box-header bg-blue" align="center">
      <h4 class="box-title"></h4>
    </div>
    <br>
    <div class="card-body">
      <!-- Button trigger modal -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link" href="#barangay" role="tab" data-toggle="tab">Barangay List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#elementary" role="tab" data-toggle="tab">Elementary List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#highschool" role="tab" data-toggle="tab">High School List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#purpose" role="tab" data-toggle="tab">Clearance Purpose</a>
        </li>
        
      </ul>

      <br>
      <!-- Tab panes -->
      <div class="tab-content">
          <!-- List of barangays -->
          <div role="tabpanel" class="tab-pane fade in active" id="barangay">
            <table id="example5" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Barangay</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include_once("../admin_page/includes/manageBarangayTable.php") ?>
                </tbody>
            </table>
          </div>

          <!-- List of elementary schools -->
          <div role="tabpanel" class="tab-pane fade" id="elementary">
            <table id="example6" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      
                      <th>DepEd Elementary Shool</th>
                      <th>Action</th>
                  </tr>
                </thead>
                 <tbody>
                  <?php include_once("../admin_page/includes/manageElemTable.php") ?>
                </tbody> 
            </table>
          </div>
          <!-- List of high schools -->
          <div role="tabpanel" class="tab-pane fade" id="highschool">
            <table id="example7" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      
                      <th>DepEd High Shool</th>
                      <th>Action</th>
                  </tr>
                </thead>
                 <tbody>
                  <?php include_once("../admin_page/includes/manageHighSchoolTable.php") ?>
                </tbody> 
            </table>
          </div>
          <!-- List of clearance purpose -->
          <div role="tabpanel" class="tab-pane fade" id="purpose">
            <table id="example8" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      
                      <th>Clearance Purpose</th>
                      <th>Action</th>
                  </tr>
                </thead>
                 <tbody >
                  <?php include_once("../admin_page/includes/managePurposeTable.php") ?>
                </tbody> 
            </table>
          </div>
          
      </div><!-- div tab content -->
    </div><!-- div card body -->
</div><!-- div box -->

    <?php
    /*include_once("../admin_page/modals/employee_modal.php");
    include_once("../admin_page/modals/city_offices_modal.php");
    include_once("../admin_page/modals/national_offices_modal.php");
    include_once("../admin_page/modals/accountcodes_modal.php");*/
    include_once("../admin_page/modals/barangay_modal.php");
    include_once("../admin_page/modals/elementary_modal.php");
    include_once("../admin_page/modals/highschool_modal.php");
    include_once("../admin_page/modals/purpose_modal.php");
    ?>



    <!--======================================================================================================================================== -->
    </section>
    <!-- /.content -->


  </div>
  <!-- /.content-wrapper -->
  

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!--  <script src="./js/add_college.js"></script>
<script src="./js/add_course.js"></script>
<script src="./js/add_office.js"></script> -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../dist/js/moment.min.js"></script>
<script src="../dist/js/fullcalendar.min.js"></script>
<!-- ======================================================================================= -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!-- page script -->
<script>
  $(function () {
      /*$('#example1').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example2').DataTable({responsive:true , lengthMenu: [25, 50, 100, 200, 500],})
      $('#example3').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example4').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})*/
      $('#example5').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example6').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example7').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example8').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
    });
    
</script>
<!-- ======================================================================================= -->
<!-- barangay script -->
<script>
    $(document).ready(function(){
        $('#insert_form_barangay').on("submit", function(event){  
            event.preventDefault();  
            if ($('#barangayName').val() == "") {  
                alert("Barangay is required");  
            } else {  
                $.ajax({  
                    url: "modals/insert/insert_barangay.php", // Replace with the actual URL for handling barangay insertion
                    method: "POST",  
                    data: $('#insert_form_barangay').serialize(),  
                    beforeSend: function(){  
                        $('#insert_barangay').val("Inserting");  
                    },  
                    success: function(data){  
                        $('#insert_form_barangay')[0].reset();  
                        $('#add_barangay_modal').modal('hide');  
                        alert(data); 
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });  
            }  
        });
    });
</script>
<!-- elem script -->
<script>
    $(document).ready(function() {
        $('#insert_form_elementary').on("submit", function(event) {
            event.preventDefault();
            if ($('#elemName').val() == "") {
                alert("Elementary name is required");
            } else {
                $.ajax({
                    url: "modals/insert/insert_elementary.php", // Replace with the actual URL for handling elementary school insertion
                    method: "POST",
                    data: $('#insert_form_elementary').serialize(),
                    beforeSend: function() {
                        $('#insert_elementary').val("Inserting");
                    },
                    success: function(data) {
                        $('#insert_form_elementary')[0].reset();
                        $('#add_elementary_modal').modal('hide');
                        alert(data);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            }
        });
    });
</script>
<!-- high school script -->
<script>
    $(document).ready(function(){
        $('#insert_form_highschool').on("submit", function(event){  
            event.preventDefault();  
            if ($('#highschoolName').val() == "") {  
                alert("High School Name is required");  
            } else {  
                $.ajax({  
                    url: "modals/insert/insert_highschool.php", // Replace with the actual URL for handling high school insertion
                    method: "POST",  
                    data: $('#insert_form_highschool').serialize(),  
                    beforeSend: function(){  
                        $('#insert_highschool').val("Inserting");  
                    },  
                    success: function(data){  
                        $('#insert_form_highschool')[0].reset();  
                        $('#add_highschool_modal').modal('hide');  
                        alert(data); 
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });  
            }  
        });
    });
</script>
<!-- clearance purpose script -->
<script>
    $(document).ready(function(){
        $('#insert_form_clearancePurpose').on("submit", function(event){  
            event.preventDefault();  
            if ($('#purposeName').val() == "") {  
                alert("Clearance Purpose is required");  
            } else {  
                $.ajax({  
                    url: "modals/insert/insert_purpose.php", // Replace with the actual URL for handling high school insertion
                    method: "POST",  
                    data: $('#insert_form_clearancePurpose').serialize(),  
                    beforeSend: function(){  
                        $('#insert_purpose').val("Inserting");  
                    },  
                    success: function(data){  
                        $('#insert_form_clearancePurpose')[0].reset();  
                        $('#add_clearancePurpose_modal').modal('hide');  
                        alert(data); 
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });  
            }  
        });
    });
</script>

<script>
    function showSuccessModal(message) {
        var modal = document.querySelector(".modal-background");
        var modalContent = document.querySelector(".modal-content");
        var modalMessage = document.querySelector(".modal-message");
        
        modalMessage.textContent = message;
        modal.style.display = "block";

        // Close the modal when the OK button is clicked
        var okButton = document.querySelector(".ok-button");
        okButton.onclick = function () {
            modal.style.display = "none";
        };
    }
</script>
</body>
</html>