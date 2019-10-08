<?php

use Groundhogg\Contact;

################# Switch Tags #################

define( 'ACTIVE_TAG_ID', 1234 ); // todo change tag id
define( 'INACTIVE_TAG_ID', 4321 ); // todo change tag id

add_action( 'groundhogg/contact/tag_applied', 'switch_tags_when_changed', 10, 2 );

/**
 * @param $contact \Groundhogg\Contact
 * @param $tag_id int
 */
function switch_tags_when_changed( $contact, $tag_id )
{
    // Ensure that a contact only has 1 of these tags at any given time.
    switch ( $tag_id ){
        case ACTIVE_TAG_ID:
            $contact->remove_tag( INACTIVE_TAG_ID );
            break;
        case INACTIVE_TAG_ID:
            $contact->remove_tag( ACTIVE_TAG_ID );
            break;
    }
}

################# Pseudo Unmarketable Tag #################

define( 'PSEUDO_UNMARKETABLE_TAG', 1234 );

add_filter( 'groundhogg/contact/is_marketable', 'tag_makes_unmarketable', 10, 2 );

/**
 * @param $is_marketable bool
 * @param $contact Contact
 * @return bool
 */
function tag_makes_unmarketable( $is_marketable, $contact )
{
    // If false contact is already unmarketable
    if ( ! $is_marketable ){
        return $is_marketable;
    }

    // return FALSE if contact has the tag
    return ! $contact->has_tag( PSEUDO_UNMARKETABLE_TAG );
}

add_filter( 'groundhogg/email_is_same_domain', '__return_true' );