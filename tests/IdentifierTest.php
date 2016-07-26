<?php

namespace Gibbo\Foursquare\Client\Tests;

use Gibbo\Foursquare\Client\Identifier;

/**
 * Tests an identifier.
 */
class IdentifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $id         = '556df7e1a7c82e6b724d822e';
        $identifier = new Identifier($id);

        $this->assertInstanceOf(Identifier::class, $identifier);
        $this->assertSame($id, (string)$identifier);
    }

    /**
     * Test invalid identifiers.
     *
     * @param mixed $id
     *
     * @dataProvider invalidIdentifiersProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIdentifiers($id)
    {
        new Identifier($id);
    }

    /**
     * Provide invalid identifiers.
     *
     * @return array
     */
    public function invalidIdentifiersProvider()
    {
        return [
            [''],
            [123],
            [null],
            [new \stdClass]
        ];
    }
}
