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

    public function redirect()
    {
        switch ($this->getRequest()->getHppVersion()) {
            case '2':
                break;
            case '1':
            default:
                // redirecting from a server-side integration requires
                // data to be in clear text, so decode the Realex JS
                // library compatible data
                $data = array();

                foreach ($this->data as $key => $value) {
                    $data[$key] = base64_decode($value);
                }

                $this->data = $data;
                break;
        }

        return parent::redirect();
    }
}
