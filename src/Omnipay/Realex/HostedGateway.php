<?php
namespace Omnipay\Realex;

class HostedGateway extends RemoteGateway
{
    public function getName()
    {
        return 'Realex Hosted';
    }
    
    public function getCardPaymentButton()
    {
        return $this->getParameter('cardpaymentbutton');
    }

    public function setCardPaymentButton($value)
    {
        return $this->setParameter('cardpaymentbutton', $value);
    }        
    
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\HostedAuthRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        $parameters['autoSettle'] = '1';        
        if (!empty($parameters['hppCustomerCountry']) || !empty($parameters['hppCustomerFirstName']) || !empty($parameters['hppCustomerLastName'])) {
            $parameters['hppVersion'] = 2;        
            return $this->apmPayment($parameters);
        } else {
            return $this->authorize($parameters);
        }
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\HostedCompleteAuthRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->completeAuthorize($parameters);
    }
    
    public function apmPayment(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\HostedApmPaymentRequest', $parameters);
    }
}
