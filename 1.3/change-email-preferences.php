<?php
/**
 * Created by PhpStorm.
 * User: adria
 * Date: 2019-07-31
 * Time: 10:41 AM
 */

add_filter( 'groundhogg/form/email_preferences/options', function ( $preferences ){

    unset( $preferences[ 'weekly' ] );
    unset( $preferences[ 'monthly' ] );

    return $preferences;
} );