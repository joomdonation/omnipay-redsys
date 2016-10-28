<?php

namespace Omnipay\RedSys\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * RedSys Complete Purchase Request
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $query = $this->httpRequest->request;
        $signature = $query->get('Ds_Signature');
        $parameters = $query->get('Ds_MerchantParameters');

        $data = $this->getEncoder()->decode($parameters);

        if (!$this->getSigner()->validateSignature($signature, $parameters, $data['Ds_Order'])) {
            throw new InvalidResponseException('Invalid signature: ' . $signature);
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
