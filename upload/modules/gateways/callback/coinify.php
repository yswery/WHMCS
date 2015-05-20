<?php

# Required File Includes
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "coinify"; # Enter your gateway module name here replacing template

$gateway = getGatewayVariables($gatewaymodule);
if (!$gateway["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback


$hash = hash('sha512', $_POST['transaction']['hash'] . $gateway["secret"]);

header('HTTP/1.1 200 OK');
print '1';

if ($_POST['hash'] == $hash && $_POST['status'] == 1)
{
	$invoiceid = checkCbInvoiceID($_POST["custom"]["invoiceid"], $gateway["name"]); # Checks invoice ID is a valid invoice number or ends processing
	
	addInvoicePayment($invoiceid, $_POST["transaction"]["hash"], $_POST["fiat"]["amount"], 0, $gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
	logTransaction($gateway["name"], $_POST, 'Successful'); # Save to Gateway Log: name, data array, status
}
else
{
	logTransaction($gateway["name"], $_POST, 'Unsuccessful'); # Save to Gateway Log: name, data array, status
}