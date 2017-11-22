<?php

namespace Omnipay\Realex;

class HostedGateway extends RemoteGateway
{
    public function getName()
    {
        return 'Realex Hosted';
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\HostedAuthRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        $parameters['autoSettle'] = '1';
        return $this->authorize($parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\HostedCompleteAuthRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->completeAuthorize($parameters);
    }
}
