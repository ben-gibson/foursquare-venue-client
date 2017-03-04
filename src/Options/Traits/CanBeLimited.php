<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

use Assert\Assertion;

/**
 * Can be limited.
 */
trait CanBeLimited
{
    private $limit;

    /**
     * Set the limit.
     *
     * @param int $limit
     *
     * @return self
     */
    public function limit($limit)
    {
        Assertion::integer($limit);
        Assertion::range($limit, 1, 50);

        $this->limit = $limit;

        return $this;
    }
}
