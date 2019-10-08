<?php

add_action( 'init', 'my_custom_function' );

function my_custom_function()
{
    $result = new \Groundhogg\Contact_Query(['optin_status' => 5]);

    if ( empty( $result ) ) {
        echo 'Sorry no contacts found with this optin status.';
    } else {
        print_r( $result );
    }
}