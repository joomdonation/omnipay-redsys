<?php

namespace Omnipay\RedSys;

use Omnipay\Common\AbstractGateway;
use Omnipay\RedSys\Message\CompletePurchaseRequest;
use Omnipay\RedSys\Message\PurchaseRequest;

/**
 * RedSys Gateway
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'RedSys';
    }

    public function getDefaultParameters()
    {
        return array(
            'consumerLanguage' => '001',
            'currency' => '978',
            'terminal' => '001',
            'merchantName' => '',
            'transactionType' => '0',
            'testMode' => false
        );
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

    public function setReturnUrl($returnUrl)
    {
        return $this->setParameter('returnUrl', $returnUrl);
    }

    public function setCancelUrl($cancelUrl)
    {
        return $this->setParameter('cancelUrl', $cancelUrl);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }
}
