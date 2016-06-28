# Omnipay - Hipay gateway

Omnipay gateway for hipay.

This code needs amelioration but is a good base to integrate hipay in your omnipay.
Please feel free to fork and do PR to improve this library.

## Purchase

Here is a code example for symfony to send a purchase request to hipay.

```php
use Bankette\OmnipayHipay\Gateway;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Payment by hipay Action.
 *
 * @return Response
 */
    public function hipayPaymentAction(SymfonyRequest $request)
    {
        $data = [
            'orderid' => 'my-order-id',
            'amount' => 10,
            'currency' => 'EUR',
            'card' => [
                'number' => '4000000000000002',
                'expiryMonth' => '10',
                'expiryYear' => '2020',
                'cvv' => '123',
            ],
            'cardtype' => 'visa',
            'description' => 'description',
        ];

        $gateway = new Gateway();
        $gateway->setClientId($this->username);
        $gateway->setSecret($this->password);
        $gateway->setTestMode(true);
        $purchaseResponse = $gateway->purchase($data)->send();

        if (!$purchaseResponse->isSuccessful() && !$purchaseResponse->isRedirect()) {
            throw new BadRequestHttpException($purchaseResponse->getError());
        }

        if ($purchaseResponse->isSuccessful()) {
            // Payment validated
        }

        if ($purchaseResponse->isRedirect() && $purchaseResponse->getRedirectUrl()) {
            // Payment waiting for 3D secure validation
        }
        // ...
    }
```

## Notify

After a purchase request, hipay will send notifications on the 'notification URL' defined in hipay back-office.
The below controller will be called directly by hipay API on your API.

```php
    /**
     * @return Response
     *
     * @Route("/hipay/notify")
     *
     * @Method("POST")
     *
     * @View()
     *
     * @throws NotFoundHttpException
     */
    public function hipayNotifyAction(SymfonyRequest $request)
    {
        $gateway = new Gateway();

        $response = $gateway->completePurchase();

        switch ($response->getStatus()) {
            // Status "Cardholder Enrolled"
            case '103':
            // Status "Cardholder Not Enrolled"
            case '104':
            // Status "Authorized"
            case '116':
            // Status "Capture Requested"
            case '117':
                // do something
                break;

            // Status "Captured"
            case '118':
                // do something
                break;

            // Status "Could Not Authenticate"
            case '108':
            // Status "Authentication Failed"
            case '109':
            // Status "Refused"
            case '113':
            // Status "Expired"
            case '114':
                // do something
                break;

            default:
                // do something
                break;
        }

        return new Response();
    }

```