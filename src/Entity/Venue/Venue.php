<?php

namespace Gibbo\Foursquare\Client\Entity\Venue;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeIdentified;
use Gibbo\Foursquare\Client\Identifier;
use Gibbo\Foursquare\Client\Entity\Photo;
use Gibbo\Foursquare\Client\Entity\Tip;
use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Entity\Contact;
use Gibbo\Foursquare\Client\Entity\Location;

/**
 * Represents a Foursquare venue.
 */
class Venue
{
    use CanBeIdentified;

    private $name;
    private $categories;
    private $tipGroups;
    private $photoGroups;
    private $contact;
    private $location;
    private $details;

    /**
     * Constructor.
     *
     * @param Identifier $identifier
     * @param string $name
     * @param Category[] $categories
     * @param Tip\Group[] $tipGroups
     * @param Photo\Group[] $photosGroups
     * @param Contact $contact
     * @param Location $location
     * @param Detail $details
     */
    public function __construct(
        Identifier $identifier,
        $name,
        array $categories,
        array $tipGroups,
        array $photosGroups,
        Contact $contact,
        Location $location,
        Detail $details
    ) {
        \Assert\that($name)->string()->notEmpty();

        Assertion::allIsInstanceOf($categories, Category::class);
        Assertion::allIsInstanceOf($tipGroups, Tip\Group::class);
        Assertion::allIsInstanceOf($photosGroups, Photo\Group::class);

        $this->identifier  = $identifier;
        $this->name        = $name;
        $this->categories  = $categories;
        $this->tipGroups   = $tipGroups;
        $this->photoGroups = $photosGroups;
        $this->contact     = $contact;
        $this->location    = $location;
        $this->details     = $details;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the details.
     *
     * @return Detail
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Get categories.
     *
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get the contact information.
     *
     * @return Contact
     */
    public function getContactInformation()
    {
        return $this->contact;
    }

    /**
     * Get the location.
     *
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get tips.
     *
     * @return Tip\Group[]
     */
    public function getTipGroups()
    {
        return $this->tipGroups;
    }

    /**
     * Get photos groups.
     *
     * @return Photo\Group[]
     */
    public function getPhotoGroups()
    {
        return $this->photoGroups;
    }

    /**
     * Get the primary category.
     *
     * @return Category|null
     */
    public function getPrimaryCategory()
    {
        foreach ($this->getCategories() as $category) {
            if ($category->isPrimary()) {
                return $category;
            }
        }

        return null;
    }
}
