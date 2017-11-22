<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

abstract class HostedCompleteAbstractResponse extends HostedAbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        if ($this->getExpectedHash() !== $this->data['SHA1HASH']) {
            throw new InvalidResponseException("SHA1 hash is invalid");
        }
    }

    abstract public function getExpectedHash();

    public function isSuccessful()
    {
        return ($this->getResult() === '00');
    }

    public function isDecline()
    {
        return (substr($this->getResult(), 0, 1) === '1');
    }

    public function isBankSystemError()
    {
        return (substr($this->getResult(), 0, 1) === '2');
    }

    public function isRealexSystemError()
    {
        return (substr($this->getResult(), 0, 1) === '3');
    }

    public function getResult()
    {
        return (string)$this->data['RESULT'];
    }

    public function getMessage()
    {
        return (string)$this->data['MESSAGE'];
    }

    public function getTransactionId()
    {
        return ($this->data['ORDER_ID']) ? (string)$this->data['ORDER_ID'] : null;
    }

    public function getTransactionReference()
    {
        return ($this->data['PASREF']) ? (string)$this->data['PASREF'] : null;
    }

    public function getAuthCode()
    {
        return ($this->data['AUTHCODE']) ? (string)$this->data['AUTHCODE'] : null;
    }

    public function isRedirect()
    {
        return false;
    }
}
