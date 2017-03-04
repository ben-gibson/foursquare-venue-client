<?php

namespace Gibbo\Foursquare\Client\Options;

use Gibbo\Foursquare\Client\Entity\Coordinates;
use Gibbo\Foursquare\Client\Options\Traits\CanBeLimited;
use Gibbo\Foursquare\Client\Options\Traits\CanBeQueried;
use Gibbo\Foursquare\Client\Options\Traits\CanSupportRadius;

/**
 * Represents options available to the venue explore endpoint.
 */
class Explore implements Options
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
     * @var bool
     */
    private $targetToCurrentTime = true;

    /**
     * @var bool
     */
    private $targetToCurrentDay = true;

    /**
     * @var bool
     */
    private $includeOpenOnly = false;

    /**
     * @var bool
     */
    private $sortByDistance = false;

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
     * Create explore options with coordinates.
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
     * Create explore options with a place name.
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
     * Set the time targeting preference.
     *
     * @See https://developer.foursquare.com/docs/venues/explore
     *
     * @param boolean $targetToCurrentTime
     *
     * @return self
     */
    public function targetToCurrentTime($targetToCurrentTime)
    {
        $this->targetToCurrentTime = $targetToCurrentTime;

        return $this;
    }

    /**
     * Set the day targeting preference.
     *
     * @see https://developer.foursquare.com/docs/venues/explore
     *
     * @param boolean $targetToCurrentDay
     *
     * @return self
     */
    public function targetToCurrentDay($targetToCurrentDay)
    {
        $this->targetToCurrentDay = $targetToCurrentDay;

        return $this;
    }

    /**
     * Set the only include open venues preference.
     *
     * @param boolean $includeOpenOnly
     *
     * @return self
     */
    public function includeOpenOnly($includeOpenOnly)
    {
        $this->includeOpenOnly = $includeOpenOnly;

        return $this;
    }

    /**
     * Set the sort by distance preference.
     *
     * @param boolean $sortByDistance
     *
     * @return self
     */
    public function sortByDistance($sortByDistance)
    {
        $this->sortByDistance = $sortByDistance;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function parametrise()
    {
        return array_filter([
            'limit'          => $this->limit,
            'll'             => $this->coordinates,
            'near'           => $this->place,
            'radius'         => $this->radius,
            'query'          => $this->query,
            'time'           => $this->targetToCurrentTime ? null : 'any',
            'day'            => $this->targetToCurrentDay ? null : 'any',
            'openNow'        => (int)$this->includeOpenOnly,
            'sortByDistance' => (int)$this->sortByDistance,
        ]);
    }
}
