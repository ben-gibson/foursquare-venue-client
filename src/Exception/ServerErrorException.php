<?php

namespace Gibbo\Foursquare\Client\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when a response status 5xx is encountered.
 */
class ServerErrorException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param ResponseInterface $response The client error response.
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct(sprintf(
            'Server error: [status code] %s [reason phrase] %s',
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
    }
}
