<?php

namespace Gibbo\Foursquare\Client\Tests\Factory\Tip;

use Gibbo\Foursquare\Client\Entity\Tip\Tip;
use Gibbo\Foursquare\Client\Factory\Tip\Tip as TipFactory;
use Gibbo\Foursquare\Client\Identifier;

class TipTest extends \PHPUnit_Framework_TestCase
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
    public function testCreateWithInvalidDescription(\stdClass $description)
    {
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
            [ // NO ID
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
                )
            ],
            [ // NO TEXT
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
                )
            ],
            [ // NO TYPE
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
                )
            ],
            [ // NO AGREE COUNT
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
                )
            ],
            [ // NO DISAGREE COUNT
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
                )
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

