<?php

namespace Bankette\OmnipayHipay\Message;

/**
 * Hipay Purchase Request.
 */
class TokenRequest extends AbstractRequest
{
    protected $endpoint = 'https://stage-secure-vault.hipay-tpp.com/rest/v1';
    protected $endpoint_test = 'https://stage-secure-vault.hipay-tpp.com/rest/v1';

    public function getData()
    {
        $this->getCard()->validate();

        $data =
        [
            'card_number' => $this->getCard()->getNumber(),
            'card_expiry_month' => sprintf('%02d', $this->getCard()->getExpiryMonth()),
            'card_expiry_year' => $this->getCard()->getExpiryYear(),
            'cvc' => $this->getCard()->getCvv(),
        ];

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', '/token/create', $data);

        return $this->response = new TokenResponse($this, $httpResponse->xml());
    }
}
