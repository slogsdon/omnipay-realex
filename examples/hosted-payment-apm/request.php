<?php
require '../../vendor/autoload.php';

use Omnipay\Realex\Message\HostedApmPaymentMethods as apmMethods;

$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('realexprepro3')
    ->setSecret('secret')
    ->setAccount('apmtest')
    ->setTestMode(true);



$response = $gateway->purchase([
        'amount' => '10.00',
        'currency' => 'EUR',
        'transactionId' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
        'pmMethods' => array(apmMethods::PAYPAl, apmMethods::TESTPAY, apmMethods::SOFORT, apmMethods::SEPAPM),
        'hppCustomerCountry' => 'US',
        'hppCustomerFirstName' => 'James',
        'hppCustomerLastName' => 'Mason',
        'merchantResponseUrl' => 'https://hpsdomain.dev/response.php',
        'hppTxstatusUrl' => 'https://hpsdomain.dev/response.php',
        'hppVersion' => 2,
        'comment1' => 'new paypal payment',
        'comment2' => 'comment2',
        'cardpaymentbutton' => 'Charge Me',
    ])->send();

if ($response->isRedirect()) {
    $response->redirect();
} else {
    echo 'error in process';
}