<?php
	session_start();
	date_default_timezone_set('Asia/Taipei');
	$conn = mysql_connect('localhost','root','');	
	$db = mysql_select_db('imonggo', $conn);
	
	if(!isset($_SESSION['imonggo_token'])){ 
		header("Location:../index.php");
	}
	
?>



<!DOCTYPE html>
<html>
<head>
    <title>Shop at Imongo w/ Shopify!</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">	
  
	<link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="ui.css"/>
	<link rel="stylesheet" href="materialize/icons/css/font-awesome.min.css">
	
    <!-- Bootstrap Core CSS -->
    <link href="finaltouch_package/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Font Awesome CSS -->
	<link href="finaltouch_package/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Animated CSS -->
	<link href="finaltouch_package/css/animate.css" rel="stylesheet" media="screen">
	<!-- Flex Slider CSS -->
	<link href="finaltouch_package/css/flexslider.css" rel="stylesheet"  type="text/css">
	<!-- Main CSS -->
	<link href="finaltouch_package/css/custom.css" rel="stylesheet" media="screen">
	
	
	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
	
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>
  
<body>
<!-- /.javascript files -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>

	<!-- /.preloader -->
<div id="preloader"></div>

  
<div id="top"></div>


								<!-- Modal Structure -->
								<form method="POST">
								  <div id="modal_tagged" class="modal modal-fixed-footer">
									<div class="modal-content" style="color:black;">
										<?php include 'buttons.php';?>
									</div>
									<div class="modal-footer">
									  <button type="submit" name="submit" class="modal-action waves-effect waves-green btn-flat">SUBMIT</button>
									</div>
								  </div>
								 </form>










<!-- service section -->

<div id="service">
	<div class="container">
				<h1>Our <span class="highlight">Service</span></h1>
                <div class="row">		
				<form method="GET">
					<div class="col-md-3 col-sm-3 wow slideInLeft">
						<button type="submit" class="icon-box" name="postProducts">
							<div class="icon-box-icon">
								<i class="fa fa-signal"></i>
							</div>
							<h3>All Products</h3>
							<p>Epsum factorial non deposit quid pro quo hic escorol.Epsum factorial non deposit quid pro.</p>
						</button>
					</div>
					
					<div class="col-md-3 col-sm-3 wow slideInLeft">
						<button type="submit" class="icon-box" name="taggedProducts">
							<div class="icon-box-icon">
								<i class="fa fa-home"></i>
							</div>
							<h3>Selected Products</h3>
							<p>Epsum factorial non deposit quid pro quo hic escorol.Epsum factorial non deposit quid pro.</p>
						</button>
					</div>
				</form>
				
				<form method="GET">	
					<div class="col-md-3 col-sm-3 wow slideInRight">
						<button type="submit" class="icon-box" name="postCustomers">
							<div class="icon-box-icon">
								<i class="fa fa-building"></i>
							</div>
							<h3>Customers</h3>
							<p>Epsum factorial non deposit quid pro quo hic escorol.Epsum factorial non deposit quid pro.</p>
						</button>
					</div>
					
					<div class="col-md-3 col-sm-3 wow slideInRight">
						<button type="submit" class="icon-box" name="postInvoices">
							<div class="icon-box-icon">
								<i class="fa fa-th"></i>
							</div>
							<h3>Invoices</h3>
							<p>Epsum factorial non deposit quid pro quo hic escorol.Epsum factorial non deposit quid pro.</p>
						</button>
					</div>
				</form>
				
                </div><!-- .row -->
            </div><!-- .container -->
</div>
<!-- /.service section -->




<!-- /.footer -->
<footer id="footer">
	<div class="container">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<a href="#top"><i class="fa fa-arrow-up scroll-top text-center"></i></a>
			<br/>
			Copyright <a target="_blank" href="http://www.Themelan.com/">Themelan</a> 2014 | <a href="logout.php"> Logout </a>
		</div>	
	</div>	
</footer>
	
	

	<!-- jQuery Library -->
    <script type="text/javascript" src="finaltouch_package/js/jquery.js"></script>
	<!-- Bootstrap Core JS -->
    <script type="text/javascript" src="finaltouch_package/js/bootstrap.min.js"></script>
	<!-- CountDown JS -->
    <script type="text/javascript" src="finaltouch_package/js/jquery.downCount.js"></script>
	<!-- Smooth Scroll JS -->
	<script type="text/javascript" src="finaltouch_package/js/smoothscroll.js"></script>
	<!-- Flex slider JS -->
	<script type="text/javascript" src="finaltouch_package/js/jquery.flexslider-min.js"></script>
	<!-- Feature text Flip sliding JS -->
	<script type="text/javascript" src="finaltouch_package/js/slide.text.js"></script>
	<!-- Animation JS -->
	<script type="text/javascript" src="finaltouch_package/js/wow.min.js"></script>
	<!-- Custom script -->
    <script type="text/javascript" src="finaltouch_package/js/custom.js"></script>
	
	
	<script type="text/javascript">
		new WOW().init();
	</script>
	
	
	<script type="text/javascript">
		$(function() {
			$('a[href*=#]:not([href=#])').click(function() {
				if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

					var target = $(this.hash);
					target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
					if (target.length) {
						$('html,body').animate({
							scrollTop: target.offset().top
						}, 1000);
						return false;
					}
				}
			});
		});
    </script>
	
	
  </body>
</html>