<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\Group;
use Gibbo\Foursquare\Client\Factory\Tip\Group as GroupFactory;
use Gibbo\Foursquare\Client\Factory\Tip\Tip as TipFactory;
use Gibbo\Foursquare\Client\Entity\Tip\Tip;

class GroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(GroupFactory::class, $this->getFactory($this->getMockTipFactory()));
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
        $factory = $this->getFactory($this->getMockTipFactory());

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
                        "type": "others",
                        "name": "All tips",
                        "count": 319,
                        "items": [{}, {}]
                    }
JSON
                ),
                new Group('All tips', 'others', [$this->getMockTip(), $this->getMockTip()])
            ],
            [
                json_decode(
                    <<<JSON
                    {
                        "type": "others",
                        "name": "All tips",
                        "count": 319,
                        "items": []
                    }
JSON
                ),
                new Group('All tips', 'others', [])
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
        $this->getFactory($this->getMockTipFactory())->create($description);
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
                        "name": "All tips",
                        "count": 319,
                        "items": [{}, {}]
                    }
JSON
                ),
                'type'
            ],
            'No name' => [
                json_decode(
                    <<<JSON
                    {
                        "type": "others",
                        "count": 319,
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
     * @param TipFactory $tipFactory
     *
     * @return GroupFactory
     */
    private function getFactory(TipFactory $tipFactory)
    {
        return new GroupFactory($tipFactory);
    }

    /**
     * Get a mock tip factory.
     *
     * @return TipFactory
     */
    private function getMockTipFactory()
    {
        $factory = $this->getMockBuilder(TipFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockTip());

        return $factory;
    }

    /**
     * Get a mock tip.
     *
     * @return Tip
     */
    private function getMockTip()
    {
        return $this->getMockBuilder(Tip::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
