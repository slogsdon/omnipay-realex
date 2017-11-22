<?php

require '../../vendor/autoload.php';

$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('merchant id')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);

header('Content-Type: application/json');


$response = $gateway->purchase([
    'amount' => '1.00',
    'currency' => 'USD',
    'transactionId' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
])->send();

echo json_encode(array(
    'url' => $response->getRedirectUrl(),
    'data' => $response->getRedirectData(),
), JSON_PRETTY_PRINT);
