<?php
require '../../vendor/autoload.php';


$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('heartlandgpsandbox')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);


$response = $gateway->apmPayment([
        'amount' => '1.00',
        'currency' => 'USD',
        'transactionId' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
        'pmMethods' => 'paypal',
        'hppCustomerCountry' => 'DE',
        'hppCustomerFirstName' => 'James',
        'hppCustomerLastName' => 'Mason',
        'merchantResponseUrl' => 'https://developer.heartlandpaymentsystems.com',
        'hppTxstatusUrl' => 'https://developer.heartlandpaymentsystems.com',
    ])->send();

$response->redirect();
