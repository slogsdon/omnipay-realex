<?php

namespace Omnipay\Realex\Message;

/**
 *
 * Example:
 *
 * <code>
 *   // Create a gateway for the Heartland Gateway
 *   // (routes to GatewayFactory::create)
 *   use Omnipay\Realex\Message\HostedApmPaymentMethods as apmMethods;
 * 
 *   $gateway = Omnipay::create('Realex_Hosted');
 * 
 *   // Initialise the gateway
 *   $gateway->setMerchantId('merchant id')
 *           ->setSecret('secret')
 *           ->setAccount('account')
 *           ->setTestMode(true);
 *
 * 	 $response = $gateway->purchase([
 * 			'amount' => '10.00',
 * 			'currency' => 'EUR',
 * 			'transactionId' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
 * 			'pmMethods' => array(apmMethods::PAYPAl, apmMethods::TESTPAY, apmMethods::SOFORT, apmMethods::SEPAPM),
 * 			'hppCustomerCountry' => 'US',
 * 			'hppCustomerFirstName' => 'James',
 * 			'hppCustomerLastName' => 'Mason',
 * 			'merchantResponseUrl' => 'https://YOURDOMAIN/response.php',
 * 			'hppTxstatusUrl' => 'https://YOURDOMAIN/response.php',
 * 			'hppVersion' => 2,
 * 			'comment1' => 'new paypal payment',
 * 			'comment2' => 'comment2',
 * 			'cardpaymentbutton' => 'Charge Me',
 * 		])->send();
 *  
 * 
 *   if ($response->isRedirect()) {
 *       $response->redirect();
 *   }
 * </code>
 *
 * @see  \Omnipay\Realex\Gateway
 * @codingStandardsIgnoreStart
 * @link https://developer.realexpayments.com/#!/hpp/alternative-payment-methods/getting-started
 * @codingStandardsIgnoreEnd
 */

class HostedApmPaymentRequest extends HostedAbstractRequest
{   
    public function getPmMethods()
    {
        return $this->getParameter('pmMethods');
    }

    public function setPmMethods($value = array())
    {
        return $this->setParameter('pmMethods', implode('|', $value));
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
    
    public function getComment1()
    {
        return $this->getParameter('comment1');
    }

    public function setComment1($value)
    {
        return $this->setParameter('comment1', $value);
    }
    
    public function getComment2()
    {
        return $this->getParameter('comment2');
    }

    public function setComment2($value)
    {
        return $this->setParameter('comment2', $value);
    }
    
    public function getCardPaymentButton()
    {
        return $this->getParameter('cardpaymentbutton');
    }

    public function setCardPaymentButton($value)
    {
        return $this->setParameter('cardpaymentbutton', $value);
    }        
    
    public function getRequestHash()
    {
        $timestamp = $this->getTimestamp();
        $merchantId = $this->getMerchantId();
        $orderId = $this->getTransactionId();
        $amount = $this->getAmountInteger();
        $currency = $this->getCurrency();
        $secret = $this->getSecret();
        $tmp = "$timestamp.$merchantId.$orderId.$amount.$currency";
        $sha1hash = sha1($tmp);
        $tmp2 = "$sha1hash.$secret";
        return sha1($tmp2);
    }

    public function getData()
    {
        $request = parent::getData();
        
        $this->validate('hppCustomerCountry', 'hppCustomerFirstName', 'hppCustomerLastName', 'merchantResponseUrl', 'hppTxstatusUrl');

        $request['HPP_VERSION'] = $this->encode($this->getHppVersion());        
        $request['HPP_CUSTOMER_COUNTRY'] = $this->encode($this->getHppCustomerCountry());
        $request['HPP_CUSTOMER_FIRSTNAME'] = $this->encode($this->getHppCustomerFirstName());
        $request['HPP_CUSTOMER_LASTNAME'] = $this->encode($this->getHppCustomerLastName());
        $request['MERCHANT_RESPONSE_URL'] = $this->encode($this->getMerchantResponseUrl());
        $request['HPP_TX_STATUS_URL'] = $this->encode($this->getHppTxstatusUrl());
        
        if ($this->getPmMethods()) {
            $request['PM_METHODS'] = $this->encode($this->getPmMethods());
        }
        
        if($this->getComment1()) {
            $request['comment1'] = $this->encode($this->getComment1());
        }
        
        if($this->getComment2()) {
            $request['comment2'] = $this->encode($this->getComment2());
        }
        
        if($this->getCardPaymentButton()) {
            $request['CARD_PAYMENT_BUTTON'] = $this->encode($this->getCardPaymentButton());
        }

        return $request;
    }

    protected function createResponse($data)
    {        
        return $this->response = new HostedApmPaymentResponse($this, $data);
    }
}
