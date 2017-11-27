# Omnipay: Realex

**Realex driver with 3D Secure support for Omnipay payment processing library**

[![Build Status](https://travis-ci.org/coatesap/omnipay-realex.png?branch=master)](https://travis-ci.org/coatesap/omnipay-realex)
[![Latest Stable Version](https://poser.pugx.org/coatesap/omnipay-realex/version.png)](https://packagist.org/packages/coatesap/omnipay-realex)
[![Total Downloads](https://poser.pugx.org/coatesap/omnipay-realex/d/total.png)](https://packagist.org/packages/coatesap/omnipay-realex)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Realex (Remote MPI) integration for Omnipay, including optional 3D Secure support.

## Installation

The realex driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "coatesap/omnipay-realex": "~3.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Realex_Remote
* Realex_Hosted

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## 3D Secure

The Realex driver has 3D Secure checking turned off by default.
To enable 3D Secure, make sure you have received a 3D Secure account reference from Realex, then set the `3dSecure` parameter as '1' when you initialise the gateway.

## Refunds

In order to process a refund, you must configure the gateway with the `refundPassword` parameter set to the 'rebate' password that Realex provide you with. In addition, you will need to pass the following parameters, relating to the original transaction: `amount`, `transactionReference`, `transactionId`, `currency`, `authCode`.

## Saved Cards

To save a card, you need to supply the `customerRef` and `cardReference` parameters. If the customer reference doesn't exist on Realex (you can check this with `$response->customerDoesntExist()` ), you must create the customer using `$gateway->createCustomer()`. Once the customer & card is setup, you can authorise a payment by supplying the card reference & customer reference instead of the card details:

```php
$gateway->purchase(
    [
        'transactionId' => $transactionId,
        'customerRef'   => $customerRef,
        'amount'        => $amount,
        'currency'      => $currency,
        'cardReference' => $cardRef,
        'card'          => ['cvv' => $cvv]
    ]
);
```

## Hosted Payment Page (HPP)

Realex offers the ability to handle the entire payment portion through their hosted payment pages, exposed through Omnipay as the `Realex_Hosted` gateway.

### Starting an HPP Request

The Realex driver is set up to work hand-in-hand with the [Realex JavaScript library](https://github.com/realexpayments/rxp-js). To initiate a payment through the Realex HPP, your integration first needs to create the request data:

```php
// configure the gateway with your credentials
$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('heartlandgpsandbox')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);

// construct the reqest with necessary data.
// below is the minimum data required.
$response = $gateway->purchase([
    'amount' => '1.00',
    'currency' => 'USD',
    'transactionId' => getOrderId(),
])->send();

// HPP url for your configured environment where
// the below data is sent via POST using the
// Realex JavaScript library.
$response->getRedirectUrl();

// HPP request data
//
// This is exposed through Omnipay as a PHP array,
// so this value will need to be encoded as JSON
// to be properly used by the Realex JavaScript
// library.
$response->getRedirectData();
```

### Presenting the HPP to the Consumer

Once the redirect URL and data is obtained, it can be used in your payment page integration:

```html
<!DOCTYPE html>
<html>
<head>
  <title>HPP Lightbox Demo</title>
  <meta charset="UTF-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="/rxp-js.js"></script>
  <script>
    // get the HPP URL and JSON from the Omnipay via AJAX.
    // this can also be completed without the AJAX request
    // if desired.
    $(document).ready(function () {
      $.getJSON("/request.php", function (resp) {
        // PHP: $response->getRedirectUrl()
        RealexHpp.setHppUrl(resp.url);
        // PHP: $response->getRedirectData()
        RealexHpp.init("payButtonId", "/response.php", resp.data);
      });
    });
  </script>
</head>
<body>
  <button type="button" id="payButtonId">Checkout Now</button>
</body>
</html>
```

### Handling the HPP Response

The consumer will be shown the hosted payment page to complete payment, and upon completion, the consumer will be redirected to the response URL passed to `RealexHpp.init` in your page's JavaScript (`/response.php` in the example code above). The response URL will need to handle the response from Realex to provide your integration the payment's result:

```php
// configure the gateway with your credentials
$gateway = Omnipay\Omnipay::create('Realex_Hosted')
    ->setMerchantId('heartlandgpsandbox')
    ->setSecret('secret')
    ->setAccount('hpp')
    ->setTestMode(true);

// Realex will send a POST request to your response URL
// with an `hppResponse` value. You can either pass the
// $_POST superglobal drectly as the request parameters:
$response = $gateway->completePurchase($_POST)->send();
// or manually create the parameters if you have another
// preferred method. For example in Laravel:
$response = $gateway->completePurchase(array(
    'hppResponse' => request()->input('hppResponse'),
))->send();

// the standard Omnipay response methods are now available,
// including any methods exposed by Realex_Remote, e.g.:
$response->isSuccessful();
$response->getTransactionReference();
// when available
$response->isRealexSystemError();
```

There is a [basic example project](examples/hosted-payment) under `examples/hosted-payment` that covers these three portions from an end-to-end viewpoint.

### Additional Documentation

Realex provides information around their hosted payment pages on their [developer center](https://developer.realexpayments.com/#!/) which gives additional insight into their HPP's capabilities and any additional features exposed by their JavaScript library.
