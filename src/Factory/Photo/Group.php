<?php

namespace Gibbo\Foursquare\Client\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\Group as GroupEntity;
use Gibbo\Foursquare\Client\Entity\Photo\Photo as PhotoEntity;
use Gibbo\Foursquare\Client\Factory\Factory;

/**
 * Creates a photo group from a description.
 */
class Group extends Factory
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
     * Create a tip group from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return GroupEntity
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'name');
        $this->validateMandatoryProperty($description, 'type');

        return new GroupEntity(
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
     * @return PhotoEntity[]
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
