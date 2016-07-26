<?php

namespace Gibbo\Foursquare\Client\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when a response status 4xx is encountered.
 */
class ClientErrorException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param ResponseInterface $response The client error response.
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct(sprintf(
            'Client error: [status code] %s [reason phrase] %s',
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
    }
}
