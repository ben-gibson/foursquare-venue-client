<?php

namespace Gibbo\Foursquare\Client\Entity;

use Assert\Assertion;

/**
 * Represents location information.
 */
class Location
{
    private $address;
    private $coordinates;
    private $postalCode;
    private $city;
    private $state;
    private $country;

    /**
     * Constructor.
     *
     * @param string $address
     * @param Coordinates $coordinates
     * @param string $postalCode
     * @param string $city
     * @param string $state
     * @param string $country
     */
    public function __construct(
        $address = null,
        Coordinates $coordinates = null,
        $postalCode = null,
        $city = null,
        $state = null,
        $country = null
    ) {
        Assertion::nullOrString($address);
        Assertion::nullOrString($postalCode);
        Assertion::nullOrString($city);
        Assertion::nullOrString($state);
        Assertion::nullOrString($country);

        $this->address     = $address;
        $this->coordinates = $coordinates;
        $this->postalCode  = $postalCode;
        $this->city        = $city;
        $this->state       = $state;
        $this->country     = $country;
    }

    /**
     * Get the address.
     *
     * @return null|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the coordiantes.
     *
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Get the postal code.
     *
     * @return null|string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Get the city.
     *
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the state.
     *
     * @return null|string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the country.
     *
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
