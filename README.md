pgpTools
========

Lookup and manage PGP keys from keyservers.

[![Build Status](https://travis-ci.org/xqus/pgp-tools.svg?branch=master)](https://travis-ci.org/xqus/pgp-tools)

```php

<?php
use xqus\pgpTools\Lookup;

$key = $lookup->find('email@example.org');

echo $key[0]->fingerprint;

echo $key[0]->uids[0]->name();

```
