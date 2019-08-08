<?php
/**
 * Created by PhpStorm.
 * User: adria
 * Date: 2019-08-08
 * Time: 10:41 AM
 */

/**
 * Retrieve a bunch of product info from an order!
 *
 * @param $order int|\WC_Order
 * @return array
 */
function get_product_info_from_order( $order )
{
    if ( is_int( $order ) ){
        $order = wc_get_order( $order );
    }

    $order_items = $order->get_items();

    /**
     * Get all the IDS, Tags, And Cats of the products which were purchased in the order.
     */
    $order_items_ids = [];
    $order_items_cats = [];
    $order_items_tags = [];

    /**
     * @var $item \WC_Order_Item_Product
     */
    foreach ( $order_items as $item ){

        $product_id = $item->get_product_id();
        $order_items_ids[] = $product_id;

        $product_cats = get_the_terms( $product_id, 'product_cat' );
        if ( $product_cats ){
            $product_cats = wp_parse_id_list( wp_list_pluck( $product_cats, 'term_id' ) );
            $order_items_cats = array_merge( $order_items_cats, $product_cats );
        }

        $product_tags = get_the_terms( $product_id, 'product_tag' );
        if ( $product_tags ){
            $product_tags = wp_parse_id_list( wp_list_pluck( $product_tags, 'term_id' ) );
            $order_items_tags = array_merge( $order_items_tags, $product_tags );
        }

    }

    return [
        'ids'  => $order_items_ids,
        'cats' => $order_items_cats,
        'tags' => $order_items_tags
    ];
}

/**
 * Add tags to a contact after a successful order completion.
 *
 * @param $order_id
 * @param $posted_data
 * @param $order \WC_Order
 */
function add_tags_to_customer( $order_id, $posted_data, $order )
{

    $product_info = get_product_info_from_order( $order );
    $contact = wpgh_get_contact( $order->get_billing_email() );

    if ( ! $contact ){
        return;
    }

    $tags = [];

    foreach ( $product_info[ 'ids' ] as $id ) {

        $product = new WC_Product( $id );

        if( $product->get_sku() ){
            // Generate a tag based on the SKU of the product
            $tags[] = sprintf( 'Purchased — %s', $product->get_sku() );
            // Generate a tag based on the Name of the product
            $tags[] = sprintf( 'Purchased — %s', $product->get_title() );
        }
    }

    $contact->apply_tag( $tags );
}

add_action( 'woocommerce_checkout_order_processed', 'add_tags_to_customer', 10, 3 );