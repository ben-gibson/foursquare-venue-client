<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

use Assert\Assertion;

/**
 * Can support radius.
 */
trait CanSupportRadius
{
    private $radius;

    /**
     * Set the radius in meters.
     *
     * @param int $meters
     *
     * @return self
     */
    public function radius($meters)
    {
        Assertion::integer($meters);
        Assertion::range($meters, 1, 100000);

        $this->radius = $meters;

        return $this;
    }
}
