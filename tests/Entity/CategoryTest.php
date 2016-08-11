<?php

namespace Gibbo\Foursquare\Client\Tests\Entity;

use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Tests the category entity.
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test the entity throws the expected exception when given invalid constructor arguments.
     *
     * @dataProvider invalidConstructProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstruct(Identifier $identifier, $name, $iconUrl, $isPrimary)
    {
        $this->getEntity($identifier, $name, $iconUrl, $isPrimary);
    }

    /**
     * Provides valid constructor arguments.
     *
     * @return array
     */
    public function invalidConstructProvider()
    {
        return [
            [
                new Identifier('M23423sdfd'),
                'Test',
                'not-a-valid-url',
                false
            ],
            [
                new Identifier('M23423sdfd'),
                null,
                'http://example.com',
                false
            ],
            [
                new Identifier('M23423sdfd'),
                'test',
                'http://example.com',
                null
            ],
        ];
    }

    /**
     * Get the entity under test.
     *
     * @param Identifier $identifier
     * @param $name
     * @param $iconUrl
     * @param $isPrimary
     *
     * @return Category
     */
    private function getEntity(Identifier $identifier, $name, $iconUrl, $isPrimary)
    {
        return new Category($identifier, $name, $iconUrl, $isPrimary);
    }
}
