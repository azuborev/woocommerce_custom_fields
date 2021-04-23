/**
 * Scripts for custom fields.
 *
 */

'use strict';

//on add-user page hide field 'medical_id' if you are not customer
jQuery(document).ready(function($) {
    const med_table = $('.medical-table');
    if($('#role').val() !== 'customer'){
        med_table.hide();
    }
    $(document).on('change', '#role', function () {
        if($('#role').val() !== 'customer'){
            med_table.hide();
        } else {
            med_table.show();
        }
    });
});
