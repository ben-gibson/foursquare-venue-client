<?php

namespace Gibbo\Foursquare\Client\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when an invalid response is returned from the API.
 */
class InvalidResponseException extends \RuntimeException
{
    /**
     * Thrown when an response could not be JSON decoded.
     *
     * @param ResponseInterface $response The response that couldn't be decoded.
     * @param string $error The decode error message.
     *
     * @return static
     */
    public static function failedToDecodeResponse(ResponseInterface $response, $error)
    {
        $response->getBody()->rewind();
        return new static(sprintf(
            "Failed to decode response '%s' with error '%s'",
            $response->getBody()->getContents(),
            $error
        ));
    }

    /**
     * Thrown when the response body is missing an expected JSON path.
     *
     * @param ResponseInterface $response The response.
     * @param string $expectedPath The expect JSON path.
     *
     * @return static
     */
    public static function invalidResponseBody(ResponseInterface $response, $expectedPath)
    {
        $response->getBody()->rewind();
        return new static(sprintf(
            "Response body '%s' is missing the expected JSON path '%s'",
            $response->getBody()->getContents(),
            $expectedPath
        ));
    }
}
