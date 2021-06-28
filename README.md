
DEPRECATION NOTICE 
---
This connector will be completely unmaintained and will remain listed until end of year 2021. Thanks to all of you who  trusted it and used it


Slydepay PHP Connector
=====================

You can sign up for a Slydepay Merchant account at https://app.slydepay.com.gh/auth/signup#business_reg

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Slydepay PHP.

```bash
$ composer require slydepay/slydepay-soap
```

This will require Slydepay PHP and all its dependencies. Slydepay PHP requires PHP 5.6 or newer.

## Usage

This is how you would process a payment with the Slydepay PHP Connector

```php
<?php

require 'vendor/autoload.php';

use Slydepay\Order\Order;
use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;

// Instantiate Slydepay
$slydepay = new Slydepay\Slydepay("merchantEmail", "merchantSecretKey");

// Create a list of OrderItems with OrderItem objects
$orderItems = new OrderItems([
    new OrderItem("1234", "Test Product", 10, 2),
    new OrderItem("1284", "Test Product2", 20, 2),
]);

// Shipping and tax pulled either from ini/properties file. Hard coded here for illustration
$shippingCost = 20; 
$tax = 10;

// Create the Order object for this transaction. 
$order = Order::createWithId(
    $orderItems,
    "order_id_1", 
    $shippingCost,
    $tax,
    "description",
    "no comment"
);

try {
    // Make request to Slydepay and get the response object for the redirect url
    $response = $slydepay->processPaymentOrder($order);
    echo $response->redirectUrl();
} catch (Slydepay\Exception\ProcessPayment $e) {
    echo $e->getMessage();
}
```

## Tests

To execute the test suite, you'll need [kahlan](https://github.com/kahlan/kahlan).

```bash
$ kahlan
```

Or
```bash
$ php pathtoproject/vendor/bin/kahlan
```
