<?php
/**
 * Plugin Name: Bigtext for Elementor
 * Description: Bigtext for Elementor makes lines of text fit in width, thanks to Bitext JS (https://github.com/zachleat/BigText). Updated to be in compliance with Elementor 2.X.
 * Plugin URI:  https://arthos.fr
 * Version:     1.1.0
 * Author:      Arthos
 * Author URI:  https://arthos.fr
 * Text Domain: bigtext-for-elementor
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_BIGTEXT__FILE__', __FILE__ );

/**
 * Load Bigtext for Elementor
 *
 * Loads the plugin after Elementor and other plugins are loaded
 *
 * @since 2.0.0
 */
function bigtext_for_elementor_load() {

	// Load localization file
	load_plugin_textdomain( 'bigtext-for-elementor' );

	// Notice if Elementor is not active
	if( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notice', 'bigtext_for_elementor_fail_load' );
		return;
	}

	// Check required version
	$elementor_version_required = '2.0';
	if( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notice', 'bigtext_for_elementor_fail_load_out_of_date' );
		return;
	}

	// Require the main plugin file
	require( __DIR__ . '/plugin.php' );

}

add_action( 'plugins_loaded', 'bigtext_for_elementor_load' );

function bigtext_for_elementor_fail_load_out_of_date() {

	if( ! current_user_can( 'update_plugins' ) ) return;

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrad-plugin_' . $file_path );
	$message = '<p>' . __( 'Bigtext for Elementor is not working because you are using an old version of Elementor.', 'bigtext-for-elementor' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'bigtext-for-elementor' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';

}