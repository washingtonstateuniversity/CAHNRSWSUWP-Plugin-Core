<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Adds FAQ post type
* @since 0.0.1
*/
class FAQ_Post_Type extends Post_Type {

	// @var string $slug Post type slug
	protected $slug = 'faq';

	/*
	* @desc Set labels use to register post type
	* @since 0.0.1
	*/
	protected function set_labels() {

		$labels = array(
			'name'               => _x( 'FAQs', 'post type general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'      => _x( 'FAQ', 'post type singular name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'          => _x( 'FAQs', 'admin menu', 'cahnrswsuwp-plugin-core' ),
			'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar', 'cahnrswsuwp-plugin-core' ),
			'add_new'            => _x( 'Add New', 'FAQ', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'       => __( 'Add New FAQ', 'cahnrswsuwp-plugin-core' ),
			'new_item'           => __( 'New FAQ', 'cahnrswsuwp-plugin-core' ),
			'edit_item'          => __( 'Edit FAQ', 'cahnrswsuwp-plugin-core' ),
			'view_item'          => __( 'View FAQ', 'cahnrswsuwp-plugin-core' ),
			'all_items'          => __( 'All FAQs', 'cahnrswsuwp-plugin-core' ),
			'search_items'       => __( 'Search FAQs', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon'  => __( 'Parent FAQs:', 'cahnrswsuwp-plugin-core' ),
			'not_found'          => __( 'No FAQs found.', 'cahnrswsuwp-plugin-core' ),
			'not_found_in_trash' => __( 'No FAQs found in Trash.', 'cahnrswsuwp-plugin-core' ),
		);

		$this->labels = $labels;

	} // End set_labels


	/*
	* @desc Set labels use to register post type
	* @since 0.0.1
	*/
	protected function set_register_args() {

		$register_args = array(
			'description'        => 'Content for FAQs.',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'faq' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array( 'post_tag', 'categories' ),
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		);

		$this->register_args = $register_args;

	} // End set_register_args


} // End FAQ_Post_Type

$faq_post_type = new FAQ_Post_Type();
