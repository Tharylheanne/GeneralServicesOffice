<?php
include_once("../database/constants.php");

if (isset($_SESSION['employeeid'])) {
	if ($_SESSION['permission']=='Administrator'){
		header('Location: ../admin_page/dashboard.php');
	}elseif ($_SESSION['permission']=='Employee') {
		header('Location: ../user_page/dashboard.php');
	}
}

?>
<!doctype html>
<html lang ="en">
<head>
	<meta charset="utf-8">
	<title>GSO Assets Inventory System</title>
	<meta content="width-device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="keywords">
	<meta content="" name="description">

	<!-- Favicons -->
	<link  href="img/baguiologo.png" rel="icon">

	<!-- Google Fonts -->
	<link rel="stylesheet" href="https://fonts.googlapis.com/css?
	family-Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900">

	<!-- Bootstrap CSS File -->
	<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

	<!-- Main Stylesheet File -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Responsive Stylesheet File -->
	<link rel="stylesheet" href="responsive.css">
	<link rel="stylesheet" href="../dist/css/fullcalendar.min.css">

</head>
<body data-spy="scroll" data-target="#navbar-example">
	<div id="preloader"></div>

<!-- Header Area Start -->
	<header>
		<div id="sticker" class="header-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<!-- Navigation Start -->
						<nav class="navbar navbar-default">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
									<span class="sr-only">Toggle Navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<!-- Navigation Title -->
								<a class="navbar-brand page-scroll sticky-logo" href="login.php">
									<h1 style="color:#000000;">
										<img src="img/baguiologo.png" title="" alt="" style="height:70px; width: 70px;">
										<span style="color:#000000;"><i>GSO</i></span> ASSETS</h1>
								</a>
							</div>
							<!-- Collexct the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
								<ul class="nav navbar-nav navbar-right">
									<li>
									<br>
								
									<form id="logins" class="form-inline" name="logins" autocomplete="off" role="form" action="do_login.php" method="post">
									<div class="form-group">
										<input type="text" name="employeeid" class="form-control" id="employeeid" placeholder="Enter Employee ID..." data-rule="mainlen:4" data-msg="Please enter at least 4 characters" pattern="\d*" required>
										<div class="validation"></div>
									</div>
									<div class="form-group">
										<input type="password" name="password" class="form-control" id="password" placeholder="Enter Password..." data-rule="mainlen:4" data-msg="Please enter at least 4 characters" required>
										<div class="validation"></div>
									</div>
									<button type="submit" class="btn" name="btn_login" id="btn_login">LOG IN</button>
									</form>
								<a href="forgot.php?#forgot" style="padding:5px;" class="pull-right"><small>Forgot Password</small></a>
								</li></ul>
							</div>
						</nav>
						<!-- END NAVIGATION -->
					</div>
				</div>
			</div>
		</div>

	</header>
	<!-- HEADER AREA END -->
	<!-- Footer Start -->
	<footer></footer>
	<!-- Footer End -->
	<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
	<!-- Javascript Libraries -->
	<script src="lib/jquery/jquery.min.js"></script>
	<script src="lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="lib/appear/jquery.appear.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>
	<!-- Contact Form JavaScript File -->
	<script src="js/main.js"></script>
		<script src="../dist/js/moment.min.js"></script>

</body>
</html>