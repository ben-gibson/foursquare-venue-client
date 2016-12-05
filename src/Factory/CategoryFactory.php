<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Entity\Category as CategoryEntity;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates a category from a description.
 */
class CategoryFactory
{
    /**
     * Create a category from a description.
     *
     * @param Description $description The category description.
     *
     * @return CategoryEntity
     */
    public function create(Description $description)
    {
        return new CategoryEntity(
            new Identifier($description->getMandatoryProperty('id')),
            $description->getMandatoryProperty('name'),
            $this->getIconUrl($description),
            (bool)$description->getOptionalProperty('primary', false)
        );
    }

    /**
     * Get the icon url.
     *
     * @param Description $description The category description.
     *
     * @return string
     */
    private function getIconUrl(Description $description)
    {
        $icon = $description->getMandatoryProperty('icon');

        return sprintf('%s%s%s', $icon->getMandatoryProperty('prefix'), '88', $icon->getMandatoryProperty('suffix'));
    }
}
