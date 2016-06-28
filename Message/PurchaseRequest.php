<?php

namespace Bankette\OmnipayHipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Hipay Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency', 'description');

        $tokenRequest = new TokenRequest($this->httpClient, $this->httpRequest);
        $tokenRequest->initialize($this->parameters->all());
        /** @var TokenResponse $tokenResponse */
        $tokenResponse = $tokenRequest->send();

        if (!$tokenResponse->isSuccessful()) {
            throw new InvalidRequestException(
                sprintf(
                    'The card was not accepted for tokenization : "%s", %s',
                    $tokenResponse->getError(),
                    $_SERVER['SERVER_ADDR']
                )
            );
        }

        $data =
        [
            'orderid' => uniqid(),
            'description' => $this->getDescription(),
            'payment_product' => $this->getCardType(),
            'currency' => $this->getCurrency(),
            'amount' => $this->getAmount(),
            'ipaddr' => $this->getClientIp(),
            'cardtoken' => $tokenResponse->getToken(),
            'eci' => 1,
        ];

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', '/order', $data);

        return $this->response = new PurchaseResponse($this, $httpResponse->xml());
    }
}
