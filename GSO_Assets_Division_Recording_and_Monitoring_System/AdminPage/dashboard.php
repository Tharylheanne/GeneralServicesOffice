<?php
require('./../database/connection.php');
require('../loginPage/login_session.php');

// Query to get counts
/*$query_active_ppe = "SELECT COUNT(*) AS active_ppe_count FROM ppe_table WHERE status = 'Active'";
$query_active_semi_expendable_ppe = "SELECT COUNT(*) AS active_semi_expendable_ppe_count FROM ppe_table WHERE status = 'Active Semi-Expendable'";
$query_returned_ppe = "SELECT COUNT(*) AS returned_ppe_count FROM ppe_table WHERE status = 'Returned'";
$query_with_prs_ppe = "SELECT COUNT(*) AS with_prs_ppe_count FROM ppe_table WHERE status = 'With PRS'";

$result_active_ppe = mysqli_query($conn, $query_active_ppe);
$result_active_semi_expendable_ppe = mysqli_query($conn, $query_active_semi_expendable_ppe);
$result_returned_ppe = mysqli_query($conn, $query_returned_ppe);
$result_with_prs_ppe = mysqli_query($conn, $query_with_prs_ppe);

$row_active_ppe = mysqli_fetch_assoc($result_active_ppe);
$row_active_semi_expendable_ppe = mysqli_fetch_assoc($result_active_semi_expendable_ppe);
$row_returned_ppe = mysqli_fetch_assoc($result_returned_ppe);
$row_with_prs_ppe = mysqli_fetch_assoc($result_with_prs_ppe);*/

// Function to generate random color
function getRandomColor() {
    $letters = 'ABCDEF';
    $color = '#';
    for ($i = 0; $i < 6; $i++) {
        $color .= $letters[rand(0, 5)];
    }
    return $color;
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
    <?php include_once("../AdminPage/sidebar/sidebar.php"); ?>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><i class="fa fa-folder-open"></i>
          DASHBOARD
        </h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="box">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> Acknowledgement Receipt for Equipment (ARE) </strong></h3>
                <small>Items costing ₱50,000.00 and above</small>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>

              <!-- Box header -->
            <div class="box-body">
              <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- Anchor tag wrapping the whole box -->
                    <a href="activePPE.php" style="text-decoration: none;">
                        <!-- small box -->
                        <div class="small-box" style="background-color: <?php echo getRandomColor(); ?>;">
                            <div class="inner">
                                <?php
                                // Your database connection code goes here
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "gso_asset";

                                // Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // SQL query to count records
                                $sql = "SELECT COUNT(*) AS recordCount FROM (
                                            SELECT 1
                                            FROM
                                                are_properties ap
                                            LEFT JOIN
                                                are_ics_gen_properties agp ON ap.ARE_ICS_id = agp.ARE_ICS_id
                                            LEFT JOIN
                                                generalproperties gp ON ap.propertyID = gp.propertyID
                                            LEFT JOIN
                                                account_codes ac ON gp.accountNumber = ac.accountNumber
                                            LEFT JOIN
                                                cityoffices co ON gp.officeName = co.officeName
                                            LEFT JOIN
                                                nationaloffices no ON gp.officeName = no.officeName
                                            LEFT JOIN
                                                conditions c ON agp.currentCondition = c.conditionName
                                            WHERE
                                                ((gp.gpremarks IS NULL)
                                                OR (gp.gpremarks NOT LIKE '%with prs%' AND gp.gpremarks NOT LIKE '%with wmr%'))
                                                AND (agp.currentCondition <> 'Returned' OR agp.currentCondition IS NULL)
                                                AND gp.propertyID NOT IN (SELECT propertyID FROM prs_properties)
                                         ) AS temp";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<h4><strong style='font-weight: bold;'>" . $row["recordCount"] . "</strong></h4>";
                                    }
                                } else {
                                    echo "0 results";
                                }

                                // Close connection
                                $conn->close();
                                ?>
                                <p>Active Property, Plant and Equipment (PPE)</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </a>
                </div><!-- class="col-lg-3 col-xs-6 -->

                <div class="col-lg-3 col-xs-6">
                    <!-- Anchor tag wrapping the whole box -->
                    <a href="PRS.php" style="text-decoration: none;">
                        <!-- small box -->
                        <div class="small-box" style="background-color: <?php echo getRandomColor(); ?>;">
                            <div class="inner">
                                <?php
                                // Your database connection code goes here
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "gso_asset";

                                // Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // SQL query to count records
                                $sql = "SELECT COUNT(*) AS recordCount FROM (
                                            SELECT 1
                                            FROM are_properties ap
                                            LEFT JOIN generalproperties gp ON ap.propertyID = gp.propertyID
                                            LEFT JOIN are_ics_gen_properties agp ON ap.ARE_ICS_id = agp.ARE_ICS_id
                                            LEFT JOIN prs_properties prs ON gp.propertyID = prs.propertyID
                                            LEFT JOIN prs_wmr_gen_properties pwgp ON gp.propertyID = pwgp.propertyID
                                            LEFT JOIN account_codes ac ON gp.accountNumber = ac.accountNumber
                                            LEFT JOIN cityoffices co ON gp.officeName = co.officeName
                                            LEFT JOIN nationaloffices no ON gp.officeName = no.officeName
                                            LEFT JOIN conditions c ON agp.currentCondition = c.conditionName
                                            LEFT JOIN mode_of_disposal disposal ON prs.prsID = disposal.prsID
                                            LEFT JOIN updates_or_status us ON prs.prsID = us.prsID
                                            WHERE 
                                                ((gp.gpremarks LIKE '%with prs%')
                                                    OR (agp.currentCondition = 'Returned'))
                                                OR (prs.propertyID IN (SELECT propertyID FROM generalproperties))
                                         ) AS temp";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<h4><strong style='font-weight: bold;'>" . $row["recordCount"] . "</strong></h4>";
                                    }
                                } else {
                                    echo "0 results";
                                }

                                // Close connection
                                $conn->close();
                                ?>
                                <p>Property Return Slip (PRS)</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-clipboard"></i>
                            </div>
                        </div>
                    </a>
                </div><!-- class="col-lg-3 col-xs-6 -->
              </div>
            </div>
          </div><!-- box-primary -->

          <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> Inventory Custodian Slip (ICS) </strong></h3>
                <small>Items costing below ₱50,000.00</small>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>

              <!-- Box header -->
            <div class="box-body">
              <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- Anchor tag wrapping the whole box -->
                    <a href="activeSemiPPE.php" style="text-decoration: none;">
                        <!-- small box -->
                        <div class="small-box" style="background-color: <?php echo getRandomColor(); ?>;">
                            <div class="inner">
                                <?php
                                // Your database connection code goes here
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "gso_asset";

                                // Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // SQL query to count records
                                $sql = "SELECT COUNT(*) AS recordCount FROM (
                                            SELECT 1
                                            FROM
                                                ics_properties ip
                                            LEFT JOIN
                                                are_ics_gen_properties agp ON ip.ARE_ICS_id = agp.ARE_ICS_id
                                            LEFT JOIN
                                                generalproperties gp ON ip.propertyID = gp.propertyID
                                            LEFT JOIN
                                                account_codes ac ON gp.accountNumber = ac.accountNumber
                                            LEFT JOIN
                                                cityoffices co ON gp.officeName = co.officeName
                                            LEFT JOIN
                                                nationaloffices no ON gp.officeName = no.officeName
                                            LEFT JOIN
                                                conditions c ON agp.currentCondition = c.conditionName
                                            WHERE
                                                ((gp.gpremarks IS NULL)
                                                OR (gp.gpremarks NOT LIKE '%with prs%' AND gp.gpremarks NOT LIKE '%with wmr%'))
                                                AND (agp.currentCondition <> 'Returned' OR agp.currentCondition IS NULL)
                                                AND gp.propertyID NOT IN (SELECT propertyID FROM wmr_properties)
                                         ) AS temp";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<h4><strong style='font-weight: bold;'>" . $row["recordCount"] . "</strong></h4>";
                                    }
                                } else {
                                    echo "0 results";
                                }

                                // Close connection
                                $conn->close();
                                ?>
                                <p>Active Semi-Expendable Property, Plant and Equipment</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                        </div>
                    </a>
                </div><!-- class="col-lg-3 col-xs-6 -->

                <div class="col-lg-3 col-xs-6">
                    <!-- Anchor tag wrapping the whole box -->
                    <a href="WMR.php" style="text-decoration: none;">
                        <!-- small box -->
                        <div class="small-box" style="background-color: <?php echo getRandomColor(); ?>;">
                            <div class="inner">
                                <?php
                                // Your database connection code goes here
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "gso_asset";

                                // Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // SQL query to count records
                                $sql = "SELECT COUNT(*) AS recordCount FROM (
                                            SELECT 1
                                            FROM 
                                                ics_properties ip
                                            LEFT JOIN 
                                                are_ics_gen_properties agp ON ip.ARE_ICS_id = agp.ARE_ICS_id
                                            LEFT JOIN 
                                                generalproperties gp ON ip.propertyID = gp.propertyID
                                            LEFT JOIN 
                                                wmr_properties wp ON gp.propertyID = wp.propertyID
                                            LEFT JOIN 
                                                prs_wmr_gen_properties pwgp ON gp.propertyID = pwgp.propertyID 
                                            LEFT JOIN 
                                                account_codes ac ON gp.accountNumber = ac.accountNumber
                                            LEFT JOIN 
                                                cityoffices co ON gp.officeName = co.officeName
                                            LEFT JOIN 
                                                nationaloffices no ON gp.officeName = no.officeName
                                            LEFT JOIN 
                                                conditions c ON agp.currentCondition = c.conditionName
                                            WHERE 
                                                ((gp.gpremarks LIKE '%with wmr%')
                                                OR (agp.currentCondition = 'Returned'))
                                                OR (wp.propertyID IN (SELECT propertyID FROM generalproperties))
                                         ) AS temp";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<h4><strong style='font-weight: bold;'>" . $row["recordCount"] . "</strong></h4>";
                                    }
                                } else {
                                    echo "0 results";
                                }

                                // Close connection
                                $conn->close();
                                ?>
                                <p>Waste Material Report (WMR)</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-compose"></i>
                            </div>
                        </div>
                    </a>
                </div><!-- class="col-lg-3 col-xs-6 -->
              </div>
            </div>
          </div><!-- box-primary -->

          <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> CLEARANCE MASTER LIST </strong></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>

              <!-- Box header -->
            <div class="box-body">
              <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- Anchor tag wrapping the whole box -->
                    <a href="your_link_here" style="text-decoration: none;">
                        <!-- small box -->
                        <div class="small-box" style="background-color: <?php echo getRandomColor(); ?>;">
                            <div class="inner">
                                <h4><strong style="font-weight: bold;">Count Code</strong></h4>
                                <p>Master List</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-done-all"></i>
                            </div>
                        </div>
                    </a>
                </div><!-- class="col-lg-3 col-xs-6 -->
              </div>
            </div>
          </div><!-- box-primary -->
          <div class="card-body">
            <!-- Pie chart canvas -->
            <canvas id="ppeChart" width="400" height="200"></canvas>
          </div>
      </div><!-- box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- Footer content -->
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->
  <!-- jQuery 2.2.3 -->
  <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      // Get the canvas element
      var ctx = document.getElementById('ppeChart').getContext('2d');
      
      // Define data for the chart
      var chartData = {
          labels: ['Active PPE', 'Active Semi-Expendable PPE', 'Returned PPE', 'Returned Semi-Expendable PPE'],
          datasets: [{
              label: 'Count',
              data: [/* Insert your count data here */],
              backgroundColor: [
                  getRandomColor(),
                  getRandomColor(),
                  getRandomColor(),
                  getRandomColor()
              ]
          }]
      };
      
      // Create the pie chart
      var myChart = new Chart(ctx, {
          type: 'pie',
          data: chartData
      });

      // Function to generate random color
      function getRandomColor() {
          var letters = '0123456789ABCDEF';
          var color = '#';
          for (var i = 0; i < 6; i++) {
              color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
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
