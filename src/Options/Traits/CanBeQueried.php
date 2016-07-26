<?php

namespace Gibbo\Foursquare\Client\Options\Traits;

/**
 * Can be queried.
 */
trait CanBeQueried
{
    private $query;

    /**
     * Get query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the query.
     *
     * @param string $query
     *
     * @return self
     */
    public function setQuery($query)
    {
        \Assert\that($query)->string()->notEmpty();

        $this->query = $query;

        return $this;
    }
}
