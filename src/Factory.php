<?php

namespace Gibbo\Foursquare\Client;

use Gibbo\Foursquare\Client\Factory\Venue\DetailFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Gibbo\Foursquare\Client\Factory\CategoryFactory;
use Gibbo\Foursquare\Client\Factory\ContactFactory;
use Gibbo\Foursquare\Client\Factory\LocationFactory;
use Gibbo\Foursquare\Client\Factory\Photo\PhotoGroupFactory;
use Gibbo\Foursquare\Client\Factory\Photo\PhotoFactory;
use Gibbo\Foursquare\Client\Factory\Tip\TipFactory;
use Gibbo\Foursquare\Client\Factory\Tip\TipGroupFactory;
use Gibbo\Foursquare\Client\Factory\Venue\VenueFactory;
use Http\Client\Common\HttpMethodsClient;

/**
 * A convenience factory for creating a client using the discovered HTTP client.
 */
class Factory
{
    /**
     * Create a client.
     */
    public static function create(Configuration $configuration)
    {
        return new Client(
            $configuration,
            new HttpMethodsClient(HttpClientDiscovery::find(), MessageFactoryDiscovery::find()),
            static::getVenueFactory()
        );
    }

    /**
     * Get the venue factory.
     *
     * @return VenueFactory
     */
    private static function getVenueFactory()
    {
        return new VenueFactory(
            new DetailFactory(new PhotoFactory()),
            new CategoryFactory(),
            new ContactFactory(),
            new LocationFactory(),
            new TipGroupFactory(new TipFactory()),
            new PhotoGroupFactory(new PhotoFactory())
        );
    }
}
