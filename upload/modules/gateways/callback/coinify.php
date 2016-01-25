<?php

# Required File Includes
if (file_exists('../../../dbconnect.php'))
{ include '../../../dbconnect.php'; }
else if (file_exists('../../../init.php'))
{ include '../../../init.php'; }
else
{ exit("error"); }
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

include('../coinify/CoinifyCallback.php');

$gatewaymodule = "coinify"; # Enter your gateway module name here replacing template

$gateway = getGatewayVariables($gatewaymodule);
if (!$gateway["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

$callback = new CoinifyCallback($gateway["ipn"]);

// Get the signature from the HTTP or email headers
$signature = $_SERVER['HTTP_X_COINIFY_CALLBACK_SIGNATURE'];

// Get the raw HTTP POST body (JSON object encoded as a string)
// Note: Substitute getBody() with a function call to retrieve the raw HTTP body.
// In "plain" PHP this can be done with file_get_contents('php://input')
$body = file_get_contents('php://input');

$arr = json_decode($body, true);

// Always reply with a HTTP 200 OK status code and an empty body, regardless of the result of validating the callback
header('HTTP/1.1 200 OK');

if (!$callback->validateCallback($body, $signature)) {
    // Invalid signature, disregard this callback
    logTransaction($gateway["name"], $body, 'Unsuccessful'); # Save to Gateway Log: name, data array, status
    return;
}

// Find invoice id from provided Coinify POST
$invoiceid = checkCbInvoiceID($arr['data']["custom"]["invoiceid"], $gateway["name"]); # Checks invoice ID is a valid invoice number or ends processing

// Get bitcoin address used for payment, as to be used for transaction id
$txid = $arr['data']["bitcoin"]["address"];

checkCbTransID($txid);

switch ($arr['data']['state']) {
    case 'complete': {
        addInvoicePayment($invoiceid, $txid, $arr['data']["native"]["amount"], 0, $gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
        logTransaction($gateway["name"], $body, 'Successful'); # Save to Gateway Log: name, data array, status
        break;
    }

    case 'paid': {
        logTransaction($gateway["name"], $body, 'We have received payments, but they are not yet confirmed enough');
        break;
    }

    case 'expired': {
        logTransaction($gateway["name"], $body, 'The transaction is expired, do not process!');
        break;
    }
}
