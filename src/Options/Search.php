<?php

namespace Gibbo\Foursquare\Client\Options;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Options\Traits\CanBeLimited;
use Gibbo\Foursquare\Client\Options\Traits\CanBeQueried;
use Gibbo\Foursquare\Client\Options\Traits\CanSupportRadius;
use Gibbo\Foursquare\Client\Options\Traits\LimitAware;
use Gibbo\Foursquare\Client\Options\Traits\QueryAware;
use Gibbo\Foursquare\Client\Options\Traits\RadiusAware;

/**
 * Represents search options.
 */
class Search implements LimitAware, QueryAware, RadiusAware, Options
{
    /**
     * @var Coordinates|null
     */
    private $coordinates;

    /**
     * @var null|string
     */
    private $place;

    /**
     * @var int[]
     */
    private $categoryIds = [];

    use CanBeLimited;
    use CanBeQueried;
    use CanSupportRadius;

    /**
     * Constructor.
     *
     * @param Coordinates $coordinates.
     * @param string $place.
     *
     * @throws \InvalidArgumentException Incorrectly configured place or coordinates.
     */
    private function __construct(Coordinates $coordinates = null, $place = null)
    {
        \Assert\that($place)->nullOr()->string()->notEmpty();

        if ($coordinates === null && $place === null) {
            throw new \InvalidArgumentException('A place or coordinates must be provided, none given.');
        }

        if ($coordinates !== null && $place !== null) {
            throw new \InvalidArgumentException('Either a place or coordinates must be provided, not both.');
        }

        $this->coordinates = $coordinates;
        $this->place       = $place;
    }

    /**
     * Create search options with coordinates.
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
     * Create search options with a place name.
     *
     * @param string $place A place name to search.
     *
     * @return static
     */
    public static function place($place)
    {
        \Assert\that($place)->string()->notEmpty();

        return new static(null, $place);
    }

    /**
     * Set the category ids.
     *
     * @param int[] $categoryIds
     *
     * @return void
     */
    public function categoryIds(array $categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }


    /**
     * {@inheritdoc}
     */
    public function parametrise()
    {
        return array_filter([
            'limit'  => $this->limit,
            'll'     => $this->coordinates,
            'near'   => $this->place,
            'radius' => $this->radius,
            'query'  => $this->query,
            'categoryId' => implode(',', $this->categoryIds)
        ]);
    }
}
