<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Aware of a radius
 */
interface RadiusAware
{
    /**
     * Get radius.
     *
     * @return int
     */
    public function getRadius();

    /**
     * Set radius.
     *
     * @param int $meters
     *
     * @return self
     */
    public function setRadius($meters);
}
