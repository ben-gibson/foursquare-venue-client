<?php

namespace Gibbo\Foursquare\Client\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Factory;
use Gibbo\Foursquare\Client\Factory\Photo\PhotoFactory;
use Gibbo\Foursquare\Client\Entity\Venue\Detail;

/**
 * Creates venue details from a description.
 */
class DetailFactory extends Factory
{
    private $photoFactory;

    /**
     * Constructor.
     *
     * @param PhotoFactory $photoFactory
     */
    public function __construct(PhotoFactory $photoFactory)
    {
        $this->photoFactory = $photoFactory;
    }

    /**
     * Create a venue from a description.
     *
     * @param \stdClass $description The venue description.
     *
     * @return Detail
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'verified');

        $this->parseOptionalParameter($description, 'rating');
        $this->parseOptionalParameter($description, 'timeZone');
        $this->parseOptionalParameter($description, 'bestPhoto');
        $this->parseOptionalParameter($description, 'url');
        $this->parseOptionalParameter($description, 'createdAt');
        $this->parseOptionalParameter($description, 'hereNow');
        $this->parseOptionalParameter($description, 'tags');
        $this->parseOptionalParameter($description, 'likes');

        return new Detail(
            $description->verified,
            $this->getCreatedAt($description),
            $this->getBestPhoto($description),
            $description->rating,
            $description->url,
            ($description->hereNow !== null) ? $description->hereNow->count : null,
            ($description->tags !== null) ? $description->tags : [],
            ($description->likes !== null) ? $description->likes->count : null,
            ($description->timeZone !== null) ? new \DateTimeZone($description->timeZone) : null
        );
    }

    /**
     * Get created at.
     *
     * @param \stdClass $description The venue description.
     *
     * @return \DateTimeImmutable|null
     */
    private function getCreatedAt(\stdClass $description)
    {
        if ($description->createdAt !== null) {
            return (new \DateTimeImmutable())->setTimestamp($description->createdAt);
        }

        return null;
    }

    /**
     * Get best photo.
     *
     * @param \stdClass $description The venue description.
     *
     * @return Photo|null
     */
    private function getBestPhoto(\stdClass $description)
    {
        if ($description->bestPhoto !== null) {
            return $this->photoFactory->create($description->bestPhoto);
        }

        return null;
    }
}
