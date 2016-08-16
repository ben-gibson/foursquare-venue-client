<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Venue;

use Gibbo\Foursquare\Client\Entity\Venue\Detail;
use Gibbo\Foursquare\Client\Factory\Venue\Detail as DetailFactory;
use Gibbo\Foursquare\Client\Factory\Photo\Photo as PhotoFactory;
use Gibbo\Foursquare\Client\Entity\Photo\Photo;

class DetailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(DetailFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Detail $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Detail $expected)
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
                         "verified": true,
                         "rating": 9.7,
                         "timeZone": "America\/New_York",
                         "bestPhoto": {
                            "id": "51888d97498ef7f58e0686a3",
                            "createdAt": 1367903639,
                            "source": {
                              "name": "Foursquare for iOS",
                              "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                            },
                            "prefix": "https:\/\/irs3.4sqi.net\/img\/general\/",
                            "suffix": "\/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg",
                            "width": 1920,
                            "height": 1440,
                            "visibility": "public"
                         },
                        "url": "http:\/\/nyc.gov\/parks",
                        "createdAt": 1367903639,
                        "hereNow": {
                            "count": 3,
                            "summary": "3 people are here",
                            "groups": [
                              {
                                "type": "others",
                                "name": "Other people here",
                                "count": 3,
                                "items": []
                              }
                            ]
                        },
                        "likes": {
                          "count": 34,
                          "groups": [
                            {
                              "type": "others",
                              "count": 34,
                              "items": []
                            }
                          ],
                          "summary": "34 likes"
                        },
                        "tags": [
                            "aia national",
                            "aia new york",
                            "boat"
                        ]
                    }
JSON
                ),
                new Detail(
                    true,
                    (new \DateTimeImmutable())->setTimestamp(1367903639),
                    $this->getMockPhoto(),
                    9.7,
                    'http://nyc.gov/parks',
                    3,
                    [
                        "aia national",
                        "aia new york",
                        "boat",
                    ],
                    34,
                    new \DateTimeZone('America/New_York')
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
                         "verified": false,
                         "hereNow": {
                            "count": 3,
                            "summary": "3 people are here",
                            "groups": [
                              {
                                "type": "others",
                                "name": "Other people here",
                                "count": 3,
                                "items": []
                              }
                            ]
                        }
                    }
JSON
                ),
                new Detail(
                    false,
                    null,
                    null,
                    null,
                    null,
                    3,
                    [],
                    null,
                    null
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
            'No verification' => [
                json_decode(
                    <<<JSON
                    {
                         "rating": 9.7,
                         "timeZone": "America\/New_York",
                         "bestPhoto": {
                            "id": "51888d97498ef7f58e0686a3",
                            "createdAt": 1367903639,
                            "source": {
                              "name": "Foursquare for iOS",
                              "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                            },
                            "prefix": "https:\/\/irs3.4sqi.net\/img\/general\/",
                            "suffix": "\/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg",
                            "width": 1920,
                            "height": 1440,
                            "visibility": "public"
                         },
                        "url": "http:\/\/nyc.gov\/parks",
                        "createdAt": 1367903639,
                        "hereNow": {
                            "count": 3,
                            "summary": "3 people are here",
                            "groups": [
                              {
                                "type": "others",
                                "name": "Other people here",
                                "count": 3,
                                "items": []
                              }
                            ]
                        },
                        "likes": {
                          "count": 34,
                          "groups": [
                            {
                              "type": "others",
                              "count": 34,
                              "items": []
                            }
                          ],
                          "summary": "34 likes"
                        },
                        "tags": [
                            "aia national",
                            "aia new york",
                            "boat"
                        ]
                    }
JSON
                ),
                'verified'
            ],
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return DetailFactory
     */
    private function getFactory()
    {
        return new DetailFactory($this->getMockPhotoFactory());
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
