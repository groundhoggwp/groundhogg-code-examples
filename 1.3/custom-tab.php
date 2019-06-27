<?php

class My_Custom_Tab
{

    /**
     * My_Custom_Tab constructor.
     */
    function __construct()
    {

        add_filter( 'wpgh_contact_record_tabs', [ $this, 'register_tab' ] );
        add_action( 'wpgh_contact_record_tab_my_custom_tab', [ $this, 'render' ] );
        add_action( 'wpgh_admin_update_contact_after', [ $this, 'save' ] );

    }

    /**
     *
     * Register you tab using a unique ID and a name.
     *
     * @param $tabs
     * @return mixed
     */
    public function register_tab( $tabs )
    {
        // Basic
        $tabs[ 'my_custom_tab' ] = __( 'My Custom Tab' );

        // Reorder tabs
        $i = 0;
        $new_tabs = [];
        foreach ( $tabs as $tab_id => $name ){

            // Insert as 3rd tab
            if ( $i === 3 ){
                $new_tabs[ 'my_custom_tab' ] = __( 'My Custom Tab' );
            }

            $new_tabs[ $tab_id ] = $name;

            $i++;
        }

        $tabs = $new_tabs;
        return $tabs;
    }

    /**
     * Render the output of the tab
     *
     * @param $contact WPGH_Contact
     */
    public function render( $contact )
    {
        ?>
        <h3>My Custom Tab</h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th>custom Field</th>
                <td><input type="text" name="my_custom_field" value="<?php esc_attr_e( $contact->get_meta( 'my_custom_field' ) ); ?>"></td>
            </tr>
            </tbody>
        </table>
        <?php
    }

    /**
     * Save the custom fields.
     *
     * @param $contact_id int
     */
    public function save( $contact_id )
    {

        if ( isset( $_POST[ 'my_custom_field' ] ) ){

            $contact = wpgh_get_contact( $contact_id );

            $my_custom_field_value = sanitize_text_field( $_POST[ 'my_custom_field' ] );

            if ( $my_custom_field_value ){
                $contact->update_meta( 'my_custom_field', $my_custom_field_value );
            }
        }

    }

}

add_action( 'admin_init', function (){
    $my_new_tab = new My_Custom_Tab();
} );
