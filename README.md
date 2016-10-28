Omnipay: RedSys
===============

**RedSys driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements RedSys (formerly Sermepa) support for Omnipay.

**Update (28-10-2016)**: Now working with the new HMAC SHA256 signature, mandatory with Redsys.

Installation
------------

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "swisnl/omnipay-redsys": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

Basic Usage
-----------

The following gateways are provided by this package:

* RedSys

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.
