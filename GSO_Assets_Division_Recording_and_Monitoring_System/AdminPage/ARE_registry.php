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
      border-left: 3px solid #ddd;
      padding-left: 10px; /* Adjust the padding based on your design */
      padding-right: 10px; /* Adjust the padding based on your design */
    }
    .horizontal-line {
      border-top: 3px solid lightblue;
      margin-top: 10px; /* Adjust the margin based on your design */
      margin-bottom: 10px; /* Adjust the margin based on your design */
    }
    textarea {
      width: 100%;
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
        <h1>ARE REGISTRY
          <small>Registry of New ARE-Issued PPE</small>
        </h1>
      </section><!-- <section class="content-header"> -->

      <!-- Main Content -->
      <section class="content container-fluid">
        <div class="box">
          <div class="box-header bg-blue" align="center">
            <h4 class="box-title">ARE-ISSUED PROPERTY, PLANT AND EQUIPMENT</h4><br>
          </div><!-- <div class="box-header bg-blue" align="center"> -->

        <!-- Container Fluid for the Registry Form -->
        <form method="POST" action="" enctype="multipart/form-data" id="AddNewAREregistry">
          <div class="box-body">
            <div class="row">

              <?php include ("./addNewARE.php") ?>
              <?php include ("./AREaddAdditionalDetails.php") ?>
              <?php include ("./AREreconciliation.php") ?>
            
              <!-- ARE Registry Button -->
              <div class="col-md-12">
                <div class="form-group" align="center">
                  <button type="button" class="btn btn-primary" name="saveARE" id="saveARE">SAVE ARE</button>
                </div>
              </div>
            </div><!-- row -->
          </div><!-- <div class="box-body"> -->
        </form><!-- <form method="POST" action="" enctype="multipart/form-data" id="AddNewAREregistry"> -->
        </div><!-- <div class="box"> -->
      </section><!-- <section class="content container-fluid"> -->
    </div><!-- <div class="content-wrapper"> -->
  </div><!-- <div class="wrapper"> -->

<!-- Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">General Services Office - Asset Division: Recording and Monitoring System</a>.</strong> All rights reserved
  </footer>


  <!-- jQuery 2.2.3 -->
  <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <!-- <script src="../dist/js/app.min.js"></script> -->
  <script src="../plugins/slimScroll/jquery.slimscroll.js"></script>
  
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

  <script>
      $(document).ready(function() {
          // Function to add a new row
          $(".add-row").click(function() {
              var newRow = '<tr>' +
                  '<td><input type="text" class="form-control" name="accountablePerson[]" autocomplete="off" list = "accountable_options"><datalist id="accountable_options"></datalist></td>' +
                  '<td><input type="text" class="form-control" name="AREno[]" autocomplete = "off"></td>' +
                  '<td><textarea type="text" class="form-control" name="serialNo[]" autocomplete="off" style="resize: vertical; height: 2.4em;"></textarea></td>' +
                  '<td><input type="text" class="form-control" name="propertyNo[]" autocomplete = "off"></td>' +
                  '<td><input type="text" class="form-control" name="location[]" autocomplete = "off"></td>' +
                  '<td><button type="button" class="btn btn-danger remove-row">X</button></td>' +
                  '</tr>';
              $('#dynamicFields tbody').append(newRow);
          });

          // Function to remove a row
          $(document).on('click', '.remove-row', function() {
              $(this).closest('tr').remove();
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
</body>