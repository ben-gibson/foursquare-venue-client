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
    private $coordinates;
    private $place;
    private $targetToCurrentTime = true;
    private $targetToCurrentDay  = true;
    private $includeOpenOnly     = false;
    private $sortByDistance      = false;

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
     * Get coordinates.
     *
     * @return Coordinates|null
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Get place.
     *
     * @return string|null
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Should results to be targeted based on the current time.
     *
     * @return boolean
     */
    public function shouldTargetToCurrentTime()
    {
        return $this->targetToCurrentTime;
    }

    /**
     * Set the time targeting preference.
     *
     * See description of 'time' here https://developer.foursquare.com/docs/venues/explore
     *
     * @param boolean $targetToCurrentTime
     *
     * @return self
     */
    public function setTargetToCurrentTime($targetToCurrentTime)
    {
        $this->targetToCurrentTime = $targetToCurrentTime;

        return $this;
    }

    /**
     * Should results to be targeted based on the current day.
     *
     * @return boolean
     */
    public function shouldTargetToCurrentDay()
    {
        return $this->targetToCurrentDay;
    }

    /**
     * Set the day targeting preference.
     *
     * See description of 'day' here https://developer.foursquare.com/docs/venues/explore
     *
     * @param boolean $targetToCurrentDay
     *
     * @return self
     */
    public function setTargetToCurrentDay($targetToCurrentDay)
    {
        $this->targetToCurrentDay = $targetToCurrentDay;

        return $this;
    }

    /**
     * Should we only include open venues in results.
     *
     * @return boolean
     */
    public function includeOpenOnly()
    {
        return $this->includeOpenOnly;
    }

    /**
     * Set the only include open venues preference.
     *
     * @param boolean $includeOpenOnly
     *
     * @return self
     */
    public function setIncludeOpenOnly($includeOpenOnly)
    {
        $this->includeOpenOnly = $includeOpenOnly;

        return $this;
    }

    /**
     * Should we sort the results by distance instead of relevance.
     *
     * @return boolean
     */
    public function shouldSortByDistance()
    {
        return $this->sortByDistance;
    }

    /**
     * Set the sort by distance preference.
     *
     * @param boolean $sortByDistance
     *
     * @return self
     */
    public function setSortByDistance($sortByDistance)
    {
        $this->sortByDistance = $sortByDistance;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array_filter([
            'limit'          => $this->getLimit(),
            'll'             => $this->getCoordinates(),
            'near'           => $this->getPlace(),
            'radius'         => $this->getRadius(),
            'query'          => $this->getQuery(),
            'time'           => $this->shouldTargetToCurrentTime() ? null : 'any',
            'day'            => $this->shouldTargetToCurrentDay() ? null : 'any',
            'openNow'        => (int)$this->includeOpenOnly(),
            'sortByDistance' => (int)$this->shouldSortByDistance(),
        ]);
    }
}
