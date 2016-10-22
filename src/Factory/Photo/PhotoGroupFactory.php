<?php

namespace Gibbo\Foursquare\Client\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\PhotoGroup;
use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Factory;

/**
 * Creates a photo group from a description.
 */
class PhotoGroupFactory extends Factory
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
     * @param \stdClass $description The description.
     *
     * @return PhotoGroup
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'name');
        $this->validateMandatoryProperty($description, 'type');

        return new PhotoGroup(
            $description->name,
            $description->type,
            $this->getPhotos($description)
        );
    }

    /**
     * Get the venue photos.
     *
     * @param \stdClass $description The description.
     *
     * @return Photo[]
     */
    private function getPhotos(\stdClass $description)
    {
        if (isset($description->items) === false) {
            return [];
        }

        return array_map(
            function (\stdClass $photoDescription) {
                return $this->photoFactory->create($photoDescription);
            },
            $description->items
        );
    }
}
