<?php

namespace Omnipay\Realex\Message;

class HostedCompleteAuthRequest extends HostedCompleteAbstractRequest
{
    public function getRequiredProperties()
    {
        return array(
            'AVSPOSTCODERESULT',
            'AVSADDRESSRESULT',
            'CVNRESULT',
            'AMOUNT',
        );
    }

    protected function createResponse($data)
    {
        return $this->response = new HostedCompleteAuthResponse($this, $data);
    }
}
