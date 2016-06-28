<?php

namespace Bankette\OmnipayHipay\Message;

/**
 * Hipay Complete Purchase Request.
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
    public function getData()
    {
    }

    public function getState()
    {
        return $this->httpRequest->get('state');
    }

    public function getStatus()
    {
        return $this->httpRequest->get('status');
    }

    public function getTransactionReference()
    {
        return $this->httpRequest->get('transaction_reference');
    }
}
