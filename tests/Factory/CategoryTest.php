<?php

namespace Gibbo\Foursquare\ClientTests\Factory;

use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Factory\Category as CategoryFactory;
use Gibbo\Foursquare\Client\Identifier;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(CategoryFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Category $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Category $expected)
    {
        $factory = $this->getFactory();

        $this->assertEquals($expected, $factory->create($description));
    }

    /**
     * Provides valid descriptions.
     *
     * @return array
     */
    public function validDescriptionProvider()
    {
        return [
            [
                json_decode(
                    <<<JSON
                    {
                      "id": "4bf58dd8d48988d163941735",
                      "name": "Park",
                      "pluralName": "Parks",
                      "shortName": "Park",
                      "icon": {
                        "prefix": "https:\/\/ss3.4sqi.net\/img\/categories_v2\/parks_outdoors\/park_",
                        "suffix": ".png"
                      },
                      "primary": true
                    }
JSON
                ),
                new Category(
                    new Identifier('4bf58dd8d48988d163941735'),
                    'Park',
                    'https://ss3.4sqi.net/img/categories_v2/parks_outdoors/park_88.png',
                    true
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
                      "id": "4bf58dd8d48988d163941735",
                      "name": "Park",
                      "pluralName": "Parks",
                      "shortName": "Park",
                      "icon": {
                        "prefix": "https:\/\/ss3.4sqi.net\/img\/categories_v2\/parks_outdoors\/park_",
                        "suffix": ".png"
                      }
                    }
JSON
                ),
                new Category(
                    new Identifier('4bf58dd8d48988d163941735'),
                    'Park',
                    'https://ss3.4sqi.net/img/categories_v2/parks_outdoors/park_88.png',
                    false
                )
            ],
        ];
    }

    /**
     * Test the creation with an invalid description.
     *
     * @param \stdClass $description
     *
     * @dataProvider invalidDescriptionProvider
     * @expectedException \Gibbo\Foursquare\Client\Factory\Exception\InvalidDescriptionException
     */
    public function testCreateWithInvalidDescription(\stdClass $description, $property)
    {
        $this->expectExceptionMessage("The entity description is missing the mandatory parameter '{$property}'");
        $this->getFactory()->create($description);
    }

    /**
     * Provides invalid descriptions.
     *
     * @return array
     */
    public function invalidDescriptionProvider()
    {
        return [
            'No Name' => [
                json_decode(
                    <<<JSON
                    {
                      "id": "4bf58dd8d48988d163941735",
                      "pluralName": "Parks",
                      "shortName": "Park",
                      "icon": {
                        "prefix": "https:\/\/ss3.4sqi.net\/img\/categories_v2\/parks_outdoors\/park_",
                        "suffix": ".png"
                      },
                      "primary": true
                    }
JSON
                ),
                'name'
            ],
            'No Id' => [
                json_decode(
                    <<<JSON
                    {
                      "name": "Park",
                      "pluralName": "Parks",
                      "shortName": "Park",
                      "icon": {
                        "prefix": "https:\/\/ss3.4sqi.net\/img\/categories_v2\/parks_outdoors\/park_",
                        "suffix": ".png"
                      },
                      "primary": true
                    }
JSON
                ),
                'id'
            ],
            'No Icon' => [
                json_decode(
                    <<<JSON
                    {
                      "id": "4bf58dd8d48988d163941735",                    
                      "name": "Park",
                      "pluralName": "Parks",
                      "shortName": "Park",
                      "primary": true
                    }
JSON
                ),
                'icon'
            ],
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return CategoryFactory
     */
    private function getFactory()
    {
        return new CategoryFactory();
    }
}
