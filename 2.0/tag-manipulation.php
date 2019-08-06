<?php

define( 'ACTIVE_TAG_ID', 1234 ); // todo change tag id
define( 'INACTIVE_TAG_ID', 4321 ); // todo change tag id

add_action( 'groundhogg/contact/tag_applied', function ( \Groundhogg\Contact $contact, int $tag_id ){

    // Ensure that a contact only has 1 of these tags at any given time.
    switch ( $tag_id ){
        case ACTIVE_TAG_ID:
            $contact->remove_tag( INACTIVE_TAG_ID );
            break;
        case INACTIVE_TAG_ID:
            $contact->remove_tag( ACTIVE_TAG_ID );
            break;
    }

} );