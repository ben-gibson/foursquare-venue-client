<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Entity\Contact as ContactEntity;

/**
 * Creates contact information from a description.
 */
class ContactFactory extends Factory
{
    /**
     * Create contact information from a description.
     *
     * @param \stdClass $description The description.
     *
     * @return ContactEntity
     */
    public function create(\stdClass $description)
    {
        $this->parseOptionalParameter($description, 'phone');
        $this->parseOptionalParameter($description, 'twitter');
        $this->parseOptionalParameter($description, 'facebook');

        return new ContactEntity($description->phone, $description->twitter, $description->facebook);
    }
}
