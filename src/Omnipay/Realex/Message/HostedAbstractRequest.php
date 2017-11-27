<?php

namespace Omnipay\Realex\Message;

abstract class HostedAbstractRequest extends RemoteAbstractRequest
{
    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    public function getChannel()
    {
        return $this->getParameter('channel');
    }

    public function setTimestamp($value)
    {
        return $this->setParameter('timestamp', $value);
    }

    public function getTimestamp()
    {
        return $this->getParameter('timestamp');
    }

    public function setHppVersion($value)
    {
        return $this->setParameter('hppVersion', $value);
    }

    public function getHppVersion()
    {
        return $this->getParameter('hppVersion');
    }

    public function getEndpoint()
    {
        return $this->getTestMode()
            ? 'https://pay.sandbox.realexpayments.com/pay'
            : 'https://pay.realexpayments.com/pay';
    }

    public function getData()
    {
        $this->validate('amount', 'currency', 'transactionId');

        if (!$this->getTimestamp()) {
            $this->setTimestamp(strftime("%Y%m%d%H%M%S"));
        }

        $timestamp = $this->getTimestamp();
        $merchantId = $this->getMerchantId();
        $orderId = $this->getTransactionId();
        $amount = $this->getAmountInteger();
        $currency = $this->getCurrency();

        $request = array(
            'TIMESTAMP' => $this->encode($timestamp),
            'MERCHANT_ID' => $this->encode($merchantId),
            'ORDER_ID' => $this->encode($orderId),
            'AMOUNT' => $this->encode($amount),
            'CURRENCY' => $this->encode($currency),
            'SHA1HASH' => $this->encode($this->getRequestHash()),
        );

        if ($this->getReturnUrl()) {
            $request['MERCHANT_RESPONSE_URL'] = $this->encode($this->getReturnUrl());
        }

        return $request;
    }

    public function getRequestHash()
    {
        return '';
    }

    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    protected function encode($data)
    {
        switch ($this->getHppVersion()) {
            case '2':
                return $data;
            case '1':
            default:
                return base64_encode($data);
        }
    }
}
