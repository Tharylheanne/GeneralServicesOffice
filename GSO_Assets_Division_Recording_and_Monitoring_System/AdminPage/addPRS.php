<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');
include('../AdminPage/includes/savePRS.php');
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
        <h1>PROPERTY RETURN SLIP
          <small>PRS</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>PRS</a></li>
          <li class="active">Property Return Slip</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content container-fluid">
        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title"></h4>
          </div><br>

          <!-- Container fluid for the Registry form -->
          <form method="post" action="" enctype="multipart/form-data" id="addPRSform">
            <div class="row-flex">
              <div class="col-md-4"><!-- Group 1 -->
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>PROPERTY RETURN SLIP</b></h4><br>
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
                  <label for="dateReturned"> Date Returned</label>
                  <input type="date" class="form-control" id="dateReturned" placeholder="Date Returned" name="dateReturned" autocomplete="off" required max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <!-- End Date Recorded -->

                <!-- Item Number -->
                <div class="form-group">
                  <label for="itemNo">Item No.</label>
                  <input type="text" name="itemNo" class="form-control" id="itemNo" placeholder="Item No." autocomplete="off">
                </div>
                <!-- End Item Number -->

                <!-- PRS Number -->
                <div class="form-group">
                  <label for="prsNo"> PRS Number</label>
                  <input type="text" name="prsNo" class="form-control" id="prsNo" placeholder="PRS Number" autocomplete="off">
                </div>
                <!-- End PRS Number -->

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
                    <label for="balancePerCard"> Balance Per Card</label>
                    <input type="number" class="form-control" id="balancePerCard" placeholder="Balance Per Card" name="balancePerCard" autocomplete="off" oninput="updateBalancePerCard()">
                </div>
                <!-- End Quantity -->

                <!-- Total Cost/Total Value -->
                <div class="form-group">
                    <label for="acquisitionCost">Total Value</label>
                    <input type="text" class="form-control" id="acquisitionCost" placeholder="Total Value" name="acquisitionCost" readonly>
                </div>
                <!-- End Total Cost/Total Value -->

                <!-- Estimated Useful Life -->
                <div class="form-group">
                  <label for="estimatedLife">Estimated Useful Life</label>
                  <input type="number" name="estimatedLife" class="form-control" id="estimatedLife" placeholder="Years of Service" name="estimatedLife" autocomplete="off" min="1">
                </div>
                <!-- end Estimated Useful Life -->

                
              </div><!-- col-md-3 -->
            <!-- End of Group 1 -->

              <!-- ===============================Group 2=============================== -->
              <div class="col-md-4 vertical-line">
                <div class="form-group">
                  <h4 class="box-title" align="center"><b>PROPERTY RETURN SLIP Continuation...</b></h4><br>
                  <div class="horizontal-line"></div>
                </div>

                <!-- Unit of Measure -->
                <div class="form-group">
                  <label for="unitOfMeasure"> Unit of Measure</label>
                  <input type="text" class="form-control" id="unitOfMeasure" placeholder="Unit of Measure" name="unitOfMeasure" autocomplete="off">
                </div>
                <!-- End Unit of Measure -->

                <!-- Accountable Employee -->
                <div class="form-group">
                  <label for="accountablePerson"> Accountable Employee</label>
                  <input type="text" list="accountable_options" class="form-control" id="accountablePerson" placeholder="Accountable Employee" name="accountablePerson" autocomplete="off">
                  <datalist id="accountable_options">
                    <!-- Populate this datalist with options -->
                  </datalist>
                </div>
                <!-- End Accountable Employee -->

                <!-- ARE/MR Number -->
                <div class="form-group">
                  <label for="AREno"> ARE/MR Number</label>
                  <div id="AREno_inputs">
                      <input type="text" class="form-control" id="AREno" placeholder="ARE/MR Number" name="AREno" autocomplete="off">
                  </div>
                </div>
                <!-- End ARE/MR Number -->

                <!-- Serial Number -->
                <div class="form-group">
                  <label for="serialNo"> Serial Number</label>
                  <div id="serialNo_inputs">
                    <textarea type="text" class="form-control" id="serialNo" placeholder="Serial Number" name="serialNo" autocomplete="off"></textarea>
                  </div>
                </div>
                <!-- End Serial Number -->

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
                  <input type="text" class="form-control" id="propertyNo" placeholder="Property Number" name="propertyNo" autocomplete="off">
                </div>
              </div>
              <!-- End Property Number -->

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

              <!-- Remarks -->
              <div class="form-group">
                <label for="remarks"> Remarks</label>
                <textarea type="text" class="form-control" id="remarks" placeholder="Remarks" autocomplete="off"  name="remarks"></textarea>
              </div>
              <!-- Remarks -->

              <!-- IIRUP -->
              <div class="form-group">
                <label for="iirup">IIRUP</label>
                <select class="form-control" name="iirup" id="iirup">
                    <option value="">--- SELECT IIRUP ---</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
              </div>
              <!-- End IIRUP -->

              <!-- IIRUP Date -->
              <div class="form-group">
                <label for="iirupDate"> Date of IIRUP</label>
                <input type="date" class="form-control" id="iirupDate" placeholder="Date Returned" name="iirupDate" autocomplete="off" autocomplete="off">
              </div>
              <!-- End IIRUP Date -->

              <!-- Container for checkboxes -->
              <div class="form-group">
                  <!-- With Attachment -->
                  <div class="checkbox-container">
                      <input type="checkbox" name="withAttachment" class="form-check-input" id="withAttachment">
                      <label class="form-check-label" for="withAttachment">With Attachment</label>
                  </div>
                  
                  <!-- With Cover Page -->
                  <div class="checkbox-container">
                      <input type="checkbox" name="withCoverPage" class="form-check-input" id="withCoverPage">
                      <label class="form-check-label" for="withCoverPage">With Cover Page</label>
                  </div>
              </div>
              <!-- End Container for checkboxes -->



            </div><!-- col-md-3 -->
            <!-- End of Group 2 -->

<!-- ===============================Group 3=============================== -->
            <div class="col-md-4 vertical-line">
              <h4 class="box-title" align="center"><b>MODE OF DISPOSAL</b></h4><br>
              <div class="horizontal-line"></div>

              <div class="form-group">
                  <select id="modeOfDisposalOptions" onchange="ShowSelectedForm()" class="form-control" name="modeOfDisposalOptions">
                    <option value="">--- Select Mode of Disposal ---</option>
                    <option value="By Destruction Or Condemnation">By Destruction or Condemnation</option>
                    <option value="Sold Through Negotiation">Sold Through Negotiation</option>
                    <option value="Sold Through Public Auction">Sold Through Public Auction</option>
                    <option value="Transferred Without Cost"> Transferred Without Cost to Other Offices/Departments, and to Other Agencies</option>
                    <option value="Continued In Service">Continued In Service</option>
                  </select>
                  <br>
                  <!-- =================================================================================== -->
                  <!-- Form for Destroyed Or Thrown -->
                  <div id="form-ByDestructionOrCondemnation" class="additional-info">
                    <div class="form-group">
                      <label for="partDestroyedThrown">Parts Destroyed or Thrown</label>
                      <textarea class="form-control" type="text" name="partDestroyedThrown" id="partDestroyedThrown" placeholder="Part Destroyed Or Thrown" autocomplete="off"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="remarksDestroyed">Remarks</label>
                      <textarea class="form-control" type="text" name="remarksDestroyed" id="remarksDestroyed" placeholder="Remarks" autocomplete="off"></textarea>
                    </div>
                  </div><!-- form-DestroyedOrCondemned -->
                  <!-- =================================================================================== -->
                  <!-- Form for Sold Through Negotiation -->
                  <div id="form-SoldThroughNegotiation" class="additional-info">
                    <div class="form-group">
                      <label for="dateOfSale">Date of Sale</label>
                      <input type="date" name="dateOfSale" id="dateOfSale" placeholder="Date of Sale" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="dateOfORNego">Date of OR</label>
                      <input type="date" name="dateOfORNego" id="dateOfORNego" placeholder="Date of OR" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="ORnumberNego">OR Number</label>
                      <input type="text" name="ORnumberNego" id="ORnumberNego" placeholder="OR Number" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="amountNego">Amount</label>
                      <input type="text" name="amountNego" id="amountNego" placeholder="Amount" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="notesNego">Notes</label>
                      <input type="text" name="notesNego" id="notesNego" class="form-control" autocomplete="off" placeholder="Notes">
                    </div>
                  </div><!-- form-SoldThroughNegotiation -->
                  <!-- =================================================================================== -->
                  <div id="form-SoldThroughPublicAuction" class="additional-info">
                    <div class="form-group">
                      <label for="dateOfAuction">Date of Auction</label>
                      <input type="date" name="dateOfAuction" id="dateOfAuction" placeholder="Date of Auction" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="dateOfORAuction">Date of OR</label>
                      <input type="date" name="dateOfORAuction" id="dateOfORAuction" placeholder="Date of OR" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="ORnumberAuction">OR Number</label>
                      <input type="text" name="ORnumberAuction" id="ORnumberAuction" placeholder="OR Number" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="amountAuction">Amount</label>
                      <input type="text" name="amountAuction" id="amountAuction" placeholder="Amount" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="notesAuction">Notes</label>
                      <input type="text" name="notesAuction" id="notesAuction" class="form-control" autocomplete="off" placeholder="Notes">
                    </div>
                  </div><!-- form-SoldThroughPublicAuction -->
                  <!-- =================================================================================== -->
                  <!-- Form for Transferred Without Cost -->
                  <div id="form-TransferredWithoutCost" class="additional-info">
                    <div class="form-group">
                      <label for="transferDateWithoutCost">Date of Transfer (Without Cost)</label>
                      <input type="date" name="transferDateWithoutCost" id="transferDateWithoutCost" placeholder="Date of Transfer (Without Cost)" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="recipientTransfer">Recipient (Name of Office/Agency/Institution)</label>
                      <input type="text" name="recipientTransfer" id="recipientTransfer" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="notesTransfer">Notes</label>
                      <input type="text" name="notesTransfer" id="notesTransfer" class="form-control" autocomplete="off">
                    </div>
                  </div><!-- form-TransferredWithoutCost -->
                  <!-- =================================================================================== -->
                  <!-- Form for Continued In Service -->
                  <div id="form-ContinuedInService" class="additional-info">
                    <div class="form-group">
                      <label for="transferDateContinued">Date of Transfer (Continued In Service)</label>
                      <input type="date" name="transferDateContinued" id="transferDateContinued" placeholder="Date of Transfer (Continued In Service)" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="recipientContinued">Recipient (Name of Office/Agency/Institution)</label>
                      <input type="text" name="recipientContinued" id="recipientContinued" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                      <label for="notesContinued">Notes</label>
                      <input type="text" name="notesContinued" id="notesContinued" class="form-control" autocomplete="off">
                    </div>
                  </div><!-- form-ContinuedInService -->

              </div><!-- form group -->
              <br><br><br><br><br>
              <div class="horizontal-line"></div>
              <!-- ========================================================================= -->
              <!-- UPDATES OR CURRENT STATUS -->
              <div class="form-group">
                  <h4 class="box-title" align="center"><b>UPDATES OR CURRENT STATUS</b></h4><br>
                  <div class="horizontal-line"></div>

                  <div id="updatesOrCurrentStatus">
                      <select id="updatesCurrentStatus" onchange="ShowSelectedUpdate()" class="form-control" name="updatesCurrentStatus">
                          <option value="">--- Select Updates/Current Status ---</option>
                          <option value="Dropped In Both Records">Dropped In Both Records</option>
                          <option value="Existing In Inventory Report">Existing In Inventory Report</option>
                      </select>
                      <br>
                      
                      <!-- ========================================================================= -->
                      <!-- Form for Dropped In Both Records -->
                      <div id="form-DroppedInBothRecords" class="updates-currentStatus">
                          <div class="form-group">
                              <label for="jevNoDropped">JEV Number (Upon Disposal)</label>
                              <input type="text" name="jevNoDropped" id="jevNoDropped" class="form-control" autocomplete="off">
                          </div>

                          <div class="form-group">
                              <label for="dateDropped">Date</label>
                              <input type="date" name="dateDropped" id="dateDropped" class="form-control" autocomplete="off">
                          </div>

                          <div class="form-group">
                              <label for="notesDropped">Notes</label>
                              <input type="text" name="notesDropped" id="notesDropped" class="form-control" autocomplete="off">
                          </div>
                      </div><!-- form-DroppedInBothRecords -->

                      <!-- Form for Existing In Inventory Report -->
                      <div id="form-ExistingInInventoryReport" class="updates-currentStatus">
                          <div class="form-group">
                              <label for="remarksExisting">Remarks</label>
                              <input type="text" name="remarksExisting" id="remarksExisting" class="form-control" autocomplete="off" value="For further monitoring">
                          </div>
                      </div><!-- form-ExistingInInventoryReport -->
                  </div>
                  </div><!-- form-group -->
              </div><!-- col-md-4 -->
              <!-- End of Group 3 -->

            </div><!-- row-flex -->

            <!-- Add ARE Registry Save button -->
            <div class="form-group" align="center" >
              <button type="button" class="btn btn-primary" name="savePRS" id="savePRS">Add PRS</button>
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
        
        // Format the value with commas for thousandths place and two decimal places
        var formattedValue = floatValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        // Update the input value
        input.value = formattedValue;
    }
</script>
<!-- End of Script for the validation of unit value input -->

<!-- Script for the dynamic addition of input fields for accountablePerson, AREno, serialNo, propertyNo -->
  <script type="text/javascript">
      var dynamicInputCounts = {
          accountablePerson: 1,
          AREno: 1,
          serialNo: 1,
          propertyNo: 1
      };

      function toggleAdditionalInfo(inputId, addInput) {
          var inputContainer = document.getElementById(inputId + '_inputs');
          var placeholderText = "";

          switch (inputId) {
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
              // Increment count for this input type
              dynamicInputCounts[inputId]++;

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
              newInput.setAttribute('name', inputId + dynamicInputCounts[inputId]); // Set unique name attribute

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
        document.getElementById("savePRS").addEventListener("click", function() {
            // You can add validation or additional logic here before submitting the form
            document.getElementById('addPRSform').submit();
            
            // Alternatively, you can use AJAX to submit the form data
            var form = document.getElementById("addPRSform");
            var formData = new FormData(form);

            // Send form data to the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "savePRS.php", true);
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
        document.getElementById("savePRS").addEventListener("click", function() {
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
            xhr.open("POST", "savePRS.php", true);
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

  <!-- script for fetching employees names based on the selected office -->
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

  <script>
    function ShowSelectedForm() {
      // Get the selected value from the dropdown
      var selectedOption = document.getElementById("modeOfDisposalOptions").value;

      // Hide all additional-info divs
      var additionalInfos = document.getElementsByClassName("additional-info");
      for (var i = 0; i < additionalInfos.length; i++) {
        additionalInfos[i].style.display = "none";
      }

      // Show the selected additional-info div
      if (selectedOption) {
        var selectedAdditionalInfo = document.getElementById("form-" + selectedOption.replace(/\s+/g, ''));
        if (selectedAdditionalInfo) {
          selectedAdditionalInfo.style.display = "block";
        }
      }
    }

    function ShowSelectedUpdate() {
        // Get the selected value from the dropdown
        var selectedUpdate = document.getElementById("updatesCurrentStatus").value;

        // Hide all updates-currentStatus divs
        var updatesCurrentStatus = document.getElementsByClassName("updates-currentStatus");
        for (var i = 0; i < updatesCurrentStatus.length; i++) {
          updatesCurrentStatus[i].style.display = "none";
        }

        // Show the selected updates-currentStatus div
        if (selectedUpdate) {
          var selectedUpdateDiv = document.getElementById("form-" + selectedUpdate.replace(/\s+/g, ''));
          if (selectedUpdateDiv) {
            selectedUpdateDiv.style.display = "block";
          }
        }
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
