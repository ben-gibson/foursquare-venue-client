<?php

namespace Gibbo\Foursquare\Client\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Description;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates a photo from a description.
 */
class PhotoFactory
{
    /**
     * Create a photo from a description.
     *
     * @param Description $description The photo description.
     *
     * @return Photo
     */
    public function create(Description $description)
    {
        return new Photo(
            new Identifier($description->getMandatoryProperty('id')),
            (new \DateTimeImmutable())->setTimestamp($description->getMandatoryProperty('createdAt')),
            sprintf(
                '%s%sx%s%s',
                $description->getMandatoryProperty('prefix'),
                $description->getMandatoryProperty('width'),
                $description->getMandatoryProperty('height'),
                $description->getMandatoryProperty('suffix')
            ),
            $description->getMandatoryProperty('visibility')
        );
    }
}
