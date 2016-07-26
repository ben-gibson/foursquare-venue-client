<?php

namespace Gibbo\Foursquare\Client\Options;

/**
 * Options that can be passed as parameters to the API.
 */
interface Options
{
    /**
     * Return an array representation of the options.
     *
     * @return array
     */
    public function toArray();
}
