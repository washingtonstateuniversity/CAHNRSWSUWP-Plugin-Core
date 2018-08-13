<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if


/**
 * Uses theme filters to add sub layouts to the page with sidebars.
 *
 * @version 0.0.1
 * @author CAHNRS Communications, Danial Bleile
 */
class Sub_Layouts_Module extends Core_Module {

	public $slug = 'sub_layouts';

	public $register_args = array(
		'label'          => 'Content Layout',
		'helper_text'    => 'Where supported by Theme.',
		'settings_page'  => array(
			'page_title'     => 'Core Sub Layout Settings',
			'menu_title'     => 'Sub Layouts',
			'capabilities'   => 'manage_options',
			'page_slug'      => 'core_sublayouts',
			'callback'       => 'render_options_page',
		),
	);

	public $settings = array(
		'core_sublayout_format' => array(
			'type'              => 'string',
			'description'       => 'Base layout to use on theme',
			'show_in_rest'      => false,
			'default'           => '',
		),
		'core_sublayout_format_front_page' => array(
			'type'              => 'string',
			'description'       => 'Base layout to use on theme',
			'show_in_rest'      => false,
			'default'           => '',
		),
		'core_sublayout_format_post' => array(
			'type'              => 'string',
			'description'       => 'Base layout to use on theme',
			'show_in_rest'      => false,
			'default'           => '',
		),
		'core_sublayout_format_page' => array(
			'type'              => 'string',
			'description'       => 'Base layout to use on theme',
			'show_in_rest'      => false,
			'default'           => '',
		),
	);


	public $sub_layouts = array(
		'default'     => 'Default',
		'left-column' => 'Left Column',
		'right-column' => 'Right Column',
	);


	/**
	 * Init the module here
	 */
	public function init() {

		add_filter( 'theme_content_html', array( $this, 'add_sublayout' ) );

	} // End init


	public function add_sublayout( $html ) {

		$layout = $this->get_layout_option();

		switch ( $layout ) {

			case 'left-column':
				ob_start();
				include __DIR__ . '/displays/left-column.php';
				$html = ob_get_clean();
				break;

			case 'right-column':
				ob_start();
				include __DIR__ . '/displays/right-column.php';
				$html = ob_get_clean();
				break;

		} // End switch

		return $html;

	} // End add_sublayout


	protected function get_layout_option() {

		$layout_option = get_option( 'core_sublayout_format' );

		if ( is_front_page() ) {

			$layout_option = get_option( 'core_sublayout_format_front_page' );

		} elseif ( is_singular() ) {

			$post_type = get_post_type();

			switch ( $post_type ) {

				case 'page':
					$layout_option = get_option( 'core_sublayout_format_page' );
					break;
				case 'post':
					$layout_option = get_option( 'core_sublayout_format_post' );
					break;
			}
		} // End if

		return $layout_option;

	} // End get_layout_option


	public function add_admin_settings() {

		$settings_adapter = get_settings_api_adapter();

		$page_slug = $this->get_settings_page_slug();

		$section = 'core_sublayouts';

		// Register settings

		$settings_adapter->register_settings(
			$page_slug,
			$this->settings
		);

		$settings_adapter->add_section(
			$section,
			'Core Sub Layout Options',
			$page_slug,
			'<p>what\'s the point of this?</p>'
		);

		$settings_adapter->add_select_field(
			'core_sublayout_format',
			'Base Layout Format',
			$page_slug,
			$section,
			$this->sub_layouts,
			get_option( 'core_sublayout_format' )
		);

		$settings_adapter->add_select_field(
			'core_sublayout_format_front_page',
			'Front Page Layout Format',
			$page_slug,
			$section,
			$this->sub_layouts,
			get_option( 'core_sublayout_format_front_page' )
		);

		$settings_adapter->add_select_field(
			'core_sublayout_format_page',
			'Page Layout Format',
			$page_slug,
			$section,
			$this->sub_layouts,
			get_option( 'core_sublayout_format_page' )
		);

		$settings_adapter->add_select_field(
			'core_sublayout_format_post',
			'Post Layout Format',
			$page_slug,
			$section,
			$this->sub_layouts,
			get_option( 'core_sublayout_format_post' )
		);

	} // End add_settings

} // End Sub_Layouts

$ccore_sub_layouts_module = new Sub_Layouts_Module();
