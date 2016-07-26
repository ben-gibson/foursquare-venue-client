<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Aware of a limit.
 */
interface LimitAware
{
    /**
     * Get limit.
     *
     * @return int
     */
    public function getLimit();

    /**
     * Set the limit.
     *
     * @param int $limit
     *
     * @return self
     */
    public function setLimit($limit);
}
