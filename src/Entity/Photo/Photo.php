<?php

namespace Gibbo\Foursquare\Client\Entity\Photo;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeIdentified;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Represents a venue tip.
 */
class Photo
{
    use CanBeIdentified;

    const VISIBILITY_PUBLIC  = 'public';
    const VISIBILITY_PRIVATE = 'private';
    const VISIBILITY_FRIENDS = 'friends';

    private static $visibilityEnum = [
        self::VISIBILITY_PUBLIC,
        self::VISIBILITY_PRIVATE,
        self::VISIBILITY_FRIENDS,
    ];

    private $createdAt;
    private $url;
    private $visibility;

    /**
     * Constructor.
     *
     * @param Identifier $identifier
     * @param \DateTimeImmutable $createdAt
     * @param string $url
     * @param string $visibility
     */
    public function __construct(
        Identifier $identifier,
        \DateTimeImmutable $createdAt,
        $url,
        $visibility
    ) {
        Assertion::choice($visibility, static::$visibilityEnum);
        Assertion::url($url);

        $this->identifier = $identifier;
        $this->createdAt  = $createdAt;
        $this->url        = $url;
        $this->visibility = $visibility;
    }

    /**
     * Get created at.
     *
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get visibility.
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Is this a private photo.
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->visibility === self::VISIBILITY_PRIVATE;
    }

    /**
     * Is this a public photo.
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->visibility === self::VISIBILITY_PUBLIC;
    }
}
