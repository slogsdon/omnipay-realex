<?php

namespace Omnipay\Realex\Tests;

//use Omnipay\Tests\GatewayTestCase;
//use Omnipay\Realex\HostedGateway;

class HostedGatewayApmTest
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize(array(
            'merchantId' => 'realexprepro3',
            'account' => 'apmtest',
            'secret' => 'secret',
        ));
    }

    public function testApmAmount()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Realex\Message\HostedApmPaymentRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

}
