<?php

namespace Gibbo\Foursquare\Client;

/**
 * A value object for a resource identifier.
 */
class Identifier
{
    private $value;

    /**
     * Constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        \Assert\that($value)->string()->notEmpty();

        $this->value = $value;
    }

    /**
     * Returns the string representation of the identifier.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
