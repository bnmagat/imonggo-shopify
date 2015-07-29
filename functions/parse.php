<?php
	if(!isset($_SESSION['imonggo_token'])){
		header("Location:../index.php");
	}
	// ------------------ Removes commas and spaces of tags and store in an array ----------------//
	function parse($product){
		$array = array();
		foreach($product as $i){
			$temp = explode(",",preg_replace('/\s+/','', strtolower($i->tag_list))); //removes unnecessary characters of each tag
			foreach($temp as $i){array_push($array, $i);} //parsed tags stored in an array
		}$array = array_unique($array); //no duplication of tags
		print_modal($array);
	}
	// ------------------ Function for printing modal when "Selected Products" button is clicked ------------------//
	function print_modal($array){
		echo "<h5>Select Tagged Products</h5><hr>";
		echo '<p><input type="checkbox" class="filled-in" onclick="checkAll(this)" name="checkall" id="checkall"/><label style="font-size:19;" for="checkall">Select all</label></p><hr>';
		foreach($array as $i){ if($i == null){ echo '<input type="checkbox" class="filled-in" value="notag" name="notag" id="notag"/><label style="font-size:19;" for="notag">Select products with no tag</label><br>';}}
		foreach($array as $i){ if($i != null){ echo '<p><input value="'.$i.'" name="checkbox[]" type="checkbox" class="filled-in" id="'.$i.'"/><label style="font-size:19;" for="'.$i.'">'.$i.'</label></p>';}}
		echo "<script> $('#modal_tagged').openModal(); </script>";	
	}
	// -------------- modal for products, customers and invoices -----------//
	function modal(){
		echo "<center>IMONGGO - SHOPIFY</center><hr><br>";
		echo "<script> $('#modal_tagged').openModal(); </script>";
	}
	// --------------- get product tags regardless of duplication ----------------//
	function explode_products($prod){
		$array = array(); 
		$temp = explode(",",preg_replace('/\s+/','', strtolower($prod->tag_list)));
		foreach($temp as $i){array_push($array, $i);} //all product tags and the duplicated tags are stored in an array
		return $array;
	}
	// --------------------- post parsed tags to shopify -------------------------//
	function post_parsed($imonggo_inventory, $imonggo_products, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify){
		if(isset($_POST['submit'])){
			$tags = $_POST['checkbox']; // if any of the tags is checked
			$notag = $_POST['notag']; // if no tag checkbox is checked
			$parsed = array();
			
			if(count($tags)>0){	 parse_tags($imonggo_inventory, $imonggo_products, $tags, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify); //if any of the tags is checked
				if(count($notag)>0){ parse_notags($imonggo_inventory, $imonggo_products, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify);} //if any of the tags AND "no tag" checkboxes are checked
			}else if(count($notag)>0 && count($tags)<1){ // if "no tag" checkbox is checked and no other tags are checked
				parse_notags($imonggo_inventory, $imonggo_products, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify);
			}else echo "<br><hr>Please select at least one tag";
		}
	}
	// ---------------------- post products that have tags -------------------------//
	function parse_tags($imonggo_inventory, $imonggo_products, $tags, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify){
		foreach($imonggo_products as $prod){
			if(!($prod->tag_list == "")){ 
				$array = explode_products($prod);
				foreach($array as $element){
					foreach($tags as $j){
						if($j == $element) array_push($parsed, $prod);
					}
				}
			}
		}post_product_shopify($imonggo_inventory, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify);
	}
	// ------------------- post products that have no tags -------------------------//
	function parse_notags($imonggo_inventory, $imonggo_products, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify){
		foreach($imonggo_products as $prod){
			if($prod->tag_list == "") {array_push($parsed, $prod);}
		}post_product_shopify($imonggo_inventory, $parsed, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify);
	}
?>