<?php

namespace Gibbo\Foursquare\Client\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Tip\Group as TipGroupEntity;
use Gibbo\Foursquare\Client\Entity\Photo\Group as PhotoGroupEntity;
use Gibbo\Foursquare\Client\Entity\Category as CategoryEntity;
use Gibbo\Foursquare\Client\Entity\Venue\Venue as VenueEntity;
use Gibbo\Foursquare\Client\Factory\Category;
use Gibbo\Foursquare\Client\Factory\Contact;
use Gibbo\Foursquare\Client\Factory\Factory;
use Gibbo\Foursquare\Client\Factory\Location;
use Gibbo\Foursquare\Client\Factory\Tip;
use Gibbo\Foursquare\Client\Factory\Photo;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates venues from a description.
 */
class Venue extends Factory
{
    private $detailFactory;
    private $categoryFactory;
    private $contactFactory;
    private $tipGroupFactory;
    private $photoGroupFactory;
    private $locationFactory;

    /**
     * Constructor.
     *
     * @param Detail $detailFactory
     * @param Category $categoryFactory
     * @param Contact $contactFactory
     * @param Location $locationFactory
     * @param Tip\Group $tipGroupFactory
     * @param Photo\Group $photoGroupFactory
     */
    public function __construct(
        Detail $detailFactory,
        Category $categoryFactory,
        Contact $contactFactory,
        Location $locationFactory,
        Tip\Group $tipGroupFactory,
        Photo\Group $photoGroupFactory
    ) {
        $this->detailFactory     = $detailFactory;
        $this->categoryFactory   = $categoryFactory;
        $this->contactFactory    = $contactFactory;
        $this->tipGroupFactory   = $tipGroupFactory;
        $this->locationFactory   = $locationFactory;
        $this->photoGroupFactory = $photoGroupFactory;
    }


    /**
     * Create a venue from a description.
     *
     * @param \stdClass $description The venue description.
     *
     * @return VenueEntity
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'id');
        $this->validateMandatoryProperty($description, 'name');
        $this->validateMandatoryProperty($description, 'contact');
        $this->validateMandatoryProperty($description, 'location');

        return new VenueEntity(
            new Identifier($description->id),
            $description->name,
            $this->getCategories($description),
            $this->getTipGroups($description),
            $this->getPhotoGroups($description),
            $this->contactFactory->create($description->contact),
            $this->locationFactory->create($description->location),
            $this->detailFactory->create($description)
        );
    }

    /**
     * Get the venue categories.
     *
     * @param \stdClass $description The venue description.
     *
     * @return CategoryEntity[]
     */
    private function getCategories(\stdClass $description)
    {
        if (isset($description->categories) === false) {
            return [];
        }

        return array_map(
            function (\stdClass $categoryDescription) {
                return $this->categoryFactory->create($categoryDescription);
            },
            $description->categories
        );
    }

    /**
     * Get the venue tip groups.
     *
     * @param \stdClass $description The venue description.
     *
     * @return TipGroupEntity[]
     */
    private function getTipGroups(\stdClass $description)
    {
        if (isset($description->tips->groups) === false) {
            return [];
        }

        return array_map(
            function (\stdClass $groupDescription) {
                return $this->tipGroupFactory->create($groupDescription);
            },
            $description->tips->groups
        );
    }

    /**
     * Get the photo groups.
     *
     * @param \stdClass $description The venue description.
     *
     * @return PhotoGroupEntity[]
     */
    private function getPhotoGroups(\stdClass $description)
    {
        if (isset($description->photos->groups) === false) {
            return [];
        }

        return array_map(
            function (\stdClass $groupDescription) {
                return $this->photoGroupFactory->create($groupDescription);
            },
            $description->photos->groups
        );
    }
}
