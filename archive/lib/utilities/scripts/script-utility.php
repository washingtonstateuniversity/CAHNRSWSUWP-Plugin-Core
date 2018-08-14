<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Adds script utility
* @since 0.0.1
*/
class Script_Utility {


	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_public_scripts' ) );

	} // End __construct


	public function add_public_scripts() {

		//wp_enqueue_style( 'cc-public-style', core_get_plugin_url( '/lib/css/public.css' ), array(), core_get_plugin_version() );
		wp_enqueue_style( 'cc-public-style', core_get_plugin_url( '/lib/css/public.min.css' ), array(), core_get_plugin_version() );

	} // End add_public_scripts


} // End Script_Utility

$script_utility = new Script_Utility();
