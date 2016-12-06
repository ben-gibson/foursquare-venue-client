<?php

namespace Gibbo\Foursquare\ClientTests\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\Tip;
use Gibbo\Foursquare\Client\Factory\Description;
use Gibbo\Foursquare\Client\Factory\Tip\TipFactory;
use Gibbo\Foursquare\Client\Identifier;

class TipFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(TipFactory::class, $this->getFactory());
    }

    /**
     * Test the creation from a description.
     *
     * @param \stdClass $description
     * @param Tip $expected
     *
     * @dataProvider validDescriptionProvider
     */
    public function testCreate(\stdClass $description, Tip $expected)
    {
        $factory = $this->getFactory();

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
                        "id": "533cdcc011d22c65ce8bc789",
                        "createdAt": 1396497600,
                        "text": "Some useful tip.",
                        "type": "user",
                        "canonicalUrl": "https:\/\/foursquare.com\/item\/533cdcc011d22c65ce8bc789",
                        "likes": {
                          "count": 83,
                          "groups": [
                            {
                              "type": "others",
                              "count": 83,
                              "items": []
                            }
                          ],
                          "summary": "83 likes"
                        },
                        "logView": true,
                        "agreeCount": 82,
                        "disagreeCount": 0,
                        "todo": {
                          "count": 5
                        },
                        "user": {
                          "id": "82505562",
                          "firstName": "The Most Interesting Man in the World",
                          "gender": "none",
                          "photo": {
                            "prefix": "https:\/\/irs1.4sqi.net\/img\/user\/",
                            "suffix": "\/82505562-GOFQHX5S4J5IX5FZ.jpg"
                          },
                          "type": "page"
                        }
                    }
JSON
                ),
                new Tip(new Identifier("533cdcc011d22c65ce8bc789"), 'Some useful tip.', 'user', 82, 0)
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
        $this->getFactory()->create(new Description($description));
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
                        "createdAt": 1396497600,
                        "text": "Some useful tip.",
                        "type": "user",
                        "canonicalUrl": "https:\/\/foursquare.com\/item\/533cdcc011d22c65ce8bc789",
                        "likes": {
                          "count": 83,
                          "groups": [
                            {
                              "type": "others",
                              "count": 83,
                              "items": []
                            }
                          ],
                          "summary": "83 likes"
                        },
                        "logView": true,
                        "agreeCount": 82,
                        "disagreeCount": 0,
                        "todo": {
                          "count": 5
                        },
                        "user": {
                          "id": "82505562",
                          "firstName": "The Most Interesting Man in the World",
                          "gender": "none",
                          "photo": {
                            "prefix": "https:\/\/irs1.4sqi.net\/img\/user\/",
                            "suffix": "\/82505562-GOFQHX5S4J5IX5FZ.jpg"
                          },
                          "type": "page"
                        }
                    }
JSON
                ),
                'id'
            ],
            'No text' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "533cdcc011d22c65ce8bc789",
                        "createdAt": 1396497600,
                        "type": "user",
                        "canonicalUrl": "https:\/\/foursquare.com\/item\/533cdcc011d22c65ce8bc789",
                        "likes": {
                          "count": 83,
                          "groups": [
                            {
                              "type": "others",
                              "count": 83,
                              "items": []
                            }
                          ],
                          "summary": "83 likes"
                        },
                        "logView": true,
                        "agreeCount": 82,
                        "disagreeCount": 0,
                        "todo": {
                          "count": 5
                        },
                        "user": {
                          "id": "82505562",
                          "firstName": "The Most Interesting Man in the World",
                          "gender": "none",
                          "photo": {
                            "prefix": "https:\/\/irs1.4sqi.net\/img\/user\/",
                            "suffix": "\/82505562-GOFQHX5S4J5IX5FZ.jpg"
                          },
                          "type": "page"
                        }
                    }
JSON
                ),
                'text'
            ],
            'No type' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "533cdcc011d22c65ce8bc789",
                        "createdAt": 1396497600,
                        "text": "Some useful tip.",
                        "createdAt": 1396497600,
                        "canonicalUrl": "https:\/\/foursquare.com\/item\/533cdcc011d22c65ce8bc789",
                        "likes": {
                          "count": 83,
                          "groups": [
                            {
                              "type": "others",
                              "count": 83,
                              "items": []
                            }
                          ],
                          "summary": "83 likes"
                        },
                        "logView": true,
                        "agreeCount": 82,
                        "disagreeCount": 0,
                        "todo": {
                          "count": 5
                        },
                        "user": {
                          "id": "82505562",
                          "firstName": "The Most Interesting Man in the World",
                          "gender": "none",
                          "photo": {
                            "prefix": "https:\/\/irs1.4sqi.net\/img\/user\/",
                            "suffix": "\/82505562-GOFQHX5S4J5IX5FZ.jpg"
                          },
                          "type": "page"
                        }
                    }
JSON
                ),
                'type'
            ],
            'No agree count' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "533cdcc011d22c65ce8bc789",
                        "createdAt": 1396497600,
                        "text": "Some useful tip.",
                        "type": "user",
                        "createdAt": 1396497600,
                        "canonicalUrl": "https:\/\/foursquare.com\/item\/533cdcc011d22c65ce8bc789",
                        "likes": {
                          "count": 83,
                          "groups": [
                            {
                              "type": "others",
                              "count": 83,
                              "items": []
                            }
                          ],
                          "summary": "83 likes"
                        },
                        "logView": true,
                        "disagreeCount": 0,
                        "todo": {
                          "count": 5
                        },
                        "user": {
                          "id": "82505562",
                          "firstName": "The Most Interesting Man in the World",
                          "gender": "none",
                          "photo": {
                            "prefix": "https:\/\/irs1.4sqi.net\/img\/user\/",
                            "suffix": "\/82505562-GOFQHX5S4J5IX5FZ.jpg"
                          },
                          "type": "page"
                        }
                    }
JSON
                ),
                'agreeCount'
            ],
            'No disagree count' => [
                json_decode(
                    <<<JSON
                    {
                        "id": "533cdcc011d22c65ce8bc789",
                        "createdAt": 1396497600,
                        "text": "Some useful tip.",
                        "type": "user",
                        "createdAt": 1396497600,
                        "canonicalUrl": "https:\/\/foursquare.com\/item\/533cdcc011d22c65ce8bc789",
                        "likes": {
                          "count": 83,
                          "groups": [
                            {
                              "type": "others",
                              "count": 83,
                              "items": []
                            }
                          ],
                          "summary": "83 likes"
                        },
                        "logView": true,
                        "agreeCount": 0,
                        "todo": {
                          "count": 5
                        },
                        "user": {
                          "id": "82505562",
                          "firstName": "The Most Interesting Man in the World",
                          "gender": "none",
                          "photo": {
                            "prefix": "https:\/\/irs1.4sqi.net\/img\/user\/",
                            "suffix": "\/82505562-GOFQHX5S4J5IX5FZ.jpg"
                          },
                          "type": "page"
                        }
                    }
JSON
                ),
                'disagreeCount'
            ]
        ];
    }

    /**
     * Get the factory under test.
     *
     * @return TipFactory
     */
    private function getFactory()
    {
        return new TipFactory();
    }
}

