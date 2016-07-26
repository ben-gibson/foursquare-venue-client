<?php

namespace Gibbo\Foursquare\Client\Tests\Factory;

use Gibbo\Foursquare\Client\Entity\Contact;
use Gibbo\Foursquare\Client\Factory\Contact as ContactFactory;

/**
 * Test the contact factory.
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ContactFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Contact $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Contact $expected)
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
                json_decode('{"phone": "2128033822", "formattedPhone": "(212) 803-3822", "twitter": "nycparks", "facebook": "104475634308", "facebookUsername": "BartowPell", "facebookName": "Bartow-Pell Mansion Museum"}'),
                new Contact('2128033822', 'nycparks', '104475634308')
            ],
            [
                json_decode('{}'),
                new Contact()
            ],
            [
                json_decode('{"twitter": "nycparks"}'),
                new Contact(null, 'nycparks')
            ]
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return ContactFactory
     */
    private function getFactory()
    {
        return new ContactFactory();
    }
}
