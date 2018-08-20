<?php

class Settings_API_Adapter {


	public function __construct() {

		include_once 'classes/class-settings-api-section.php';

		include_once 'classes/class-settings-api-text-field.php';

		include_once 'classes/class-settings-api-select-field.php';

	}

	public function register_setting( $group, $id, $args ) {

		register_setting(
			$group,
			$id,
			$args
		);

	} // End add_section

	public function register_settings( $group, $settings ) {

		foreach ( $settings as $key => $setting_args ) {

			$this->register_setting( $group, $key, $setting_args );

		} // End foreach

	} // End register_settings


	public function add_section( $id, $title, $page, $html_content = '', $callback = false, $args = array() ) {

		$section = new Settings_API_Section(
			$id,
			$title,
			$page,
			$html_content,
			$callback,
			$args
		);

	} // End add_section


	public function add_text_field( $id, $label, $page, $section, $args = array(), $callback = false ) {

		$field = new Settings_API_Text_Field(
			$id,
			$label,
			$page,
			$section,
			$args,
			$callback
		);

	}

	public function add_select_field( $id, $label, $page, $section, $options, $current_value, $args = array(), $callback = false ) {

		$field = new Settings_API_Select_Field(
			$id,
			$label,
			$page,
			$section,
			$options,
			$current_value,
			$args,
			$callback
		);

	}
}