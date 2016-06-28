<?php

namespace Bankette\OmnipayHipay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Hipay Token Response.
 */
class TokenResponse extends Response implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return (bool) $this->getToken();
    }

    public function isRedirect()
    {
        return false;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        return;
    }

    public function getRedirectData()
    {
        return;
    }

    public function getToken()
    {
        if (isset($this->getData()->token)) {
            return (string) $this->getData()->token;
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
}
