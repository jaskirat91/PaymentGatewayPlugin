<?php 
/**
 * Payment Gateway Plugin for CodeIgniter
 *
 * An open source Plugin facilates payment gateway integration with PayU
 *
 * @package		PaymentGatewayPlugin
 * @author		Jaskirat Singh
 * @link		http://www.codesharper.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Client Side Code
 *
 * @package		PaymentGatewayPlugin
 * @filename	client.php
 * @category	Payment Gateway
 * @author		Jaskirat Singh
 * @link		http://www.codesharper.com
 */
 
// ------------------------------------------------------------------------

include('class.payment_gateway.php');

/**
 * Step 1: Initialize Plugin with payment gateway name
 * Step 2: Set Credentials MERCHANT KEY & SALT ID
 * Step 3: Setup post back URL's. For eg:-
 * 		   Success URL - http://localhost/PaymentGatewayPlugin/success_url.php
 * 		   Fail URL - http://localhost/PaymentGatewayPlugin/fail_url.php
 * Step 4: Feed invoice detial into an array and pass it
		   to postData() function.
 * Step 5: ***Boom*** you are redirected to payment gateway.
 *
 * Enjoy and Share :-)
 *
 */

$gateway = new Gateway("PAYU");
$gateway->gatewayCredentials("YOUR_MERCHANT_KEY", "YOUR_SALT_ID");
$gateway->postBackUrl("SUCCESS_URL","FAIL_URL");		
$data = array();	//	Store you form data into this Array
$data["txnid"] = "PM32253";	 	// 	Order ID or Invoice ID	
$data["ship_cus_id"] = 239;		//	Ship Customer ID
$data["firstname"] = "Test";	//	Ship First Name
$data["lastname"] = "Singh";	//	Ship Last Name
$data["udf1"] = 1;	//	Quantity
$data["address1"] = "Amritsar 3265/987";	//	Shipping Address
$data["city"] = "Amritsar";		//	Shipping City
$data["state"] = "Punjab";		//	Shipping State
$data["country"] = "India";		//	Shipping Country
$data["zipcode"] = "143001";	// 	Shipping Pin/Zip Code
$data["phone"] = "9888888888";	//	Mobile no. of customer
$data["email"] = "test@yahoo.com";	//	Email ID of customer
$data["amount"] = 12999;	//	TOTAL INVOICE AMOUNT 
$data["productinfo"] = "iPhone 7";	//	Product Info or Name

$gateway->postData($data);	//	Make payment

?>
