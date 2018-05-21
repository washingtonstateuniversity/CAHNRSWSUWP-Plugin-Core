<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

/*
* @desc Get plugin base path
* @since 0.0.1
*
* @param string $path Optional path to append
*
* @return string full path
*/
function core_get_plugin_path( $path = '' ) {

	$path = CAHNRSWSUWPCOREPATH . $path;

	return $path;

} // End core_get_plugin_path


/*
* @desc Get plugin base URL
* @since 0.0.1
*
* @param string $path Optional path to append
*
* @return string full path
*/
function core_get_plugin_url( $path = '' ) {

	$path = CAHNRSWSUWPCOREURL . $path;

	return $path;

} // End core_get_plugin_path


/*
* @desc Get plugin version
* @since 0.0.1
*
* @return string Plugin version
*/
function core_get_plugin_version( $path = '' ) {

	return CAHNRSWSUWPCOREVERSION;

} // End core_get_plugin_path


/*
* @desc Get registered post types
* @since 0.0.1
*
* @return array Post types slug => label
*/
function core_get_registered_post_types() {

	global $core_registered_post_types;

	return $core_registered_post_types;

} // End core_get_registered_post_types


/*
* @desc Register post types
* @since 0.0.1
*
* @return array Post types slug => label
*/
function core_register_post_types( $slug, $label ) {

	global $core_registered_post_types;

	$core_registered_post_types[ $slug ] = $label;

} // End core_get_registered_post_types

/**
 * @desc Get excerpt from given post
 * @since 0.0.3
 *
 * @param WP_Post $post
 *
 * @return string Post excerpt
 */
function core_get_excerpt_from_post( $post ) {

	// If this has an excerpt let's just use that
	if ( isset( $post->post_excerpt ) && ! empty( $post->post_excerpt ) ) {

		// bam done
		return $post->post_excerpt;

	} else { // OK so someone didn't set an excerpt, let's make one

		// We'll start with the post content
		$excerpt = $post->post_content;

		// Remove shortcodes but keep text inbetween ]...[/
		$excerpt = \preg_replace( '~(?:\[/?)[^/\]]+/?\]~s', '', $excerpt );

		// Remove HTML tags and script/style
		$excerpt = \wp_strip_all_tags( $excerpt );

		// Shorten to 35 words and convert special characters
		$excerpt = \htmlspecialchars( \wp_trim_words( $excerpt, 35 ) );

		return $excerpt;

	}// End if

} // End get_excerpt_from_post
