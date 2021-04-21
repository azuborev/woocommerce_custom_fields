<?php
/**
 * File with functions for filter ACF fields
 */

//Add read-only attribute for text fields
function hds_add_readonly_to_text_field($field) {
    acf_render_field_setting( $field, array(
        'label'      => __( 'Только для чтения','acf' ),
        'instructions'  => '',
        'type'      => 'true_false',
        'name'      => 'readonly',
        'ui'			=> 1,
        'class'	  => 'acf-field-object-true-false-ui'
    ));
}
add_action('acf/render_field_settings/type=text', 'hds_add_readonly_to_text_field');
