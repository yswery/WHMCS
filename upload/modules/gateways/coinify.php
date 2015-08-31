<?php
	define('coinify_plugin_name', 'WHMCS');
	define('coinify_plugin_version', '0.1');

	function coinify_config()
	{
		$configarray = array(
			"FriendlyName" => array("Type" => "System", "Value" => "Coinify"),
			"api" => array("FriendlyName" => "API Key", "Type" => "text", "Size" => "40", ),
			"secret" => array("FriendlyName" => "API Secret", "Type" => "text", "Size" => "40", ),
            "ipn" => array("FriendlyName" => "IPN Secret", "Type" => "text", "Size" => "40", )
		);
		return $configarray;
	}

	function coinify_link($params)
	{
        // Generate a nonce
        $mt = explode(' ', microtime());
        $nonce = $mt[1] . substr($mt[0], 2, 6);

        // Concatenate the nonce and the API key
        $message = $nonce . $params["api"];
        // Compute the signature and convert it to lowercase
        $signature = strtolower( hash_hmac('sha256', $message, $params["secret"], false ) );

        // Construct the HTTP Authorization header.
        $auth_header = "Authorization: Coinify apikey=\"" . $params["api"] . "\", nonce=\"$nonce\", signature=\"$signature\"";

        $params = array(
            'amount' => number_format($params["amount"], 2, '.', ''),
            'currency' => $params['currency'],
            'plugin_name' => coinify_plugin_name,
            'plugin_version' => coinify_plugin_version,
            'description' => $params["description"],
            'callback_url' => $params['systemurl'] . '/modules/gateways/callback/coinify.php',
            'return_url' => $params['systemurl'] . '/clientarea.php',
            'custom' => array(
                'invoiceid' => $params['invoiceid']
            )
        );

        $url = 'https://api.coinify.com/v3/invoices';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth_header));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = json_decode( curl_exec($ch), true );
        curl_close($ch);

        $payment_url = isset($result['data']['payment_url']) ? $result['data']['payment_url'] : '';

        $code = <<<EOT
<form id="myForm" method="GET" action="{$payment_url}">
    <input type="submit" value="Pay Now" />
</form>
EOT;
        return $code;
	}
?>
