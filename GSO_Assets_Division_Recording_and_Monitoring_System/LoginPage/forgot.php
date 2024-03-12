<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GSO Inventory System</title>
	<meta content="" name="keywords">
	<meta content="" name="description">

	<!-- Favicons -->
	<link href="img/baguiologo.png" rel="icon">
	<link rel="apple-touch-icon" href="img/baguiologo.png">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet">

	<!-- Bootstrap CSS File -->
	<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Libraries CSS Files -->
	<link href="lib/nivo-slider/css/nivo-slider.css" rel="stylesheet">
	<link href="lib/owlcarousel/owl.carousel.css" rel="stylesheet">
	<link href="lib/owlcarousel/owl.transitions.css" rel="stylesheet">
	<link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="lib/animate/animate.min.css" rel="stylesheet">
	<link href="lib/venobox/venobox.css" rel="stylesheet">

	<!-- Main Stylesheet File -->
	<link href="css/style.css" rel="stylesheet">

	<!-- Responsive Stylesheet File -->
	<link href="css/responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="../dist/css/fullcalendar.min.css">
	
</head>
<body data-spy="scroll" data-target="#navbar-example">
	<div id="preloader"></div>

	<header><!-- Header Area Start -->
		<div id="sticker" class="header-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<nav class="navbar navbar-default"><!-- Start Navbar -->
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expandded="false">
									<span class="sr-only"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a href="login.php" class="navbar-brand sticky-logo">
									<h1><img src="img/baguiologo.png" alt="" title="" style="height:60px; width:60px"><span style="color:#5f07db;">GSO</span> Assets</h1>
								</a>
							</div>
							<div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
								<ul class="nav navbar-nav navbar-right">
									<li class="active">
										<a href="#home" class="page-scroll">Home</a>
									</li>
									<li class="page-scroll" href="#forgot">Forgot Password</li>
								</ul>
							</div>
						</nav><!-- Navbar End -->
					</div>
				</div>
			</div>
		</div>
	</header><!-- Header Area End -->
	<div id="forgot" class="about-area area-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="section-headline text-center">
						<h2>FORGOT PASSWORD</h2>
					</div>
				</div>
			</div>
			<form method="POST" autocomplete="off">
				<div class="form contact-form">
					<div class="form-group">
						<input type="text" name="employeeid" class="form-control" id="employeeid" placeholder="Please Enter your Employee ID..." data-rule="minlen:4" data-msg="Please enter a valid Employee ID">
						<div class="validation">
							<div class="text-center">
								<button class="submit" name="btn-submit">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form><br>
			<?php
				$connect = mysqli_connect("localhost", "root", "","db_gso");
				$query = "SELECT * FROM user WHERE employeeid=?";
				$pre_stmt = $connect ->prepare($query) or die(msqli_error());
				$pre_stmt->bind_param('i', $_POST['employeeid']);
				$pre_stmt->execute();
				$result = $pre_stmt->get_result();
				$rows = mysqli_fetch($result);

				if (isset($_POST['btn_submit'])) {
					if (mysqli_num_ros($result) > 0) {
						$id = ($_POST['employeeid']);
						if (($rows['question1'] == NULL and $rows['answer1'] == NULL) AND ($rows['question2'] == NUll and $rows['answer2'] == NULL)) {
							echo '<script language="javascript">';
							echo 'alert("You Dont Have Security Question Please Login with default password and change it!!!")';
							echo '</script>';
						}else{
							echo '<script type="text/javascript">window.location = "forgotpassword.php?idnumber='.$id.'#forgotpass"</script>';
						}
					}else{
						echo '<script language="javascript">';
						echo 'alert("User ID/ID No. Not Found!!!")';
						echo '</script>';
					}
				}
			?>
			<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
		</div>
	</div>
<footer>
	<div class="footer-area-bottom">
		<div class="container"></div>
	</div>
</footer>

</body>
</html>