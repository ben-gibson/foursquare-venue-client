<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Category;
use Gibbo\Foursquare\Client\Entity\Contact;
use Gibbo\Foursquare\Client\Entity\Location;
use Gibbo\Foursquare\Client\Entity\Photo\Group as PhotoGroup;
use Gibbo\Foursquare\Client\Entity\Tip\Group as TipGroup;
use Gibbo\Foursquare\Client\Entity\Venue\Detail;
use Gibbo\Foursquare\Client\Entity\Venue\Venue;
use Gibbo\Foursquare\Client\Factory\Venue\Venue as VenueFactory;
use Gibbo\Foursquare\Client\Factory\Venue\Detail as DetailFactory;
use Gibbo\Foursquare\Client\Factory\Photo\Group as PhotoGroupFactory;
use Gibbo\Foursquare\Client\Factory\Tip\Group as TipGroupFactory;
use Gibbo\Foursquare\Client\Factory\Location as LocationFactory;
use Gibbo\Foursquare\Client\Factory\Category as CategoryFactory;
use Gibbo\Foursquare\Client\Factory\Contact as ContactFactory;
use Gibbo\Foursquare\Client\Identifier;

class VenueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(VenueFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Venue $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Venue $expected)
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
                         "id": "430d0a00f964a5203e271fe3",
                         "name": "Brooklyn Bridge Park",
                         "contact": {},
                         "location": {},
                         "categories": [],
                         "photos": [],
                         "tips": []      
                    }
JSON
                ),
                new Venue(
                    new Identifier('430d0a00f964a5203e271fe3'),
                    'Brooklyn Bridge Park',
                    [],
                    [],
                    [],
                    $this->getMockContact(),
                    $this->getMockLocation(),
                    $this->getMockDetail()
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
                         "id": "430d0a00f964a5203e271fe3",
                         "name": "Brooklyn Bridge Park",
                         "contact": {},
                         "location": {}
                    }
JSON
                ),
                new Venue(
                    new Identifier('430d0a00f964a5203e271fe3'),
                    'Brooklyn Bridge Park',
                    [],
                    [],
                    [],
                    $this->getMockContact(),
                    $this->getMockLocation(),
                    $this->getMockDetail()
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
                         "id": "121",
                         "name": "Universal Studios",
                         "contact": {},
                         "location": {},
                         "categories": [
                            {},
                            {}
                         ],
                         "photos": {
                            "groups": [{}]
                         },
                         "tips": {
                            "groups": [{}]
                         }      
                    }
JSON
                ),
                new Venue(
                    new Identifier('121'),
                    'Universal Studios',
                    [$this->getMockCategory(),$this->getMockCategory()],
                    [$this->getMockTipGroup()],
                    [$this->getMockPhotoGroup()],
                    $this->getMockContact(),
                    $this->getMockLocation(),
                    $this->getMockDetail()
                )
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
        $this->getFactory()->create($description);
    }

    /**
     * Provides invalid descriptions.
     *
     * @return array
     */
    public function invalidDescriptionProvider()
    {
        return [
            'No id' => [
                json_decode(
                    <<<JSON
                   {
                         "name": "Brooklyn Bridge Park",
                         "contact": {},
                         "location": {},
                         "categories": [],
                         "photos": [],
                         "tips": []      
                    }
JSON
                ),
                'id'
            ],
            'No name' => [
                json_decode(
                    <<<JSON
                   {
                         "id": "121",
                         "contact": {},
                         "location": {},
                         "categories": [],
                         "photos": [],
                         "tips": []      
                    }
JSON
                ),
                'name'
            ],
            'No contact' => [
                json_decode(
                    <<<JSON
                   {
                         "id": "121",
                         "name": "Brooklyn Bridge Park",
                         "location": {},
                         "categories": [],
                         "photos": [],
                         "tips": []      
                    }
JSON
                ),
                'contact'
            ],
            'No location' => [
                json_decode(
                    <<<JSON
                   {
                         "id": "121",
                         "name": "Brooklyn Bridge Park",
                         "contact": {},
                         "categories": [],
                         "photos": [],
                         "tips": []  
                    }
JSON
                ),
                'location'
            ],
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return VenueFactory
     */
    private function getFactory()
    {
        return new VenueFactory(
            $this->getMockDetailFactory(),
            $this->getMockCategoryFactory(),
            $this->getMockContactFactory(),
            $this->getMockLocationFactory(),
            $this->getMockTipGroupFactory(),
            $this->getMockPhotoGroupFactory()
        );
    }

    /**
     * Get a mock category factory.
     *
     * @return CategoryFactory
     */
    private function getMockCategoryFactory()
    {
        $factory = $this->getMockBuilder(CategoryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockCategory());

        return $factory;
    }

    /**
     * Get a mock category.
     *
     * @return Category
     */
    private function getMockCategory()
    {
        return $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Get a mock contact factory.
     *
     * @return ContactFactory
     */
    private function getMockContactFactory()
    {
        $factory = $this->getMockBuilder(ContactFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockContact());

        return $factory;
    }

    /**
     * Get a mock contact.
     *
     * @return Contact
     */
    private function getMockContact()
    {
        return $this->getMockBuilder(Contact::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Get a mock location factory.
     *
     * @return LocationFactory
     */
    private function getMockLocationFactory()
    {
        $factory = $this->getMockBuilder(LocationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockLocation());

        return $factory;
    }

    /**
     * Get a mock location.
     *
     * @return Location
     */
    private function getMockLocation()
    {
        return $this->getMockBuilder(Location::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Get a mock detail factory.
     *
     * @return DetailFactory
     */
    private function getMockDetailFactory()
    {
        $factory = $this->getMockBuilder(DetailFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockDetail());

        return $factory;
    }

    /**
     * Get a mock detail.
     *
     * @return Detail
     */
    private function getMockDetail()
    {
        return $this->getMockBuilder(Detail::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Get a mock tip group factory.
     *
     * @return TipGroupFactory
     */
    private function getMockTipGroupFactory()
    {
        $factory = $this->getMockBuilder(TipGroupFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockTipGroup());

        return $factory;
    }

    /**
     * Get a mock tip group.
     *
     * @return TipGroup
     */
    private function getMockTipGroup()
    {
        return $this->getMockBuilder(TipGroup::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Get a mock photo group factory.
     *
     * @return PhotoGroupFactory
     */
    private function getMockPhotoGroupFactory()
    {
        $factory = $this->getMockBuilder(PhotoGroupFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory
            ->method('create')
            ->willReturn($this->getMockPhotoGroup());

        return $factory;
    }

    /**
     * Get a mock photo group.
     *
     * @return TipGroup
     */
    private function getMockPhotoGroup()
    {
        return $this->getMockBuilder(PhotoGroup::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
