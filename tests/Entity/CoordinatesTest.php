<?php

namespace Gibbo\Foursquare\ClientTests\Entity;

use Gibbo\Foursquare\Client\Entity\Coordinates;

/**
 * Tests the coordinates value object.
 */
class CoordinatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Coordinates::class, $this->getCoordinates(44.34, 54.32));
    }

    /**
     * Test the accessor methods.
     */
    public function testAccessors()
    {
        $latitude  = 44.34;
        $longitude = 54.32;

        $coordinates = $this->getCoordinates($latitude, $longitude);

        $this->assertSame($latitude, $coordinates->getLatitude());
        $this->assertSame($longitude, $coordinates->getLongitude());
    }

    /**
     * Test to string.
     */
    public function testToString()
    {
        $this->assertSame('44.34,54.32', $this->getCoordinates(44.34, 54.32)->__toString());
    }

    /**
     * Test the latitude is correctly validated.
     *
     * @dataProvider invalidCoordinatesProvider
     * @expectedException \InvalidArgumentException
     */
    public function testLatitudeAssertion($latitude)
    {
        $this->getCoordinates($latitude, 44.4);
    }

    /**
     * Test the longitude is correctly validated.
     *
     * @dataProvider invalidCoordinatesProvider
     * @expectedException \InvalidArgumentException
     */
    public function testLongitudeAssertion($longitude)
    {
        $this->getCoordinates(44.4, $longitude);
    }

    /**
     * Provides invalid coordinates.
     *
     * @return array
     */
    public function invalidCoordinatesProvider()
    {
        return [
            [''],
            [new \stdClass],
            [213],
            [[]],
            [1],
            [false],
            ["test"],
            [null],
            ["1.23"],
            ["10"],
        ];
    }

    /**
     * Get the coordinates.
     *
     * @return Coordinates
     */
    private function getCoordinates($latitude, $longitude)
    {
        return new Coordinates($latitude, $longitude);
    }
}
