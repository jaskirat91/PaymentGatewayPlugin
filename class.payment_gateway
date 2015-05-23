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
 * Gateway Class
 *
 * @package		PaymentGatewayPlugin
 * @filename	class.payment_gateway.php
 * @category	Payment Gateway
 * @author		Jaskirat Singh
 * @link		http://www.codesharper.com
 */
class Gateway
{
	private $merchant_key;		//	Your MERCHANT KEY & SALT ID here provided by -
	private $salt_ID;			//	- Payment Gateways (PG)
	private $gateway_base_url;	//	Base URL of payment gateway
	private $payment_gateway;	//	Name of payment gateway
	private $success_url;		//	URL on which server send success responses
	private $fail_url;			//	URL on which server send failure responses
	private $posted_data = array();	//	Array containing invoice data to be carried out on PG
	
	function __construct($gateway)
	{
		//	Initialize variables
		$this->payment_gateway = $gateway;
		if($gateway == 'PAYU')	//	If PG is PAYU
		{
			$this->gateway_base_url = "https://secure.payu.in/_payment";
		}
		else
		{
			// For other payment Gateways
			
		}
	}
	/*
	 *	Call this for configuring test environment at PG
	 *	Default is payU
	 *
	*/
	function forTest()
	{
		if($gateway == 'PAYU')	
		{
			$this->gateway_base_url = "https://test.payu.in/_payment";
		}
		else
		{
			// For other payment Gateways
			
		}
	}
	
	function gatewayCredentials($merchantKey, $salt)
	{
		/*
		 * Setting PG credentials
		*/
		$this->merchant_key = $merchantKey;
		$this->salt_ID = $salt;
	}
	
	function postBackUrl($surl,$furl)
	{
		/*
		 *	Setting URL path on which server transmit
		 * 	success & fail statuses
		 *
		*/
		$this->success_url = $surl;
		$this->fail_url = $furl;
	}
	
	function postData($data = array())
	{
		/*
		 * Collect required data from clients
		*/
		if(is_array($data))
		{
			if($this->payment_gateway == 'PAYU')
			{
				$this->posted_data["txnid"] = $data["txnid"];
				$this->posted_data["ship_cus_id"] = $data["ship_cus_id"];
				$this->posted_data["firstname"] = $data["firstname"];
				$this->posted_data["lastname"] = $data["lastname"];
				$this->posted_data["udf1"] = $data["udf1"];
				$this->posted_data["address1"] = $data["address1"];
				$this->posted_data["city"] = $data["city"];				
				$this->posted_data["state"] = $data["state"];
				$this->posted_data["country"] = $data["country"];
				$this->posted_data["zipcode"] = $data["zipcode"];
				$this->posted_data["phone"] = $data["phone"];
				$this->posted_data["email"] = $data["email"];
				$this->posted_data["amount"] = $data["amount"];
				$this->posted_data["productinfo"] = $data["productinfo"];
				$this->posted_data['surl']=$this->success_url;
				$this->posted_data['furl']=$this->fail_url;
				$this->posted_data['key']=$this->merchant_key;
				$this->callPaymentGateway();
			}
			else
			{
				//	For other payment gateways
				
			}
		}
	}
	
	
	private function callPaymentGateway()
	{
		/*
		 *	Get all the posted data and encrypt it
		 *  using hash encoding method
		*/
		if($this->payment_gateway == 'PAYU')
		{
			$error = array();
			
			if($this->merchant_key != '' && $this->salt_ID != '')
			{
				if(empty($this->posted_data["txnid"]))
				{
					// Generate random transaction id
					$this->posted_data["txnid"] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				}
				if(empty($this->posted_data["hash"]))
				{
					$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
					$hashVarsSeq = explode('|', $hashSequence);
					$hash_string = '';
					foreach($hashVarsSeq as $hash_var) {
					  $hash_string .= isset($this->posted_data[$hash_var]) ? $this->posted_data[$hash_var] : '';
					  $hash_string .= '|';
					}
					$hash_string .= $this->salt_ID;
					$hash = strtolower(hash('sha512', $hash_string));
					//echo $hash; exit;
					$this->posted_data['hash'] =$hash;
				}
				
				//	Checking for errors
				
				if(empty($this->posted_data['key']))
				{
					$error[] = "Key can not be blank!";
				}
				if(empty($this->posted_data['txnid']))
				{
					$error[] = "txnid can not be blank!";
				}
				if(empty($this->posted_data['amount']))
				{
					$error[] = "amount can not be blank!";
				}
				if(empty($this->posted_data['firstname']))
				{
					$error[] = "firstname can not be blank!";
				}
				if(empty($this->posted_data['email']))
				{
					$error[] = "email can not be blank!";
				}
				if(empty($this->posted_data['phone']))
				{
					$error[] = "phone can not be blank!";
				}
				if(empty($this->posted_data['productinfo']))
				{
					$error[] = "productinfo can not be blank!";
				}
				if(empty($this->posted_data['surl']))
				{
					$error[] = "surl can not be blank!";
				}
				if(empty($this->posted_data['furl']))
				{
					$error[] = "furl can not be blank!";
				}
				
				//	If no error in user input
				
				if(count($error) == 0)
				{
					/*
					 *	Feed data provided by user into payu
					 *	form and call this function to submit this form
					*/
					$this->submitGatewayform();
				}
				else
				{
					$strerror = implode("<br>",$error);
					return $strerror;
				}
				
			}
			else
			{
				return "Please set gateway credentials!";
			}
		}
		else
		{
			return "Invalid Payment Gateway selected!";
		}
	}
	
	private function submitGatewayform()
	{
		/*
		 *	Render form and feed user provided data into it
		 *	and submit it on load event, so that user is 
		 *	redirected to PG
		*/
		if($this->payment_gateway == "PAYU")
		{
	?>
	<html>
		<script type="text/javascript">
			function myfunc () {
			
				var frm = document.getElementById("payuForm");
				frm.submit();
			}
			window.onload = myfunc;
		</script>
		<script>document.getElementById('payuForm').submit();</script>
	  <script>
		var hash = '<?php echo $this->posted_data['hash']; ?>';
		function submitPayuForm() {
		//alert (hash);
		  if(hash == '') {
			return;
		  }
		  var payuForm = document.forms.payuForm;
		  payuForm.submit();
		}
	  </script>
  <body onLoad="submitPayuForm();">
    
    <br/>
    
    <form action="<?php echo $this->gateway_base_url; ?>" method="post" name="payuForm" id="payuForm" >
      <input type="hidden" name="key" value="<?php echo $this->posted_data['key']; ?>" />
      <input type="hidden" name="hash" value="<?php echo $this->posted_data['hash']; ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $this->posted_data['txnid']; ?>" />
      <table>
        <tr>
        
        </tr>
        <tr>
        
          <td><input type="hidden" name="amount" value="<?php echo (empty($this->posted_data['amount'])) ? '' : $this->posted_data['amount'] ?>" /></td>
        
          <td><input type="hidden" name="txn" value="<?php echo (empty($this->posted_data['amount'])) ? '' : $this->posted_data['amount'] ?>" /></td>
        <!--  <td>First Name: </td>-->
          <td><input type="hidden" name="firstname" id="firstname" value="<?php echo (empty($this->posted_data['firstname'])) ? '' : $this->posted_data['firstname']; ?>" /></td>
        </tr>
        <tr>
        <!--  <td>Email: </td>-->
          <td><input type="hidden" name="email" id="email" value="<?php echo (empty($this->posted_data['email'])) ? '' : $this->posted_data['email']; ?>" /></td>
         <!-- <td>Phone: </td>-->
          <td><input type="hidden" name="phone" value="<?php echo (empty($this->posted_data['phone'])) ? '' : $this->posted_data['phone']; ?>" /></td>
        </tr>
        <tr>
          <!--<td>Product Info: </td>-->
          <td colspan="3"><input name="productinfo" type="hidden" value="<?php echo (empty($this->posted_data['productinfo'])) ? '' : $this->posted_data['productinfo'] ?>" size="64" /></td>
        </tr>
        <tr>
        <!--  <td>Success URI: </td>-->
          <td colspan="3"><input name="surl" type="hidden" value="<?php echo (empty($this->posted_data['surl'])) ? '' : $this->posted_data['surl'] ?>" size="64" /></td>
        </tr>
        <tr>
         <!-- <td>Failure URI: </td>-->
          <td colspan="3"><input name="furl" type="hidden" value="<?php echo (empty($this->posted_data['furl'])) ? '' : $this->posted_data['furl'] ?>" size="64" /></td>
        </tr>
        <tr>
         <!-- <td><b>Optional Parameters</b></td>-->
        </tr>
        <tr>
          <!--<td>Last Name: </td>-->
          <td><input name="lastname" id="lastname" type="hidden" value="<?php echo (empty($this->posted_data['lastname'])) ? '' : $this->posted_data['lastname']; ?>" /></td>
          <!--<td>Cancel URI: </td>-->
         <!-- <td><input name="curl" value="" /></td>-->
        </tr>
        <tr>
         <!-- <td>Address1: </td>-->
          <td><input name="address1" type="hidden" value="<?php echo (empty($this->posted_data['address1'])) ? '' : $this->posted_data['address1']; ?>" /></td>
        <!--  <td>Address2: </td>-->
          <td><input name="address2" type="hidden" value="<?php echo (empty($this->posted_data['address1'])) ? '' : $this->posted_data['address1']; ?>" /></td>
        </tr>
        <tr>
          <!--<td>City: </td>-->
          <td><input name="city"  type="hidden" value="<?php echo (empty($this->posted_data['city'])) ? '' : $this->posted_data['city']; ?>" /></td>
       <!--   <td>State: </td>-->
          <td><input name="state" type="hidden" value="<?php echo (empty($this->posted_data['state'])) ? '' : $this->posted_data['state']; ?>" /></td>
        </tr>
        <tr>
         <!-- <td>Country: </td>-->
          <td><input name="country" type="hidden" value="<?php echo (empty($this->posted_data['country'])) ? '' : $this->posted_data['country']; ?>" /></td>
          <!--<td>Zipcode: </td>-->
          <td><input name="zipcode" type="hidden" value="<?php echo (empty($this->posted_data['zipcode'])) ? '' : $this->posted_data['zipcode']; ?>" /></td>
        </tr>
        <tr>
          <!--<td>UDF1: </td>-->
          <td><input name="udf1" type="hidden"  value="<?php echo (empty($this->posted_data['udf1'])) ? '' : $this->posted_data['udf1']; ?>" /></td>
       
        <tr>
          <?php if(!$this->posted_data['hash']) { ?>
            <td colspan="4"><input type="submit" value="Submit" /></td>
          <?php } ?>
        </tr>
      </table>
    </form>

  </body>
</html>
	
	<?php		
		}
	}
	
}

?>
