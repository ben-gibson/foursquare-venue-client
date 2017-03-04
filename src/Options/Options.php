<?php

namespace Gibbo\Foursquare\Client\Options;

/**
 * Options that can be passed as parameters to the API.
 */
interface Options
{
    /**
     * Return the parametrised options.
     *
     * @return array
     */
    public function parametrise();
}
