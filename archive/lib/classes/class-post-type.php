<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

/*
* @desc Abstract class used for new post types
* @since 0.0.1
*/
class Post_Type {

	// @var string $slug Post type slug
	protected $slug = '';

	// @var array $labe's Labels to use when registering the post type
	protected $labels = array();

	// @var array $args Args to use when registering the post type
	protected $register_args = array();

	// @var bool $register Registers post type if true
	protected $register = true;

	// @var bool $add_to_customizer Adds post type to customizer as a checkbox (must be checked to register post type)
	protected $add_to_customizer = true;

	// @var array $post_meta_defaults Default post meta settings
	protected $post_meta_defaults = array();

	// @var bool $save_post Save post action if is set to true
	protected $save_post = false;


	public function __construct() {

		$this->init_post_type();

	} // End __construct


	/*
	* @desc Do init stuff related to the post type
	* @since 0.0.1
	*/
	protected function init_post_type() {

		if ( method_exists( $this, 'set_default_meta' ) ) {

			$this->set_default_meta();

		} // End if

		if ( method_exists( $this, 'set_labels' ) ) {

			$this->set_labels();

		} // End if

		if ( method_exists( $this, 'set_register_args' ) ) {

			$this->set_register_args();

		} // End if

		if ( $this->register ) {

			add_action( 'init', array( $this, 'register_post_type' ), 10 );

		} // End if

		if ( $this->add_to_customizer ) {

			core_register_post_types( $this->slug, $this->labels['name'] );

		} // End if

		if ( method_exists( $this, 'the_edit_form' ) ) {

			add_action( 'edit_form_after_title', array( $this, 'edit_form' ) );

		} // End if

		if ( method_exists( $this, 'the_content_filter' ) ) {

			add_filter( 'the_content', array( $this, 'do_filter_content' ), 10 );

		} // End if

		if ( $this->save_post ) {

			add_action( 'save_post_' . $this->slug, array( $this, 'save_post' ), 10, 3 );

		} // End if

	} // End init_post_type


	/*
	* @desc Set variables and call edit form method
	* @since 0.0.1
	*
	* @param WP_Post WP_Post object
	*/
	public function edit_form( $post ) {

		if ( $this->slug === $post->post_type ) {

			wp_nonce_field( 'cc_save_post_' . $post->ID, 'cc_nonce' );

			$post_meta = $this->get_post_meta_array( $post->ID );

			$this->the_edit_form( $post, $post_meta );

		} // End if

	} // End edit_form


	/*
	* @desc Get array of post meta values from $post_meta_defaults
	* @since 0.0.1
	*
	* @param int $post_id Post ID for the given post
	*
	* @return array Array of Key => Value pairs
	*/
	protected function get_post_meta_array( $post_id ) {

		$post_meta_array = array();

		$defaults = $this->post_meta_defaults;

		if ( ! empty( $defaults ) ) {

			foreach ( $defaults as $key => $default ) {

				$post_meta = get_post_meta( $post_id, $key, true );

				if ( '' !== $post_meta ) {

					$post_meta_array[ $key ] = $post_meta;

				} else {

					$post_meta_array[ $key ] = $default;

				} // End if
			} // End foreach
		} // End if

		return $post_meta_array;

	} // End get_post_meta_array


	/*
	* @desc Register post type
	* @sicne 0.0.1
	*/
	public function register_post_type() {

		$slug = $this->slug;

		$labels = $this->labels;

		$args = $this->register_args;

		if ( $this->check_do_register() ) {

			$args['labels'] = $labels;

			register_post_type( $slug, $args );

		} // End if

	} // End register_post_type


	public function do_filter_content( $content ) {

		if ( is_singular( $this->slug ) ) {

			$content = $this->the_content_filter( $content );

		} // End if

		remove_filter( 'the_content', array( $this, 'do_filter_content' ), 10 );

		return $content;

	} // End filter_content


	/*
	* @desc Check can register
	* @since 0.0.1
	*
	* @return bool True is should register
	*/
	protected function check_do_register() {

		$slug = $this->slug;

		$labels = $this->labels;

		$args = $this->register_args;

		if ( empty( $slug ) || empty( $labels ) || empty( $args ) ) {

			return false;

		} // End if

		if ( $this->add_to_customizer ) {

			$post_types = \get_theme_mod( 'core_post_types', array() );

			if ( empty( $post_types[ $slug ] ) ) {

				return false;

			} // End if
		} // End if

		return true;

	} // End check_do_register


	/**
	 * @desc Santitize post meta from default atts. For more complex sanitation redeclare this in child class
	 * @since 0.0.3
	 *
	 * @return array Sanitized values
	 */
	protected function sanitize_editor_values() {

		$clean_meta = array();

		$default_meta = $this->post_meta_defaults;

		foreach ( $default_meta as $key => $default_value ) {

			// @codingStandardsIgnoreStart // Nonce already checked
			if ( isset( $_POST[ $key ] ) ) {

				// @codingStandardsIgnoreEnd
				$clean_meta[ $key ] = sanitize_text_field( $_POST[ $key ] );

			} // End if
		} // End foreach

		return $clean_meta;

	} // End sanitize_editor_values


	public function save_post( $post_id, $post, $update ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return;

		} // End if

		if ( ! $update ) {

			return;

		} // End if

		// Check the nonce
		if ( wp_verify_nonce( $_REQUEST['cc_nonce'], 'cc_save_post_' . $post_id ) ) {

			if ( 'page' === $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {

					return;

				} // End if
			} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {

					return;

				} // End if
			} // End if

			// Sanitized form values
			$clean_values = $this->sanitize_editor_values();

			// check to make sure we have something to save
			if ( ! empty( $clean_values ) ) {

				//var_dump( $clean_values ); die();

				// Loop through key value pairs
				foreach ( $clean_values as $key => $value ) {

					// Update post meta
					update_post_meta( $post_id, $key, $value );

				} // End foreach
			} // End if
		} else {

			return;

		}// End if

	} // End save_post

} // End Post_Type
