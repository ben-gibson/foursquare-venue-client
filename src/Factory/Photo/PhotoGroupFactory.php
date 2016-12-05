<?php

namespace Gibbo\Foursquare\Client\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\PhotoGroup;
use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Description;

/**
 * Creates a photo group from a description.
 */
class PhotoGroupFactory
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
     * Create a tip group from a description.
     *
     * @param Description $description The photo group description.
     *
     * @return PhotoGroup
     */
    public function create(Description $description)
    {
        return new PhotoGroup(
            $description->getMandatoryProperty('name'),
            $description->getMandatoryProperty('type'),
            $this->getPhotos($description)
        );
    }

    /**
     * Get the venue photos.
     *
     * @param Description $description The photo group description.
     *
     * @return Photo[]
     */
    private function getPhotos(Description $description)
    {
        return array_map(
            function (\stdClass $photoDescription) {
                return $this->photoFactory->create(new Description($photoDescription));
            },
            $description->getOptionalProperty('items', [])
        );
    }
}
