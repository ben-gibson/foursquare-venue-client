<?php

namespace Gibbo\Foursquare\Client\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Tip\TipGroup;
use Gibbo\Foursquare\Client\Entity\Photo\PhotoGroup;
use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Entity\Venue\Venue;
use Gibbo\Foursquare\Client\Factory\CategoryFactory;
use Gibbo\Foursquare\Client\Factory\ContactFactory;
use Gibbo\Foursquare\Client\Factory\Factory;
use Gibbo\Foursquare\Client\Factory\LocationFactory;
use Gibbo\Foursquare\Client\Factory\Tip;
use Gibbo\Foursquare\Client\Factory\Photo;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates venues from a description.
 */
class VenueFactory extends Factory
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
     * @param DetailFactory           $detailFactory
     * @param CategoryFactory         $categoryFactory
     * @param ContactFactory          $contactFactory
     * @param LocationFactory         $locationFactory
     * @param Tip\TipGroupFactory     $tipGroupFactory
     * @param Photo\PhotoGroupFactory $photoGroupFactory
     */
    public function __construct(
        DetailFactory $detailFactory,
        CategoryFactory $categoryFactory,
        ContactFactory $contactFactory,
        LocationFactory $locationFactory,
        Tip\TipGroupFactory $tipGroupFactory,
        Photo\PhotoGroupFactory $photoGroupFactory
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
     * @return Venue
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'id');
        $this->validateMandatoryProperty($description, 'name');
        $this->validateMandatoryProperty($description, 'contact');
        $this->validateMandatoryProperty($description, 'location');

        return new Venue(
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
     * @return Category[]
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
     * @return TipGroup[]
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
     * @return PhotoGroup[]
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
