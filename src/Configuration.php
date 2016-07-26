<?php

namespace Gibbo\Foursquare\Client;

use Assert\Assertion;

/**
 * Represents the client configuration.
 */
class Configuration
{
    private $clientId;
    private $clientSecret;
    private $version  = 2;
    private $date     = '20160730'; // See https://developer.foursquare.com/overview/versioning
    private $basePath = 'https://api.foursquare.com';

    /**
     * Constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string|null $basePath
     */
    public function __construct($clientId, $clientSecret, $basePath = null)
    {
        \Assert\that($clientId)->string()->notEmpty();
        \Assert\that($clientSecret)->string()->notEmpty();

        if ($basePath !== null) {
            Assertion::url($basePath);

            $this->basePath = rtrim($basePath, '/');
        }

        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Get the client id.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Get the client secret.
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Get the version.
     *
     * @return float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get the versioned date.
     *
     * @return string
     */
    public function getVersionedDate()
    {
        return $this->date;
    }
}
