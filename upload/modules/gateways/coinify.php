<?php
	function coinify_config()
	{
		$configarray = array(
			"FriendlyName" => array("Type" => "System", "Value" => "Coinify"),
			"api" => array("FriendlyName" => "Invoice API key", "Type" => "text", "Size" => "35", ),
			"secret" => array("FriendlyName" => "IPN Secret", "Type" => "text", "Size" => "20", )
		);
		return $configarray;
	}

	function coinify_link($params)
	{
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => 'https://coinify.com/api/v1/invoice',
		CURLOPT_USERPWD => $params["api"],
		CURLOPT_POSTFIELDS => 'price=' . number_format($params["amount"], 2, '.', '') . '&currency=' . $params['currency'] . '&item=' . $params["description"] . '&custom=' . json_encode(array('invoiceid' => $params['invoiceid'], 'returnurl' => rawurlencode($params['systemurl']), 'cancelurl' => rawurlencode($params['systemurl']), 'plugin' => 'WHMCS')),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPAUTH => CURLAUTH_BASIC));
		$url = curl_exec($ch);
		curl_close($ch);

		$link = '<a href="' . $url . '">' . $params['langpaynow'] . '</a>';

		if (stripos($params['returnurl'], 'viewinvoice') === false || stripos($_SERVER['REQUEST_URI'], 'complete') !== false)
		{
			header('Location: ' . $url);
			exit;
		}

		return $link;
	}
?>
