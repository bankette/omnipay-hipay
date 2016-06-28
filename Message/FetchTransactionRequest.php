<?php

namespace Bankette\OmnipayHipay\Message;

/**
 * Hipay Fetch Transaction Request.
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        return array('id' => $this->getTransactionReference());
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/transactions/'.$data['id']);

        return $this->response = new Response($this, $httpResponse->json());
    }
}
