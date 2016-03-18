<?php

namespace Omnipay\RedSys\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * RedSys Complete Purchase Request
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $this->validate('Ds_Signature');

        $data = $this->httpRequest->request->all();

        if ($this->generateSignature($data) !== $this->httpRequest->request->get('Ds_Signature')) {
            throw new InvalidRequestException('Incorrect signature');
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    protected function generateSignature($data)
    {
        $input = $data['Ds_Amount'] . $data['Ds_Order'] . $data['Ds_MerchantCode'] . $data['Ds_Currency'] . $data['Ds_Response'];

        return hash('sha1', $input . $this->getParameter('merchantKey'));
    }
}
