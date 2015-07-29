<?php
	session_start();
	if(isset($_SESSION['imonggo_token'])){
		header("Location:interface/home.php");
	}

	if(isset($_POST['login'])){
		$id = $_POST['id'];
		$email =  $_POST['email'];
		$pass =  $_POST['pass'];
		$_SESSION['id'] = $id;
		$_SESSION['email'] = $email;
		$_SESSION['pass'] = $pass;
		
		$shopify_shop_name = $_POST['shopify_shop_name'];
		$X_Shopify_Access_Token = $_POST['X_Shopify_Access_Token'];
		$_SESSION['shopify_shop_name'] = $shopify_shop_name;
		$_SESSION['X_Shopify_Access_Token'] = $X_Shopify_Access_Token;
		
		$url_imonggo = 'https://' .$id. '.c3.imonggo.com/api/tokens.xml?email='.$email.'&password='.$pass;
		imonggo_login($url_imonggo);
	}
	//---------------------------- Function for pulling imonggo_token ------------------------------//
	function imonggo_login($url_imonggo){
		$http_header = array(
			'Content-Type: application/xml',
			'Accept: application/xml'
		);
		$options = array(
			CURLOPT_HTTPHEADER 	   => $http_header,
			CURLOPT_RETURNTRANSFER => true,   // return web page
			CURLOPT_HEADER         => false,  // don't return headers
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
			CURLOPT_FAILONERROR	   => 1,
			CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
			CURLOPT_ENCODING       => "",     // handle compressed
			CURLOPT_USERAGENT      => "test", // name of client
			CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
			CURLOPT_TIMEOUT        => 120,    // time-out on response
			CURLOPT_SSL_VERIFYPEER => false
		); 
		$ch = curl_init($url_imonggo);
		curl_setopt_array($ch, $options);
		$content = simplexml_load_string(curl_exec($ch));
		curl_close($ch);
		
		if($content != null){ // content holds the api_token
			$_SESSION['imonggo_token'] = (string)$content->api_token;
			header("Location:interface/home.php");
		}else{
			echo '<script language="javascript">';
			echo 'alert("Invalid username or password!")';
			echo '</script>';  
		}
	}
	
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login to ShopImonggo</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">	
    
	
    <!-- Bootstrap Core CSS -->
    <link href="interface/finaltouch_package/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Font Awesome CSS -->
	<link href="interface/finaltouch_package/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Animated CSS -->
	<link href="interface/finaltouch_package/css/animate.css" rel="stylesheet" media="screen">
	<!-- Flex Slider CSS -->
	<link href="interface/finaltouch_package/css/flexslider.css" rel="stylesheet"  type="text/css">
	<!-- Main CSS -->
	<link href="interface/finaltouch_package/css/custom.css" rel="stylesheet" media="screen">
	
	
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

<div id="top"></div>

<!-- /.parallax full screen background image -->
<div class="fullscreen landing parallax" style="background-image:url('interface/finaltouch_package/images/banner.jpg');" data-img-width="1586" data-img-height="892" data-diff="100">
	
	<div class="overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
				
					<!-- /.logo -->
					<div class="logo wow fadeInDown"> <h1>Shopify - Imonggo</h1></div>
						<!-- /.main title -->
						<div id="home-slider" class="flexslider">			
							<ul class="slides styled-list">
							
								<li class="home-slide"><p class="home-slide-content">Shop at <span class="highlight">Imonggo</span> </p></li>
								
								<li class="home-slide"><p class="home-slide-content">Shop at <span class="highlight">Shopify</span> </p></li>
								
								<li class="home-slide"><p class="home-slide-content"><span class="highlight">Shopify</span> & <span class="highlight">Imonggo</span></p></li>
							
							</ul>
					   </div><!-- END FLEXSLIDER -->

					<!-- /.count down timer -->	
					<ul class="countdown">
						<li>
							<div class="numb wow fadeInUp">
							<span class="days">00</span>
							<p class="days_ref">days</p>
							</div>
						</li>
						<li>
							<div class="numb wow fadeInUp">
							<span class="hours">00</span>
							<p class="hours_ref">hours</p>
							</div>
						</li>
						<li>
							<div class="numb wow fadeInUp">
							<span class="minutes">00</span>
							<p class="minutes_ref">minutes</p>
							</div>
						</li>
						<li>
							<div class="numb wow fadeInUp">
							<span class="seconds">00</span>
							<p class="seconds_ref">seconds</p>
							</div>
						</li>
					</ul>			  
				  
					<!-- /.header paragraph -->
					<div class="working">
						We are working on our new project. <br/>Subscribe to get notified when we launch!
					</div>				  
	
					<!-- /.header menu -->
					<div class="more wow fadeInLeft">
						<a href="#feature" class="btn option"><i class="fa fa-apple"></i>Features</a>
						<a href="#subscribe" class="btn option"><i class="fa fa-send"></i>Subscribe</a>
						<a href="#contact" class="btn option"><i class="fa fa-map-marker"></i>Login</a>
						<a href="#service" class="btn option"><i class="fa fa-map-marker"></i>Service</a>
					</div>			  

				</div> 
			</div>
		</div> 
	</div> 
</div>






<!-- /.contact section -->
<div id="contact">

	<div class="container">
		<h1>Login <span class="highlight">Information</span></h1>
		<div class="row contact-row">
		
			<!-- /.address and contact -->
			<div class="col-sm-5 contact-left wow fadeInUp">
				<h2><span class="highlight">Touch </span> with us</h2>
					<ul class="ul-address">
					<li><i class="fa fa-map-marker"></i>Office # 38, Elizebth Street, Famous City Newyork, <br/>
					USA 33026
					</li>
					<li><i class="fa fa-mobile"></i>+1 (123) 123-7890<br/>
					+2 (123) 345-7845
					</li>
					<li><i class="fa fa-edit"></i>info@example.com</li>
					<li><i class="fa fa-link"></i>www.example.com</li>
					</ul>	
				
			</div>
			
			<!-- /.contact form -->
			<div class="col-sm-7 contact-right wow fadeInUp">
					<form method="POST" id="contact-form" class="form-horizontal">
				
						<div class="form-group">
							<input class="form-control" name="id" type="text" placeholder="Account ID" required/>
						</div>
						<div class="form-group">
							<input class="form-control" name="email" type="text" placeholder="Email" required/>
						</div>		
						<div class="form-group">
							<input class="form-control" name="pass" type="password" placeholder="Password" required/>
						</div>	
						
						<hr>
						
						<div class="form-group">
							<input class="form-control" type="text" name="shopify_shop_name" placeholder="Shopify Name" required/>
						</div>
						<div class="form-group">
							<input class="form-control" type="text" name="X_Shopify_Access_Token" placeholder="X-Shopify-Access-Token" required/>
						</div>
						<div class="form-group">
							<input type="hidden" name="save" value="contact-form">
							<button class="btn btn-success" name="login" id="login" type="submit">Submit</button>		
						</div>
					</form>		
	
			</div>
		</div>
	</div>
</div>		



<!-- /.footer -->
<footer id="footer" style="background-image:url('interface/finaltouch_package/images/footer.jpg');margin-top:1%;">
	<div class="container">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<a href="#top"><i class="fa fa-arrow-up scroll-top text-center" style="background-color:#f86166;color:white;"></i></a>
			<br/>
			Copyright Themelan 2014. Template by <a target="_blank" href="http://www.Themelan.com/">Themelan</a>
		</div>	
	</div>	
</footer>
	
	<!-- /.javascript files -->
	
	<!-- jQuery Library -->
    <script type="text/javascript" src="interface/finaltouch_package/js/jquery.js"></script>
	<!-- Bootstrap Core JS -->
    <script type="text/javascript" src="interface/finaltouch_package/js/bootstrap.min.js"></script>
	<!-- CountDown JS -->
    <script type="text/javascript" src="interface/finaltouch_package/js/jquery.downCount.js"></script>
	<!-- Smooth Scroll JS -->
	<script type="text/javascript" src="interface/finaltouch_package/js/smoothscroll.js"></script>
	<!-- Flex slider JS -->
	<script type="text/javascript" src="interface/finaltouch_package/js/jquery.flexslider-min.js"></script>
	<!-- Feature text Flip sliding JS -->
	<script type="text/javascript" src="interface/finaltouch_package/js/slide.text.js"></script>
	<!-- Animation JS -->
	<script type="text/javascript" src="interface/finaltouch_package/js/wow.min.js"></script>
	
	<!-- Custom script -->
    <script type="text/javascript" src="interface/finaltouch_package/js/custom.js"></script>
	
	
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