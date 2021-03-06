# Foursquare Venue API Client

[![Join the chat at https://gitter.im/foursquare-venue-client/Lobby](https://badges.gitter.im/foursquare-venue-client/Lobby.svg)](https://gitter.im/foursquare-venue-client/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

A `PHP` client library for interacting with the `Foursquare` userless venue API.
[HTTPlug](http://httplug.io/) is used to support multiple `HTTP` 
clients including `Guzzle`, `Buzz`, and `Curl`.

## Install

Use composer to install this library and your preferred `HTTP` client.

``` bash
$ composer require php-http/guzzle6-adapter
$ composer require ben-gibson/foursquare-venue-client
```

## Usage

``` php
<?php

require_once __DIR__.'/../vendor/autoload.php';

use Gibbo\Foursquare\Client\Client;
use Gibbo\Foursquare\Client\Configuration;
use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Factory\Venue\VenueFactory;
use Gibbo\Foursquare\Client\Identifier;
use Gibbo\Foursquare\Client\Options\Search;

$client = Client::simple(new Configuration('client-id', 'client-secret'), VenueFactory::simple());

// Get by id
$venue = $client->getVenue(new Identifier('430d0a00f964a5203e271fe3'));

$venue->getName();
$venue->getDetails()->getRating();

// Search by coordinates
$options = Search::coordinates(new Coordinates(28.538336, -81.379234))
    ->limit(10)
    ->radius(500)
    ->query('Donuts');

$venues = $client->search($options);

// Search by place
$options = Search::place('Chicago, IL')
    ->limit(10)
    ->radius(500)
    ->query('Donuts');

$venues = $client->search($options);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email ben.gibson.2011@gmail.com instead of using the issue tracker.

## Credits

- [Ben Gibson][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ben-gibson/foursquare-venue-client.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ben-gibson/foursquare-venue-client/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ben-gibson/foursquare-venue-client.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/ben-gibson/foursquare-venue-client
[link-travis]: https://travis-ci.org/ben-gibson/foursquare-venue-client
[link-downloads]: https://packagist.org/packages/ben-gibson/foursquare-venue-client
[link-author]: https://github.com/ben-gibson
[link-contributors]: ../../contributors
