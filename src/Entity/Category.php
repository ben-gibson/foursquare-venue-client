<?php

namespace Gibbo\Foursquare\Client\Entity;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeIdentified;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Represents a category.
 */
class Category
{
    use CanBeIdentified;

    private $name;
    private $iconUrl;
    private $isPrimary;

    /**
     * Constructor.
     *
     * @param Identifier $identifier
     * @param string $name
     * @param $isPrimary
     */
    public function __construct(Identifier $identifier, $name, $iconUrl, $isPrimary)
    {
        \Assert\that($name)->string()->notEmpty();
        Assertion::boolean($isPrimary);
        Assertion::url($iconUrl);

        $this->identifier = $identifier;
        $this->name       = $name;
        $this->iconUrl    = $iconUrl;
        $this->isPrimary  = $isPrimary;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Is this the primary category.
     *
     * @return mixed
     */
    public function isPrimary()
    {
        return $this->isPrimary;
    }

    /**
     * Get the icon url.
     *
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }
}
