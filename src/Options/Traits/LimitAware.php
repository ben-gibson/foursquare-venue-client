<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Aware of a limit.
 */
interface LimitAware
{

    /**
     * Set the limit.
     *
     * @param int $limit
     *
     * @return self
     */
    public function limit($limit);
}
