<?php

namespace Omnipay\Realex\Tests;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Realex\HostedGateway;

class HostedGatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize(array(
            'merchantId' => 'Merchant Id',
            'account' => 'account',
            'secret' => 'secret',
        ));
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Realex\Message\HostedAuthRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Realex\Message\HostedAuthRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }
}
