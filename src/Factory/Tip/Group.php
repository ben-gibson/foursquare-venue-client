<?php

namespace Gibbo\Foursquare\Client\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\Group as GroupEntity;
use Gibbo\Foursquare\Client\Entity\Tip\Tip as TipEntity;
use Gibbo\Foursquare\Client\Factory\Factory;

/**
 * Creates a tip group from a description.
 */
class Group extends Factory
{
    private $tipFactory;

    /**
     * Constructor.
     *
     * @param Tip $tipFactory
     */
    public function __construct(Tip $tipFactory)
    {
        $this->tipFactory = $tipFactory;
    }

    /**
     * Create a tip group from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return GroupEntity
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'name');
        $this->validateMandatoryProperty($description, 'type');

        return new GroupEntity(
            $description->name,
            $description->type,
            $this->getTips($description)
        );
    }

    /**
     * Get the venue tips.
     *
     * @param \stdClass $description The venue description.
     *
     * @return TipEntity[]
     */
    private function getTips(\stdClass $description)
    {
        if (isset($description->items) === false) {
            return [];
        }

        return array_map(
            function (\stdClass $tipDescription) {
                return $this->tipFactory->create($tipDescription);
            },
            $description->items
        );
    }
}
