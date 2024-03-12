<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');
include('../AdminPage/includes/saveAREregistry.php');
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
        <h1>ARE REGISTRY
          <small>Registry of New ARE-Issued PPE</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Registry</a></li>
          <li class="active">Registry of ARE-Issued PPE</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">Registry of ARE-Issued PPE</h4>
          </div><br>

          <!-- Container fluid for the Registry form -->
          <form method="post" action="" enctype="multipart/form-data" id="AddNewAREregistry">
            <div class="row-flex">
              <div class="col-md-4"><!-- Group 1 -->
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>REGISTRY OF NEW ARE-ISSUED PPE</b></h4><br>
                  <div class="horizontal-line"></div>
                </div><!-- form-group -->

                <!-- Scanned Docs -->
                <div class="form-group">
                  <label for="scannedDocs">Scanned Documents</label>
                  <input type="file" name="scannedDocs" class="form-control" id="scannedDocs" accept=".pdf">
                </div>
                <!-- End of Scanned Docs -->

                <!-- Date Recorded -->
                <div class="form-group">
                  <label for="dateReceived"> Date Received</label>
                  <input type="date" class="form-control" id="dateReceived" placeholder="Date Recorded" name="dateReceived" autocomplete="off" required max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <!-- End Date Recorded -->

                <!-- Article -->
                <div class="form-group">
                  <label for="article"> Article</label>
                  <input type="text" class="form-control" id="article" placeholder="Article" name="article" autocomplete="off" style="text-transform: uppercase;" required>
                </div>
                <!-- End Article -->

                <!-- Brand -->
                <div class="form-group">
                  <label for="brand"> Brand/Model</label>
                  <input type="text" class="form-control" id="brand" placeholder="Brand/Model" name="brand" autocomplete="off" style="text-transform: uppercase;" required>
                </div>
                <!-- End Brand -->

                <!-- Particulars -->
                <div class="form-group">
                  <label for="particulars"> Particulars</label>
                  <textarea type="text" class="form-control" id="particulars" placeholder="Particulars" name="particulars" autocomplete="off"></textarea>
                </div>
                <!-- End Particulars -->

                <!-- Responsibility Center(Office/Department) -->
                <div class="form-group">
                  <label for="officeName"> Responsibility Center (Offices and Departments)</label>
                  <input list="rescenter_options" class="form-control" id="officeName" placeholder="Responsibility Center" name="officeName" autocomplete="off" onchange="fetchEmployeesByCenter()">
                  <datalist id="rescenter_options">
                      <?php
                      $responsibilityCenter = $connect->query("SELECT co.officeID, co.officeName AS officeName, co.officeCodeNumber FROM cityoffices co UNION ALL SELECT no.officeID, no.officeName AS officeName, no.officeCodeNumber FROM nationaloffices no ORDER BY officeName");
                      $rowCount = $responsibilityCenter->num_rows;
                      if ($rowCount > 0) {
                          while ($row = $responsibilityCenter->fetch_assoc()) {
                              echo '<option value="'.$row['officeName'].'">'.$row['officeName'].'</option>';
                          }
                      } else {
                          echo '<option value="">No Responsibility Center available</option>';
                      }
                      ?>
                  </datalist>
                </div>
                <!-- End Responsibility Center(Office/Department) -->


                <!-- Property Account Code (Classification) -->
                <div class="form-group">
                  <label for="accountNumber"> Account Code</label>
                  <input list="classification_options" class="form-control" id="accountNumber" placeholder="Account Code" name="accountNumber" autocomplete="off" required>
                  <datalist id="classification_options">
                      <?php
                      $query1 = $connect->query("SELECT * FROM account_codes");
                      $rowCount = $query1->num_rows;
                      if ($rowCount > 0) {
                          while ($row = $query1->fetch_assoc()) {
                              echo '<option value="' . $row['accountNumber'] . '">' . $row['accountNumber'] . '</option>';
                          }
                      } else {
                          echo '<option value="">No Classifications available</option>';
                      }
                      ?>
                  </datalist>
                </div>
                <!-- End Classification(Property Account Code) -->

                <!-- Acquisition Date -->
                <div class="form-group">
                  <label for="acquisitionDate"> Acquisition Date</label>
                  <input type="date" class="form-control" id="acquisitionDate" placeholder="Acquisition Date" name="acquisitionDate" autocomplete="off">
                </div>
                <!-- End Acquisition Date -->


                <!-- Acquisition Cost/Unit Value -->
                <div class="form-group">
                    <label for="unitValue"> Unit Value</label>
                    <input type="text" class="form-control" id="unitValue" placeholder="Unit Value" name="unitValue" autocomplete="off"onblur="validateUnitValue(this)">
                    <p id="errorMessage" style="color: red;"></p>
                </div>

                <!-- End Acquisition Cost/Unit Value -->

                <!-- Quantity -->
                <div class="form-group">
                    <label for="balancePerCard"> Quantity</label>
                    <input type="number" class="form-control" id="balancePerCard" placeholder="Quantity" name="balancePerCard" autocomplete="off" oninput="updateBalancePerCard()">
                </div>
                <!-- End Quantity -->

                <!-- Total Cost/Total Value -->
                <div class="form-group">
                    <label for="acquisitionCost">Total Value</label>
                    <input type="text" class="form-control" id="acquisitionCost" placeholder="Total Value" name="acquisitionCost" readonly>
                </div>
                <!-- End Total Cost/Total Value -->
                      
                <!-- Unit of Measure -->
                <div class="form-group">
                  <label for="unitOfMeasure"> Unit of Measure</label>
                  <input type="text" class="form-control" id="unitOfMeasure" placeholder="Unit of Measure" name="unitOfMeasure" autocomplete="off">
                </div>
                <!-- End Unit of Measure -->

                <!-- Accountable Employee -->
                <div class="form-group">
                  <label for="accountablePerson"> Accountable Employee</label>
                  <div id="accountablePerson_inputs" style="margin-bottom: 10px;">
                    <div class="input-group">
                      <input list="accountable_options" class="form-control" id="accountablePerson[]" placeholder="LAST NAME, First Name, MI" name="accountablePerson[]" autocomplete="off">

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
                      <input type="text" class="form-control" id="AREno[]" placeholder="ARE/MR Number" name="AREno[]" autocomplete="off">
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
                      <textarea type="text" class="form-control" id="serialNo[]" placeholder="Serial Number" name="serialNo[]" autocomplete="off"></textarea>
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
                <input type="text" class="form-control" id="eNGAS" placeholder="enGAS Property Number" name="eNGAS" autocomplete="off">
              </div>
              <!-- end eNGAS -->

              <!-- Property Number -->
              <div class="form-group">
                <label for="propertyNo"> Property Number</label>
                <div id="propertyNo_inputs">
                  <div class="input-group" style="margin-bottom: 10px;">
                    <input type="text" class="form-control" id="propertyNo[]" placeholder="Property Number" name="propertyNo[]" autocomplete="off">
                    <div class="input-group-addon clickable" onclick="toggleAdditionalInfo('propertyNo', true)"><i class="fa fa-plus"></i></div>
                  </div>
                </div>
              </div>
              <!-- End Property Number -->

              <!-- Balance Per Card -->
              <div class="form-group">
                <label for="quantity"> Balance Per Card Quantity</label>
                <input type="number" class="form-control" id="quantity" placeholder="Balance Per Card Quantity" name="quantity" autocomplete="off">
              </div>
              <script>
                  function updateBalancePerCard() {
                      // Get the value from the Quantity input
                      var quantityValue = document.getElementById('balancePerCard').value;

                      // Update the Balance Per Card input with the Quantity value
                      document.getElementById('quantity').value = quantityValue;
                  }
              </script>
              <!-- End Balance Per Card -->

              <!-- Onhand Per Count -->
              <div class="form-group">
                <label for="onhandPerCount"> On-hand per Count Quantity</label>
                <input type="number" class="form-control" id="onhandPerCount" placeholder="On-hand per Count Quantity" name="onhandPerCount" autocomplete="off">
              </div>
              <!-- End Onhand Per Count -->

              <!-- Shortage/Overage Quantity -->
              <div class="form-group">
                <label for="soQty"> Shortage/Overage Qty</label>
                <input type="text" class="form-control" id="soQty" placeholder="Shortage/Overage Qty" name="soQty" readonly>
              </div>
              <!-- End Shortage/Overage Quantity -->

              <!-- Shortage/Overage value -->
              <div class="form-group">
                <label for="soValue"> Shortage/Overage Value</label>
                <input type="text" class="form-control" id="soValue" placeholder="Shortage/Overage Value" name="soValue" readonly>
              </div>
              <!-- End Shortage/Overage value -->

              <!-- Previous Condition -->
              <div class="form-group">
                <label for="previousCondition"> Previous Condition</label>
                <input type="text" class="form-control" id="previousCondition" placeholder="Previous Condition" autocomplete="off"  name="previousCondition">
              </div>
              <!-- End Previous condition -->

              <!-- Location/Whereabouts -->
              <div class="form-group">
                <label for="location"> Location</label>
                <input type="text" class="form-control" id="location" placeholder="Location/Whereabouts" autocomplete="off"  name="location">
              </div>
              <!-- End Location/Whereabouts -->

              <!-- Current Condition -->
              <div class="form-group">
                <label for="current_condition">Current Condition</label>
                <input list="current_condition_options" class="form-control" id="current_condition" placeholder="Enter or select Current Condition" name="current_condition" autocomplete="off">
                <datalist id="current_condition_options">
                    <?php
                    // Query the database to fetch condition data from conditions table
                    $conditions_query = $connect->query("SELECT conditionID, conditionName FROM conditions");
                    
                    while ($conditions_row = $conditions_query->fetch_assoc()) {
                        echo '<option value="' . $conditions_row['conditionName'] . '">' . $conditions_row['conditionName'] . '</option>';
                    }
                    ?>
                    <option value="Other"></option>
                </datalist>
              </div>

              <div class="form-group" id="other_condition_group" style="display: none;">
                <label for="other_condition">Other Condition</label>
                <input type="text" class="form-control" id="other_condition" placeholder="Enter Other Condition" name="other_condition" autocomplete="off" disabled>
              </div>
              <!-- End Current Condition -->

              <!-- Date of Physical Inventory -->
              <div class="form-group">
                <label for="dateOfPhysicalInventory">Date of Physical Inventory</label>
                <input type="date" name="dateOfPhysicalInventory" id="dateOfPhysicalInventory" class="form-control" placeholder="Date of Physical Inventory" autocomplete="off">
              </div>
              <!-- End Date of Physical Inventory -->

              <!-- Remarks -->
              <div class="form-group">
                <label for="remarks"> Remarks</label>
                <textarea type="text" class="form-control" id="remarks" placeholder="Remarks" autocomplete="off"  name="remarks"></textarea>
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
                <label for="estimatedLife">Estimated Useful Life</label>
                <input type="number" name="estimatedLife" class="form-control" id="estimatedLife" placeholder="Years of Service" name="estimatedLife" autocomplete="off" min="1">
              </div>
              <!-- end Estimated Useful Life -->

            <!-- Years of Service -->
            <div class="form-group">
              <label for="yearsOfService">Years of Service</label>
              <input type="number" name="yearsOfService" class="form-control" id="yearsOfService" placeholder="Years of Service" name="yearsOfService" autocomplete="off" min="1">
            </div>
            <!-- End Years of Service -->

            <!-- Monthly Depreciation -->
            <div class="form-group">
              <label for="monthlyDepreciation">Monthly Depreciation</label>
              <input type="text" name="monthlyDepreciation" class="form-control" id="monthlyDepreciation" placeholder="Monthly Depreciation" name="monthlyDepreciation" autocomplete="off">
            </div>
            <!-- End Monthly Depreciation -->

            <!-- Accumulated Depreciation -->
            <div class="form-group">
              <label for="accumulatedDepreciation">Accumulated Depreciation</label>
              <input type="text" name="accumulatedDepreciation" class="form-control" id="accumulatedDepreciation" placeholder="Accumulated Depreciation" name="accumulatedDepreciation" autocomplete="off">
            </div>
            <!-- End Accumulated Depreciation -->

            <!-- Book Value -->
            <div class="form-group">
              <label for = "bookValue">Book Value</label>
              <input type="text" name="bookValue" class="form-control" id="bookValue" placeholder="Book Value" name="bookValue" autocomplete="off">
            </div>
            <!-- End Book Value -->

            <!-- Additional Details for Disposal -->
            <!-- <div class="horizontal-line"></div><br>
            <h4 class="box-title" align="center"><b>ADDITIONAL DETAILS FOR DISPOSAL</b></h4><br>
            <div class="horizontal-line"></div> -->

            <!-- Supplier -->
            <div class="form-group">
              <label for="supplier">Supplier</label>
              <input type="text" name="supplier" class="form-control" placeholder="Supplier" id="supplier" autocomplete="off">
            </div>
            <!-- End Supplier -->

            <!-- PO No -->
            <div class="form-group">
              <label for="POno">PO No.</label>
              <input type="text" name="POno" class="form-control" placeholder="PO No." autocomplete="off"  id="POno">
            </div>
            <!-- End PO No -->

            <!-- AIR/RIS No -->
            <div class="form-group">
              <label for="AIRnumber">AIR/RIS No.</label>
              <input type="text" name="AIRnumber" class="form-control" placeholder="AIR/RIS No" autocomplete="off" id="AIRnumber">
            </div>
            <!-- End AIR/RIS No -->

            <!-- JEV Number -->
            <div class="form-group">
              <label for="jevNo">jevNo Number(Registry)</label>
              <input type="text" name="jevNo" id="jevNo" class="form-control" placeholder="JEV Number" autocomplete="off">
            </div>
            <!-- End JEV Number -->

            <!-- Notes -->
            <div class="form-group">
              <label for="notes">Notes</label>
              <textarea type="text" name="notes" class="form-control" placeholder="Notes" id="notes" autocomplete="off"></textarea>
            </div>
            <!-- End Notes -->

              </div><!-- col-md-4 -->
              <!-- End of Group 3 -->

            </div><!-- row-flex -->

            <!-- Add ARE Registry Save button -->
            <div class="form-group" align="center" >
              <button type="button" class="btn btn-primary" name="saveARE" id="saveARE">Add ARE Registry</button>
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

    <!-- Script for other conditions -->
  <script type="text/javascript">
      // Get references to the select and input elements
      var currentConditionSelect = document.getElementById("current_condition");
      var otherConditionGroup = document.getElementById("other_condition_group");
      var currentConditionInput = document.getElementById("other_condition");

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

<!-- Script for the calculation of soQty, soValue, and formatting unitValue to accounting format -->

<script>
    // Function to calculate and update acquisition cost, shortage/overage qty, and shortage/overage value
    function updateCalculations() {
        var unitValue = parseFloat(document.getElementById("unitValue").value.replace(/,/g, '')) || 0;
        var balancePerCard = parseFloat(document.getElementById("balancePerCard").value) || 0;
        var onHandPerCount = parseFloat(document.getElementById("onhandPerCount").value) || 0;

        // Calculate acquisition cost: unit value * balance per card
        var acquisitionCost = unitValue * balancePerCard;

        // Calculate shortage/overage qty: balance per card - on hand per count
        var shortageOverageQty = balancePerCard - onHandPerCount;

        // Calculate shortage/overage value: unit value * shortage/overage qty
        var shortageOverageValue = unitValue * shortageOverageQty;

        // Format the acquisition cost with commas
        var formattedAcquisitionCost = acquisitionCost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2});
        var formattedShortageOverageValue = shortageOverageValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Format the shortage/overage qty and shortage/overage value as strings with two decimal places
        var formattedShortageOverageQty = shortageOverageQty;

        // Update the acquisition cost, shortage/overage qty, and shortage/overage value inputs
        document.getElementById("acquisitionCost").value = formattedAcquisitionCost;
        document.getElementById("soQty").value = formattedShortageOverageQty;
        document.getElementById("soValue").value = formattedShortageOverageValue;
    }

    // Add event listeners to unit value, balance per card, and on hand per count inputs
    document.getElementById("unitValue").addEventListener("input", updateCalculations);
    document.getElementById("balancePerCard").addEventListener("input", updateCalculations);
    document.getElementById("onhandPerCount").addEventListener("input", updateCalculations);

    // Initial calculation when the page loads (optional)
    updateCalculations();
</script>
<!-- End of Script for the calculation of soQty, soValue, and formatting unitValue to accounting format -->

<!-- End of Script for the validation of unit value input -->
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
<!-- End of Script for the validation of unit value input -->

<!-- Script for the dynamic addition of input fields for accountablePerson, AREno, serialNo, propertyNo -->
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
  <!-- End of Script for the dynamic addition of input fields for accountablePerson, AREno, serialNo, propertyNo -->
  
<!-- Script for saving the inputs -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("saveARE").addEventListener("click", function() {
            // You can add validation or additional logic here before submitting the form
            document.getElementById('AddNewAREregistry').submit();
            
            // Alternatively, you can use AJAX to submit the form data
            var form = document.getElementById("AddNewAREregistry");
            var formData = new FormData(form);

            // Send form data to the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "saveARERegistry.php", true);
            xhr.onload = function() {
                // Handle response from the server
                if (xhr.status === 200) {
                    // Display success message or handle any other actions
                    console.log(xhr.responseText);
                } else {
                    // Handle errors
                    console.error("Error: " + xhr.statusText);
                }
            };
            xhr.onerror = function() {
                // Handle network errors
                console.error("Network Error");
            };
            xhr.send(formData);
        });
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("saveARE").addEventListener("click", function() {
            // Get all input fields in the accountable person section
            var accountableInputs = document.querySelectorAll('[name^="accountablePerson"]');
            
            // Create an array to store the input values
            var inputValues = [];

            // Iterate over each input field
            accountableInputs.forEach(function(input) {
                // Get the input value
                var inputValue = input.value;
                
                // Push the input value into the array
                inputValues.push(inputValue);
            });

            // Prepare the data to send to the server
            var data = {
                accountablePersons: inputValues
            };

            // Send data to the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "saveARERegistry.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onload = function() {
                // Handle response from the server
                if (xhr.status === 200) {
                    // Display success message or handle any other actions
                    console.log(xhr.responseText);
                } else {
                    // Handle errors
                    console.error("Error: " + xhr.statusText);
                }
            };

            xhr.onerror = function() {
                // Handle network errors
                console.error("Network Error");
            };

            // Convert data object to JSON before sending
            xhr.send(JSON.stringify(data));
        });
    });
  </script>

  <script>
    // Add event listener to the office selection input
    document.getElementById('officeName').addEventListener('change', function() {
        var selectedOffice = this.value;
        fetchEmployeesByOffice(selectedOffice);
    });

    // Function to fetch accountable employees based on the selected office
    function fetchEmployeesByOffice(selectedOffice) {
        // Make an Ajax request to the server
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetchEmployees.php?office=' + encodeURIComponent(selectedOffice), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the JSON response
                    var employees = JSON.parse(xhr.responseText);
                    // Update the datalist options
                    updateDatalistOptions(employees);
                } else {
                    console.error('Error fetching employees');
                }
            }
        };
        xhr.send();
    }

    // Function to update the datalist options with the fetched employees
    function updateDatalistOptions(employees) {
        var datalist = document.getElementById('accountable_options');
        datalist.innerHTML = ''; // Clear existing options
        employees.forEach(function(employee) {
            var option = document.createElement('option');
            option.value = employee;
            datalist.appendChild(option);
        });
    }
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
