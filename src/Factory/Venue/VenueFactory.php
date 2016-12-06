<?php

namespace Gibbo\Foursquare\Client\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Tip\TipGroup;
use Gibbo\Foursquare\Client\Entity\Photo\PhotoGroup;
use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Entity\Venue\Venue;
use Gibbo\Foursquare\Client\Factory\CategoryFactory;
use Gibbo\Foursquare\Client\Factory\ContactFactory;
use Gibbo\Foursquare\Client\Factory\Description;
use Gibbo\Foursquare\Client\Factory\LocationFactory;
use Gibbo\Foursquare\Client\Factory\Tip;
use Gibbo\Foursquare\Client\Factory\Photo;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates venues from a description.
 */
class VenueFactory
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
     * @param Description $description The venue description.
     *
     * @return Venue
     */
    public function create(Description $description)
    {
        return new Venue(
            new Identifier($description->getMandatoryProperty('id')),
            $description->getMandatoryProperty('name'),
            $this->getCategories($description),
            $this->getTipGroups($description),
            $this->getPhotoGroups($description),
            $this->contactFactory->create($description->getMandatoryProperty('contact')),
            $this->locationFactory->create($description->getMandatoryProperty('location')),
            $this->detailFactory->create($description)
        );
    }

    /**
     * Get the venue categories.
     *
     * @param Description $description The venue description.
     *
     * @return Category[]
     */
    private function getCategories(Description $description)
    {
        return array_map(
            function (\stdClass $categoryDescription) {
                return $this->categoryFactory->create(new Description($categoryDescription));
            },
            $description->getOptionalProperty('categories', [])
        );
    }

    /**
     * Get the venue tip groups.
     *
     * @param Description $description The venue description.
     *
     * @return TipGroup[]
     */
    private function getTipGroups(Description $description)
    {
        $tipsDescription = $description->getOptionalProperty('tips');

        if (!($tipsDescription instanceof Description)) {
            return [];
        }

        return array_map(
            function (\stdClass $groupDescription) {
                return $this->tipGroupFactory->create(new Description($groupDescription));
            },
            $tipsDescription->getOptionalProperty('groups', [])
        );
    }

    /**
     * Get the photo groups.
     *
     * @param Description $description The venue description.
     *
     * @return PhotoGroup[]
     */
    private function getPhotoGroups(Description $description)
    {
        $photosDescription = $description->getOptionalProperty('photos');

        if (!($photosDescription instanceof Description)) {
            return [];
        }

        return array_map(
            function (\stdClass $groupDescription) {
                return $this->photoGroupFactory->create(new Description($groupDescription));
            },
            $photosDescription->getOptionalProperty('groups', [])
        );
    }
}
