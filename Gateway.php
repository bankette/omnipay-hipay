<?php

namespace Bankette\OmnipayHipay;

use Omnipay\Common\AbstractGateway;

/**
 * Hipay Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Hipay';
    }

    /**
     * @param array $parameters
     *
     * @return \Bankette\OmnipayHipay\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Bankette\OmnipayHipay\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Bankette\OmnipayHipay\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(
            '\Bankette\OmnipayHipay\Message\CompletePurchaseRequest',
            $parameters
        );
    }

    /**
     * @param array $parameters
     *
     * @return \Bankette\OmnipayHipay\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        // TODO
    }

    /**
     * Get client ID for the basic authentication.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * Set client ID for the basic authentication.
     *
     * @param string $value
     *
     * @return Gateway
     */
    public function setClientId($value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * Get secret for the basic authentication.
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * Set secret for the basic authentication.
     *
     * @param string $value
     *
     * @return Gateway
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * Is test mode?
     *
     * @return bool
     */
    public function getTestMode()
    {
        return $this->getParameter('test_mode');
    }

    /**
     * Set test mode to true or false.
     *
     * @param bool $value
     *
     * @return Gateway
     */
    public function setTestMode($value)
    {
        return $this->setParameter('test_mode', $value);
    }
}
