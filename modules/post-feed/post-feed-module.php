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
class Post_Feed_Module extends Core_Module {

	public $slug = 'post_feed';

	public $register_args = array(
		'label'          => 'Post Feed',
		'helper_text'    => 'Shortcode for displaying content.',
	);

	public $default_atts = array(
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'protocol'         => 'http',
		'host'             => '',
		'rest_path'        => '/wp-json/wp/v2/',
		'per_page'         => 10,
		'tags'             => '',
		'categories'       => '',
		'order_by'         => 'publish',
		'order'            => 'DECS',
		'offset'           => 0,
		'page'             => 1,
		'filters'          => '',
		'allow_pagination' => 1,
		'show_search'      => '',
		'display'          => 'promo',
		'excerpt_length'   => 25,
		'show_author'      => '',
		'show_date'        => '',
	);


	/**
	 * Init the module here
	 */
	public function init() {

		add_shortcode( 'post_feed', array( $this, 'render_shortcode' ) );

	} // End init


	public function render_shortcode( $atts, $content = '', $tag ) {

		$html = '';

		$atts = shortcode_atts( $this->default_atts, $atts, $tag );

		return $html;

	} // End render_shortcode


} // End Sub_Layouts

$ccore_post_feed_module = new Post_Feed_Module();
