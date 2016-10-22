<?php

namespace Gibbo\Foursquare\Client\Entity\Photo;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeArrayAccessed;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeCounted;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeIterated;

/**
 * Represents a photo group.
 */
class PhotoGroup implements \Countable, \Iterator, \ArrayAccess
{
    use CanBeCounted;
    use CanBeIterated;
    use CanBeArrayAccessed;

    private $name;
    private $type;
    private $photos;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $type
     * @param Photo[] $photos
     */
    public function __construct($name, $type, array $photos)
    {
        \Assert\that($name)->string()->notEmpty();
        \Assert\that($type)->string()->notEmpty();

        Assertion::allIsInstanceOf($photos, Photo::class);

        $this->name   = $name;
        $this->type   = $type;
        $this->photos = $photos;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get photos.
     *
     * @return Photo[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCollection()
    {
        return $this->getPhotos();
    }
}
