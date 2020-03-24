<?php
	$classPath = "..";
	//$classPath = dirname(dirname(__FILE__)) . "/MeritDevelopment";
//	include_once "include/merit/deliverable.php";
	include_once "include/merit/discount.php";
//	include_once "include/merit/staff.php";
	include_once "include/merit/address.php";
	
	session_start();
	
	// Test caching of pages and assets
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.  
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: Thu, 01 Dec 1994 16:00:00 GMT"); // Proxies.
	
	// Money format function for Windows
	/*function money_format($formatString, $val)
	{
		return sprintf($formatString, $val);
	}*/
	
	// Get Deliverable Information
//	$Deliverable = new EventsDeliverable();
//	$Deliverable->DeliverableNo($_GET["code"]);
//	$Deliverable->FillFields();
//	$Deliverable->GetCourseInformation();
//	$itemPrice = $Deliverable->Price();
//	$sessionName = $Deliverable->Name();
	$sessionName = "Rutgers University - PMP&reg; Exam Prep";
	$stamp = '';
	$examPrice = 199;
	$bookPrice = 79;
	$subTotal = $examPrice + $bookPrice;
//	$PrimaryInstructor = new EventsStaff();
//	$PrimaryInstructor->ID(19);
//	$PrimaryInstructor->FillFields();
//	$SecondaryInstructor = new EventsStaff();
//	$SecondaryInstructor->ID(1);
//	$SecondaryInstructor->FillFields();
//	$instructorText = "Instructors: " . $PrimaryInstructor->ShortName() . " " . $PrimaryInstructor->LastName() . ", " . $PrimaryInstructor->Designation() . " &amp; " . $SecondaryInstructor->ShortName() . " " . $SecondaryInstructor->LastName() . ", " . $SecondaryInstructor->Designation();
	
	$Address = new EventsAddress();
	$Address->GetStates();
	
	setlocale(LC_MONETARY,'en_US.ISO-8559-1');
	
	// Get Stored Discount Codes
	$Discounts = new EventsDiscounts();
	$Discounts->GetCodes();
	
	// Convert array into Javascript array
	$json_discountCodes = json_encode($Discounts->IDList());
	
	ob_start();
	
?>
<h2>Course Materials Order Form</h2>
<p class="subhead">10 Weeks starting March 23, 6:30 PM</p>
<p>The following materials are included in this package and are required for this course:</p>
<ul>
	<li>Rita Mulcahy's PMP&reg; Exam Prep, Ninth Edition - Paperback Edition</li>
	<li>Access to X-AM PMP&reg;/CAPM - PMP Version, an online exam simulator by STS</li>
</ul>
<hr />
<script>
	var discountCodeArray = <?php echo $json_discountCodes;?>;
</script>
<form action="thankyou3.php" method="post">
	<h3>Shipping Information</h3>
	<p class="important required right">* Required information</p>
	<span class="row">
		<span class="important required">*</span><input type="text" name="firstName" id="firstName" placeholder="First Name" required />
	</span>
	<span class="row">
		<span class="important required">*</span><input type="text" name="lastName" id="lastName" placeholder="Last Name" required  />
	</span>
	<span class="row">
		<span class="important required">*</span><input type="email" name="email" id="email" placeholder="Email Address where you want to receive your exam simulator login credentials" required />
	</span>
	<span class="row">
		<span class="important required">*</span><input type="email" name="email2" id="email2" placeholder="Confirm Email Address" required />
	</span>
	<span class="row">
		<input type="text" name="company" id="company" placeholder="Company" />
	</span>
	<span class="row">
		<input type="text" name="title" id="title" placeholder="Title" />
	</span>
	<span class="row">
		<span class="important required">*</span><input type="text" name="address1" id="address1" placeholder="Address 1" required />
	</span>
	<span class="row">
		<input type="text" name="address2" id="address2" placeholder="Address 2" />
	</span>
	<span class="row">
		<span class="important required">*</span><input type="text" name="city" id="city" placeholder="City" required />
	</span>
	<span class="row">
		<span class="important required">*</span>
		<select id="stateList" name="stateList" required>
			<option value="NA">--Please choose a state--</option>
			<?php
			foreach($Address->States() as $state)
			{
				echo "<option value=\"" . $state["StateCode"] . "\">" . $state["StateName"] . "</option>";	
			}
			?>
	</select>
	</span>
	<span class="row">
		<span class="important required">*</span><input type="text" name="zip" id="zip" placeholder="Zip Code" required />
	</span>
	<span class="row">
		<input type="tel" name="phone" id="phone" placeholder="Phone" />
	</span>
	<h3>Order Summary</h3>
	<table id="registrantTable">
		<tr>
			<th style="text-align:left;">Item</th>
			<th>Quantity</th>
			<th style="text-align: right;">Price</th>
			<th style="text-align: right;">Total</th>
		</tr>
		<tr id="registrantRow">
			<td>PMP Exam Prep - Ninth Edition</td>
			<td style="text-align: center;">1</td>
			<td style="text-align: right;"><?php echo "$" . money_format('%.2n',$bookPrice);?></td>
			<td style="text-align: right;"><?php echo "$" . money_format('%.2n',$bookPrice);?></td>
		</tr>
		<tr id="registrantRow">
			<td>X-AM PMP&reg;/CAPM exam simulator</td>
			<td style="text-align: center;">1</td>
			<td style="text-align: right;"><?php echo "$" . money_format('%.2n',$examPrice);?></td>
			<td style="text-align: right;"><?php echo "$" . money_format('%.2n',$examPrice);?></td>
		</tr>
		<tr id="subTotalRow">
			<td>Subtotal:</td>
			<td style="text-align: center">1</td>
			<td style="text-align: right;">&nbsp;</td>
			<td style="text-align: right;"><?php echo "$" . money_format('%.2n',$subTotal);?></td>
		</tr>
		<tr id="discountRow">
			<td>Discount: RUTGERS (20% off)</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align: right;">
			<?php
				$discount = 0.2 * ($subTotal);
				echo "-$" . money_format('%.2n', $discount);
				$itemPrice = $subTotal - $discount;?>
			</td>
		</tr>
		<tr id="totalRow">
			<td>Grand Total:</td>
			<td style="text-align: center;">1</td>
			<td style="text-align: right;">&nbsp;</td>
			<td style="text-align: right;"><?php echo "$" . money_format('%.2n',$itemPrice);?></td>
		</tr>
	</table>
	<input type="hidden" name="promo" id="promo" value="FRIENDS">
	<!--<h3>Promo/Discount Code</h3>
	<span class="row emphasis">
		Enter Code: <input type="text" name="promo" id="promo" class="medium" /><a class="btn" onclick="applyCode(discountCodeArray);">Apply</a>
	</span> -->
	<span id="paymentRow" class="row center margin-top">
		<div id="paypal-button"></div>
		<p>You will be taken to PayPal to complete payment.<br />No PayPal account is required.</p>
	</span>
	<span id="freeRegisterRow" class="row center margin-top">
		<button type="submit" class="btn">Register Now!</button>
	</span>
	<input type="hidden" name="DeliverableNo" id="DeliverableNo" value="<?php echo $_GET["code"];?>">
	<?php if ($ref != "Merit") {
		echo '<input type="hidden" name="ref" id="ref" value="' . $_GET["ref"] . '">';
	}?>
</form>
<script src="scripts/custom.js"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
	var freeButtonRow = document.getElementById('freeRegisterRow');
	var paymentRow = document.getElementById('paymentRow');
    var grandTotal = <?php echo $itemPrice;?>
	
    paypal.Button.render({

	  client: {
		sandbox: 'Sandbox key',
		production: 'Production key'
		
	  },
      env: 'production', // Or 'production',
	  
      commit: true, // Show a 'Pay Now' button

      style: {
            label: 'buynow',
            fundingicons: true, // optional
            branding: true, // optional
            size:  'small', // small | medium | large | responsive
            shape: 'rect',   // pill | rect
            color: 'gold'   // gold | blue | silve | black
        },

      payment: function(data, actions) {
        return actions.payment.create({
                transactions: [
                    {
                        amount: { total: grandTotal, currency: 'USD' }
                    }
                ]
            });
      },

      onAuthorize: function(data, actions) {
		return actions.payment.execute().then(function() {
                window.alert('Your payment has been completed successfully. To complete your registration, close this window and click on the "Register Now" button');
				freeButtonRow.style.display = 'block';
				paymentRow.style.display = 'none';

        });        
      },

      onCancel: function(data, actions) {
        /* 
         * Buyer cancelled the payment 
         */
      },

      onError: function(err) {
        /* 
         * An error occurred during the transaction 
         */
      }
    }, '#paypal-button');
</script>
<?php
	$pageContent = ob_get_contents();
	ob_end_clean();
	$contact = '<p>John Juzbasich<br />Merit Career Development<br />610-225-0193<br /><a href="mailto:jjuzbasich@meritcd.com">jjuzbasich@meritcd.com</a></p>';
	switch ($ref) {
		case "WCU":
			$template = "wcupa.php";
			break;
		default:
			$template = "sub.php";
	}
	include($template);	
?>