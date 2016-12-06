<?php

namespace Gibbo\Foursquare\Client\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\Tip;
use Gibbo\Foursquare\Client\Factory\Description;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates a tip from a description.
 */
class TipFactory
{
    /**
     * Create a tip from a description.
     *
     * @param Description $description The tip description.
     *
     * @return Tip
     */
    public function create(Description $description)
    {
        return new Tip(
            new Identifier($description->getMandatoryProperty('id')),
            $description->getMandatoryProperty('text'),
            $description->getMandatoryProperty('type'),
            $description->getMandatoryProperty('agreeCount'),
            $description->getMandatoryProperty('disagreeCount')
        );
    }
}
