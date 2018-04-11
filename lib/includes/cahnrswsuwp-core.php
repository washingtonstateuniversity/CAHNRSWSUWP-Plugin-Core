<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Start the plugin stuff, yeah
* @since 0.0.1
*/
class CAHNRSWSUWP_Core {


	public function __construct() {

		$this->init_plugin();

	} // End __construct


	protected function init_plugin() {

		// Set plugin path constant
		\define( 'CAHNRSWSUWPCOREPATH', dirname( dirname( __DIR__ ) ) );

		// Set plugin url cinstant
		\define( 'CAHNRSWSUWPCOREURL', \plugin_dir_url( dirname( dirname( __FILE__ ) ) ) );

		// Set plugin version
		\define( 'CAHNRSWSUWPCOREVERSION', '0.0.1' );

		// Include plugin functions
		require CAHNRSWSUWPCOREPATH . '/lib/functions/public.php';

		$this->add_post_types();

		$this->add_shortcodes();

		$this->add_customizer();

		$this->add_utilities();

	} // End init_plugin


	/*
	* @desc Add post types to WordPress
	* @since 0.0.1
	*/
	protected function add_post_types() {

		// Abstract class used by post types
		require_once core_get_plugin_path( '/lib/classes/class-post-type.php' );

		// FAQ post type
		require_once core_get_plugin_path( '/lib/post-types/faq/faq-post-type.php' );

		// RFP post type
		require_once core_get_plugin_path( '/lib/post-types/rfp/rfp-post-type.php' );

		// Research Review post type
		require_once core_get_plugin_path( '/lib/post-types/research-review/research-review-post-type.php' );

	} // end add_post_types


	/*
	* @desc Add customizer to WordPress
	* @since 0.0.1
	*/
	protected function add_shortcodes() {

		// Adds customizer settings
		require_once core_get_plugin_path( '/lib/shortcodes/rfp/rfp-shortcode.php' );

	} // end add_post_types


	/*
	* @desc Add customizer to WordPress
	* @since 0.0.1
	*/
	protected function add_customizer() {

		// Adds customizer settings
		require_once core_get_plugin_path( '/lib/includes/customizer.php' );

	} // end add_post_types


	/*
	* @desc Add scritps to WP
	* @since 0.0.1
	*/
	protected function add_utilities() {

		// Adds scripts
		require_once core_get_plugin_path( '/lib/utilities/scripts/script-utility.php' );

		// Add Analytics
		require_once core_get_plugin_path( '/lib/utilities/analytics/analytics-utility.php' );

	} // End add_utilites


} // End CAHNRSWSUWP_Core

$cahnrswsuwp_core = new CAHNRSWSUWP_Core();
