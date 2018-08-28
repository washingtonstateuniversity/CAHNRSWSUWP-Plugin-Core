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
class Publications_Module extends Core_Module {

	public $slug = 'core_pubs'; // The ID for the module _ only

	public $register_args = array(
		'label'          => 'Publications', // Edit This | Shows on activate module panel
		'helper_text'    => 'Index of publications.', // Edit This | Shows on activate module panel
		'settings_page'  => array(
			'page_title'     => 'Publications Module',
			'menu_title'     => 'Publications',
			'capabilities'   => 'manage_options', // Don't touch | Role that can see this
			'page_slug'      => 'page_slug_here', // Edit This | similar to ID
			'callback'       => 'render_options_page', // Don't touch
		),
	);

	protected $save_args = array(
		'post_types'             => array( 'publications' ),
		'nonce_name'             => 'publication_info',
		'nonce_action'           => 'save_pub_info',
	);


	protected $post_settings = array(
		'_pub' => array(
			'sanitize_type'      => 'array',
			'ignore_empty'       => true,
		),
	);
	/**
	 * Init the module here
	 */
	public function init() { 
		
		$this->register_post_type();
		$this->create_pubs_taxonomies();

		if ( is_admin() ) {

			add_action( 'add_meta_boxes', array( $this, 'add_grant_meta_box' ) );

		}

		add_filter( 'template_include', array( $this, 'publication_url_redirect' ), 99 );

		// Do module stuff here

	} // End init

	function publication_url_redirect( $template ) {
		if (is_singular ( 'publications' ) ) {

			$post_id = get_the_ID();

			$publication = get_post_meta( $post_id, '_pub', true );

			$url_content = $publication['url'];

			var_dump ($url_content);

			if  ( ! empty( $url_content )) {
				if ( wp_redirect( $url_content ) ) {
					exit;
				}

		   }
		} 
		return $template;
	}

	public function add_grant_meta_box() {
        // Wp action for adding metabox.
        add_meta_box(
            'core_pub_info', // id
            'Publication Information', // label
            array( $this, 'the_pub_metabox' ) // callback to render content from metabox
        );
	} // End add_grant_meta_box

	public function the_pub_metabox( $post ) {
        // Check if grants post type
        if ( 'publications' === $post->post_type ) {
            // Add nonce field to metabox.
			wp_nonce_field( 'save_pub_info', 'publication_info' );
			
			$publication = get_post_meta( $post->ID, '_pub', true );

            $url_content = $publication['url']; // string HTML for publications.
            $feature_content      = $publication['featured']; // string HTML for funding.
			$external_resources       = $publication['external']; // string HTML for impact.
            include __DIR__ . '/displays/publications-meta-box.php';
        } // End if
    } // End if
	
	protected function register_post_type() {
		$labels = array(
			'name'               => _x( 'Publications', 'post type general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'      => _x( 'Publication', 'post type singular name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'          => _x( 'Publications', 'admin menu', 'cahnrswsuwp-plugin-core' ),
			'name_admin_bar'     => _x( 'Publication', 'add new on admin bar', 'cahnrswsuwp-plugin-core' ),
			'add_new'            => __( 'Add New', 'publication', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'       => __( 'Add New Publication', 'cahnrswsuwp-plugin-core' ),
			'new_item'           => __( 'New Publication', 'cahnrswsuwp-plugin-core' ),
			'edit_item'          => __( 'Edit Publication', 'cahnrswsuwp-plugin-core' ),
			'view_item'          => __( 'View Publication' , 'cahnrswsuwp-plugin-core' ),
			'all_items'          => __( 'All Publications', 'cahnrswsuwp-plugin-core' ),
			'search_items'       => __( 'Search Publications', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon'  => __( 'Parent Publication:', 'cahnrswsuwp-plugin-core' ),
			'not_found'          => __( 'No publications found.', 'cahnrswsuwp-plugin-core' ),
			'not_found_in_trash' => __( 'No publications found in Trash.', 'cahnrswsuwp-plugin-core' ),
		);
	
		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'cahnrswsuwp-plugin-core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);
	
		register_post_type( 'publications', $args );
	}  // End register_post_type

	protected function create_pubs_taxonomies() {

		//publication-authors
		$authors_labels = array(
			'name'              => _x( 'Authors', 'taxonomy general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'     => _x( 'Author', 'taxonomy singular name', 'cahnrswsuwp-plugin-core' ),
			'search_items'      => __( 'Search Authors', 'cahnrswsuwp-plugin-core' ),
			'all_items'         => __( 'All Authors', 'cahnrswsuwp-plugin-core' ),
			'parent_item'       => __( 'Parent Author', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon' => __( 'Parent Author:', 'cahnrswsuwp-plugin-core' ),
			'edit_item'         => __( 'Edit Author', 'cahnrswsuwp-plugin-core' ),
			'update_item'       => __( 'Update Author', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'      => __( 'Add New Author', 'cahnrswsuwp-plugin-core' ),
			'new_item_name'     => __( 'New Author Name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'         => __( 'Author', 'cahnrswsuwp-plugin-core' ),
		);
	
		$authors_args = array(
			'hierarchical'      => true,
			'labels'            => $authors_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);
	
		register_taxonomy( 'publication-authors', array ( 'publications' ), $authors_args );
	
		//taxonomy=publication-program-areas
		$program_areas_labels = array(
			'name'              => _x( 'Program Areas', 'taxonomy general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'     => _x( 'Program Area', 'taxonomy singular name', 'cahnrswsuwp-plugin-core' ),
			'search_items'      => __( 'Search Program Areas', 'cahnrswsuwp-plugin-core' ),
			'all_items'         => __( 'All Program Areas', 'cahnrswsuwp-plugin-core' ),
			'parent_item'       => __( 'Parent Program Area', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon' => __( 'Parent Program Area:', 'cahnrswsuwp-plugin-core' ),
			'edit_item'         => __( 'Edit Program Area', 'cahnrswsuwp-plugin-core' ),
			'update_item'       => __( 'Update Program Area', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'      => __( 'Add New Program Area', 'cahnrswsuwp-plugin-core' ),
			'new_item_name'     => __( 'New Program Area Name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'         => __( 'Program Area', 'cahnrswsuwp-plugin-core' ),
		);
	
		$program_areas_args = array(
			'hierarchical'      => true,
			'labels'            => $program_areas_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);
	
		register_taxonomy( 'publication-program-areas', array ( 'publications' ), $program_areas_args );
	
		//taxonomy=publication-topics
		$topic_labels = array(
			'name'              => _x( 'Topics', 'taxonomy general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'     => _x( 'Topic' , 'taxonomy singular name', 'cahnrswsuwp-plugin-core' ),
			'search_items'      => __( 'Search Topics', 'cahnrswsuwp-plugin-core' ),
			'all_items'         => __( 'All Topics', 'cahnrswsuwp-plugin-core' ),
			'parent_item'       => __( 'Parent Topic', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon' => __( 'Parent Topic:', 'cahnrswsuwp-plugin-core' ),
			'edit_item'         => __( 'Edit Topic', 'cahnrswsuwp-plugin-core' ),
			'update_item'       => __( 'Update Topic', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'      => __( 'Add New Topic', 'cahnrswsuwp-plugin-core' ),
			'new_item_name'     => __( 'New Topic Name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'         => __( 'Topic', 'cahnrswsuwp-plugin-core' ),
		);
	
		$topics_args = array(
			'hierarchical'      => true,
			'labels'            => $topic_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);
	
		register_taxonomy( 'publication-topics', array ( 'publications' ), $topics_args );
	
		//taxonomy=keywords
		$keyword_labels = array(
			'name'              => _x( 'Keywords', 'taxonomy general name', 'cahnrswsuwp-plugin-core' ),
			'singular_name'     => _x( 'Keyword', 'taxonomy singular name', 'cahnrswsuwp-plugin-core' ),
			'search_items'      => __( 'Search Keywords', 'cahnrswsuwp-plugin-core' ),
			'all_items'         => __( 'All Keywords', 'cahnrswsuwp-plugin-core' ),
			'parent_item'       => __( 'Parent Keyword', 'cahnrswsuwp-plugin-core' ),
			'parent_item_colon' => __( 'Parent Keyword:', 'cahnrswsuwp-plugin-core' ),
			'edit_item'         => __( 'Edit Keyword' , 'cahnrswsuwp-plugin-core' ),
			'update_item'       => __( 'Update Keyword', 'cahnrswsuwp-plugin-core' ),
			'add_new_item'      => __( 'Add New Keyword', 'cahnrswsuwp-plugin-core' ),
			'new_item_name'     => __( 'New Keyword Name', 'cahnrswsuwp-plugin-core' ),
			'menu_name'         => __( 'Keyword', 'cahnrswsuwp-plugin-core' ),
		);
	
		$keyword_args = array(
			'hierarchical'      => true,
			'labels'            => $keyword_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'keyword' ),
		);
	
		register_taxonomy( 'publication-keywords', array ( 'publications' ), $keyword_args );
	
	} // end create_pubs_taxonomies

	// --------------- //

	public function add_admin_settings() {

		$settings_adapter = get_settings_api_adapter(); // Don't touch | Custom settings wrapper to make using it easier

		$page_slug = $this->get_settings_page_slug(); // Don't touch | Gets the page slug for this setting

		$section = 'page_section'; // Edit This | Define your section here

		// Register settings

		$settings_adapter->register_settings( // Don't touch | Registers all of your settings from $this->settings
			$page_slug,
			$this->settings
		);

		$settings_adapter->add_section( // Edit This | Add a custom section
			$section,
			'My Section Name Here',
			$page_slug,
			'Some random text here' // Edit This | Descriptor text for the section
		);

		$settings_adapter->add_select_field( // Edit This | Add a select field
			'setting_key_id',
			'Setting Label Here',
			$page_slug, // Don't touch
			$section, // Don't touch
			array( // Edit This | Select options as an array
				'value' => 'Value Label',
			),
			get_option( 'setting_key_id' ) // Edit This | Current value of 'setting_key_id'
		);

	} // End add_settings



} // End Sub_Layouts

$ccore_publiations_module = new Publications_Module(); // Edit This
