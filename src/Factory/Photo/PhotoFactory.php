<?php

namespace Gibbo\Foursquare\Client\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Factory;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates a photo from a description.
 */
class PhotoFactory extends Factory
{
    /**
     * Create a photo from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return Photo
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'id');
        $this->validateMandatoryProperty($description, 'createdAt');
        $this->validateMandatoryProperty($description, 'prefix');
        $this->validateMandatoryProperty($description, 'suffix');
        $this->validateMandatoryProperty($description, 'width');
        $this->validateMandatoryProperty($description, 'height');
        $this->validateMandatoryProperty($description, 'visibility');

        return new Photo(
            new Identifier($description->id),
            (new \DateTimeImmutable())->setTimestamp($description->createdAt),
            sprintf('%s%sx%s%s', $description->prefix, $description->width, $description->height, $description->suffix),
            $description->visibility
        );
    }
}
