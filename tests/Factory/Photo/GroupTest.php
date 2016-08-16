<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\Group;
use Gibbo\Foursquare\Client\Factory\Photo\Group as GroupFactory;
use Gibbo\Foursquare\Client\Factory\Photo\Photo as PhotoFactory;
use Gibbo\Foursquare\Client\Entity\Photo\Photo;

class GroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(GroupFactory::class, $this->getFactory($this->getMockPhotoFactory()));
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Group $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Group $expected)
    {
        $factory = $this->getFactory($this->getMockPhotoFactory());

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
                        "type": "venue",
                        "name": "Venue photos",
                        "count": 4000,
                        "items": [{}, {}]
                    }
JSON
                ),
                new Group('Venue photos', 'venue', [$this->getMockPhoto(), $this->getMockPhoto()])
            ],
            [
                json_decode(
                    <<<JSON
                    {
                        "type": "venue",
                        "name": "Venue photos",
                        "count": 4000,
                        "items": []
                    }
JSON
                ),
                new Group('Venue photos', 'venue', [])
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
        $this->getFactory($this->getMockPhotoFactory())->create($description);
    }

    /**
     * Provides invalid descriptions.
     *
     * @return array
     */
    public function invalidDescriptionProvider()
    {
        return [
            'No type' => [
                json_decode(
                    <<<JSON
                     {
                        "name": "Venue photos",
                        "count": 4000,
                        "items": []
                    }
JSON
                ),
                'type'
            ],
            'No name' => [
                json_decode(
                    <<<JSON
                     {
                        "type": "venue",
                        "count": 4000,
                        "items": []
                    }
JSON
                ),
                'name'
            ],
        ];
    }

    /**
     * Get the factory under test.
     *
     * @param Photo $photoFactory
     *
     * @return GroupFactory
     */
    private function getFactory(PhotoFactory $photoFactory)
    {
        return new GroupFactory($photoFactory);
    }

    /**
     * Get a mock photo factory.
     *
     * @return PhotoFactory
     */
    private function getMockPhotoFactory()
    {
        $factory = $this->getMockBuilder(PhotoFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockPhoto());

        return $factory;
    }

    /**
     * Get a mock photo.
     *
     * @return Photo
     */
    private function getMockPhoto()
    {
        return $this->getMockBuilder(Photo::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
