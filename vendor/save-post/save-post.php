<?php

class Save_Post_Data {

	protected $settings;
	protected $post_types;
	protected $nonce_name;
	protected $nonce_action;


	public function __construct( $settings, $post_types = array(), $nonce_name, $nonce_action ) {

		$this->settings = $this->fill_settings( $settings );
		$this->post_types = ( ! is_array( $post_types ) ) ? array( $post_types ) : $post_types;
		$this->nonce_name = $nonce_name;
		$this->nonce_action = $nonce_action;

		add_action( 'save_post', array( $this, 'save_post' ), 10, 3 );

	} // End __construct


	protected function fill_settings( $settings ) {

		$setting_defaults = array(
			'sanitize_type' => 'text',
			'default'       => false,
			'check_isset'   => true,
			'ignore_empty'  => false,
		);

		foreach ( $settings as $key => $data ) {

			$settings[ $key ] = array_merge( $setting_defaults, $data );

		} // End foreach

		return $settings;

	} // End fill_settings


	public function save_post( $post_id, $post, $update ) {

		if ( in_array( $post->post_type, $this->post_types, true ) ) {

			if ( ! $update ) {

				return;

			} // End if

			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

				return false;

			} // end if

			if ( ! isset( $_POST[ $this->nonce_name ] ) || ! wp_verify_nonce( $_POST[ $this->nonce_name ], $this->nonce_action ) ) {

				return false;

			}

			// Check the user's permissions.
			if ( 'page' === $post->post_type ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {

					return false;

				} // end if
			} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {

					return false;

				} // end if
			} // end if

			foreach ( $this->settings as $key => $data ) {

				if ( isset( $_REQUEST[ $key ] ) ) {

					$value = $this->sanitize_request_value( $key, $type );

					if ( ! $data['ignore_empty'] || ! empty( $value ) ) {

						update_post_meta( $post_id, $key, $value );

					} // End if
				} // End if
			} // End foreach
		} // End if

	} // End save_post


	protected function sanitize_request_value( $key, $type ) {

		switch ( $type ) {

			default:
				$value = sanitize_text_field( $_REQUEST[ $key ] );
				break;

		} // End switch

		return $value;

	} // End sanitize_request_value


}
