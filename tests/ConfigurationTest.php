<?php

namespace Gibbo\Foursquare\ClientTests;

use Gibbo\Foursquare\Client\Configuration;

/**
 * Tests the configuration.
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $clientId      = 'example-id';
        $clientSecret  = 'example-secret';
        $configuration = new Configuration($clientId, $clientSecret, 'https://dev-api.co.uk/');

        $this->assertInstanceOf(Configuration::class, $configuration);
        $this->assertSame($clientId, $configuration->getClientId());
        $this->assertSame($clientSecret, $configuration->getClientSecret());
        $this->assertSame('https://dev-api.co.uk', $configuration->getBasePath());
    }

    /**
     * Test invalid client credentials.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidClientCredentials()
    {
        new Configuration('', 'example-secret');
        new Configuration('example-id', '');
        new Configuration(null, null);
    }

    /**
     * Test invalid base paths.
     *
     * @param mixed $basePath
     *
     * @dataProvider invalidBasePathProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidBasePath($basePath)
    {
        new Configuration('example-id', 'example-secret', $basePath);
    }

    /**
     * Provide invalid base paths.
     *
     * @return array
     */
    public function invalidBasePathProvider()
    {
        return [
            [''],
            [123],
            ['api.com'],
            ['www.api.com'],
        ];
    }

    /**
     * Test valid base paths.
     *
     * @param string $basePath
     *
     * @dataProvider validBasePathProvider
     */
    public function testValidBasePath($basePath)
    {
        new Configuration('example-id', 'example-secret', $basePath);
    }

    /**
     * Provide valid base paths.
     *
     * @return array
     */
    public function validBasePathProvider()
    {
        return [
            [null],
            ['https://api-test.com'],
            ['http://hello.api.com'],
            ['http://api.hello.com/test/api']
        ];
    }
}
