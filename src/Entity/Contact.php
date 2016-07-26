<?php

namespace Gibbo\Foursquare\Client\Entity;

use Assert\Assertion;

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
        Assertion::nullOrString($phone);
        Assertion::nullOrString($twitterId);
        Assertion::nullOrString($facebookId);

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
