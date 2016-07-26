<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Factory\Exception\InvalidDescriptionException;

/**
 * Exposes continent methods to entity factories.
 */
abstract class Factory
{
    /**
     * Parse an optional parameter.
     *
     * @param \stdClass $description
     * @param string $parameter
     *
     * @return mixed
     */
    protected function parseOptionalParameter(\stdClass $description, $parameter)
    {
        \Assert\that($parameter)->string()->notEmpty();

        if (property_exists($description, $parameter) === false) {
            $description->{$parameter} = null;
        }
    }

    /**
     * Validate the existence of a mandatory parameter.
     *
     * @param \stdClass $description
     * @param string $parameter
     *
     * @return void
     */
    protected function validateMandatoryProperty(\stdClass $description, $parameter)
    {
        \Assert\that($parameter)->string()->notEmpty();

        if (isset($description->{$parameter}) === false) {
            throw InvalidDescriptionException::missingMandatoryParameter($parameter);
        }
    }
}
