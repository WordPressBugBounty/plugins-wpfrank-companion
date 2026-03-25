/*global control_settings*/

/**
 * File customizer_sections_order.js
 *
 * The main file for sections order.
 */

jQuery(document).ready(function(){
    'use strict';

    var sections_container = control_settings.sections_container;
    var blocked_items = control_settings.blocked_items;
    var saved_data_input = control_settings.saved_data_input;
    update_order(); //Do this at the beginning to display sections in customizer that were just added

    var items_selector = '> li:not(.panel-meta)';
    if (blocked_items && blocked_items.trim() !== '') {
        items_selector = '> li:not(.panel-meta, '+ blocked_items +')';
    }

    jQuery( sections_container ).sortable({
        axis: 'y',
        items: items_selector,
        handle: '> h3',
        update: function(){
            update_order();
        },
        helper : 'clone',
        placeholder: 'ui-state-highlight'
    });

    function update_order(){
        var values = {};
        var update_items_selector = '> li:not(.panel-meta)';
        if (blocked_items && blocked_items.trim() !== '') {
            update_items_selector = '> li:not(.panel-meta, '+ blocked_items +')';
        }

        var idsInOrder = jQuery( sections_container ).sortable({
            axis: 'y',
            items: update_items_selector,
            handle: '> h3',
            helper : 'clone',
            placeholder: 'ui-state-highlight'
        });
        var sections = idsInOrder.sortable('toArray');
        for(var i = 0; i < sections.length; i++){
            var section_id =  sections[i].replace('accordion-section-','');
            values[section_id] = (i+2)*5;
        }
        var data_to_send = JSON.stringify(values);
        jQuery(saved_data_input).val(data_to_send);
        jQuery(saved_data_input).trigger('change');
    }
});