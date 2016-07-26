<?php

namespace Gibbo\Foursquare\Client\Entity\Traits;

use Gibbo\Foursquare\Client\Identifier;

/**
 * Provides the ability to be identified.
 */
trait CanBeIdentified
{
    private $identifier;

    /**
     * Get the identifier.
     *
     * @return Identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
