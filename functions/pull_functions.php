 <?php
	if(!isset($_SESSION['imonggo_token'])){
		header("Location:../index.php");
	}
	//---------------------------- Function for pulling imonggo products ------------------------------//
	function pull_imonggo($url_imonggo, $imonggo_username, $imonggo_password){
		$options = array(
			CURLOPT_HTTPAUTH  	   => CURLAUTH_BASIC,
			CURLOPT_USERPWD		   => $imonggo_username . ":" . $imonggo_password,
			CURLOPT_RETURNTRANSFER => true,   // return web page
			CURLOPT_HEADER         => false,  // don't return headers
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
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
		return $content;
	}
	//---------------------------- Function for pulling shopify customers and invoices ------------------------------//
	function pull_shopify($url_shopify, $http_header_pull){
		$options = array(
			CURLOPT_HTTPHEADER => $http_header_pull,
			CURLOPT_RETURNTRANSFER => true,   // return web page
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
			CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
			CURLOPT_ENCODING       => "",     // handle compressed
			CURLOPT_USERAGENT      => "test", // name of client
			CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
			CURLOPT_CONNECTTIMEOUT => 520,    // time-out on connect
			CURLOPT_TIMEOUT        => 520,    // time-out on response
			CURLOPT_SSL_VERIFYPEER => false
		); 
		$ch = curl_init($url_shopify);
		curl_setopt_array($ch, $options);
		$content = simplexml_load_string(curl_exec($ch));
		curl_close($ch);
		return $content;
	}
?>