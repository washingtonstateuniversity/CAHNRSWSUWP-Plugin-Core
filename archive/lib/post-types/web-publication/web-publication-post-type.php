<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Article post type
* @since 0.0.1
*/
class Web_Publication_Post_Type extends Post_Type {

	// @var string $slug Post type slug
	protected $slug = 'web_publication';

	// @var array $post_meta_defaults Default post meta settings
	protected $post_meta_defaults = array(
		'_fs_number'    => '',
		'_fs_authors'   => array(),
	);

	// @var bool $register Registers post type if true
	protected $register = false;

	// @var bool $add_to_customizer Adds post type to customizer as a checkbox (must be checked to register post type)
	protected $add_to_customizer = false;

	// @var bool $save_post Save post action if is set to true
	protected $save_post = true;


	/*
	* @desc Add edit form after title
	* @since 0.0.1
	*
	* @param WP_Post $post Instance of WP_Post object
	* @param array $post_meta Array of key => values from $post_meta_defaults with meta values or default if empty
	*/
	protected function the_edit_form( $post, $post_meta ) {

		$authors = ( ! empty( $post_meta['_fs_authors'] ) && is_array( $post_meta['_fs_authors'] ) ) ? $post_meta['_fs_authors'] : array();

		$fs_number = ( ! empty( $post_meta['_fs_number'] ) ) ? $post_meta['_fs_number'] : '';

		include __dir__ . '/form-fields.php';

	} // end the_edit_form


	/**
	 * @desc Add content to the article using the_content filter
	 * @since 0.0.3
	 *
	 * @param string $content Post content
	 *
	 * @return string Appended content
	 */
	protected function the_content_filter( $content ) {

		$post_id = get_the_ID();

		$authors = get_post_meta( $post_id, '_fs_authors', true );

		$fs_number = get_post_meta( $post_id, '_fs_number', true );

		ob_start();

		include __dir__ . '/authors.php';

		$author_html = ob_get_clean();

		return $author_html . $content;

	} // End the_content_filter

	/**
	 * @desc Santitize post meta from default atts. For more complex sanitation redeclare this in child class
	 * @since 0.0.3
	 *
	 * @return array Sanitized values
	 */
	protected function sanitize_editor_values() {

		$clean_meta = array();

		// @codingStandardsIgnoreStart // Nonce already checked
		if ( isset( $_POST['_fs_authors'] ) && is_array( $_POST['_fs_authors'] ) ) {

			$authors = array();

			foreach ( $_POST['_fs_authors'] as $author ) { // @codingStandardsIgnoreEnd

				$clean_author = array();

				foreach ( $author as $key => $value ) {

					$clean_author[ $key ] = sanitize_text_field( $value );

				} // End foreach

				$authors[] = $clean_author;

			} // End foreach

			$clean_meta['_fs_authors'] = $authors;

		} // End if

		// @codingStandardsIgnoreStart // Nonce already checked
		if ( isset( $_POST['_fs_number'] ) ) {

			// @codingStandardsIgnoreEnd
			$clean_meta['_fs_number'] = sanitize_text_field( $_POST['_fs_number'] ); // End sanitize_editor_values

		} // End if

		return $clean_meta;

	}


} // End RFP_Post_Type

$web_publication_post_type = new Web_Publication_Post_Type();
