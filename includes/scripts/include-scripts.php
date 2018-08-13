<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if


class Scripts {


	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_public_scripts' ) );

	}


	public function add_public_scripts() {

		// TODO make version pull from plugin version
		wp_enqueue_style( 'core-css', ccore_get_plugin_url() . '/css/core-public.css', array(), '0.0.1' );

	} // End add_public_scripts


} // End Modules

$ccore_scripts = new Scripts();
