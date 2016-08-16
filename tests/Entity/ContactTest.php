<?php

namespace Gibbo\Foursquare\ClientTests\Entity;

use Gibbo\Foursquare\Client\Entity\Contact;
use Gibbo\Foursquare\ClientTests\Traits\InvalidStringProvider;

/**
 * Tests the contact entity.
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Contact::class, $this->getEntity());
    }

    /**
     * Test the accessor methods.
     */
    public function testAccessors()
    {
        $phone    = '+44 7162637411';
        $twitter  = 'twitter-id';
        $facebook = '111231';

        $entity = $this->getEntity($phone, $twitter, $facebook);

        $this->assertSame($phone, $entity->getPhone());
        $this->assertSame($twitter, $entity->getTwitterId());
        $this->assertSame($facebook, $entity->getFacebookId());
    }

    /**
     * Test the phone number is correctly validated.
     *
     * @dataProvider invalidPhoneProvider
     * @expectedException \InvalidArgumentException
     */
    public function testPhoneAssertion($phone)
    {
        $this->getEntity($phone);
    }

    /**
     * Provides invalid phone numbers.
     *
     * @return array
     */
    public function invalidPhoneProvider()
    {
        return [
            [''],
            [new \stdClass],
            [213],
            [[]],
        ];
    }

    /**
     * Test the twitter id is correctly validated.
     *
     * @dataProvider invalidTwitterIdProvider
     * @expectedException \InvalidArgumentException
     */
    public function testTwitterIdAssertion($twitterId)
    {
        $this->getEntity(null, $twitterId);
    }

    /**
     * Provides invalid twitter ids.
     *
     * @return array
     */
    public function invalidTwitterIdProvider()
    {
        return [
            [''],
            [new \stdClass],
            [213],
            [[]],
        ];
    }

    /**
     * Test the facebook id is correctly validated.
     *
     * @dataProvider invalidFacebookIdProvider
     * @expectedException \InvalidArgumentException
     */
    public function testFacebookIdAssertion($facebookId)
    {
        $this->getEntity(null, null, $facebookId);
    }

    /**
     * Provides invalid facebook ids.
     *
     * @return array
     */
    public function invalidFacebookIdProvider()
    {
        return [
            [''],
            [new \stdClass],
            [213],
            [[]],
        ];
    }

    /**
     * Get the entity under test.
     *
     * @return Contact
     */
    private function getEntity($phone = null, $twitter = null, $facebook = null)
    {
        return new Contact($phone, $twitter, $facebook);
    }
}
