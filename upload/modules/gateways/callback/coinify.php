<?php

# Required File Includes
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "coinify"; # Enter your gateway module name here replacing template

$gateway = getGatewayVariables($gatewaymodule);
if (!$gateway["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

// Get the raw HTTP POST body (JSON object encoded as a string)
// Note: Substitute getBody() with a function call to retrieve the raw HTTP body.
// In "plain" PHP this can be done with file_get_contents('php://input')
$body = file_get_contents('php://input');

// Get the signature from the HTTP or email headers
$signature = $_SERVER['HTTP_X_COINIFY_CALLBACK_SIGNATURE'];

// Calculate the signature using the callback data and your IPN secret
$expected_signature = strtolower(hash_hmac('sha256', $body, $gateway["ipn"], false));

$arr = json_decode($body, true);

// Check that the signatures match
if (strtolower($signature) != $expected_signature) {
    // Invalid signature, disregard this callback
    logTransaction($gateway["name"], $body, 'Unsuccessful'); # Save to Gateway Log: name, data array, status
    return false;
}

header('HTTP/1.1 200 OK');
print '1';

$invoiceid = checkCbInvoiceID($arr['data']["custom"]["invoiceid"], $gateway["name"]); # Checks invoice ID is a valid invoice number or ends processing

addInvoicePayment($invoiceid, $arr['data']["bitcoin"]["address"], $arr['data']["native"]["amount"], 0, $gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
logTransaction($gateway["name"], $body, 'Successful'); # Save to Gateway Log: name, data array, status

// Valid signature
return true;
