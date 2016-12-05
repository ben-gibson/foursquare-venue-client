<?php

namespace Gibbo\Foursquare\Client\Factory\Exception;

/**
 * Thrown when an invalid entity description is provided.
 */
class InvalidDescriptionException extends \RuntimeException
{
    /**
     * Thrown when a mandatory property is missing from an entity description.
     *
     * @param string $property The missing property.
     *
     * @return static
     */
    public static function missingMandatoryProperty($property)
    {
        return new static(sprintf("The entity description is missing the mandatory property '%s'", $property));
    }
}
