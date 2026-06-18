<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
* Plugin Name:  WPFrank Companion
* Plugin URI:   https://wordpress.org/plugins/wpfrank-companion
* Description:  WPFrank Companion plugin provides themes extra settings for front page.
* Version:      0.3.10
* Author:       WP Frank
* Author URI:   https://wpfrank.com/
* Tested up to: 7.0
* Requires:     4.0 or higher
* License:      GPLv3 or later
* License URI:  http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 4.0
* Text Domain:  wpfrank-companion
* Domain Path:  /languages
*/

/*
WPFrank Companion is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WPFrank Companion is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WPFrank Companion. If not, see http://www.gnu.org/licenses/gpl-3.0.html.
*/

define( 'wpfrank_companion_plugin_url', plugin_dir_url( __FILE__ ) );
define( 'wpfrank_companion_plugin_dir', plugin_dir_path( __FILE__ ) );

if ( ! function_exists( 'wpfrank_companion_init' ) ) {
	function wpfrank_companion_init() {
		$activate_theme = strtolower( get_template() );

		if ( in_array( $activate_theme, array( 'businessexpo', 'architect-designs', 'medical-health', 'building-construction' ) ) ) {
			require 'inc/businessexpo/businessexpo.php';
		}

		if ( in_array( $activate_theme, array( 'cryptoairdrop', 'cryptocompare', 'cryptomining', 'cryptotoken', 'memetoken' ) ) ) {
			require 'inc/cryptoairdrop/cryptoairdrop.php';
		}

		if ( 'homerix' === $activate_theme ) {
			require wpfrank_companion_plugin_dir . 'inc/homerix/homerix.php';
		}

	}
	add_action( 'init', 'wpfrank_companion_init', 9 );
}

// on plugin activation
function wpfrank_companion_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/wpfrank-companion-activator.php';
	wpfrank_companion_plugin_activator::activate();
}
register_activation_hook( __FILE__, 'wpfrank_companion_activate' );
