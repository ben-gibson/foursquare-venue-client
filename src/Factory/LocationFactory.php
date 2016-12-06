<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Entity\Location as LocationEntity;

/**
 * Creates a location from a description.
 */
class LocationFactory
{
    /**
     * Create a location from a description.
     *
     * @param Description $description The location description.
     *
     * @return LocationEntity
     */
    public function create(Description $description)
    {
        return new LocationEntity(
            $description->getOptionalProperty('address'),
            $this->getCoordinates($description),
            $description->getOptionalProperty('postalCode'),
            $description->getOptionalProperty('city'),
            $description->getOptionalProperty('state'),
            $description->getOptionalProperty('country')
        );
    }

    /**
     * Get the locaton coordinates.
     *
     * @param Description $description The location description.
     *
     * @return Coordinates|null
     */
    private function getCoordinates(Description $description)
    {
        $latitude  = $description->getOptionalProperty('lat');
        $longitude = $description->getOptionalProperty('lng');

        if ($latitude === null || $longitude === null) {
            return null;
        }

        return new Coordinates($latitude, $longitude);
    }
}
