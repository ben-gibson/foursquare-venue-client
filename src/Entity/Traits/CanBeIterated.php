<?php

namespace Gibbo\Foursquare\Client\Entity\Traits;

/**
 * Provides the ability to be iterated.
 */
trait CanBeIterated
{
    private $position = 0;

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return empty($this->getCollection()) ? null : $this->getCollection()[$this->position];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->getCollection()[$this->position]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Get the collection.
     *
     * @return array
     */
    protected abstract function getCollection();
}
