<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Add open graph to single page views
* @since 0.0.1
*/
class Open_Graph_Utility {

	public function __construct() {

		add_action( 'wp_head', array( $this, 'add_open_graph_meta' ), 1 );

		add_filter( 'language_attributes', array( $this, 'add_opengraph_att' ), 10, 2 );

	} // End __construct


	/**
	 * @desc Add open graph to attributes
	 */
	public function add_opengraph_att( $output, $doctype ) {

		if ( is_singular() ) {

			$output .= ' prefix="og: http://ogp.me/ns#"';

		} // End if

		return $output;

	} // End add_opengraph_att


	/**
	 * @desc Add open graph meta to the head
	 * @since 0.0.3
	 */
	public function add_open_graph_meta() {

		if ( is_singular() ) {

			global $post;

			if ( isset( $post ) && isset( $post->ID ) ) {

				$title = \get_the_title( $post );

				$meta_title = esc_html( spine_get_title() );

				$url = \get_permalink( $post );

				$img = \get_the_post_thumbnail_url( $post, 'full' );

				$unit_name = esc_html( \get_bloginfo( 'name' ) );

				$fbadmin = '';

				$excerpt = core_get_excerpt_from_post( $post );

				include __dir__ . '/open-graph-meta.php';

			} // End if
		} // End if

	} // End add_open_graph_meta


} // End Open_Graph

$open_graph_utility = new Open_Graph_Utility();
