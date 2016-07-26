<?php

namespace Gibbo\Foursquare\Client\Entity\Traits;

/**
 * Provides the ability to be array accessed.
 */
trait CanBeArrayAccessed
{
    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $collection = $this->getCollection();

        if (is_null($offset)) {
            $collection[] = $value;
        } else {
            $collection[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $collection = $this->getCollection();
        return isset($collection[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $collection = $this->getCollection();
        unset($collection[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $collection = $this->getCollection();
        return isset($collection[$offset]) ? $collection[$offset] : null;
    }

    /**
     * Get the collection.
     *
     * @return array
     */
    protected abstract function getCollection();
}
