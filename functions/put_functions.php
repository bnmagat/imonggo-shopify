<?php
	if(!isset($_SESSION['imonggo_token'])){
		header("Location:../index.php");
	}
	//---------------------------- Function for updating shopify products ------------------------------//
	function put_shopify($url_shopify, $json, $http_header_post){
		$options = array(
			CURLOPT_HTTPHEADER	   => $http_header_post,
			CURLOPT_RETURNTRANSFER => true,   // Will return the response, if false it print the response
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
			CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
			CURLOPT_ENCODING       => "",     // handle compressed
			CURLOPT_USERAGENT      => "test", // name of client
			CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
			CURLOPT_TIMEOUT        => 120,    // time-out on response
			CURLOPT_SSL_VERIFYPEER => false,  // Disable SSL verification
			CURLOPT_CUSTOMREQUEST  => "PUT",
			CURLOPT_POSTFIELDS	   => $json
		);
		$ch = curl_init($url_shopify);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
?>