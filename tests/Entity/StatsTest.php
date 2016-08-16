<?php

namespace Gibbo\Foursquare\ClientTests\Entity;

use Gibbo\Foursquare\Client\Entity\Stats;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Tests the stats entity.
 */
class StatsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the construction.
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Stats::class, $this->getEntity(1, 1, 1, 1));
    }

    /**
     * Test the accessor methods.
     */
    public function testAccessors()
    {
        $checkins = 22;
        $users    = 10000;
        $tips     =  100;
        $visits   = 23;

        $entity = $this->getEntity($checkins, $users, $tips, $visits);

        $this->assertSame($checkins, $entity->getCheckins());
        $this->assertSame($users, $entity->getUsers());
        $this->assertSame($tips, $entity->getTips());
        $this->assertSame($visits, $entity->getVisits());
    }

    /**
     * Get the entity under test.
     *
     * @return Stats
     */
    private function getEntity($checkins, $users, $tips, $visits)
    {
        return new Stats($checkins, $users, $tips, $visits);
    }
}
