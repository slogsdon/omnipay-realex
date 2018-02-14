<?php
require '../../vendor/autoload.php';


$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('realexprepro3')
    ->setSecret('secret')
    ->setAccount('apmtest')
    ->setTestMode(true);
	


$response = $gateway->apmPayment([
        'amount' => '10.00',
        'currency' => 'EUR',
        'transactionId' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
        'pmMethods' => 'cards|paypal|testpay|sepapm|sofort',
        'hppCustomerCountry' => 'US',
        'hppCustomerFirstName' => 'James',
        'hppCustomerLastName' => 'Mason',
        'merchantResponseUrl' => 'http://localhost/master_branches/omnipay-realex/examples/hosted-payment-apm/response.php',
        'hppTxstatusUrl' => 'http://localhost/master_branches/omnipay-realex/examples/hosted-payment-apm/response.php',
		'hppVersion' => 2
    ])->send();

//echo '<pre>';
//print_r($response);die;

$response->redirect();