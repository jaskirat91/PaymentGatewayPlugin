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
 * Success & Fail page
 *
 * @package		PaymentGatewayPlugin
 * @filename	success_url.php
 * @category	Payment Gateway
 * @author		Jaskirat Singh
 * @link		http://www.codesharper.com
 */
 
// ------------------------------------------------------------------------


if($_REQUEST['mihpayid']!='')
{	
	/**
	 * This file facilates and capture PG server
	 * response and take required action accordingly
	 */

	if($_REQUEST['status']=='success')
	{	
		/**
		 * Payment is successfully done.
		 * You can add your logic here which needs to be run
		 * on successful transaction.
		 */
	}
	else if($_REQUEST['status']=='failure')
	{
		/**
		 * Payment is unsuccessful due to user cancellation.
		 * You can add your logic here which needs to be run
		 * on failed transaction.
		 */
	}
	else if($_REQUEST['status']=='pending')
	{
		/**
		 * Payment is pending due to some reasons.
		 * You can add your logic here which needs to be run
		 * on pending transaction.
		 */
	}
}

?>
