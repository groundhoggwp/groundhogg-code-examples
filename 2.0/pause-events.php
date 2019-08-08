<?php

define( 'ACTIVE_TAG_ID', 1234 ); // todo change tag id
define( 'INACTIVE_TAG_ID', 4321 ); // todo change tag id

add_action( 'groundhogg/contact/tag_applied', 'pause_events_when_status_changed', 10, 2 );

/**
 * @param $contact \Groundhogg\Contact
 * @param $tag_id int
 */
function pause_events_when_status_changed( $contact, $tag_id )
{
    // Ensure that a contact only has 1 of these tags at any given time.
    switch ( $tag_id ){
        case ACTIVE_TAG_ID:

            \Groundhogg\get_db( 'events' )->mass_update( [
                'status' => 'paused',
            ], [
                'status' => \Groundhogg\Event::WAITING,
                'contact_id' => $contact->get_id(),
                'funnel_id' => [
                    2, 3 //TODO Ids of funnels you want paused
                ]
            ] );

            break;
        case INACTIVE_TAG_ID:

            \Groundhogg\get_db( 'events' )->mass_update( [
                'status' => 'waiting',
            ], [
                'status' => 'paused',
                'contact_id' => $contact->get_id(),
            ] );

            break;
    }
}