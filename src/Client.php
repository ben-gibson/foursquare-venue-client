<?php

namespace Gibbo\Foursquare\Client;

use Gibbo\Foursquare\Client\Exception\ClientErrorException;
use Gibbo\Foursquare\Client\Exception\InvalidResponseException;
use Gibbo\Foursquare\Client\Entity\Venue\Venue;
use Gibbo\Foursquare\Client\Exception\ServerErrorException;
use Gibbo\Foursquare\Client\Factory\Venue\VenueFactory;
use Gibbo\Foursquare\Client\Options\Explore;
use Gibbo\Foursquare\Client\Options\Search;
use Gibbo\Foursquare\Client\Options\Trending;
use Http\Client\Common\HttpMethodsClient;
use Psr\Http\Message\ResponseInterface;

/**
 * The client.
 */
class Client
{
    private $configuration;
    private $httpClient;
    private $venueFactory;

    /**
     * Constructor.
     *
     * @param Configuration $configuration The configuration.
     * @param HttpMethodsClient $httpClient The http client.
     * @param VenueFactory $venueFactory The venue factory.
     */
    public function __construct(Configuration $configuration, HttpMethodsClient $httpClient, VenueFactory $venueFactory)
    {
        $this->configuration = $configuration;
        $this->httpClient    = $httpClient;
        $this->venueFactory  = $venueFactory;
    }

    /**
     * Get a venue by its unique identifier.
     *
     * @param Identifier $identifier The venue identifier.
     *
     * @return Venue
     */
    public function getVenue(Identifier $identifier)
    {
        $url = $this->getUrl(sprintf('venues/%s', urlencode($identifier)));

        $response = $this->httpClient->get($url, $this->getDefaultHeaders());

        $description = $this->parseResponse($response);

        if (!isset($description->response->venue)) {
            throw InvalidResponseException::invalidResponseBody($response, 'response.venue');
        }

        return $this->venueFactory->create($description->response->venue);
    }

    /**
     * Search venues.
     *
     * @param Search $options The search options.
     *
     * @return Venue[]
     */
    public function search(Search $options)
    {
        $url = $this->getUrl('venues/search', $options->toArray());

        $response = $this->httpClient->get($url, $this->getDefaultHeaders());

        $description = $this->parseResponse($response);

        if (!isset($description->response->venues)) {
            throw InvalidResponseException::invalidResponseBody($response, 'response.venues');
        }

        return array_map(function (\stdClass $venueDescription) {
            return $this->venueFactory->create($venueDescription);
        }, $description->response->venues);
    }

    /**
     * Explore venues.
     *
     * @param Explore $options The explore options.
     *
     * @return Venue[]
     */
    public function explore(Explore $options)
    {
        $url = $this->getUrl('venues/explore', $options->toArray());

        $response = $this->httpClient->get($url, $this->getDefaultHeaders());

        $description = $this->parseResponse($response);

        if (!isset($description->response->groups[0]->items)) {
            throw InvalidResponseException::invalidResponseBody($response, 'response.groups[0].items');
        }

        return array_map(function (\stdClass $itemDescription) {
            return $this->venueFactory->create($itemDescription->venue);
        }, $description->response->groups[0]->items);
    }

    /**
     * Get trending venues.
     *
     * @param Trending $options The trending options.
     *
     * @return Venue[]
     */
    public function trending(Trending $options)
    {
        $url = $this->getUrl('venues/trending', $options->toArray());

        $response = $this->httpClient->get($url, $this->getDefaultHeaders());

        $description = $this->parseResponse($response);

        if (!isset($description->response->venues)) {
            throw InvalidResponseException::invalidResponseBody($response, 'response.venues');
        }

        return array_map(function (\stdClass $venueDescription) {
            return $this->venueFactory->create($venueDescription);
        }, $description->response->venues);
    }

    /**
     * Parse a response.
     *
     * @param ResponseInterface $response The response to parse.
     *
     * @throws ClientErrorException Thrown when a 4xx response status is returned.
     * @throws ServerErrorException Thrown when a 5xx response status is returned.
     * @throws InvalidResponseException Thrown when an invalid response body is encountered.
     *
     * @return mixed
     */
    private function parseResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
            throw new ClientErrorException($response);
        }

        if ($response->getStatusCode() >= 500 && $response->getStatusCode() < 600) {
            throw new ServerErrorException($response);
        }

        $response->getBody()->rewind();

        $result = json_decode($response->getBody()->getContents());

        if ($result === null) {
            throw InvalidResponseException::failedToDecodeResponse($response, json_last_error_msg());
        }

        return $result;
    }

    /**
     * Get the API url for a given path.
     *
     * @param string $path The path.
     * @param array $parameters The query parameters to include.
     *
     * @return string
     */
    private function getUrl($path, $parameters = [])
    {
        $url = sprintf(
            '%s/v%d/%s?client_id=%s&client_secret=%s&v=%s%s',
            $this->configuration->getBasePath(),
            urlencode($this->configuration->getVersion()),
            trim($path, '/'),
            urlencode($this->configuration->getClientId()),
            urlencode($this->configuration->getClientSecret()),
            urlencode($this->configuration->getVersionedDate()),
            $this->parseParameters($parameters)
        );

        return $url;
    }

    /**
     * Get the default request headers.
     *
     * @return string[]
     */
    private function getDefaultHeaders()
    {
        return [
            'accept-encoding' => 'application/json'
        ];
    }

    /**
     * Parse an array of parameters to their string representation.
     *
     * @param array $parameters
     *
     * @return string
     */
    private function parseParameters(array $parameters)
    {
        if (empty($parameters)) {
            return '';
        }

        $parameters = implode('&', array_map(
            function ($value, $key) {
                return sprintf('%s=%s', $key, urlencode($value));
            },
            $parameters,
            array_keys($parameters)
        ));

        return "&{$parameters}";
    }
}
