<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\TipGroup;
use Gibbo\Foursquare\Client\Factory\Description;
use Gibbo\Foursquare\Client\Factory\Tip\TipGroupFactory;
use Gibbo\Foursquare\Client\Factory\Tip\TipFactory as TipFactory;
use Gibbo\Foursquare\Client\Entity\Tip\Tip;

class GroupFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(TipGroupFactory::class, $this->getFactory($this->getMockTipFactory()));
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param TipGroup  $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, TipGroup $expected)
    {
        $factory = $this->getFactory($this->getMockTipFactory());

        $this->assertEquals($expected, $factory->create(new Description($description)));
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
                new TipGroup('All tips', 'others', [$this->getMockTip(), $this->getMockTip()])
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
                new TipGroup('All tips', 'others', [])
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
        $this->expectExceptionMessage("The entity description is missing the mandatory property '{$property}'");
        $this->getFactory($this->getMockTipFactory())->create(new Description($description));
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
     * @return TipGroupFactory
     */
    private function getFactory(TipFactory $tipFactory)
    {
        return new TipGroupFactory($tipFactory);
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
