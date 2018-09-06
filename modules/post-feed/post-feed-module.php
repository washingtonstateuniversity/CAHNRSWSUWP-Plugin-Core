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
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'protocol'            => 'http',
		'host'                => '',
		'rest_path'           => '/wp-json/wp/v2/',
		'count'               => 10,
		'tags'                => '',
		'categories'          => '',
		'order_by'            => 'date',
		'order'               => 'DESC',
		'offset'              => 0,
		'page'                => 1,
		'filters'             => '',
		'allow_pagination'    => 1,
		'show_search'         => '',
		'display'             => 'promo',
		'excerpt_length'      => 25,
		'show_author'         => '',
		'show_date'           => '',
		'tax_query_relation'  => 'AND',
	);


	/**
	 * Init the module here
	 */
	public function init() {

		add_shortcode( 'post_feed', array( $this, 'render_shortcode' ) );

	} // End init


	public function render_shortcode( $atts, $content, $tag ) {

		$html = '';

		$atts = shortcode_atts( $this->default_atts, $atts, $tag );

		if ( ! empty( $atts['host'] ) ) {

			// This is a REST request

		} else {

			// This is a local query
			$items = $this->get_local_items( $atts );

		} // end if

		return $html;

	} // End render_shortcode


	private function get_local_items( $atts ) {

	} // End get_local_items


	private function get_local_query_args( $atts ) {

		$query_args = array(
			'post_type'      => $atts['post_type'],
			'post_status'    => $atts['post_status'],
			'posts_per_page' => $atts['count'],
			'order_by'       => $atts['order_by'],
			'order'          => $atts['order'],
			'offset'         => $atts['offset'],
			'page'           => $atts['page'],
		);

		$taxonomy_query = $this->get_local_taxonomy_query( $atts );

		if ( ! empty( $taxonomy_query ) ) {

			$query_args['tax_query'] = $taxonomy_query;

			$query_args['tax_query']['relation'] = $atts['tax_query_relation'];

		}



	} // End get_local_query_args


	private function get_local_taxonomy_query( $atts ) {

	} // get_local_taxonomy_query


} // End Sub_Layouts

$ccore_post_feed_module = new Post_Feed_Module();
