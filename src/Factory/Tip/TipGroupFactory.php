<?php

namespace Gibbo\Foursquare\Client\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\TipGroup;
use Gibbo\Foursquare\Client\Entity\Tip\Tip;
use Gibbo\Foursquare\Client\Factory\Description;

/**
 * Creates a tip group from a description.
 */
class TipGroupFactory
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
     * @param Description $description The tip group description.
     *
     * @return TipGroup
     */
    public function create(Description $description)
    {
        return new TipGroup(
            $description->getMandatoryProperty('name'),
            $description->getMandatoryProperty('type'),
            $this->getTips($description)
        );
    }

    /**
     * Get the venue tips.
     *
     * @param Description $description The tip group description.
     *
     * @return Tip[]
     */
    private function getTips(Description $description)
    {
        return array_map(
            function (\stdClass $tipDescription) {
                return $this->tipFactory->create(new Description($tipDescription));
            },
            $description->getOptionalProperty('items', [])
        );
    }
}
