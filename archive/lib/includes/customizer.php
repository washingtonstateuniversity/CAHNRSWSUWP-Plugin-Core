<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Manage customizer stuff
* @since 0.0.1
*/
class Customizer {

	public function __construct() {

		add_action( 'customize_register', array( $this, 'add_panel' ) );

	}


	/*
	* @desc Add panel for CAHNRS Core
	* @since 0.0.1
	*
	* @param WP_Customize $wp_customize Instance of customizer
	*/
	public function add_panel( $wp_customize ) {

		$panel_id = 'cahnrs_core_panel';

		$wp_customize->add_panel(
			$panel_id,
			array(
				'title'       => 'CAHNRS Core',
				'description' => 'Core features & functionality',
				'priority'    => 10,
			)
		);

		$this->add_post_type_section( $wp_customize, $panel_id );

	} // End add_panel


	/*
	* @desc Add post types
	* @since 0.0.1
	*
	* @param WP_Customize $wp_customize Instance of customizer
	* @param string $panel_id Panel ID
	*/
	protected function add_post_type_section( $wp_customize, $panel_id ) {

		$post_types = core_get_registered_post_types();

		$section_id = 'cahnrs_core_post_types';

		$wp_customize->add_section(
			$section_id,
			array(
				'title'    => 'Add Post Types',
				'priority' => 10,
				'panel'    => $panel_id,
			)
		);

		foreach ( $post_types as $slug => $label ) {

			$wp_customize->add_setting(
				'core_post_types[' . $slug . ']',
				array(
					'default' => 0,
				)
			);

			// Add control and output for select field
			$wp_customize->add_control(
				'core_post_types_' . $slug . '_control',
				array(
					'label'      => 'Add ' . $label . ' Post Type',
					'section'    => $section_id,
					'settings'   => 'core_post_types[' . $slug . ']',
					'type'       => 'checkbox',
					'std'        => '1',
				)
			);

		} // End foreach

	} // End add_post_type_section

}

$core_customizer = new Customizer();
