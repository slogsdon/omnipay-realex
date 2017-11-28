<?php

namespace Omnipay\Realex\Message;

class HostedApmPaymentRequest extends HostedAbstractRequest
{
    public function getPmMethods()
    {
        return $this->getParameter('pmMethods');
    }

    public function setPmMethods($value)
    {
        return $this->setParameter('pmMethods', $value);
    }

    public function getHppCustomerCountry()
    {
        return $this->getParameter('hppCustomerCountry');
    }

    public function setHppCustomerCountry($value)
    {
        return $this->setParameter('hppCustomerCountry', $value);
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

        if ($this->getAccount()) {
            $request['ACCOUNT'] = $this->encode($this->getAccount());
        }

        if ($this->getChannel()) {
            $request['CHANNEL'] = $this->encode($this->getChannel());
        }

        if ($this->getAutoSettle()) {
            $request['AUTO_SETTLE_FLAG'] = $this->encode($this->getAutoSettle());
        }

        return $request;
    }

    protected function createResponse($data)
    {
        return $this->response = new HostedApmPaymentResponse($this, $data);
    }
}
