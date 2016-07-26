<?php

namespace Gibbo\Foursquare\Client\Entity;

use Assert\Assertion;

/**
 * A value object for coordinates.
 */
class Coordinates
{
    private $latitude;
    private $longitude;

    /**
     * Constructor.
     *
     * @param float $latitude The latitude.
     * @param float $longitude The longitude.
     */
    public function __construct($latitude, $longitude)
    {
        Assertion::float($latitude);
        Assertion::float($longitude);

        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get the latitude.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Get the longitude.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getLatitude() .','. $this->getLongitude();
    }
}
