<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Aware of a radius
 */
interface RadiusAware
{

    /**
     * Set radius.
     *
     * @param int $meters
     *
     * @return self
     */
    public function radius($meters);
}
