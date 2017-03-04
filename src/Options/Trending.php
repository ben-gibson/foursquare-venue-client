<?php

namespace Gibbo\Foursquare\Client\Options;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Options\Traits\CanBeLimited;
use Gibbo\Foursquare\Client\Options\Traits\CanSupportRadius;
use Gibbo\Foursquare\Client\Options\Traits\LimitAware;
use Gibbo\Foursquare\Client\Options\Traits\RadiusAware;

/**
 * Represents trending options.
 */
class Trending implements Options, LimitAware, RadiusAware
{
    /**
     * @var Coordinates
     */
    private $coordinates;

    use CanBeLimited;
    use CanSupportRadius;

    /**
     * Constructor.
     *
     * @param Coordinates $coordinates
     */
    private function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Create trending options with coordinates.
     *
     * @param Coordinates $coordinates
     *
     * @return static
     */
    public static function coordinates(Coordinates $coordinates)
    {
        return new static($coordinates);
    }

    /**
     * {@inheritdoc}
     */
    public function parametrise()
    {
        return array_filter([
            'limit'  => $this->limit,
            'll'     => $this->coordinates,
            'radius' => $this->radius,
        ]);
    }
}
