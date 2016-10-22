<?php

namespace Gibbo\Foursquare\Client\Entity\Tip;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeArrayAccessed;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeCounted;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeIterated;

/**
 * Represents a tip group.
 */
class TipGroup implements \Countable, \Iterator, \ArrayAccess
{
    use CanBeCounted;
    use CanBeIterated;
    use CanBeArrayAccessed;

    private $name;
    private $type;
    private $tips;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $type
     * @param Tip[] $tips
     */
    public function __construct($name, $type, array $tips)
    {
        \Assert\that($name)->string()->notEmpty();
        \Assert\that($type)->string()->notEmpty();

        Assertion::allIsInstanceOf($tips, Tip::class);

        $this->name  = $name;
        $this->type  = $type;
        $this->tips  = $tips;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get tips.
     *
     * @return Tip[]
     */
    public function getTips()
    {
        return $this->tips;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCollection()
    {
        return $this->getTips();
    }
}
