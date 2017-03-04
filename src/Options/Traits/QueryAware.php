<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Aware of a query.
 */
interface QueryAware
{

    /**
     * Set the query.
     *
     * @param string $query
     *
     * @return self
     */
    public function query($query);
}
