<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Adds RFP post type
* @since 0.0.1
*/
class RFP_Post_Type extends Post_Type {

	// @var string $slug Post type slug
	protected $slug = 'rfp';

	// @var array $post_meta_defaults Default post meta settings
	protected $post_meta_defaults = array(
		'_post_date'   => '',
		'_redirect_to' => '',
	);

	// @var bool $save_post Save post action if is set to true
	protected $save_post = true;

	/*
	* @desc Set labels use to register post type
	* @since 0.0.1
	*/
	protected function set_labels() {

		$labels = array(
			'name'               => _x( 'RFPs', 'post type general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'      => _x( 'RFP', 'post type singular name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'          => _x( 'RFPs', 'admin menu', 'cahnrswsuwp-plugin-core' ),
			'name_admin_bar'     => _x( 'RFP', 'add new on admin bar', 'cahnrswsuwp-plugin-core' ),
			'add_new'            => _x( 'Add New', 'RFP', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'       => __( 'Add New RFP', 'cahnrswsuwp-plugin-core' ),
			'new_item'           => __( 'New RFP', 'cahnrswsuwp-plugin-core' ),
			'edit_item'          => __( 'Edit RFP', 'cahnrswsuwp-plugin-core' ),
			'view_item'          => __( 'View RFP', 'cahnrswsuwp-plugin-core' ),
			'all_items'          => __( 'All RFPs', 'cahnrswsuwp-plugin-core' ),
			'search_items'       => __( 'Search RFPs', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon'  => __( 'Parent RFPs:', 'cahnrswsuwp-plugin-core' ),
			'not_found'          => __( 'No RFPs found.', 'cahnrswsuwp-plugin-core' ),
			'not_found_in_trash' => __( 'No RFPs found in Trash.', 'cahnrswsuwp-plugin-core' ),
		);

		$this->labels = $labels;

	}


	/*
	* @desc Set labels use to register post type
	* @since 0.0.1
	*/
	protected function set_register_args() {

		$register_args = array(
			'description'        => 'Content for RFPs.',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'rfp' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array( 'post_tag', 'categories' ),
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		);

		$this->register_args = $register_args;

	}


	/*
	* @desc Add edit form after title
	* @since 0.0.1
	*
	* @param WP_Post $post Instance of WP_Post object
	* @param array $post_meta Array of key => values from $post_meta_defaults with meta values or default if empty
	*/
	protected function the_edit_form( $post, $post_meta ) {

		$date = $post_meta['_post_date'];

		$redirect = $post_meta['_redirect_to'];

		include_once __DIR__ . '/editor.php';

	} // end the_edit_form


	/*
	* @desc Sanitize submitted form fields
	* @since 0.0.1
	*
	* @return array Clean form fields array
	*/
	protected function sanitize_editor_values() {

		$clean = array();

		$defaults = $this->post_meta_defaults;

		foreach ( $defaults as $key => $value ) {

			// @codingStandardsIgnoreStart Nonce already verified before this is called
			if ( ! empty( $_POST[ $key ] ) ) {

				$clean[ $key ] = sanitize_text_field( $_POST[ $key ] );

			} // End if @codingStandardsIgnoreEnd
		} // End foreach

		return $clean;

	} // End sanitize_editor_values


} // End RFP_Post_Type

$faq_post_type = new RFP_Post_Type();
