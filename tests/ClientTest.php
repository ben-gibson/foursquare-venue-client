<?php

namespace Gibbo\Foursquare\ClientTests;

use Gibbo\Foursquare\Client\Client;
use Gibbo\Foursquare\Client\Configuration;
use Gibbo\Foursquare\Client\Exception\InvalidResponseException;
use Gibbo\Foursquare\Client\Factory\Venue\VenueFactory;
use Gibbo\Foursquare\Client\Entity\Venue\Venue;
use Gibbo\Foursquare\Client\Identifier;
use Gibbo\Foursquare\Client\Options\Search;
use Http\Client\Common\HttpMethodsClient;
use Http\Message\MessageFactory;
use Http\Mock\Client as MockHttpClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tests the client.
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Client::class, $this->getClient());
    }

    /**
     * Test client error response.
     *
     * @param ResponseInterface $response The client error response
     *
     * @dataProvider clientErrorResponseProvider
     * @expectedException \Gibbo\Foursquare\Client\Exception\ClientErrorException
     */
    public function testClientErrorResponse(ResponseInterface $response)
    {
        $client = $this->getClient($response);

        $client->getVenue(new Identifier('430d0a00f964a5203e271fe3'));
    }

    /**
     * Provide client error responses.
     *
     * @return array
     */
    public function clientErrorResponseProvider()
    {
        return [
            [
                $this->getMockResponse(
                    '{"meta":{"code":400,"errorType":"other","errorDetail":"Client error","requestId":"fake"},"response":{}}',
                    400
                )
            ],
            [
                $this->getMockResponse(
                    '{"meta":{"code":404,"errorType":"other","errorDetail":"Client error","requestId":"fake"},"response":{}}',
                    404
                )
            ],
            [
                $this->getMockResponse(
                    '{"meta":{"code":422,"errorType":"other","errorDetail":"Client error","requestId":"fake"},"response":{}}',
                    422
                )
            ],
            [
                $this->getMockResponse('', 422)
            ]
        ];
    }

    /**
     * Test server error response.
     *
     * @param ResponseInterface $response The server error response
     *
     * @dataProvider serverErrorResponseProvider
     * @expectedException \Gibbo\Foursquare\Client\Exception\ServerErrorException
     */
    public function testServerErrorResponse(ResponseInterface $response)
    {
        $client = $this->getClient($response);

        $client->getVenue(new Identifier('430d0a00f964a5203e271fe3'));
    }

    /**
     * Provide server error responses.
     *
     * @return array
     */
    public function serverErrorResponseProvider()
    {
        return [
            [
                $this->getMockResponse(
                    '{"meta":{"code":500,"errorType":"other","errorDetail":"Server error","requestId":"fake"},"response":{}}',
                    500
                )
            ],
            [
                $this->getMockResponse(
                    '{"meta":{"code":501,"errorType":"other","errorDetail":"Server error","requestId":"fake"},"response":{}}',
                    501
                )
            ],
            [
                $this->getMockResponse(
                    '{"meta":{"code":502,"errorType":"other","errorDetail":"Server error","requestId":"fake"},"response":{}}',
                    502
                )
            ],
            [
                $this->getMockResponse('', 503)
            ]
        ];
    }

    /**
     * Test a response with invalid JSON.
     *
     * @param ResponseInterface $response The response containing invalid JSON.
     *
     * @dataProvider invalidJSONResponseProvider
     * @expectedException \Gibbo\Foursquare\Client\Exception\InvalidResponseException
     * @expectedExceptionMessage Failed to decode response
     */
    public function testInvalidJSONResponse(ResponseInterface $response)
    {
        $client = $this->getClient($response);

        $client->getVenue(new Identifier('fake'));
    }

    /**
     * Provide responses with invalid JSON.
     *
     * @return array
     */
    public function invalidJSONResponseProvider()
    {
        return [
            [
                $this->getMockResponse('sdf')
            ],
            [
                $this->getMockResponse('invalid')
            ],
            [
                $this->getMockResponse('{"response": {"test": [],}}')
            ],
        ];
    }

    /**
     * Test getting a venue.
     */
    public function testGetVenue()
    {
        $body = '{"meta": {"code": 200, "requestId": "213454"},"response": {"venue": {"id": "430d0a00f964a5203e271fe3", "name": "Brooklyn Bridge Park"}}}';

        $description = json_decode($body);

        $venue = $this->getMockBuilder(Venue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $venueFactory = $this->getMockVenueFactory();

        $venueFactory->expects($this->once())
            ->method('create')
            ->with($this->equalTo($description->response->venue))
            ->willReturn($venue);

        $client = $this->getClient($this->getMockResponse($body), $venueFactory);

        $this->assertSame($venue, $client->getVenue(new Identifier('fake')));

        $this->expectException(InvalidResponseException::class);

        $client = $this->getClient($this->getMockResponse('{"meta": {"invalid": "content"}}'));

        $client->getVenue(new Identifier('fake'));
    }

    /**
     * Test searching for venues.
     */
    public function testSearchVenues()
    {
        $body = '{"meta": {"code": 200, "requestId": "234234"},"response": {"venues": [{"id": "430d0a00f964a5203e271fe3", "name": "Brooklyn Bridge Park"}, {"id": "430d0a00f964a5203e271fe3", "name": "Brooklyn Bridge Park"}]}}';

        $venue = $this->getMockBuilder(Venue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $venueFactory = $this->getMockVenueFactory();

        $venueFactory->expects($this->exactly(2))
            ->method('create')
            ->willReturn($venue);

        $client = $this->getClient($this->getMockResponse($body), $venueFactory);

        $venues = $client->search(Search::createWithPlace('Chicago, IL'));

        $this->assertCount(2, $venues);

        $this::assertEquals([$venue, $venue], $venues);

        $this->expectException(InvalidResponseException::class);

        $client = $this->getClient($this->getMockResponse('{"meta": {"invalid": "content"}}'));

        $client->search(Search::createWithPlace('Chicago, IL'));
    }

    /**
     * Get the client under test.
     *
     * @param ResponseInterface $response The response to return.
     * @param VenueFactory $factory       The venue factory.
     *
     * @return Client
     */
    private function getClient(ResponseInterface $response = null, VenueFactory $factory = null)
    {
        if ($response === null) {
            $response = $this->getMockResponse('');
        }

        if ($factory === null) {
            $factory = $this->getMockVenueFactory();
        }

        $httpClient = new MockHttpClient();
        $httpClient->addResponse($response);

        return new Client(
            new Configuration('3244few432', '423r234f234'),
            new HttpMethodsClient($httpClient, $this->getMockMessageFactory()),
            $factory
        );
    }

    /**
     * Get a mock venue factory.
     *
     * @return VenueFactory
     */
    private function getMockVenueFactory()
    {
        return $this->getMockBuilder(VenueFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Get a mock response.
     *
     * @param string $contents The response contents
     * @param int $status      The response status
     *
     * @return ResponseInterface
     */
    private function getMockResponse($contents, $status = 200)
    {
        $body     = $this->getMockBuilder(StreamInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
            ->method('getBody')
            ->willReturn($body);

        $body
            ->method('getContents')
            ->willReturn($contents);

        $response
            ->method('getStatusCode')
            ->willReturn($status);

        return $response;
    }

    /**
     * Get a mock message factory.
     *
     * @return MessageFactory
     */
    private function getMockMessageFactory()
    {
        $factory = $this->getMockBuilder(MessageFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request
            ->method('withHeader')
            ->willReturn($request);

        $factory
            ->method('createRequest')
            ->willReturn($request);

        return $factory;
    }
}
