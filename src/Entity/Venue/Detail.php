<?php

namespace Gibbo\Foursquare\Client\Entity\Venue;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Photo;

/**
 * A container for more specific venue details.
 */
class Detail
{
    private $verified;
    private $rating;
    private $url;
    private $timeZone;
    private $createdAt;
    private $bestPhoto;
    private $hereNow;
    private $tags;
    private $likes;

    /**
     * Constructor.
     *
     * @param bool $verified
     * @param \DateTimeImmutable|null $createdAt
     * @param Photo\Photo $bestPhoto
     * @param float|null $rating
     * @param string|null $url
     * @param int|null $hereNow
     * @param [string] $tags
     * @param int|null $likes
     * @param \DateTimeZone|null $timeZone
     */
    public function __construct(
        $verified,
        \DateTimeImmutable $createdAt = null,
        Photo\Photo $bestPhoto = null,
        $rating = null,
        $url = null,
        $hereNow = null,
        $tags = [],
        $likes = null,
        \DateTimeZone $timeZone = null
    ) {
        Assertion::boolean($verified);
        Assertion::isArray($tags);
        Assertion::nullOrInteger($likes);
        Assertion::nullOrFloat($rating);
        Assertion::nullOrUrl($url);
        Assertion::nullOrInteger($hereNow);

        $this->verified    = $verified;
        $this->rating      = $rating;
        $this->hereNow     = $hereNow;
        $this->url         = $url;
        $this->createdAt   = $createdAt;
        $this->timeZone    = $timeZone;
        $this->bestPhoto   = $bestPhoto;
        $this->tags        = $tags;
        $this->likes       = $likes;
    }

    /**
     * Get tags.
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get the number of likes.
     *
     * @return int|null
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Get number of users who are here now.
     *
     * @return int|null
     */
    public function getNumberOfUsersHereNow()
    {
        return $this->hereNow;
    }

    /**
     * Get the best photo.
     *
     * @return Photo\Photo|null
     */
    public function getBestPhoto()
    {
        return $this->bestPhoto;
    }

    /**
     * Get the url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Get time zone.
     *
     * @return \DateTimeZone|null
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Get created at.
     *
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Has this venue been verified.
     *
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * Get Rating.
     *
     * @return float|null
     */
    public function getRating()
    {
        return $this->rating;
    }
}
