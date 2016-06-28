<?php

namespace Bankette\OmnipayHipay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Hipay Response.
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return 'completed' === $this->getState();
    }

    public function isRedirect()
    {
        if (isset($this->getData()->state)) {
            return 'forwarding' === (string) $this->getData()->state;
        }

        return false;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        if (isset($this->getData()->forward_url)) {
            return (string) $this->getData()->forward_url;
        }

        return false;
    }

    public function getRedirectData()
    {
        return;
    }

    public function getState()
    {
        if (isset($this->getData()->state)) {
            return (string) $this->getData()->state;
        }

        return false;
    }

    public function getStatus()
    {
        if (isset($this->getData()->status)) {
            return (string) $this->getData()->status;
        }

        return false;
    }

    public function getError()
    {
        if (isset($this->getData()->message)) {
            return (string) $this->getData()->message;
        }

        return false;
    }

    public function getTransactionReference()
    {
        if (isset($this->data->transaction_reference)) {
            return $this->data->transaction_reference;
        }
    }
}
