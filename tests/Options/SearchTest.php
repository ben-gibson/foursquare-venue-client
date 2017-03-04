<?php

namespace Gibbo\Foursquare\ClientTests\Options;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Options\Search;

/**
 * Tests the search options.
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test creation with coordinates.
     */
    public function testCreateWithCoordinates()
    {
        $coordinates = new Coordinates(40.0, 50.0);

        $options = Search::coordinates($coordinates);

        $this->assertInstanceOf(Search::class, $options);
        $this->assertCount(1, $options->parametrise());
        $this->assertSame($coordinates, $options->parametrise()['ll']);
    }

    /**
     * Test creation with place.
     */
    public function testCreateWithPlace()
    {
        $options = Search::place('Chicago, IL');

        $this->assertInstanceOf(Search::class, $options);
        $this->assertCount(1, $options->parametrise());
        $this->assertArrayHasKey('near', $options->parametrise());
    }

    /**
     * Test creation with an invalid place.
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider  invalidPlaceProvider
     */
    public function testCreateWithInvalidPlace($place)
    {
        Search::place($place);
    }

    /**
     * Provides invalid place names.
     *
     * @return array
     */
    public function invalidPlaceProvider()
    {
        return [
            [null],
            [123],
            [[]],
            ['']
        ];
    }

    /**
     * Test the options can be parametrised.
     *
     * @param Search $options
     * @param array $expected
     *
     * @dataProvider  optionsProvider
     */
    public function testParametrise(Search $options, array $expected)
    {
        $actual = $options->parametrise();

        ksort($actual);
        ksort($expected);

        $this->assertEquals($actual, $expected);
    }

    /**
     * Provides options.
     *
     * @return array
     */
    public function optionsProvider()
    {
        return [
            [
                Search::place('Chicago, IL')->limit(1)->radius(500),
                [
                    'near'   => 'Chicago, IL',
                    'limit'  => 1,
                    'radius' => 500
                ]
            ],
            [
                Search::coordinates(new Coordinates(40.12, 50.12))->limit(40)->radius(10),
                [
                    'll'     => new Coordinates(40.12, 50.12),
                    'limit'  => 40,
                    'radius' => 10
                ]
            ],
            [
                Search::coordinates(new Coordinates(40.12, 50.12))->radius(10),
                [
                    'll'     => new Coordinates(40.12, 50.12),
                    'radius' => 10
                ]
            ]
        ];
    }
}
