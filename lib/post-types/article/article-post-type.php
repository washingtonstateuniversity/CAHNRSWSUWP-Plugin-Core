<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if

/*
* @desc Article post type
* @since 0.0.1
*/
class Article_Post_Type extends Post_Type {

	// @var string $slug Post type slug
	protected $slug = 'article';

	// @var array $post_meta_defaults Default post meta settings
	protected $post_meta_defaults = array();

	// @var bool $register Registers post type if true
	protected $register = false;

	// @var bool $add_to_customizer Adds post type to customizer as a checkbox (must be checked to register post type)
	protected $add_to_customizer = false;

	// @var bool $save_post Save post action if is set to true
	protected $save_post = true;


	/**
	 * @desc Set the default meta keys
	 * @since 0.0.3
	 */
	protected function set_default_meta() {

		for ( $i = 1; $i < 6; $i++ ) {

			$this->post_meta_defaults[ '_firstname_' . $i ] = '';
			$this->post_meta_defaults[ '_lastname_' . $i ] = '';
			$this->post_meta_defaults[ '_title_' . $i ] = '';
			$this->post_meta_defaults[ '_email_' . $i ] = '';
			$this->post_meta_defaults[ '_phone_' . $i ] = '';

		} // End for

	} // End set_default_meta


	/*
	* @desc Add edit form after title
	* @since 0.0.1
	*
	* @param WP_Post $post Instance of WP_Post object
	* @param array $post_meta Array of key => values from $post_meta_defaults with meta values or default if empty
	*/
	protected function the_edit_form( $post, $post_meta ) {

		$form_items_html = '';

		for ( $i = 1; $i < 6; $i++ ) {

			$firstname = get_post_meta( $post->ID, '_firstname_' . $i, true );

			if ( ! empty( $firstname ) ) {

				$lastname = get_post_meta( $post->ID, '_lastname_' . $i, true );

				$title = get_post_meta( $post->ID, '_title_' . $i, true );

				$email = get_post_meta( $post->ID, '_email_' . $i, true );

				$phone = get_post_meta( $post->ID, '_phone_' . $i, true );

			} else {

				$mediacontact = $this->get_legacy_contact( $post->ID, $i );

				$firstname = $mediacontact['firstname'];

				$lastname = $mediacontact['lastname'];

				$title = $mediacontact['title'];

				$email = $mediacontact['email'];

				$phone = $mediacontact['phone'];

			}

			$display = ( 1 === $i || ! empty( $firstname ) ) ? 'block' : 'none';

			ob_start();

			include __dir__ . '/media-contact/form-item.php';

			$form_items_html .= ob_get_clean();

		}

		include __dir__ . '/media-contact/media-contact-form.php';

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

		global $post;

		$article_html = '';

		$article_html .= $this->get_social_buttons_html( $post );

		$article_html .= $this->get_media_contact_html( $post );

		$content .= $article_html;

		return $content;

	} // End the_content_filter


	/**
	 * @desc Get html structure for Media Contact
	 * @since 0.0.3
	 *
	 * @param WP_Post $post
	 *
	 * @return string Html for media contact
	 */
	protected function get_media_contact_html( $post ) {

		$html = '';

		$media_contact_items_html = '';

		for ( $i = 1; $i < 6; $i++ ) {

			$firstname = get_post_meta( $post->ID, '_firstname_' . $i, true );

			if ( ! empty( $firstname ) ) {

				$mediacontact = array(
					'firstname' => $firstname,
					'lastname'  => get_post_meta( $post->ID, '_lastname_' . $i, true ),
					'title'     => get_post_meta( $post->ID, '_title_' . $i, true ),
					'email'     => get_post_meta( $post->ID, '_email_' . $i, true ),
					'phone'     => get_post_meta( $post->ID, '_phone_' . $i, true ),
				);

			} else {

				$mediacontact = $this->get_legacy_contact( $post->ID, $i );

			} // End if

			if ( ! empty( $mediacontact['firstname'] ) ) {

				ob_start();

				include __dir__ . '/media-contact/media-contact-record.php';

				$media_contact_items_html .= ob_get_clean();

			} // End if
		} // End for

		if ( ! empty( $media_contact_items_html ) ) {

			ob_start();

			include __dir__ . '/media-contact/media-contact-wrapper.php';

			$html .= ob_get_clean();

		}

		return $html;

	} // End get_media_contact_html


	/**
	 * @desc Get lecacy media contact info
	 * @since 0.0.3
	 *
	 * @param int $post_id ID for the give post
	 * @param int $i Index value of given post
	 *
	 * @return array Array of media contact items
	 */
	protected function get_legacy_contact( $post_id, $i ) {

		$source_meta = get_post_meta( $post_id, '_sources', true );

		$mediacontact = array(
			'firstname' => '',
			'lastname'  => '',
			'title'     => '',
			'email'     => '',
			'phone'     => '',
		);

		if ( ! empty( $source_meta[ 'name_' . $i ] ) ) {

			$legacy_name = $source_meta[ 'name_' . $i ];

			$person_info = explode( ', ', $legacy_name );

			$person_names = explode( ' ', $person_info[0] );

			$mediacontact['firstname'] = $person_names[0];

			if ( ! empty( $person_names[1] ) ) {

				$mediacontact['lastname'] = $person_names[1];

			}

			if ( ! empty( $person_info[1] ) ) {

				$mediacontact['title'] = $person_info[1];

			} // End if
		} // End if

		if ( ! empty( $source_meta[ 'info_' . $i ] ) ) {

			$legacy_info = $source_meta[ 'info_' . $i ];

			$person_contact = explode( ', ', $legacy_info );

			$mediacontact['phone'] = $person_contact[0];

			if ( ! empty( $person_contact[1] ) ) {

				$mediacontact['email'] = $person_contact[1];

			} // End if
		} // End if

		return $mediacontact;

	}


	/**
	 * @desc Get social buttons html
	 * @since 0.0.3
	 *
	 * @param WP_Post $post
	 *
	 * @return string Html for social buttions
	 */
	protected function get_social_buttons_html( $post ) {

		$title = \get_the_title( $post );

		$url = \get_permalink( $post );

		$utf_url = rawurlencode( $url );

		ob_start();

		include __dir__ . '/social-media/social-buttons.php';

		$html = ob_get_clean();

		return $html;

	} // End get_social_buttons_html


} // End RFP_Post_Type

$article_post_type = new Article_Post_Type();
