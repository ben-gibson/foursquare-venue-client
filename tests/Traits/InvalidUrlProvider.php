<?php

namespace Gibbo\Foursquare\ClientTests\Traits;

/**
 * Invalid url provider.
 *
 * Used for the purpose of testing the assertions on arguments that are expected to contain a url.
 */
trait InvalidUrlProvider
{
    /**
     * Provides invalid urls.
     *
     * @return array
     */
    public function invalidUrlProvider()
    {
        return [
            [''],
            [new \stdClass],
            [213],
            [[]],
            [null],
            ['example.com'],
            ['htt://example.com'],
            ['ssh://example.com'],
        ];
    }
}
