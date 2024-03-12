<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');
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

  
  <!-- <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->
  
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

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
        <h1><i class="fa fa-plus"></i> 
          DATA LIST
          <small>Manage your list of offices, account codes, and employees</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>

          <li class="active">Data List</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_employee_modal">
          <span class="fa fa-fw fa-plus" aria-hidden="true"></span>
          Add Employee
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#city_offices_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
        Add City Office
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#national_offices_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
        Add Natinoal Office
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#account_codes_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
        Add Account for Equipment
        </button>
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
            <ul class="nav nav-tabs" role="tablist">
              <!-- Employees with Accountabilities -->
              <li class="nav-item">
                <a href="#employees" class="nav-link" role="tab" data-toggle="tab">Employees with Accountabilites</a>
              </li>
              <!-- City Offices -->
              <li class="nav-item">
                <a class="nav-link active" href="#cityoffice" role="tab" data-toggle="tab">City Offices</a>
              </li>
              <!-- National Offices -->
              <li class="nav-item">
                <a class="nav-link" href="#nationaloffice" role="tab" data-toggle="tab">National Offices</a>
              </li>
              <!-- Account Code for Equipment -->
              <li class="nav-item">
                <a class="nav-link" href="#account" role="tab" data-toggle="tab">Account for equipment</a>
              </li>
              <!-- Barangay List -->
              <li class="nav-item">
                <a class="nav-link" href="#barangay" role="tab" data-toggle="tab">Barangay List</a>
              </li>
              <!-- Elementary List -->
              <li class="nav-item">
                <a class="nav-link" href="#elementary" role="tab" data-toggle="tab">Elementary School List</a>
              </li>
              <!-- High school List -->
              <li class="nav-item">
                <a class="nav-link" href="#highschool" role="tab" data-toggle="tab">High School List</a>
              </li>
              <!-- Clearance Purpose -->
              <li class="nav-item">
                <a class="nav-link" href="#purpose" role="tab" data-toggle="tab">Clearance Purpose</a>
              </li>
            </ul><!-- nav nav-tabs -->
            <br>
            <!-- Tab Panes -->
            <div class="tab-content">
              <!-- Employees Table -->
                <div role="tabpanel" class="tab-pane fade in active" id="employees">
                  <table id="example4" class="table table-hover" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            
                            <th>Employee Name</th>
                            <th>TIN Number</th>
                            <th>Employee ID Number</th>
                            <th>Office/Department</th>
                            <th>Remarks</th>
                            
                             <th>Action</th>
                        </tr>
                      </thead>
                       <tbody >
                        <?php include_once("../AdminPage/includes/manage_employee_table.php") ?>
                      </tbody> 
                  </table>
                </div><!-- tab panel -->
            
            <!-- City Offices Table -->
            <div role="tabpanel" class="tab-pane fade" id="cityoffice">
                <table id="example1" class="table table-hover" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              
                              <th>City Office Name</th>
                              <th>Code Number</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                       <tbody >
                         <?php include_once("../AdminPage/includes/manage_cityoffices_table.php") ?>
                      </tbody> 
                </table>
            </div><!-- tab panel -->

            <!-- National Offices Table -->
            <div role="tabpanel" class="tab-pane fade" id="nationaloffice">
              <table id="example2" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          
                          <th>Office Name</th>
                          <th>Code Number</th>
                           <th>Action</th>
                      </tr>
                  </thead>
                   <tbody >
                    <?php include_once("../AdminPage/includes/manage_nationaloffices_table.php") ?>
                  </tbody> 
              </table>
            </div> <!-- tab panel -->

            <!-- Account Codes table -->
            <div role="tabpanel" class="tab-pane fade" id="account">
              <table id="example3" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        
                        <th>Account Title</th>
                        <th>Account Code</th>
                         <th>Action</th>
                    </tr>
                  </thead>
                   <tbody >
                    <?php include_once("../AdminPage/includes/manage_accountcodes_table.php") ?>
                  </tbody> 
              </table>
            </div><!-- tab panel -->

            <!-- Barangay List -->
            <div role="tabpanel" class="tab-pane fade" id="barangay">
              <table id="example5" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th>Barangay</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php include_once("../AdminPage/includes/manageBarangayTable.php") ?>
                  </tbody>
              </table>
            </div><!-- tab panel -->

            <!-- Elementary List -->
            <div role="tabpanel" class="tab-pane fade" id="elementary">
              <table id="example6" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        
                        <th>DepEd Elementary Shool</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                   <tbody>
                    <?php include_once("../AdminPage/includes/manageElemTable.php") ?>
                  </tbody> 
              </table>
            </div><!-- tab panel -->

            <!-- Highschool List -->
            <div role="tabpanel" class="tab-pane fade" id="highschool">
              <table id="example7" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        
                        <th>DepEd High Shool</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                   <tbody>
                    <?php include_once("../AdminPage/includes/manageHighSchoolTable.php") ?>
                  </tbody> 
              </table>
            </div><!-- tab panel -->

            <!-- Clearance Purposes -->
            <div role="tabpanel" class="tab-pane fade" id="purpose">
              <table id="example8" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        
                        <th>Clearance Purpose</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                   <tbody >
                    <?php include_once("../AdminPage/includes/managePurposeTable.php") ?>
                  </tbody> 
              </table>
            </div><!-- tab panel -->
            </div><!-- tab-content -->
          </div><!--  div card-body -->
        </div><!-- div box -->

      </section>
    </div><!-- content-wrapper -->
  </div><!-- wrapper -->

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>

  <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

  <!-- script for the table -->
  <?php
  include_once("../AdminPage/modals/employee_modal.php");
  include_once("../AdminPage/modals/city_offices_modal.php");
  include_once("../AdminPage/modals/national_offices_modal.php");
  include_once("../AdminPage/modals/accountcodes_modal.php");
  include_once("../AdminPage/modals/barangay_modal.php");
  include_once("../AdminPage/modals/elementary_modal.php");
  include_once("../AdminPage/modals/highschool_modal.php");
  include_once("../AdminPage/modals/purpose_modal.php");
  ?>
  <!-- page script -->
  <script>
    $(function () {
      $('#example1').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example3').DataTable({responsive:true , lengthMenu: [25, 50, 100, 200, 500],})
      $('#example2').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example4').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example5').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example6').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example7').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
      $('#example8').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
    })

  </script>
  <!-- ======================================================================================= -->
  <script>
      $(document).ready(function(){
       $('#insert_formcityoffices').on("submit", function(event){  
        event.preventDefault();  
        if($('#cityoffice_name').val() == "")  
        {  
         alert("City Office Name is required");  
        }  

        else  
        {  
         $.ajax({  
          url:"modals/insert/insert_city_offices.php",  
          method:"POST",  
          data:$('#insert_formcityoffices').serialize(),  
          beforeSend:function(){  
           $('#insertcityoffice').val("Inserting");  
          },  
          success:function(data){  
           $('#insert_formcityoffices')[0].reset();  
           $('#city_offices_modal').modal('hide');  
           alert(data); 
           location.reload();
          }  
         });  
        }  
       });

      });
  </script>
  <!-- End of Script for City Offices -->
  <!-- ==================================================================== -->
  <!-- Start Script for National Offices -->
    <script>
      $(document).ready(function(){
       $('#insert_formnationaloffices').on("submit", function(event){  
        event.preventDefault();  
        if($('#nationaloffice_name').val() == "")  
        {  
         alert("National Office Name is required");  
        }  

        else  
        {  
         $.ajax({  
          url:"modals/insert/insert_national_offices.php",  
          method:"POST",  
          data:$('#insert_formnationaloffices').serialize(),  
          beforeSend:function(){  
           $('#insertnationaloffice').val("Inserting");  
          },  
          success:function(data){  
           $('#insert_formnationaloffices')[0].reset();  
           $('#national_offices_modal').modal('hide');  
           alert(data); 
           location.reload();
          }  
         });  
        }  
       });

      });
  </script>
  <!-- End for National Offices -->

  <!-- Start Script for National Offices -->
    <script>
      $(document).ready(function(){
        $('#insert_formaccountcodes').on("submit", function(event){  
          event.preventDefault();  
          if($('#accounttitle').val() == "") {  
            alert("Account Title is required");  
          } else {  
            $.ajax({  
              url: "modals/insert/insert_account_codes.php",  
              method: "POST",  
              data: $('#insert_formaccountcodes').serialize(),  
              beforeSend: function(){  
                $('#insertaccountcode').val("Inserting");  
              },  
              success: function(data){  
                $('#insert_formaccountcodes')[0].reset();  
                $('#account_codes_modal').modal('hide');  
                alert(data); 
                location.reload();
              }  
            });  
          }  
        });
      });
  </script>
  <!-- End Script for Account Codes for Equipment -->
  <!-- Start Script for Employees -->
  <script>
      $(document).ready(function(){
        $('#insert_form_employee').on("submit", function(event){  
          event.preventDefault();  
          if ($('#employeeName').val() == "") {  
            alert("Employee Name is required");  
          } else if ($('#office_department').val() == "") {  
            alert("Office/Department is required");  
          } else {  
            $.ajax({  
              url: "modals/insert/insert_employee.php",  // Replace with the actual URL for handling employee insertion
              method: "POST",  
              data: $('#insert_form_employee').serialize(),  
              beforeSend: function(){  
                $('#insert_employee').val("Inserting");  
              },  
              success: function(data){  
                $('#insert_form_employee')[0].reset();  
                $('#add_employee_modal').modal('hide');  
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
  <!-- End Script for Employees -->
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
  <script>
    
  </script>
</body>
</html>