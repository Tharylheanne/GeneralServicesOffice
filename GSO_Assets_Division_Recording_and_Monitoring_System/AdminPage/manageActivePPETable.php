<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');
include('../AdminPage/includes/editActivePPE.php');
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
        <h1>EDIT ARE REGISTRY
          <small>Edit Active Property, Plant and Equipment(PPE)</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Registry</a></li>
          <li class="active">EDIT ARE-ISSUED PROPERTY, PLANT AND EQUIPMENT (PPE)</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">EDIT ARE-Issued PPE</h4>
          </div><br>

          <!-- Container fluid for the Registry form -->
          <form method="post" action="editActivePPe.php" enctype="multipart/form-data" id="editAREform">
            <div class="row-flex">
              <div class="col-md-4"><!-- Group 1 -->
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>EDIT ARE-ISSUED PPE</b></h4><br>
                  <div class="horizontal-line"></div>
                </div><!-- form-group -->

                <!-- Scanned Docs -->
                <div class="form-group">
                  <label for="scannedDocs">Scanned Documents</label>
                  <input type="file" name="scannedDocs" class="form-control" id="scannedDocs" accept=".pdf">
                </div>

                <div class="form-group">
                  <br><label for="savedScannedFile">Saved Scanned Document</label>
                  <input type="text" class="form-control" id="savedScannedFile" name="savedScannedFile" value="<?php echo $row['scannedDocs']; ?>" readonly>
                </div>
                <!-- End of Scanned Docs -->

                <!-- Date Recorded -->
                <div class="form-group">
                  <label for="dateReceived"> Date Received</label>
                  <input type="date" class="form-control" id="dateReceived" name="dateReceived" value="<?php echo $row['dateReceived']; ?>">
                </div>
                <!-- End Date Recorded -->

                <!-- Article -->
                <div class="form-group">
                  <label for="article"> Article</label>
                  <input type="text" class="form-control" id="article" placeholder="Article" name="article" style="text-transform: uppercase;" value="<?php echo $row['article']; ?>">
                </div>
                <!-- End Article -->

                <!-- Brand -->
                <div class="form-group">
                  <label for="brand"> Brand/Model</label>
                  <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" autocomplete="off" style="text-transform: uppercase;" value="<?php echo $row['brand']; ?>">
                </div>
                <!-- End Brand -->

                <!-- Particulars -->
                <div class="form-group">
                  <label for="particulars"> Particulars</label>
                  <textarea type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" autocomplete="off"><?php echo $row['particulars']; ?></textarea>
                </div>
                <!-- End Particulars -->

                <!-- Responsibility Center(Office/Department) -->
                <div class="form-group">
                    <label for="officeName"> Responsibility Center (Offices and Departments)</label>
                    <input list="officeName_options" class="form-control" id="officeName" placeholder="Responsibility Center" name="officeName" value="<?php echo $row['officeName']; ?>" autocomplete="off" onchange="fetchEmployeesByCenter()">
                    <datalist id="officename_options">
                        <?php
                        $officeName = $connect->query("SELECT co.officeID, co.officeName AS officeName, co.officeCodeNumber FROM cityoffices co UNION ALL SELECT no.officeID, no.officeName AS officeName, no.officeCodeNumber FROM nationaloffices no ORDER BY officeName");
                        $rowCount = $officeName->num_rows;
                        while ($officename_row = $officeName->fetch_assoc()) {
                            $selected = ($officename_row['officeName'] === $row['officeName']) ? 'selected' : '';
                            echo '<option value="' . $officename_row['officeName'] . '" ' . $selected . '>' . $officename_row['officeName'] . '</option>';
                        }
                        ?>
                    </datalist>
                </div>
                <!-- End Responsibility Center(Office/Department) -->

                <!-- Property Account Code (Classification) -->
                <div class="form-group">
                    <label for="accountNumber">Account Code</label>
                    <input list="accountNumber_options" class="form-control" id="accountNumber" placeholder="Account Code" name="accountNumber" autocomplete="off" value="<?php echo htmlspecialchars($row['accountNumber']); ?>">
                    <datalist id="accountNumber_options">
                        <?php
                        $accountNumbers = $connect->query("SELECT * FROM account_codes");
                        while ($accountNumber_row = $accountNumbers->fetch_assoc()) {
                            $selected = ($accountNumber_row['accountNumber'] === $row['accountNumber']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($accountNumber_row['accountNumber']) . '" ' . $selected . '>' . htmlspecialchars($accountNumber_row['accountNumber']) . '</option>';
                        }
                        ?>
                    </datalist>
                </div>
                <!-- End Classification(Property Account Code) -->

                <!-- Acquisition Date -->
                <div class="form-group">
                  <label for="acquisitionDate"> Acquisition Date</label>
                  <input type="date" class="form-control" id="acquisitionDate" placeholder="Acquisition Date" name="acquisitionDate" autocomplete="off" value="<?php echo $row['acquisitionDate']; ?>">
                </div>
                <!-- End Acquisition Date -->

                <!-- Acquisition Cost/Unit Value -->
                <div class="form-group">
                    <label for="unitValue"> Unit Value/Acquisition Cost</label>
                    <input type="text" class="form-control" id="unitValue" placeholder="Unit Value" name="unitValue" autocomplete="off" onblur="validateUnitValue(this)" value="<?php echo $row['unitValue'] ?>">
                    <p id="errorMessage" style="color: red;"></p>
                </div>

                      <script>
                          function validateUnitValue(input) {
                              // Get the input value and remove any existing commas
                              var value = input.value.replace(/,/g, '');
                              // Parse the value as a float
                              var floatValue = parseFloat(value);
                              
                              // Check if the value is less than 50000
                              if (floatValue < 50000) {
                                  // Display the alert message below the input box
                                  document.getElementById('errorMessage').innerText = "Please enter a value that is 50,000.00 or above";
                                  // Reset the input value
                                  input.value = '';
                                  // Clear values of other input fields
                                  document.getElementById('quantity').value = '';
                                  document.getElementById('acquisitionCost').value = '';
                                  return;
                              } else {
                                  // Clear the error message if the value is valid
                                  document.getElementById('errorMessage').innerText = "";
                              }

                              // Format the value with commas for thousandths place and two decimal places
                              var formattedValue = floatValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                              // Update the input value
                              input.value = formattedValue;
                          }
                      </script>
                <!-- End Acquisition Cost/Unit Value -->

                <!-- Quantity -->
                <div class="form-group">
                    <label for="quantity"> Quantity</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity" min="1" autocomplete="off" value="<?php echo $row['quantity']; ?>">
                </div>
                <!-- End Quantity -->

                <!-- Total Cost/Total Value -->
                <div class="form-group">
                    <label for="acquisitionCost">Total Value</label>
                    <input type="text" class="form-control" id="acquisitionCost" placeholder="Total Value" name="acquisitionCost" value="<?php echo $row['acquisitionCost']; ?>">
                </div>
                    <script>
                        function calculateTotal() {
                            // Get the unitValue input value and remove commas
                            var unitValueStr = document.getElementById('unitValue').value.replace(/,/g, '');
                            // Parse the unitValue as a float
                            var unitValue = parseFloat(unitValueStr);

                            // Get the quantity input value
                            var quantity = parseInt(document.getElementById('quantity').value);

                            // Calculate the total value
                            var totalValue = unitValue * quantity;

                            // Format the totalValue with commas for thousandths place and two decimal places
                            var formattedTotalValue = totalValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

                            // Update the acquisitionCost input value
                            document.getElementById('acquisitionCost').value = isNaN(totalValue) ? '' : formattedTotalValue;
                        }
                      </script>
                <!-- End Total Cost/Total Value -->
                      
                <!-- Unit of Measure -->
                <div class="form-group">
                  <label for="unitOfMeasure"> Unit of Measure</label>
                  <input type="text" class="form-control" id="unitOfMeasure" placeholder="Unit of Measure" name="unitOfMeasure" autocomplete="off" value="<?php echo $row['unitOfMeasure']; ?>">
                </div>
                <!-- End Unit of Measure -->

                <!-- Accountable Employee -->
                <div class="form-group">
                  <label for="accountablePerson"> Accountable Employee</label>
                  <div id="accountablePerson_inputs" style="margin-bottom: 10px;">
                    <div class="input-group">
                      <input list="accountable_options" class="form-control" id="accountablePerson" placeholder="LAST NAME, First Name, MI" name="accountablePerson" autocomplete="off" value="<?php echo $row['accountablePerson'] ?>">

                      <div class="input-group-addon clickable" onclick="toggleAdditionalInfo('accountablePerson', true)"><i class="fa fa-plus"></i></div>
                    </div>
                    <datalist id="accountable_options">
                        <!-- Populate this datalist with options -->
                    </datalist>
                  </div>
                </div>
                <!-- End Accountable Employee -->

                <!-- ARE/MR Number -->
                <div class="form-group">
                  <label for="AREno"> ARE/MR Number</label>
                  <div id="AREno_inputs">
                    <div class="input-group" style="margin-bottom: 10px;">
                      <input type="text" class="form-control" id="AREno" placeholder="ARE/MR Number" name="AREno" autocomplete="off" value="<?php echo $row['AREno'] ?>">
                      <div class="input-group-addon clickable" onclick="toggleAdditionalInfo('AREno', true)"><i class="fa fa-plus"></i></div>
                    </div>
                  </div>
                </div>
                <!-- End ARE/MR Number -->

                <!-- Serial Number -->
                <div class="form-group">
                  <label for="serialNo"> Serial Number</label>
                  <div id="serialNo_inputs">
                    <div class="input-group" style="margin-bottom: 10px;">
                      <textarea type="text" class="form-control" id="serialNo" placeholder="Serial Number" name="serialNo" autocomplete="off"><?php echo $row['serialNo']; ?></textarea>
                      <div class="input-group-addon clickable" onclick="toggleAdditionalInfo('serialNo', true)"><i class="fa fa-plus"></i></div>
                    </div>
                  </div>
                </div>
                <!-- End Serial Number -->
              </div><!-- col-md-3 -->
            <!-- End of Group 1 -->

              <!-- ===============================Group 2=============================== -->
              <div class="col-md-4 vertical-line">
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>ADDITIONAL DETAILS FOR PHYSICAL INVENTORY</b></h4><br>
                  <div class="horizontal-line"></div>
                </div>

              <!-- eNGAS -->
              <div class="form-group">
                <label for="eNGAS"> eNGAS Property Number</label>
                <input type="text" class="form-control" id="eNGAS" placeholder="enGAS Property Number" name="eNGAS" autocomplete="off" value="<?php echo $row['eNGAS']; ?>">
              </div>
              <!-- end eNGAS -->

              <!-- Property Number -->
              <div class="form-group">
                <label for="propertyNo"> Property Number</label>
                <div id="propertyNo_inputs">
                  <div class="input-group" style="margin-bottom: 10px;">
                    <input type="text" class="form-control" id="propertyNo" placeholder="Property Number" name="propertyNo" autocomplete="off" value="<?php echo $row['propertyNo']; ?>">
                    <div class="input-group-addon clickable" onclick="toggleAdditionalInfo('propertyNo', true)"><i class="fa fa-plus"></i></div>
                  </div>
                </div>
              </div>
              <!-- End Property Number -->

              <!-- Balance Per Card -->
              <div class="form-group">
                <label for="balancePerCard"> Balance Per Card Quantity</label>
                <input type="number" class="form-control" id="balancePerCard" placeholder="Balance Per Card Quantity" name="balancePerCard" autocomplete="off" value="<?php echo $row['quantity']; ?>">
              </div>
              <!-- End Balance Per Card -->

              <!-- Onhand Per Count -->
              <div class="form-group">
                <label for="onhandPerCount"> On-hand per Count Quantity</label>
                <input type="number" class="form-control" id="onhandPerCount" placeholder="On-hand per Count Quantity" name="onhandPerCount" autocomplete="off" value="<?php echo $row['onhandPerCount']; ?>">
              </div>
              <!-- End Onhand Per Count -->

              <!-- Shortage/Overage Quantity -->
              <div class="form-group">
                <label for="soQty"> Shortage/Overage Qty</label>
                <input type="text" class="form-control" id="soQty" placeholder="Shortage/Overage Qty" name="soQty" readonly value="<?php echo $row['soQty']; ?>">
              </div>
              <!-- End Shortage/Overage Quantity -->

              <!-- Shortage/Overage value -->
              <div class="form-group">
                <label for="soValue"> Shortage/Overage Value</label>
                <input type="text" class="form-control" id="soValue" placeholder="Shortage/Overage Value" name="soValue" readonly value="<?php echo $row['soValue'] ?>">
              </div>
              <!-- End Shortage/Overage value -->

              <!-- Previous Condition -->
              <div class="form-group">
                <label for="previousCondition"> Previous Condition</label>
                <input type="text" class="form-control" id="previousCondition" placeholder="Previous Condition" autocomplete="off"  name="previousCondition" value="<?php echo $row['previousCondition']; ?>">
              </div>
              <!-- End Previous condition -->

              <!-- Location/Whereabouts -->
              <div class="form-group">
                <label for="location"> Location</label>
                <input type="text" class="form-control" id="location" placeholder="Location/Whereabouts" autocomplete="off"  name="location" value="<?php echo $row['location']; ?>">
              </div>
              <!-- End Location/Whereabouts -->

              <!-- Current Condition -->
              <div class="form-group">
                  <label for="current_condition_input">Current Condition</label>
                  <input list="current_condition_options" class="form-control" id="current_condition_input" placeholder="Enter or select Current Condition" name="current_condition_input" autocomplete="off" value="<?php echo htmlspecialchars($row['currentCondition']); ?>">
                  <datalist id="current_condition_options">
                      <?php
                      // Query the database to fetch condition data from conditions table
                      $conditions_query = $connect->query("SELECT conditionID, conditionName FROM conditions");
                      while ($condition_row = $conditions_query->fetch_assoc()) {
                          $selected = ($condition_row['conditionID'] === $row['currentCondition']) ? 'selected' : '';
                          echo '<option value="' . htmlspecialchars($condition_row['conditionName']) . '" ' . $selected . '>' . htmlspecialchars($condition_row['conditionName']) . '</option>';
                      }
                      ?>
                      <option value="Other"></option>
                  </datalist>
              </div>

              <div class="form-group" id="other_condition_group" style="display: none;">
                <label for="other_condition_input">Other Condition</label>
                <input type="text" class="form-control" id="other_condition_input" placeholder="Enter Other Condition" name="other_condition_input" autocomplete="off" disabled>
              </div>
              <!-- End Current Condition -->

              <!-- Date of Physical Inventory -->
              <div class="form-group">
                <label for="dateOfPhysicalInventory">Date of Physical Inventory</label>
                <input type="date" name="dateOfPhysicalInventory" id="dateOfPhysicalInventory" class="form-control" placeholder="Date of Physical Inventory" autocomplete="off" value="<?php echo $row['dateOfPhysicalInventory']; ?>">
              </div>
              <!-- End Date of Physical Inventory -->

              <!-- Remarks -->
              <div class="form-group">
                <label for="remarks"> Remarks</label>
                <textarea type="text" class="form-control" id="remarks" placeholder="Remarks" autocomplete="off"  name="remarks"><?php echo $row['remarks']; ?></textarea>
              </div>
              <!-- Remarks -->

            </div><!-- col-md-3 -->
            <!-- End of Group 2 -->

<!-- ===============================Group 3=============================== -->
            <div class="col-md-4 vertical-line">
              <h4 class="box-title" align="center"><b>ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</b></h4><br>
              <div class="horizontal-line"></div>

              <!-- Estimated Useful Life -->
              <div class="form-group">
                <label for="estimatedLife"> Estimated Useful Life</label>
                <input list="estimatedLife_options" class="form-control" id="estimatedLife" placeholder="Estimated Useful Life" name="estimatedLife" style="width:100%;" autocomplete="off" value="<?php echo $row['estimatedLife']; ?>">
            </div>
              <!-- end Estimated Useful Life -->

            <!-- Years of Service -->
            <div class="form-group">
              <label for="yearsOfService">Years of Service</label>
              <input type="number" name="yearsOfService" class="form-control" id="yearsOfService" placeholder="Years of Service" name="yearsOfService" autocomplete="off" value="<?php echo $row['yearsOfService']; ?>">
            </div>
            <!-- End Years of Service -->

            <!-- Monthly Depreciation -->
            <div class="form-group">
              <label for="monthlyDepreciation">Monthly Depreciation</label>
              <input type="text" name="monthlyDepreciation" class="form-control" id="monthlyDepreciation" placeholder="Monthly Depreciation" name="monthlyDepreciation" autocomplete="off" value="<?php echo $row['monthlyDepreciation']; ?>">
            </div>
            <!-- End Monthly Depreciation -->

            <!-- Accumulated Depreciation -->
            <div class="form-group">
              <label for="accumulatedDepreciation">Accumulated Depreciation</label>
              <input type="text" name="accumulatedDepreciation" class="form-control" id="accumulatedDepreciation" placeholder="Accumulated Depreciation" name="accumulatedDepreciation" autocomplete="off" value="<?php echo $row['accumulatedDepreciation']; ?>">
            </div>
            <!-- End Accumulated Depreciation -->

            <!-- Book Value -->
            <div class="form-group">
              <label for = "bookValue">Book Value</label>
              <input type="text" name="bookValue" class="form-control" id="bookValue" placeholder="Book Value" name="bookValue" autocomplete="off" value="<?php echo $row['bookValue']; ?>">
            </div>
            <!-- End Book Value -->

            <!-- Additional Details for Disposal -->
            <!-- <div class="horizontal-line"></div><br>
            <h4 class="box-title" align="center"><b>ADDITIONAL DETAILS FOR DISPOSAL</b></h4><br>
            <div class="horizontal-line"></div> -->

            <!-- Supplier -->
            <div class="form-group">
              <label for="supplier">Supplier</label>
              <input type="text" name="supplier" class="form-control" placeholder="Supplier" id="supplier" autocomplete="off" value="<?php echo $row['supplier']; ?>">
            </div>
            <!-- End Supplier -->

            <!-- PO No -->
            <div class="form-group">
              <label for="POno">PO No.</label>
              <input type="text" name="POno" class="form-control" placeholder="PO No." autocomplete="off"  id="POno" value="<?php echo $row['POnumber']; ?>">
            </div>
            <!-- End PO No -->

            <!-- AIR/RIS No -->
            <div class="form-group">
              <label for="AIRnumber">AIR/RIS No.</label>
              <input type="text" name="AIRnumber" class="form-control" placeholder="AIR/RIS No" autocomplete="off" id="AIRnumber" value="<?php echo $row['AIRNumber']; ?>">
            </div>
            <!-- End AIR/RIS No -->

            <!-- JEV Number -->
            <div class="form-group">
              <label for="jevNo">jevNo Number(Registry)</label>
              <input type="text" name="jevNo" id="jevNo" class="form-control" placeholder="JEV Number" autocomplete="off" value="<?php echo $row['jevNo']; ?>">
            </div>
            <!-- End JEV Number -->

            <!-- Notes -->
            <div class="form-group">
              <label for="notes">Notes</label>
              <textarea type="text" name="notes" class="form-control" placeholder="Notes" id="notes" autocomplete="off"><?php echo $row['notes']; ?></textarea>
            </div>
            <!-- End Notes -->

              </div><!-- col-md-4 -->
              <!-- End of Group 3 -->

            </div><!-- row-flex -->

            <!-- Add ARE Registry Save button -->
            <div class="form-group" align="center" >
              <button type="button" class="btn btn-primary" name="updateARE" id="updateARE">UPDATE</button>
            </div>
          </form><!-- AddNewAREregistry -->     
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

  <!-- Script for the estimated life -->
  <script>
    // Get the select element by its ID
    var estLifeSelect = document.getElementById("estimatedLife");

    // Add an event listener to listen for changes in the select element
    estLifeSelect.addEventListener("change", function() {
        // Get the selected value
        var estLifeValue = estLifeSelect.value;

        // You can now use the 'selectedValue' variable as needed
        console.log("Selected Value: " + estLifeValue);
    });
  </script>

  <!-- Script for other conditions -->
  <script type="text/javascript">
      // Get references to the select and input elements
      var currentConditionSelect = document.getElementById("current_condition_input");
      var otherConditionGroup = document.getElementById("other_condition_group");
      var currentConditionInput = document.getElementById("other_condition_input");

      // Add an event listener to the select element
      currentConditionSelect.addEventListener("change", function() {
          if (currentConditionSelect.value === "Other") {
              // If "Other" is selected, show the input field
              otherConditionGroup.style.display = "block";
              currentConditionInput.disabled = false;
          } else {
              // If any other option is selected, hide and clear the input field
              otherConditionGroup.style.display = "none";
              currentConditionInput.disabled = true;
              currentConditionInput.value = "";
          }
      });
  </script>


  <!-- This is the script function of adding additional input fields of Accountable Employee, ARE/MR Number, Serial Number, and Property Number when + sign is clicked -->
  <script type="text/javascript">
      function toggleAdditionalInfo(inputId, addInput) {
          var inputExtra = document.getElementById(inputId + '_extra');
          var inputContainer = document.getElementById(inputId + '_inputs');
          var placeholderText = "";
          
          switch(inputId) {
              case 'accountablePerson':
                  placeholderText = "LAST NAME, First Name, MI.";
                  break;
              case 'AREno':
                  placeholderText = "ARE/MR Number";
                  break;
              case 'serialNo':
                  placeholderText = "Serial Number";
                  break;
              case 'propertyNo':
                  placeholderText = "Property Number";
                  break;
              // Add cases for other input IDs if needed
              default:
                  break;
          }
          
          if (addInput) {
              // Create a new input group element
              var newInputGroup = document.createElement('div');
              newInputGroup.classList.add('input-group');
              newInputGroup.style.marginBottom = '10px'; // Add margin bottom to new input group

              // Create a new input element or textarea depending on the inputId
              var newInput;
              if (inputId === 'serialNo') {
                  newInput = document.createElement('textarea');
              } else {
                  newInput = document.createElement('input');
                  newInput.setAttribute('type', 'text');
              }

              newInput.setAttribute('class', 'form-control');
              newInput.setAttribute('placeholder', placeholderText); // Set the placeholder text
              newInput.setAttribute('autocomplete', 'off');

              // Create a new minus sign element
              var minusSign = document.createElement('div');
              minusSign.classList.add('input-group-addon', 'clickable');
              minusSign.innerHTML = '<i class="fa fa-minus"></i>';
              minusSign.onclick = function() {
                  toggleAdditionalInfo(inputId, false);
              };

              // Append the new input or textarea and minus sign elements to the input group
              newInputGroup.appendChild(newInput);
              newInputGroup.appendChild(minusSign);

              // Append the input group to the input container
              inputContainer.appendChild(newInputGroup);

              // Add margin top to the newly added input group
              newInputGroup.style.marginTop = '10px';
          } else {
              // Remove the last added input group element
              inputContainer.removeChild(inputContainer.lastChild);
          }
      }
  </script>
  <!-- script so that the sidebar is accessible anywhere in the page -->
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
