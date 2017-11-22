<?php

require '../../vendor/autoload.php';

$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('merchant id')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);

$response = $gateway->completePurchase($_POST)->send();
echo '<pre>' . print_r($response, true) . '</pre>';
