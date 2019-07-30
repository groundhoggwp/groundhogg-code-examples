<?php

define( 'ACTIVE_TAG_ID', 1234 );
define( 'INACTIVE_TAG_ID', 4321 );

add_action( 'wpgh_tag_applied', function ( WPGH_Contact $contact, int $tag_id ){

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