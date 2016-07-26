<?php

namespace Gibbo\Foursquare\Client\Entity;

use Assert\Assertion;

/**
 * Represents venue statistics.
 */
class Stats
{
    private $checkins;
    private $users;
    private $tips;
    private $visits;

    /**
     * Constructor.
     *
     * @param int $checkins
     * @param int $users
     * @param int $tips
     * @param int $visits
     */
    public function __construct($checkins, $users, $tips, $visits)
    {
        Assertion::integer($checkins);
        Assertion::integer($users);
        Assertion::integer($tips);
        Assertion::integer($visits);

        $this->checkins = $checkins;
        $this->users    = $users;
        $this->tips     = $tips;
        $this->visits   = $visits;
    }

    /**
     * Get checkins.
     *
     * @return int
     */
    public function getCheckins()
    {
        return $this->checkins;
    }

    /**
     * Get users.
     *
     * @return int
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get tips.
     *
     * @return int
     */
    public function getTips()
    {
        return $this->tips;
    }

    /**
     * Get visits.
     *
     * @return int
     */
    public function getVisits()
    {
        return $this->visits;
    }
}
