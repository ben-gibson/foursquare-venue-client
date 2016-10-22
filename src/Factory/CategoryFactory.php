<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Entity\Category as CategoryEntity;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Creates a category from a description.
 */
class CategoryFactory extends Factory
{
    /**
     * Create a category from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return CategoryEntity
     */
    public function create(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'id');
        $this->validateMandatoryProperty($description, 'name');

        return new CategoryEntity(
            new Identifier($description->id),
            $description->name,
            $this->getIconUrl($description),
            (isset($description->primary))
        );
    }

    /**
     * Get the icon url.
     *
     * @param \stdClass $description The description.
     *
     * @return string
     */
    private function getIconUrl(\stdClass $description)
    {
        $this->validateMandatoryProperty($description, 'icon');

        return sprintf('%s%s%s', $description->icon->prefix, '88', $description->icon->suffix);
    }
}
