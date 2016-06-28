<?php

namespace Bankette\OmnipayHipay\Message;

use Omnipay\Common\Message\AbstractRequest as baseRequest;

/**
 * Hipay Abstract Request.
 *
 * @method Response send()
 */
abstract class AbstractRequest extends baseRequest
{
    protected $endpoint = 'https://stage-secure-gateway.hipay-tpp.com/rest/v1';
    protected $endpoint_test = 'https://stage-secure-gateway.hipay-tpp.com/rest/v1';

    public function getEndPoint()
    {
        if ($this->getTestMode()) {
            return $this->endpoint_test;
        }

        return $this->endpoint;
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function getCardType()
    {
        return $this->getParameter('cardType');
    }

    public function setCardType($value)
    {
        return $this->setParameter('cardType', $value);
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function sendRequest($method, $action, $data = null)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $url = $this->getEndPoint().$action;
        $body = $data ? http_build_query($data) : null;

        $httpRequest = $this->httpClient->createRequest($method, $url, null, $body);
        $httpRequest->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        $httpRequest->setHeader(
            'Authorization',
            sprintf(
                'Basic %s',
                base64_encode(sprintf('%s:%s', $this->getClientId(), $this->getSecret()))
            )
        );

        return $httpRequest->send();
    }

    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    public function setClientId($value)
    {
        return $this->setParameter('clientId', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('test_mode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('test_mode', $value);
    }
}
