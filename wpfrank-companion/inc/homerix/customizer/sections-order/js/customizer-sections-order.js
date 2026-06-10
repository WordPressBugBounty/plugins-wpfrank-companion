/**
 * File customizer_sections_order.js
 *
 * The main file for sections order.
 *
 * @package Homerix
 */

/*global control_settings*/

jQuery( document ).ready(
	function () {
		'use strict';

		// Use a more robust selector for the sections container.
		// We target both the potential panel list and the sub-accordion container.
		var sections_container = '#sub-accordion-panel-homerix_sections, #accordion-panel-homerix_sections > ul';
		var blocked_items      = control_settings.blocked_items || '#accordion-section-homerix_footer, #accordion-section-homerix_header';
		var saved_data_input   = control_settings.saved_data_input || '#customize-control-homerix_sections_order input';

		function init_sortable() {
			var $container = jQuery( sections_container );
			if ( ! $container.length ) {
				return;
			}

			var items_selector = 'li.accordion-section:not(.panel-meta)';
			if (blocked_items && blocked_items.trim() !== '') {
				items_selector = 'li.accordion-section:not(.panel-meta, ' + blocked_items + ')';
			}

			$container.sortable(
				{
					axis: 'y',
					items: items_selector,
					handle: '.accordion-section-title',
					update: function () {
						update_order();
					},
					helper : 'clone',
					placeholder: 'ui-state-highlight'
				}
			);

			// Initial order update.
			update_order();
		}

		function update_order(){
			var $container = jQuery( sections_container );
			if ( ! $container.length ) {
				return;
			}

			var values                = {};
			var update_items_selector = 'li.accordion-section:not(.panel-meta)';
			if (blocked_items && blocked_items.trim() !== '') {
				update_items_selector = 'li.accordion-section:not(.panel-meta, ' + blocked_items + ')';
			}

			var sections = $container.find( update_items_selector );
			sections.each(
				function (index) {
					var id = jQuery( this ).attr( 'id' );
					if (id) {
						var section_id     = id.replace( 'accordion-section-', '' );
						values[section_id] = (index + 2) * 5;
					}
				}
			);

			var data_to_send = JSON.stringify( values );
			var $input       = jQuery( saved_data_input );
			if ($input.length) {
				$input.val( data_to_send );
				$input.trigger( 'change' );
			}
		}

		// Initialize after a short delay to ensure Customizer is ready.
		setTimeout( init_sortable, 500 );
	}
);