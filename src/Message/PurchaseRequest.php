<?php

namespace Omnipay\RedSys\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * RedSys Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://sis.redsys.es/sis/realizarPago';

    protected $testEndpoint = 'https://sis-t.redsys.es:25443/sis/realizarPago';

    public function setTransactionId($value)
    {
        if (!preg_match('/^[0-9]{4}[0-9a-zA-Z]{0,8}$/', $value)) {
            throw new \InvalidArgumentException('Invalid transaction id');
        }
        return parent::setTransactionId($value);
    }

    public function setTransactionReference($value)
    {
        if (!preg_match('/^[0-9]{4}[0-9a-zA-Z]{0,8}$/', $value)) {
            throw new \InvalidArgumentException('Invalid transaction reference');
        }
        return parent::setTransactionReference($value);
    }

    public function setTitular($titular)
    {
        return $this->setParameter('titular', $titular);
    }

    public function setMerchantName($merchantName)
    {
        return $this->setParameter('merchantName', $merchantName);
    }

    public function setMerchantCode($merchantCode)
    {
        return $this->setParameter('merchantCode', $merchantCode);
    }

    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    public function setTerminal($terminal)
    {
        return $this->setParameter('terminal', $terminal);
    }

    public function setConsumerLanguage($consumerLanguage)
    {
        return $this->setParameter('consumerLanguage', $consumerLanguage);
    }

    public function getTransactionType()
    {
        return '0';
    }

    public function getData()
    {
        $data = [];
        $data['Ds_Merchant_Amount'] = $this->getAmountInteger();
        $data['Ds_Merchant_Currency'] = $this->getCurrencyNumeric();
        $data['Ds_Merchant_Order'] = $this->getTransactionReference() ?: $this->getTransactionId();
        $data['Ds_Merchant_ProductDescription'] = $this->getDescription();
        $data['Ds_Merchant_Titular'] = $this->getParameter('titular');
        $data['Ds_Merchant_MerchantCode'] = $this->getParameter('merchantCode');
        $data['Ds_Merchant_MerchantURL'] = $this->getNotifyUrl();
        $data['Ds_Merchant_UrlOK'] = $this->getReturnUrl();
        $data['Ds_Merchant_UrlKO'] = $this->getCancelUrl();
        $data['Ds_Merchant_MerchantName'] = $this->getParameter('merchantName');
        $data['Ds_Merchant_ConsumerLanguage'] = $this->getParameter('consumerLanguage');
        $data['Ds_Merchant_Terminal'] = $this->getParameter('terminal');
        $data['Ds_Merchant_TransactionType'] = $this->getTransactionType();

        $data['Ds_Merchant_MerchantSignature'] = $this->generateSignature($data);

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function generateSignature($data)
    {
        $input = $data['Ds_Merchant_Amount'] . $data['Ds_Merchant_Order'] . $data['Ds_Merchant_MerchantCode'] . $data['Ds_Merchant_Currency'] . $data['Ds_Merchant_TransactionType'] . $data['Ds_Merchant_MerchantURL'];

        return hash('sha1', $input . $this->getParameter('secretKey'));
    }
}
