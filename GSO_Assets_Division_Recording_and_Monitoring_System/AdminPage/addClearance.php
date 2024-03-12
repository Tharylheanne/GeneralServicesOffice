<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');
include('../AdminPage/includes/saveClearance.php');
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
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
    }
    .additional-info {
      display: none;
    }
    .updates-currentStatus {
      display: none;
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
    <?php include_once("../AdminPage/header/header.php");?>
    <?php include_once("../AdminPage/sidebar/sidebar.php");?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1 class="ion-android-checkmark-circle"> NEW CLEARANCE
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="ion-android-checkmark-circle"></i> Dashboard</a></li>
          <li class="active">New Clearance</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">NEW CLEARANCE</h4>
          </div><br>

          <!-- Container fluid for the Registry form -->
          <form method="post" action="" enctype="multipart/form-data" id="addPRSform">
            <div class="row-flex">
              <div class="col-md-12"><!-- Group 1 -->
                <!-- Date Cleared -->
                <div class="col-md-4">
	                <div class="form-group">
	                  <label for="dateCleared"> Date Cleared By GSO</label>
	                  <input type="date" class="form-control" id="dateCleared" placeholder="Date Cleared By GSO" name="dateCleared" autocomplete="off" required>
	                </div>
                </div>
                <!-- End of Date Cleared -->

                <div class="col-md-4"><!--Control Number -->
                <div class="form-group">
                  <label for="controlNo"> Control Number</label>
                  <input type="text" class="form-control" id="controlNo" placeholder="Control Number" name="controlNo" autocomplete="off" required>
                </div>
              </div><!-- End Control Number -->

              <div class="col-md-4"><!-- Scanned Documents -->
                    <div class="form-group">
                        <label for="scannedDocs">Scanned Copy</label>
                        <input type="file" class="form-control" id="scannedDocs" name="scannedDocs" accept=".pdf">
                    </div>
                </div><!-- End Scanned Documents -->

                <div class="col-md-4"><!-- Accountable Person  -->
                  <div class="form-group">
                      <label for="accountablePerson"> Employee Name</label>
                      <input list="accountable_options" class="form-control" id="accountablePerson" placeholder="LAST NAME, First Name, MI" name="accountablePerson" autocomplete="off" required>
                      <datalist id="accountable_options">
                          <?php
                          // Query the database to fetch condition data from conditions table
                          $employees = $connect->query("SELECT employeeID, employeeName FROM employees ORDER BY employeeName");
                          
                          while ($employee_row = $employees->fetch_assoc()) {
                              echo '<option value="' . $employee_row['employeeName'] . '">' . $employee_row['employeeName'] . '</option>';
                          }
                          ?>
                      </datalist>
                  </div>
              </div><!-- End Accountable Person -->

              <div class="col-md-4"><!-- Position -->
                <div class="form-group">
                  <label for="Position"> Position:</label>
                  <input type="text" class="form-control" id="position" placeholder="Position" name="position" autocomplete="off">
                </div>
              </div><!-- End Position -->

              <div class="col-md-4"><!-- Clearance Classification -->
                  <div class="form-group">
                      <label for="classification"> Classification</label>
                      <select class="form-control" id="classification" name="classification" style="width:100%;">
                              <option value="">---Select Classification---</option>
                              <option value="Barangay">Barangay</option>
                              <option value="DepEd">DepEd - Division Office</option>
                              <option value="DepEd Elementary School">DepEd - Elementary School</option>
                              <option value="DepEd High School">DepEd - High School</option>
                              <option value="Alternative Learning System (ALS)">DepEd - Alternative Learning System (ALS)</option>
                              <option value="Special Education (SPED)">DepEd - Special Education (SPED)</option>
                              <option value="City Office">City Office</option>
                              <option value="National Office">National Office</option>
                          </select>
                  </div>
              </div><!-- End Clearance Classification -->

              <div class="col-md-4"><!-- Responsibility Center -->
                  <div class="form-group">
                      <label for="rescenter">Specific Location/Responsibility Center</label>
                      <input list="rescenter_options" class="form-control" id="rescenter" placeholder="Responsibility Center" name="rescenter" autocomplete="off">
                            <datalist id="rescenter_options">
                                <!-- Options will be dynamically updated using JavaScript -->
                            </datalist>
                  </div>
              </div><!-- End Responsibility Center -->

              <div class="col-md-4"><!-- Purpose -->
                  <div class="form-group">
                      <label for="purpose"> Purpose</label>
                      <input list="purpose_options" class="form-control" id="purpose_input" placeholder="Select Clearance Purpose" name="purpose_input" autocomplete="off">
                      <datalist id="purpose_options">
                          <?php
                          // Query the database to fetch condition data from conditions table
                          $purpose_query = $connect->query("SELECT purposeID, purposeName FROM clearancepurpose");
                          
                          while ($purpose_row = $purpose_query->fetch_assoc()) {
                              echo '<option value="' . $purpose_row['purposeName'] . '">' . $purpose_row['purposeName'] . '</option>';
                          }
                          ?>
                          <option value="Other"></option>
                      </datalist>
                  </div>
              </div><!-- End Purpose -->
              <!-- Other Purpose Input -->
              <div class="col-md-4" id="otherPurposeContainer" style="display: none;">
                  <div class="form-group">
                      <label for="otherPurpose"> Other Purpose</label>
                      <input type="text" class="form-control" id="otherPurpose_input" placeholder="Enter other purpose if not on the list" name="otherPurpose_input" autocomplete="off" disabled>
                  </div>
              </div><!-- End Other Purpose Input -->

              <div class="col-md-4"><!-- Effectivity Date -->
                <div class="form-group">
                  <label for="effectivityDate"> Effectivity Date</label>
                  <input type="text" class="form-control" id="effectivityDate" placeholder="Effectivity Date" name="effectivityDate" autocomplete="off">
                </div>
              </div><!-- End Effectivity Date -->
              <div class="col-md-4"><!-- Particulars -->
                <div class="form-group">
                  <label for="remarks"> Remarks/Conditions</label>
                  <input type="text" class="form-control" id="remarks" placeholder="remarks" name="remarks" autocomplete="off">
                </div><!-- End remarks -->
              </div>
              
              <div class="col-md-4"><!-- enGAS Property Number  -->
                <div class="form-group">
                  <label for="clearedBy"> Cleared By:</label>
                  <input type="text" class="form-control" id="clearedBy" placeholder="Cleared By" name="clearedBy">
                </div>
              </div><!-- End clearedby Property Number   -->
              </div><!-- col-md-4 -->
            <!-- End of Group 1 -->
           
            </div><!-- row-flex -->
            <!-- Add ARE Registry Save button -->
            <div class="form-group" style="text-align: center;">
              <button type="submit" class="btn btn-success" name="btn_clearanceSave" onClick="">Add Clearance</button>
            </div>
          </form><!-- addPRSform -->     
        </div><!-- div-box -->
      </section>
    </div><!-- content-wrapper -->
  </div><!-- wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">GSO Asset Division - Recording and Monitoring System</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

  <!-- REQUIRED JAVASCRIPTS -->
  <!-- jQuery 2.2.3 -->
  <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <!-- <script src="../dist/js/app.min.js"></script> -->
  <script src="../plugins/slimScroll/jquery.slimscroll.js"></script>

  <!-- Script for the dynamically changing responsibility center based on the user's selection in the classification -->
  <script>
  // Get references to the classification and responsibility center input
  const classificationInput = document.getElementById("classification");
  const responsibilityCenterInput = document.getElementById("rescenter");

  // Add an event listener to the classification input
  classificationInput.addEventListener("change", function () {
      // Clear the responsibility center input
      responsibilityCenterInput.value = "";
      updateResponsibilityCenterOptions();
  });

  // Function to update the responsibility center options based on the selected classification
  function updateResponsibilityCenterOptions() {
      const classification = classificationInput.value;
      const rescenterDatalist = document.getElementById("rescenter_options");

      // Clear the existing options
      rescenterDatalist.innerHTML = '';

      if (classification === 'Barangay') {
          // Fetch and update options for Barangay
          fetch('getBarangays.php')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not okay');
                  }
                  return response.json();
              })
              .then(data => {
                  data.forEach(barangayName => {
                      const optionElement = document.createElement('option');
                      optionElement.value = barangayName;
                      rescenterDatalist.appendChild(optionElement);
                  });
              })
              .catch(error => {
                  console.error('Error fetching barangays: ', error);
              });
      } else if (classification === 'DepEd Elementary School') {
          // Fetch and update options for DepEd ES
          fetch('getDepEdES.php')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not okay');
                  }
                  return response.json();
              })
              .then(data => {
                  data.forEach(elemName => {
                      const optionElement = document.createElement('option');
                      optionElement.value = elemName;
                      rescenterDatalist.appendChild(optionElement);
                  });
              })
              .catch(error => {
                  console.error('Error fetching elementary schools: ', error);
              });
      } else if (classification === 'DepEd High School') {
          // Fetch and update options for DepEd HS
          fetch('getDepEdHS.php')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not okay');
                  }
                  return response.json();
              })
              .then(data => {
                  data.forEach(highSchoolName => {
                      const optionElement = document.createElement('option');
                      optionElement.value = highSchoolName;
                      rescenterDatalist.appendChild(optionElement);
                  });
              })
              .catch(error => {
                  console.error('Error fetching high schools: ', error);
              });
      } else if (classification === 'City Office') {
          // Fetch and update options for City Office
          fetch('getCityOffices.php')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not okay');
                  }
                  return response.json();
              })
              .then(data => {
                  data.forEach(officeName => {
                      const optionElement = document.createElement('option');
                      optionElement.value = officeName;
                      rescenterDatalist.appendChild(optionElement);
                  });
              })
              .catch(error => {
                  console.error('Error fetching city offices: ', error);
              });
      } else if (classification === 'National Office') {
          // Fetch and update options for National Office
          fetch('getNationalOffices.php')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not okay');
                  }
                  return response.json();
              })
              .then(data => {
                  data.forEach(nofficeName => {
                      const optionElement = document.createElement('option');
                      optionElement.value = nofficeName;
                      rescenterDatalist.appendChild(optionElement);
                  });
              })
              .catch(error => {
                  console.error('Error fetching national offices: ', error);
              });
      } else if (classification === 'DepEd') {
      	responsibilityCenterInput.value = 'Division Office';
      } else if (classification === 'Special Education (SPED)') {
      	responsibilityCenterInput.value = 'Baguio City SPED Center';
      } else if (classification === 'Alternative Learning System (ALS)'){
      	responsibilityCenterInput.value = 'Alternative Learning System (ALS)';
      }
  }

  // Call the function to initialize the Responsibility Center options
  updateResponsibilityCenterOptions();
  </script>
  <!-- Script for the other purpose input -->
  <script>
  // Get references to the purpose input, other purpose input, and its container
  const purposeInput = document.getElementById("purpose_input");
  const otherPurposeContainer = document.getElementById("otherPurposeContainer");
  const otherPurposeInput = document.getElementById("otherPurpose_input");

  // Add an event listener to the purpose input
  purposeInput.addEventListener("change", function () {
      if (purposeInput.value.toLowerCase() === "other") {
          // If "Other" is selected, show the otherPurpose input
          otherPurposeContainer.style.display = "block";
          otherPurposeInput.disabled = false;
      } else {
          // If another option is selected, hide the otherPurpose input
          otherPurposeContainer.style.display = "none";
          otherPurposeInput.disabled = true;
          otherPurposeInput.value = ""; // Clear the input
      }
  });
  </script>


<!-- Accessible sidebar anywhere the page -->
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
