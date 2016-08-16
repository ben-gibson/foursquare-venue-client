<?php

namespace Gibbo\Foursquare\ClientTests\Factory;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Entity\Location;
use Gibbo\Foursquare\Client\Factory\Location as LocationFactory;

class LocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(LocationFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Location $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Location $expected)
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
                        "address": "Main St",
                        "crossStreet": "Plymouth St",
                        "lat": 40.70227697066692,
                        "lng": -73.9965033531189,
                        "postalCode": "11201",
                        "cc": "US",
                        "city": "Brooklyn",
                        "state": "NY",
                        "country": "United States",
                        "formattedAddress": [
                          "Main St (Plymouth St)",
                          "Brooklyn, NY 11201",
                          "United States"
                        ]
                  }
JSON
                ),
                new Location(
                    'Main St',
                    new Coordinates(40.70227697066692, -73.9965033531189),
                    '11201',
                    'Brooklyn',
                    'NY',
                    'United States'
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
                    
                    }
JSON
                ),
                new Location()
            ],
            [
                json_decode(
                    <<<JSON
                    {
                        "crossStreet": "Plymouth St",
                        "cc": "US",
                        "city": "Brooklyn",
                        "state": "NY",
                        "country": "United States",
                        "formattedAddress": [
                          "Main St (Plymouth St)",
                          "Brooklyn, NY 11201",
                          "United States"
                        ]
                  }
JSON
                ),
                new Location(
                    null,
                    null,
                    null,
                    'Brooklyn',
                    'NY',
                    'United States'
                )
            ],
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return LocationFactory
     */
    private function getFactory()
    {
        return new LocationFactory();
    }
}
