<?php

namespace Gibbo\Foursquare\Client\Entity;

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
        \Assert\that($checkins)->integer()->greaterOrEqualThan(0);
        \Assert\that($users)->integer()->greaterOrEqualThan(0);
        \Assert\that($tips)->integer()->greaterOrEqualThan(0);
        \Assert\that($visits)->integer()->greaterOrEqualThan(0);

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
