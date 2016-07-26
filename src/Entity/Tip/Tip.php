<?php

namespace Gibbo\Foursquare\Client\Entity\Tip;

use Assert\Assertion;
use Gibbo\Foursquare\Client\Entity\Traits\CanBeIdentified;
use Gibbo\Foursquare\Client\Identifier;

/**
 * Represents a venue tip.
 */
class Tip
{
    use CanBeIdentified;

    private $text;
    private $type;
    private $agreeCount;
    private $disagreeCount;

    /**
     * Constructor.
     *
     * @param Identifier $identifier
     * @param string $text
     * @param string $type
     */
    public function __construct(Identifier $identifier, $text, $type, $agreeCount, $disagreeCount)
    {
        \Assert\that($text)->string()->notEmpty();
        \Assert\that($type)->string()->notEmpty();
        Assertion::integer($agreeCount);
        Assertion::integer($disagreeCount);

        $this->identifier    = $identifier;
        $this->text          = $text;
        $this->type          = $type;
        $this->agreeCount    = $agreeCount;
        $this->disagreeCount = $disagreeCount;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
     * Get agree count.
     *
     * @return int
     */
    public function getAgreeCount()
    {
        return $this->agreeCount;
    }

    /**
     * Get the disagree count.
     *
     * @return int
     */
    public function getDisagreeCount()
    {
        return $this->disagreeCount;
    }
}
