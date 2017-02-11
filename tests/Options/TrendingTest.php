<?php

namespace Gibbo\Foursquare\ClientTests\Options;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Options\Trending;

/**
 * Tests the trending options.
 */
class TrendingTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test creation with coordinates.
     */
    public function testCreateWithCoordinates()
    {
        $coordinates = new Coordinates(40.0, 50.0);
        $options = Trending::coordinates($coordinates);

        $this->assertInstanceOf(Trending::class, $options);

        $this->assertCount(1, $options->toArray());
        $this->assertSame($coordinates, $options->getCoordinates());
    }

    /**
     * Test to array.
     *
     * @param Trending $options
     * @param array $expected
     *
     * @dataProvider  optionsProvider
     */
    public function testToArray(Trending $options, array $expected)
    {
        $actual = $options->toArray();

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
                Trending::coordinates(new Coordinates(40.12, 50.12))->setRadius(10)->setLimit(50),
                [
                    'll'     => new Coordinates(40.12, 50.12),
                    'radius' => 10,
                    'limit'  => 50
                ]
            ],
            [
                Trending::coordinates(new Coordinates(40.12, 50.12))->setRadius(10),
                [
                    'll'   => new Coordinates(40.12, 50.12),
                    'radius' => 10
                ]
            ]
        ];
    }
}
