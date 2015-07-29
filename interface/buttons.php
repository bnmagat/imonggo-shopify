<?php
	session_start();
	$default = ini_get('max_execution_time');
	set_time_limit(1000);
	
	if(!isset($_SESSION['imonggo_token'])){
		header("Location:../index.php");
	}
	// include all php files here
	include '../functions/pull_functions.php';
	include '../functions/post_functions.php';
	include '../functions/put_functions.php';
	include '../functions/parse.php';
	include '../functions/other_functions.php';
	
	//------------------------------ IMONGGO USER INFO ------------------------------------//
	$imonggo_username = 'e2a91021f232de8e4e58b76fd7cd945a7fc650d0';
	$imonggo_password = 'x';
	$imonggo_account_id = 'sypilimon';
	//------------------------------ SHOPIFY USER INFO ------------------------------------//
	$http_header_pull = array( //needed array for pulling in shopify
			'Content-Type: application/xml;charset=UTF-8',
			'Accept: application/xml',
			'X-Shopify-Access-Token: '.$_SESSION['X_Shopify_Access_Token'].''
			);
	$http_header_post = array( //needed array for posting to shopify
			'Content-Type: application/json;charset=UTF-8',
			'Accept: application/json',
			'X-Shopify-Access-Token: '.$_SESSION['X_Shopify_Access_Token'].''
			);
	
	if(isset($_GET['taggedProducts'])){ //will parse products to filter tags before posting to shopify
		$url_imonggo = 'https://'.$imonggo_account_id.'.c3.imonggo.com/api/products.xml';
		$url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/products.json';
		$pull_url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/products.xml';
		$url_imonggo_inventory = 'https://'.$imonggo_account_id.'.c3.imonggo.com/api/inventories.xml';
		$imonggo_products = pull_imonggo($url_imonggo, $imonggo_username, $imonggo_password); //pull products from imonggo
		$imonggo_inventory = pull_imonggo($url_imonggo_inventory, $imonggo_username, $imonggo_password); //pull inventory for quantity update
		parse($imonggo_products); //will parse products
		post_parsed($imonggo_inventory, $imonggo_products, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify); //post to shopify
	}else if(isset($_GET['postProducts'])){
		$url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/products.json';
		$pull_url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/products.xml';
		$url_imonggo = 'https://'.$imonggo_account_id.'.c3.imonggo.com/api/products.xml';
		$url_imonggo_inventory = 'https://'.$imonggo_account_id.'.c3.imonggo.com/api/inventories.xml';
		$imonggo_products = pull_imonggo($url_imonggo, $imonggo_username, $imonggo_password); //pull products from imonggo
		$imonggo_inventory = pull_imonggo($url_imonggo_inventory, $imonggo_username, $imonggo_password); //pull inventory for quantity update
		modal(); //prints all errors in a modal
		post_product_shopify($imonggo_inventory, $imonggo_products, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify); //post to shopify
	}else if(isset($_GET['postCustomers'])){
		$url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/customers.xml';
		$url_imonggo = 'https://'.$imonggo_account_id.'.c3.imonggo.com/api/customers.xml?active_only=1';
		$customer = pull_shopify($url_shopify, $http_header_pull); //pull customers from shopify
		modal();//prints all errors in a modal
		post_customer_imonggo($customer, $url_imonggo, $imonggo_username, $imonggo_password, $http_header_post);
	}else if(isset($_GET['postInvoices'])){
		$url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/orders.xml';
		$url_imonggo = 'https://'.$imonggo_account_id.'.c3.imonggo.com/api/invoices.xml';
		$invoices = pull_shopify($url_shopify, $http_header_pull); //pull orders from shopify
		modal(); //prints all errors in a modal
		post_invoice_imonggo($invoices, $url_imonggo, $imonggo_username, $imonggo_password); //post invoices to imonggo
	}
	set_time_limit($default);
?>
<script>
	 function checkAll(ele) {
		 var checkboxes = document.getElementsByTagName('input');
		 if (ele.checked) { for (var i = 0; i < checkboxes.length; i++) { if (checkboxes[i].type == 'checkbox') {checkboxes[i].checked = true;}}} 
		 else {for (var i = 0; i < checkboxes.length; i++) { if (checkboxes[i].type == 'checkbox') { checkboxes[i].checked = false; }}}
	}
</script>