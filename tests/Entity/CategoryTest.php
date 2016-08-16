<?php

namespace Gibbo\Foursquare\ClientTests\Entity;

use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Identifier;
use Gibbo\Foursquare\ClientTests\Traits\InvalidUrlProvider;

/**
 * Tests the category entity.
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    use InvalidUrlProvider;

    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $category = $this->getEntity(new Identifier('430d0a00f964a5203e271fe3'), 'Park', 'https://example.com', true);
        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * Test the accessor methods.
     */
    public function testAccessors()
    {
        $identifier = new Identifier('430d0a00f964a5203e271fe3');
        $name       = 'Park';
        $iconUrl    = 'https://example.com/img.png';
        $isPrimary  = false;

        $entity = $this->getEntity($identifier, $name, $iconUrl, $isPrimary);

        $this->assertSame($identifier, $entity->getIdentifier());
        $this->assertSame($iconUrl, $entity->getIconUrl());
        $this->assertSame($isPrimary, $entity->isPrimary());
    }

    /**
     * Test the icon url is correctly validated.
     *
     * @dataProvider invalidUrlProvider
     * @expectedException \InvalidArgumentException
     */
    public function testIconUrlAssertion($url)
    {
        $this->getEntity(new Identifier('430d0a00f964a5203e271fe3'), 'Park', $url, true);
    }

    /**
     * Get the entity under test.
     *
     * @param Identifier $identifier
     * @param string $name
     * @param string $iconUrl
     * @param bool $isPrimary
     *
     * @return Category
     */
    private function getEntity(Identifier $identifier, $name, $iconUrl, $isPrimary)
    {
        return new Category($identifier, $name, $iconUrl, $isPrimary);
    }
}
