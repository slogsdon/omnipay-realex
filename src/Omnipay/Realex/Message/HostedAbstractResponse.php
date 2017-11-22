<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class HostedAbstractResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $data;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isDecline()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }

    public function getRedirectUrl()
    {
        return $this->getRequest()->getEndpoint();
    }
}
