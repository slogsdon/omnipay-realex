<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Exception\InvalidRequestException;

abstract class HostedCompleteAbstractRequest extends HostedAbstractRequest
{
    protected $baseProperties = [
        'RESULT',
        'AUTHCODE',
        'MESSAGE',
        'PASREF',
        'ACCOUNT',
        'MERCHANT_ID',
        'ORDER_ID',
        'TIMESTAMP',
        'SHA1HASH',
    ];

    public function getHppResponse()
    {
        return $this->getParameter('hppResponse');
    }

    public function setHppResponse($value)
    {
        return $this->setParameter('hppResponse', $value);
    }

    public function getBaseProperties()
    {
        return $this->baseProperties;
    }

    abstract public function getRequiredProperties();

    public function getData()
    {
        $this->validate('hppResponse');

        $data = (array)json_decode($this->getHppResponse());

        if ($data === false) {
            throw new InvalidRequestException("Improperly formatted value for hppResponse");
        }

        $response = array();
        $requiredProperties = array_merge($this->getBaseProperties(), $this->getRequiredProperties());

        foreach ($requiredProperties as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidRequestException(
                    sprintf("Missing key '%s' in hppResponse", $key)
                );
            }

            $response[$key] = $this->decode($data[$key]);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $requiredProperties)) {
                continue;
            }

            $response[$key] = $this->decode($value);
        }

        return $response;
    }

    protected function decode($data)
    {
        switch ($this->getHppVersion()) {
            case '2':
                return $data;
            case '1':
            default:
                return base64_decode($data);
        }
    }
}
