<?php

namespace Gibbo\Foursquare\Client\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Venue as VenueEntity;
use Gibbo\Foursquare\Client\Factory\Factory;
use Gibbo\Foursquare\Client\Factory\Photo\Photo as PhotoEntity;
use Gibbo\Foursquare\Client\Factory\Photo\Photo;
use Gibbo\Foursquare\Client\Entity\Venue\Detail as DetailEntity;

/**
 * Creates venue details from a description.
 */
class Detail extends Factory
{
    private $photoFactory;

    /**
     * Constructor.
     *
     * @param Photo $photoFactory
     */
    public function __construct(Photo $photoFactory)
    {
        $this->photoFactory = $photoFactory;
    }

    /**
     * Create a venue from a description.
     *
     * @param \stdClass $description The venue description.
     *
     * @return DetailEntity
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

        return new DetailEntity(
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
     * @return PhotoEntity|null
     */
    private function getBestPhoto(\stdClass $description)
    {
        if ($description->bestPhoto !== null) {
            return $this->photoFactory->create($description->bestPhoto);
        }

        return null;
    }
}
