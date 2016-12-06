<?php

namespace Gibbo\Foursquare\Client\Factory;

use Gibbo\Foursquare\Client\Entity\Contact as ContactEntity;

/**
 * Creates contact information from a description.
 */
class ContactFactory
{
    /**
     * Create contact information from a description.
     *
     * @param Description $description The contact description.
     *
     * @return ContactEntity
     */
    public function create(Description $description)
    {
        return new ContactEntity(
            $description->getOptionalProperty('phone'),
            $description->getOptionalProperty('twitter'),
            $description->getOptionalProperty('facebook')
        );
    }
}
