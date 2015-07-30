<?php
	if(!isset($_SESSION['imonggo_token'])){
		header("Location:../index.php");
	}
	// ----------------------------- Function for posting products to Shopify --------------------------------//
	function post_product_shopify($imonggo_inventory, $imonggo_products, $url_shopify, $http_header_post, $http_header_pull, $pull_url_shopify){
		foreach($imonggo_products as $i){ //traverse all imonggo products
			if($i->tax_exempt == "true"){ //tax_exempt in imonggo, taxable in shopify
				$tax_exempt = "false";
			}else{$tax_exempt = "true";}
			$check_id = mysql_query("SELECT imonggo_id FROM products WHERE imonggo_id = $i->id"); //check product id in the database
			$existing = mysql_fetch_row($check_id);
			if($i->status != 'D'){ //if not deleted, check whether or not existing in the database
				if(!$existing){ //if not deleted and not existing in the database, add
					foreach($imonggo_inventory as $inventory){
						$quantity = (float)$inventory->quantity; //quantity of a certain product
						if((string)$i->id == (string)$inventory->product_id){ //traverse and check if the product matches the product in the inventory
							if($quantity > 0){ //if the traversed product has stock
								$json = '{ 
									"product": { 
										"title" : "'.$i->name.'", 
										"body_html" : "'.$i->description.'",
										"tags" : "'.$i->tag_list.'",
											"variant":{
												"title" : "'.$i->name.'", 
												"price" : "'.$i->retail_price.'",
												"sku" : "'.$i->stock_no.'",
												"taxable" : "'.$tax_exempt.'",
												"barcode" : "'.$i->barcode_list.'",
												"inventory_management" : "shopify",
												"inventory_quantity" : "'.$quantity.'"
											}
										}
									}';
								echo $i->name." was successfully added to Shopify with ".$quantity." stock/s<br>";
								$json = json_decode(post_shopify($url_shopify, $json, $http_header_post), true); //decode json to normal array
								foreach($json as $key => $value){
									$shopify_id = $value['id']; //gets the shopify id of each product to be saved into the databases
								} $insert_product = mysql_query("INSERT INTO products (imonggo_id, shopify_id, name) VALUES ('$i->id', '$shopify_id', '$i->name')");
							}else{ echo "Error: ".$i->name." is out of stock<br>"; }
						}
					}
				}else{ //not deleted, existing in database, update in Shopify
					foreach($imonggo_inventory as $inventory){
						$quantity = (float)$inventory->quantity;
						if((string)$i->id == (string)$inventory->product_id){
							if($quantity > 0){
								$shopify_products = pull_shopify($pull_url_shopify, $http_header_pull);
									$query = mysql_query("SELECT shopify_id FROM products WHERE imonggo_id = $i->id");
									$exists = mysql_fetch_row($query);
									if($exists){
										$json = '{ 
											"product": { 
												"id" : "'.$exists['shopify_id'].'",
												"title" : "'.$i->name.'", 
												"body_html" : "'.$i->description.'",
												"tags" : "'.$i->tag_list.'"
											}
										}'; //variants can't be updated even in postman, quantity tag is under variants field
										echo $i->name." was successfully updated in Shopify with ".$quantity." stock/s<br>";
										$put_url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/products/'.$exists[0].'.json';
										$shopify = put_shopify($put_url_shopify, $json, $http_header_post);
									}
							}else{ echo "Error: ".$i->name." is out of stock<br>"; }
						}
					}
				}
			}else{ //if deleted, check if existing or not
				if($existing){ //if deleted and existing in the database, hide
					echo "Shopify has no hide method for products<br>";
				}else if(!$existing){} //if deleted and not existing in the database, do nothing
			} 
		}	
	}
	function post_customer_imonggo($shopify_customers, $url_imonggo, $imonggo_username, $imonggo_password, $http_header_post){
		foreach($shopify_customers as $i){
			foreach($i->{'default-address'} as $address){
				$company = $address->company;
				$mobile = $address->phone;
				$country = $address->country;
				$city = $address->city;
				$zip = $address->zip;
			}	
			$check_id = mysql_query("SELECT shopify_id FROM customers WHERE shopify_id = $i->id");
			$existing = mysql_fetch_row($check_id);
			if($i->state != "disabled"){ //if not disabled, check if existing in the database or not
				if(!$existing){ //if not disabled and not existing, add
					$xml = '<?xml version="1.0" encoding="UTF-8"?> 
					<customer> 
						<first_name>'.$i->{'first-name'}.'</first_name> 
						<last_name>'.$i->{'last-name'}.'</last_name> 
						<email nil="true">'.$i->email.'</email>
						<tax_exempt>'.$i->{'tax-exempt'}.'</tax_exempt>
						<company_name nil="true">'.$company.'</company_name>
						<mobile nil="true">'.$mobile.'</mobile>
						<telephone nil="true">'.$mobile.'</telephone>
						<country nil="true">'.$country.'</country>
						<city nil="true">'.$city.'</city>
						<zipcode nil="true">'.$zip.'</zipcode>
					</customer>';
					echo $i->{'first-name'}." ".$i->{'last-name'}." was successfully added to Imonggo.<br>";
					$imonggo_id = post_imonggo($url_imonggo, $xml, $imonggo_username, $imonggo_password);
					$insert_customer = mysql_query("INSERT INTO customers (imonggo_id, shopify_id, email) VALUES ('$imonggo_id->id', '$i->id', '$i->email')");
				}else{ //not disabled, existing in database, update
					$imonggo_customers = pull_imonggo($url_imonggo, $imonggo_username, $imonggo_password);
					foreach($imonggo_customers as $cust){
						$query = mysql_query("SELECT imonggo_id FROM customers WHERE imonggo_id = $cust->id");
						$exists = mysql_fetch_row($query);
						if($exists){ 
							$json = '{ 
									"customer": { 
										"id" : "'.$i->id.'",
										"first_name": "'.$cust->first_name.'",
										"last_name": "'.$cust->last_name.'",
										"email": "'.$cust->email.'",
										"addresses":[{
											"city":"'.$cust->city.'",
											"company":"'.$cust->company_name .'",
											"phone":"'.$cust->mobile .'",
											"country_name":"'. $cust->country.'",
											"zip":"'. $cust->zipcode.'"
										}]
										}
									}';
							echo $i->{'first-name'}." ".$i->{'last-name'}." was successfully updated in Shopify.<br>";
							$url_shopify = 'https://'.$_SESSION['shopify_shop_name'].'.myshopify.com/admin/customers/'.$i->id.'.json';
							$shopify = put_shopify($url_shopify, $json, $http_header_post);
						}
					}
				}
			}else{
				if($existing){ //if disabled but already existing in the database,
				}else if(!$existing){} //if disabled and not existing in the database, do nothing
				echo "Error: ".$i->{'first-name'}." ".$i->{'last-name'}." is disabled in Shopify.<br>";
			}
		}
	}
					
	function post_invoice_imonggo($shopify_orders, $url_imonggo, $imonggo_username, $imonggo_password){
		foreach($shopify_orders as $i){
			$check_id = mysql_query("SELECT order_id FROM last_invoice_posting WHERE order_id = $i->id"); //check if the order's id is already in the database
			$existing = mysql_fetch_row($check_id);
			$date_time = date('M d, Y h:i:s a', time());
			if(!$existing){ //if order is not yet in the database, add
				$insert_to_last_posting = mysql_query("INSERT INTO last_invoice_posting (order_id, id, date) VALUES('$i->id', DEFAULT, '$date_time')");
				$insert_to_invoices = mysql_query("INSERT INTO invoices (id, post_date) VALUES (DEFAULT, '$date_time')");
			
				$xml = '<?xml version="1.0" encoding="UTF-8"?> 
				<invoice>
					<reference>'.$i->id.'</reference>
					<customer_name nil="true">'.$i->customer->{'default-address'}->{'name'}.'</customer_name>
					<customer_id nil="true">'.$i->customer->id.'</customer_id>
					<payments type="array">
						<payment>
							<amount>'.$i->{'total-price'}.'</amount>
						</payment>
					</payments>
					<tax_exempt nil="true">'.$i->customer->{'tax-exempt'}.'</tax_exempt>					
				<invoice_tax_rates type="array"/>
				<invoice_lines type="array">';
				
				foreach($i->{'line-items'}->{'line-item'} as $item){ //traverse each product per order in shopify
					$query = "SELECT * FROM products";
					$result = mysql_query($query);
					$row = mysql_fetch_array($result);
					
					$shopify_id = $item->{'product-id'}; //gets the id per product
					$quantity = $item->quantity;
					$price = $item->price;
					if(!$row){
						echo "Error: No record of products in Shopify store";
						return;
					}else{
						$update_choice = mysql_query("SELECT imonggo_id FROM products WHERE shopify_id='$shopify_id'"); //check the shopify_id stored in the database to the $shopify_id variable
						$row = mysql_fetch_array($update_choice);
						if($row[0]!=null){ //gets the imonggo id if not null
							$id = $row[0];
						}
					}
						$xml = $xml . 
							'<invoice_line>
								<product_id>' . $id . '</product_id>
								<quantity>' . $quantity . '</quantity>
								<retail_price>' . $price . '</retail_price>
							</invoice_line>';
				}
				$xml = $xml .  '</invoice_lines> </invoice>';
				echo "Invoice ".$i->number." named to customer ".$i->customer->{'default-address'}->{'name'}." was successfully added to Imonggo.<br>";
				$result = post_imonggo($url_imonggo, $xml, $imonggo_username, $imonggo_password);
			}else{
				echo "Error: Invoice ".$i->number." named to customer ".$i->customer->{'default-address'}->{'name'}." is already in Imonggo.<br>";
				$update_last_posting = mysql_query("UPDATE last_invoice_posting SET order_id = '$i->id', date = '$date_time' WHERE id='$row[0]'");
				$insert_to_invoices = mysql_query("INSERT INTO invoices (id, post_date) VALUES (DEFAULT, '$date_time')");
			}
		}
	}
?>