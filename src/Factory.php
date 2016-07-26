<?php

namespace Gibbo\Foursquare\Client;

use Gibbo\Foursquare\Client\Factory\Venue\Detail;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Gibbo\Foursquare\Client\Factory\Category;
use Gibbo\Foursquare\Client\Factory\Contact;
use Gibbo\Foursquare\Client\Factory\Location;
use Gibbo\Foursquare\Client\Factory\Photo\Group as PhotoGroup;
use Gibbo\Foursquare\Client\Factory\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Tip\Tip;
use Gibbo\Foursquare\Client\Factory\Tip\Group as TipGroup;
use Gibbo\Foursquare\Client\Factory\Venue\Venue;
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
     * @return Venue
     */
    private static function getVenueFactory()
    {
        return new Venue(
            new Detail(new Photo()),
            new Category(),
            new Contact(),
            new Location(),
            new TipGroup(new Tip()),
            new PhotoGroup(new Photo())
        );
    }
}
