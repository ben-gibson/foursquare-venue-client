<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Factory\Exception\InvalidDescriptionException;

/**
 * An entity description.
 */
class Description
{

    private $description;

    /**
     * Constructor.
     *
     * @param \stdClass $description The entity description.
     */
    public function __construct(\stdClass $description)
    {
        $this->description = $description;
    }

    /**
     * Get an optional property.
     *
     * @param string $property The optional property to get.
     * @param mixed  $default  The default value to return if the property has not been defined.
     *
     * @return Description|mixed
     */
    public function getOptionalProperty($property, $default = null)
    {
        \Assert\that($property)->string()->notEmpty();

        if (property_exists($this->description, $property) === false) {
            return $default;
        }

        return $this->getMandatoryProperty($property);
    }

    /**
     * Get a mandatory property.
     *
     * @param string $property The mandatory property to get.
     *
     * @return Description|mixed
     */
    public function getMandatoryProperty($property)
    {
        \Assert\that($property)->string()->notEmpty();

        if (isset($this->description->{$property}) === false) {
            throw InvalidDescriptionException::missingMandatoryProperty($property);
        }

        if ($this->description->{$property} instanceof \stdClass) {
            return new static($this->description->{$property});
        }

        return $this->description->{$property};
    }
}
