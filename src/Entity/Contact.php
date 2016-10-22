<?php

namespace Gibbo\Foursquare\Client\Entity;

/**
 * Represents contact information.
 */
class Contact
{
    private $phone;
    private $twitterId;
    private $facebookId;

    /**
     * Constructor.
     *
     * @param string|null $phone
     * @param string|null $twitterId
     * @param string|null $facebookId
     */
    public function __construct($phone = null, $twitterId = null, $facebookId = null)
    {
        \Assert\that($phone)->nullOr()->string()->notEmpty();
        \Assert\that($twitterId)->nullOr()->string()->notEmpty();
        \Assert\that($facebookId)->nullOr()->string()->notEmpty();

        $this->phone      = $phone;
        $this->twitterId  = $twitterId;
        $this->facebookId = $facebookId;
    }

    /**
     * Get the phone number.
     *
     * @return null|string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the twitter id.
     *
     * @return null|string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Get the facebook id.
     *
     * @return null|string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }
}
