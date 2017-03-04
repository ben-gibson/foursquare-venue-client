<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Can be queried.
 */
trait CanBeQueried
{
    private $query;

    /**
     * Set the query.
     *
     * @param string $query
     *
     * @return self
     */
    public function query($query)
    {
        \Assert\that($query)->string()->notEmpty();

        $this->query = $query;

        return $this;
    }
}
