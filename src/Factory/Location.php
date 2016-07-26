<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Entity\Location as LocationEntity;

/**
 * Creates a location from a description.
 */
class Location extends Factory
{
    /**
     * Create a location from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return LocationEntity
     */
    public function create(\stdClass $description)
    {
        $this->parseOptionalParameter($description, 'address');
        $this->parseOptionalParameter($description, 'lat');
        $this->parseOptionalParameter($description, 'lng');
        $this->parseOptionalParameter($description, 'postalCode');
        $this->parseOptionalParameter($description, 'city');
        $this->parseOptionalParameter($description, 'state');
        $this->parseOptionalParameter($description, 'country');

        return new LocationEntity(
            $description->address,
            $this->getCoordinates($description),
            $description->postalCode,
            $description->city,
            $description->state,
            $description->country
        );
    }

    /**
     * Get the locaton coordinates.
     *
     * @param \stdClass $description
     *
     * @return Coordinates|null
     */
    private function getCoordinates(\stdClass $description)
    {
        if (isset($description->lat) === false || isset($description->lng) === false) {
            return null;
        }

        return new Coordinates($description->lat, $description->lng);
    }
}
