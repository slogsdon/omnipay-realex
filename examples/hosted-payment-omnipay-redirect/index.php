<?php

require '../../vendor/autoload.php';

$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('merchant id')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);

$response = $gateway->purchase([
    'amount' => '1.00',
    'currency' => 'USD',
    'transactionId' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
    'returnUrl' => 'http://' . $_SERVER['HTTP_HOST'] . '/response.php',
])->send();

$response->redirect();
