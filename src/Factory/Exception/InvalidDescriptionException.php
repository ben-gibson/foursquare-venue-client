<?php

namespace Gibbo\Foursquare\Client\Factory\Exception;

/**
 * Thrown when an invalid entity description is provided.
 */
class InvalidDescriptionException extends \RuntimeException
{
    /**
     * Missing
     *
     * @param string $parameter The missing parameter.
     *
     * @return static
     */
    public static function missingMandatoryParameter($parameter)
    {
        return new static(sprintf("The entity description is missing the mandatory parameter '%s'", $parameter));
    }
}
