<?php
namespace Omnipay\Realex;

class HostedGateway extends RemoteGateway
{

    public function getName()
    {
        return 'Realex Hosted';
    }

    public function getDefaultParameters()
    {
        return array(            
            'pmMethods' => '',
            'hppCustomerCountry' => '',
            'hppCustomerFirstName' => '',
            'hppCustomerLastName' => '',
            'merchantResponseUrl' => '',
            'hppTxstatusUrl' => '',
            'hppVersion' => '',
        );
    }

    public function getPmMethods()
    {
        return $this->getParameter('pmMethods');
    }

    public function setPmMethods($value)
    {
        return $this->setParameter('pmMethods', $value);
    }
    
    public function getHppCustomerFirstName()
    {
        return $this->getParameter('hppCustomerFirstName');
    }

    public function setHppCustomerFirstName($value)
    {
        return $this->setParameter('hppCustomerFirstName', $value);
    }

    public function getHppCustomerLastName()
    {
        return $this->getParameter('hppCustomerLastName');
    }

    public function setHppCustomerLastName($value)
    {
        return $this->setParameter('hppCustomerLastName', $value);
    }

    public function getMerchantResponseUrl()
    {
        return $this->getParameter('merchantResponseUrl');
    }

    public function setMerchantResponseUrl($value)
    {
        return $this->setParameter('merchantResponseUrl', $value);
    }

    public function getHppTxstatusUrl()
    {
        return $this->getParameter('hppTxstatusUrl');
    }

    public function setHppTxstatusUrl($value)
    {
        return $this->setParameter('hppTxstatusUrl', $value);
    }

    public function setHppVersion($value)
    {
        return $this->setParameter('hppVersion', $value);
    }

    public function getHppVersion()
    {
        return $this->getParameter('hppVersion');
    }
    
    public function getHppCustomerCountry()
    {
        return $this->getParameter('hppCustomerCountry');
    }

    public function setHppCustomerCountry($value)
    {
        return $this->setParameter('hppCustomerCountry', $value);
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
    
    public function apmPayment(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\HostedApmPaymentRequest', $parameters);
    }
}
