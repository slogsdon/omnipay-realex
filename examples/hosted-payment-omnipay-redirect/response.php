<?php

require '../../vendor/autoload.php';

// This file won't get hit in test unless hosted on a publicly
// accessible domain due to a limitation of Realex.
//
// If this is an issue for production, please use an integration
// using the Realex JavaScript library to get around this
// restriction.

$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('merchant id')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);

$response = $gateway->completePurchase($_POST)->send();
echo '<pre>' . print_r($response, true) . '</pre>';
