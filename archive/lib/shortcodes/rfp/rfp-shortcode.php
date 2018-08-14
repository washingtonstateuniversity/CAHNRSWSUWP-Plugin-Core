<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Adds RFP Shortcode
* @since 0.0.1
*/
class RFP_Shortcode {

	// @var stirng $slug Shortcode slug
	protected $slug = 'rfp';

	// @var array $default_atts Default atts to use in shortcode
	protected $default_atts = array(
		'count' => -1,
		'show_archived' => '',
	);


	public function __construct() {

		add_action( 'init', array( $this, 'register_shortcode' ) );

	} // End __construct


	/*
	* @desc Add the shortcode to WP
	* @since 0.0.1
	*/
	public function register_shortcode() {

		add_shortcode( $this->slug, array( $this, 'render_shortcode' ) );

	} // End register_shortcode


	/*
	* @desc Render shortcode from callback
	* @since 0.0.1
	*
	* @param array $atts Array of shortcode attributes
	* @param string $content Shortcode content
	* @param string $tag Shortcode tag
	*
	* @return string Shortcode HTML
	*/
	public function render_shortcode( $atts, $content, $tag ) {

		$html = '';

		$atts = shortcode_atts( $this->default_atts, $atts );

		// Yesterdays timestamp
		$yesterday = time() - ( 24 * 60 * 60 );

		$query_args = array(
			'posts_per_page' => $atts['count'],
			'post_type' => 'rfp',
			'post_status' => 'publish',
			'orderby' => 'meta_value_num',
			'meta_query' => array(
				array(
					'key' => '_post_date',
					'value' => $yesterday,
					'type' => 'numeric',
					'compare' => '>',
				),
			),
			'order' => 'ASC',
		);

		$the_query = new \WP_Query( $query_args );

		if ( $the_query->have_posts() ) {

			$html .= '<div class="cc-shortcode-rfp">';

			while ( $the_query->have_posts() ) {

				$the_query->the_post();

				$title = get_the_title();

				$link_src = get_post_meta( $the_query->post->ID, '_redirect_to', true );

				$excerpt = get_the_excerpt();

				$the_date = get_post_meta( $the_query->post->ID, '_post_date', true );

				$date = date( 'D, d M Y', $the_date );

				ob_start();

				include __DIR__ . '/item.php';

				$html .= ob_get_clean();

			} // End while

			/* Restore original Post Data */
			wp_reset_postdata();

			$html .= '</div>';

		} // End if

		return apply_filters( 'cc_shortcode_html_after', $html, $atts, $content, $tag );

	} // End render_shortcode


} // End RFP_Shortcode

$rfp_shortcode = new RFP_Shortcode();
