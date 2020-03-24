<?php
	$classPath = "..";
	include_once "../includes/email.php";
//	include_once "include/merit/deliverable.php";
	
	session_start();
	
	// Test caching of pages and assets
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.  
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: Thu, 01 Dec 1994 16:00:00 GMT"); // Proxies.
	
	foreach ($_POST as $varname=>$value)
	{
		$parameters[$varname] = $value;
	}

	// Get Session Information
//	$Deliverable = new EventsDeliverable();
//	$Deliverable->DeliverableNo($parameters["DeliverableNo"]);
//	$Deliverable->FillFields();
//	$sessionName = $Deliverable->Name();
	$sessionName = 'Rutgers University - PMP&reg; Exam Prep';
	$body = "Course:\t" . $sessionName;
	$body .= "\nName:\t" . $parameters["firstName"] . " " . $parameters["lastName"] . "\nEmail:\t" . $parameters["email"];
	
	// Check to see if the company was entered
	if (!empty($parameters["company"]))
		$body .= "\nCompany:\t" . $parameters["company"] . "\nPosition:\t" . $parameters["title"];
		
	// Add the optional fields to the body of the internal email, including guests
	if (!empty($parameters["address1"]))
		$body .= "\nAddress:\t" . $parameters["address1"];
	if (!empty($parameters["address2"]))
		$body .= "\n\t" . $parameters["address2"];
	if (!empty($parameters["city"]))
		$body .= "\nCity:\t" . $parameters["city"];
	if ($parameters["stateList"] != "NA")
		$body .= "\nState:\t" . $parameters["stateList"];
	if (!empty($parameters["zip"]))
		$body .= "\nZip:\t" . $parameters["zip"];
	if (!empty($parameters["phone"]))
		$body .= "\nPhone:\t" . $parameters["phone"];
		
	mail("dhisey@meritcd.com","Course Materials Order",$body,"From: Rutgers PMP Exam Prep<no_reply@meritcd.com>");
	
	// Create the body of the customer email (also display on the screen)
	$customerBody = "<p>Thank you for your order. Details of your order are listed below.</p>";
	$customerBody .= "<p><strong>Order Date:</strong> " . date("m/d/Y h:i a") . "</p>";
	$customerBody .= "<p><strong>Item 1: Rita Mulcahy's PMP&reg; Exam Prep, Ninth Edition - Paperback</strong></p>";
	$customerBody .= "<p>This item will be shipped to:";
	$customerBody .= "<br />" . $parameters["firstName"] . " " . $parameters["lastName"];
	$customerBody .= "<br />" . $parameters["address1"];
	if (!empty($parameters["address2"]))
		$customerBody .= "<br />" . $parameters["address2"];
	$customerBody .= "<br />" . $parameters["city"] . ", " . $parameters["StateList"] . " " . $parameters["zip"];
	$customerBody .= "<br />" . $parameters["phone"] . "</p>";
	$customerBody .= "<p>You will receive an email at " . $parameters["email"] . " when your item has shipped.</p>";
	$customerBody .= "<p><strong>Item 2: Login credentials for the X-AM PMP&reg;/CAPM exam Simulator - PMP version</strong></p>";
	$customerBody .= "<p>You will received your login credentials at " . $parameters["email"] . " within 24 hours.";
	
		
	CustomerEmail($parameters["email"],"Order Confirmation for Rutgers PMP Exam Prep Course Materials",$customerBody);
	ob_start();
?>
<h3>Thank You For Your Order</h3>
<?php echo $customerBody; ?>
<p>You will be emailed a copy of this page for your records. If you do not receive it, be sure to check your spam folder.</p>
<p><a href="http://www.meritcd.com/index.php">Return to the Merit Career Development Homepage</a></p>

<?php
	$pageContent = ob_get_contents();
	ob_end_clean();
	$contact = '<p>John Juzbasich<br />Merit Career Development<br />610-225-0193<br /><a href="mailto:jjuzbasich@meritcd.com">jjuzbasich@meritcd.com</a></p>';
	switch ($_POST["ref"]) {
		case "WCU":
			$template = "wcupa.php";
			break;
		default:
			$template = "sub.php";
	}
	include($template);
	
?>	