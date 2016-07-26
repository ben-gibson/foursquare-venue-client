<?php

namespace Gibbo\Foursquare\Client\Entity\Traits;

/**
 * Provides the ability to be counted.
 */
trait CanBeCounted
{
    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $collection = $this->getCollection();
        return count($collection);
    }

    /**
     * Get the collection.
     *
     * @return array
     */
    protected abstract function getCollection();
}
