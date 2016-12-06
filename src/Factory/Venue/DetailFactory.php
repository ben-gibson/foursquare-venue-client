<?php

namespace Gibbo\Foursquare\Client\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Description;
use Gibbo\Foursquare\Client\Factory\Photo\PhotoFactory;
use Gibbo\Foursquare\Client\Entity\Venue\Detail;

/**
 * Creates venue details from a description.
 */
class DetailFactory
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
     * @param Description $description The venue details description.
     *
     * @return Detail
     */
    public function create(Description $description)
    {
        $timeZone           = $description->getOptionalProperty('timeZone');
        $likesDescription   = $description->getOptionalProperty('likes');
        $hereNowDescription = $description->getOptionalProperty('hereNow');

        return new Detail(
            $description->getMandatoryProperty('verified'),
            $this->getCreatedAt($description),
            $this->getBestPhoto($description),
            $description->getOptionalProperty('rating'),
            $description->getOptionalProperty('url'),
            ($hereNowDescription instanceof Description) ? $hereNowDescription->getMandatoryProperty('count') : null,
            $description->getOptionalProperty('tags', []),
            ($likesDescription instanceof Description) ? $likesDescription->getMandatoryProperty('count'): null,
            ($timeZone !== null) ? new \DateTimeZone($timeZone) : null
        );
    }

    /**
     * Get created at.
     *
     * @param Description $description The venue details description.
     *
     * @return \DateTimeImmutable|null
     */
    private function getCreatedAt(Description $description)
    {
        $createdAt = $description->getOptionalProperty('createdAt');

        return ($createdAt !== null) ? (new \DateTimeImmutable())->setTimestamp($createdAt) : null;
    }

    /**
     * Get best photo.
     *
     * @param Description $description The venue details description.
     *
     * @return Photo|null
     */
    private function getBestPhoto(Description $description)
    {
        $bestPhotoDescription = $description->getOptionalProperty('bestPhoto');

        if ($bestPhotoDescription instanceof Description) {
            return $this->photoFactory->create($bestPhotoDescription);
        }

        return null;
    }
}
