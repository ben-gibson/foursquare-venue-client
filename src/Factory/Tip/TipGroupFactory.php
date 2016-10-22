<?php

namespace Gibbo\Foursquare\Client\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\TipGroup;
use Gibbo\Foursquare\Client\Entity\Tip\Tip;
use Gibbo\Foursquare\Client\Factory\Factory;

/**
 * Creates a tip group from a description.
 */
class TipGroupFactory extends Factory
{
    private $tipFactory;

    /**
     * Constructor.
     *
     * @param TipFactory $tipFactory
     */
    public function __construct(TipFactory $tipFactory)
    {
        $this->tipFactory = $tipFactory;
    }

    /**
     * Create a tip group from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return TipGroup
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'name');
        $this->validateMandatoryProperty($description, 'type');

        return new TipGroup(
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
     * @return Tip[]
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
