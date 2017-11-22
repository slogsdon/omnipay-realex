<?php

namespace Omnipay\Realex\Message;

class HostedCompleteAuthResponse extends HostedCompleteAbstractResponse
{
    public function getExpectedHash()
    {
        $timestamp = $this->data['TIMESTAMP'];
        $merchantId = $this->getRequest()->getMerchantId();
        $orderId = $this->getTransactionId();
        $result = $this->getResult();
        $message = $this->getMessage();
        $pasref = $this->getTransactionReference();
        $authcode = $this->getAuthCode();
        $secret = $this->getRequest()->getSecret();
        $tmp = "$timestamp.$merchantId.$orderId.$result.$message.$pasref.$authcode";
        $sha1hash = sha1($tmp);
        $tmp2 = "$sha1hash.$secret";
        return sha1($tmp2);
    }
}
