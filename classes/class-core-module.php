<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

class Core_Module {

	public $slug = false;

	public $register_args = array(
		'icon'           => '',
		'label'          => 'Why you no add Label?',
		'helper_text'    => '',
	);

	public $module_settings = array(
		'init_priority' => 11,
	);

	public $settings = array();


	public function __construct() {

		add_action( 'init', array( $this, 'register_module' ) );

		if ( ! empty( $this->register_args['settings_page'] ) ) {

			add_action( 'admin_init', array( $this, 'add_admin_settings' ) );

		} // End if

		add_action( 'init', array( $this, 'init_module' ), $this->module_settings['init_priority'] );

	} // End construct


	public function add_admin_settings() {

		return false;

	} // End add_settings


	/**
	 * Register the module so it shows up on the Core settings page
	 */
	public function register_module() {

		$register_args = $this->register_args;

		if ( ! empty( $register_args['settings_page'] ) ) {

			$register_args['settings_page']['callback'] = array( $this, 'render_options_page' );

		} // End if

		ccore_register_module( $this->slug, $register_args );

	} // end register_module


	/**
	 * Check if module is active, if is active do module stuff.
	 */
	public function init_module() {

		if ( $this->slug && ccore_is_active_module( $this->slug ) ) {

			$this->init();

		} // End if

	} // end init_module


	/**
	 * This should be overwritten in child module class
	 */
	public function init() {

		return false;

	} // End init


	public function render_options_page() {

		if ( method_exists( $this, 'render_sub_options_page' ) ) {

			$this->render_sub_options_page();

		} else {

			echo '<marquee><h1 style="padding-top: 60px;">You need to add the render_sub_options_page to your module if you want this to work :)</marquee><p>And yes this is a marquee because you deserve it.</p>';

		} // End if

	} // End render_options_page


	public function get_settings_page_slug() {

		return $this->register_args['settings_page']['page_slug'];

	}


	public function render_sub_options_page() {

		$page_slug = $this->get_settings_page_slug();

		include dirname( __DIR__ ) . '/includes/modules/displays/module-settings.php';

	}


} // End Core_Module
