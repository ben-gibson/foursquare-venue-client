<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Aware of a query.
 */
interface QueryAware
{
    /**
     * Get the query.
     *
     * @return string
     */
    public function getQuery();

    /**
     * Set the query.
     *
     * @param string $query
     *
     * @return self
     */
    public function setLimit($query);
}
