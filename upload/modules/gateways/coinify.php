<?php
define('coinify_plugin_name', 'WHMCS');
define('coinify_plugin_version', '0.4');

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
    if (class_exists('CoinifyAPI') === false){
        require_once('coinify/CoinifyAPI.php');
    }

    $api = new CoinifyAPI( $params["api"], $params["secret"] );

    $custom = array('invoiceid' => $params['invoiceid']);

    $result = $api->invoiceCreate(
        $params["amount"],
        $params['currency'],
        coinify_plugin_name,
        coinify_plugin_version,
        $params["description"],
        $custom,
        $params['systemurl'] . '/modules/gateways/callback/coinify.php',
        null,
        $params['systemurl'] . '/viewinvoice.php?id=' . $params['invoiceid']
    );

    $code = <<<EOT
<form id="myForm" method="GET" action="{$result['data']['payment_url']}">
    <input type="submit" value="Pay Now" />
</form>
EOT;
    return $code;
}
?>
