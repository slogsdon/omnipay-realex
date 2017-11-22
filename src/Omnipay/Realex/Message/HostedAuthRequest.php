<?php

namespace Omnipay\Realex\Message;

class HostedAuthRequest extends HostedAbstractRequest
{
    public function setAutoSettle($value)
    {
        return $this->setParameter('autoSettle', $value);
    }

    public function getAutoSettle()
    {
        return $this->getParameter('autoSettle');
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
        return $this->response = new HostedAuthResponse($this, $data);
    }
}
