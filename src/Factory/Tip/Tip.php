<?php

namespace Gibbo\Foursquare\Client\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\Tip as TipEntity;
use Gibbo\Foursquare\Client\Factory\Factory;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates a tip from a description.
 */
class Tip extends Factory
{
    /**
     * Create a tip from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return TipEntity
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'id');
        $this->validateMandatoryProperty($description, 'text');
        $this->validateMandatoryProperty($description, 'type');
        $this->validateMandatoryProperty($description, 'agreeCount');
        $this->validateMandatoryProperty($description, 'disagreeCount');

        return new TipEntity(
            new Identifier($description->id),
            $description->text,
            $description->type,
            $description->agreeCount,
            $description->disagreeCount
        );
    }
}
