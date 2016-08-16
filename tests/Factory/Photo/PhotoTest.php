<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Photo;

use Gibbo\Foursquare\Client\Entity\Photo\Photo;
use Gibbo\Foursquare\Client\Factory\Photo\Photo as PhotoFactory;
use Gibbo\Foursquare\Client\Identifier;

class PhotoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(PhotoFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Photo $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Photo $expected)
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
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "public"
                    }
JSON
                ),
                new Photo(
                    new Identifier("51888d97498ef7f58e0686a3"),
                    (new \DateTimeImmutable())->setTimestamp(1367903639),
                    'https://irs3.4sqi.net/img/general/1920x1440/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg',
                    'public'
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
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
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "private"
                    }
JSON
                ),
                new Photo(
                    new Identifier("51888d97498ef7f58e0686a3"),
                    (new \DateTimeImmutable())->setTimestamp(1367903639),
                    'https://irs3.4sqi.net/img/general/1920x1440/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg',
                    'private'
                )
            ],
            [
                json_decode(
                    <<<JSON
                    {
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
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "friends"
                    }
JSON
                ),
                new Photo(
                    new Identifier("51888d97498ef7f58e0686a3"),
                    (new \DateTimeImmutable())->setTimestamp(1367903639),
                    'https://irs3.4sqi.net/img/general/1920x1440/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg',
                    'friends'
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
                        "createdAt": 1367903639,
                        "source": {
                          "name": "Foursquare for iOS",
                          "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                        },
                        "prefix": "https:\/\/irs3.4sqi.net\/img\/general\/",
                        "suffix": "\/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg",
                        "width": 1920,
                        "height": 1440,
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "public"
                    }
JSON
                ),
                'id',
            ],
            'No prefix' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "51888d97498ef7f58e0686a3",
                        "createdAt": 1367903639,
                        "source": {
                          "name": "Foursquare for iOS",
                          "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                        },
                        "suffix": "\/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg",
                        "width": 1920,
                        "height": 1440,
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "public"
                    }
JSON
                ),
                'prefix'
            ],
            'No suffix' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "51888d97498ef7f58e0686a3",
                        "createdAt": 1367903639,
                        "source": {
                          "name": "Foursquare for iOS",
                          "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                        },
                        "prefix": "https:\/\/irs3.4sqi.net\/img\/general\/",
                        "width": 1920,
                        "height": 1440,
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "public"
                    }
JSON
                ),
                'suffix'
            ],
            'No width' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "51888d97498ef7f58e0686a3",
                        "createdAt": 1367903639,
                        "source": {
                          "name": "Foursquare for iOS",
                          "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                        },
                        "suffix": "\/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg",
                        "prefix": "https:\/\/irs3.4sqi.net\/img\/general\/",
                        "height": 1440,
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "public"
                    }
JSON
                ),
                'width'
            ],
            'No height' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "51888d97498ef7f58e0686a3",
                        "createdAt": 1367903639,
                        "source": {
                          "name": "Foursquare for iOS",
                          "url": "https:\/\/foursquare.com\/download\/#\/iphone"
                        },
                        "suffix": "\/29797551_Gl0N3YYNpnAt7nJd_ujqBmI7rvcJSREurkNCunKzAFg.jpg",
                        "prefix": "https:\/\/irs3.4sqi.net\/img\/general\/",
                        "width": 1440,
                        "user": {
                          "id": "29797551",
                          "firstName": "Amanda",
                          "gender": "female",
                          "photo": {
                            "prefix": "https:\/\/irs2.4sqi.net\/img\/user\/",
                            "suffix": "\/G3EPJ0UTMXXYJUSO.jpg"
                          }
                        },
                        "visibility": "public"
                    }
JSON
                ),
                'height'
            ],
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return PhotoFactory
     */
    private function getFactory()
    {
        return new PhotoFactory();
    }
}

