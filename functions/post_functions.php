<?php
	if(!isset($_SESSION['imonggo_token'])){
		header("Location:../index.php");
	}
	//---------------------------- Function for posting products to shopify ------------------------------//
	function post_shopify($url_shopify, $json, $http_header_post){
		$options = array(
			CURLOPT_HTTPHEADER	   => $http_header_post,
			CURLOPT_RETURNTRANSFER => true,   // Will return the response, if false it will print the response
			CURLOPT_HEADER         => false,  // don't return headers			
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
			CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
			CURLOPT_ENCODING       => "",     // handle compressed
			CURLOPT_USERAGENT      => "test", // name of client
			CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
			CURLOPT_TIMEOUT        => 120,    // time-out on response
			CURLOPT_SSL_VERIFYPEER => false,  // Disable SSL verification
			CURLOPT_POST		   => true,
			CURLOPT_POSTFIELDS	   => $json
		);
		$ch = curl_init($url_shopify);
		curl_setopt_array($ch, $options);
		$result  = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	//---------------------------- Function for posting customers and invoices to imonggo ------------------------------//
	function post_imonggo($url_imonggo, $xml, $imonggo_username, $imonggo_password){
		$http_header = array(
			'Content-Type: application/xml; charset=UTF-8',
			'Accept: application/xml'
		);
		$options = array(
			CURLOPT_HTTPAUTH  	   => CURLAUTH_BASIC,
			CURLOPT_USERPWD		   => $imonggo_username . ":" . $imonggo_password,
			CURLOPT_RETURNTRANSFER => true,   // Will return the response, if false it will print the response
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
			CURLOPT_MAXREDIRS      => 20,     // stop after 20 redirects
			CURLOPT_ENCODING       => "",     // handle compressed
			CURLOPT_USERAGENT      => "test", // name of client
			CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
			CURLOPT_TIMEOUT        => 120,    // time-out on response
			CURLOPT_SSL_VERIFYPEER => false,  // Disable SSL verification
			CURLOPT_POST		   => true,
			CURLOPT_HTTPHEADER	   => $http_header,
			CURLOPT_POSTFIELDS	   => $xml
		);
		$ch = curl_init($url_imonggo);
		curl_setopt_array($ch, $options);
		$result = simplexml_load_string(curl_exec($ch));
		curl_close($ch);
		return $result;
	}
?>