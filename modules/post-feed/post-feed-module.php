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
		'id'                     => 'core-post-feed',
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'protocol'               => 'http',
		'host'                   => '',
		'rest_path'              => '/wp-json/wp/v2/',
		'count'                  => 10,
		'tags'                   => '',
		'categories'             => '',
		'order_by'               => 'date',
		'order'                  => 'DESC',
		'offset'                 => 0,
		'page'                   => 1,
		'taxonomy_filters'       => '',
		'show_pagination'        => '',
		'show_search'            => '',
		'display'                => 'promo',
		'excerpt_length'         => 25,
		'show_author'            => '',
		'show_date'              => '',
		'tax_query_relation'     => 'AND',
		'image_size'             => 'medium',
		's'                      => '',
		'taxonomies'             => '',
		'title_tag'              => 'h3',
		'css_hook'               => '',
		'show_image_placeholder' => '',
	);


	/**
	 * Init the module here
	 */
	public function init() {

		add_shortcode( 'post_feed', array( $this, 'render_shortcode' ) );

	} // End init


	public function render_shortcode( $atts, $content, $tag ) {

		$atts = $this->parse_shortcode_atts( $atts );

		$atts = $this->get_request_atts( $atts );

		$atts = shortcode_atts( $this->default_atts, $atts, $tag );

		$query_items = $this->get_query_items( $atts );

		$items = ( ! empty( $query_items['items'] ) ) ? $query_items['items'] : array();

		$id = ( ! empty( $atts['id'] ) ) ? $atts['id'] : 'core-post-feed';

		$html = '';

		ob_start();

		echo '<div class="core-post-feed"><form class="core-post-form" method="get">';

		$this->the_search( $atts );

		$this->the_filters( $atts );

		$this->the_pagination( $query_items, $atts );

		$this->the_items_html( $items, $atts );

		$this->the_pagination( $query_items, $atts, true );

		echo '</div></form>';

		$html .= ob_get_clean();

		return $html;

	} // End render_shortcode


	private function the_search( $atts ) {

		if ( ! empty( $atts['show_search'] ) ) {

			$keyword = $atts['s'];

			include __DIR__ . '/displays/search.php';

		} // End if

	} // End the_search


	private function the_filters( $atts ) {

		if ( ! empty( $atts['taxonomy_filters'] ) || ! empty( $atts['meta_filters'] ) ) {

			$filters_array = $this->get_filters_array( $atts );

			if ( ! empty( $filters_array ) ) {

				include __DIR__ . '/displays/filters.php';

			} // End if
		} // End if

	} // End the_filters


	private function the_pagination( $query_items, $atts, $is_end = false ) {

		if ( ! empty( $atts['show_pagination'] ) ) {

			$pages = ( ! empty( $query_items['pages'] ) ) ? (int) $query_items['pages'] : 0;

			$current_page = ( ! empty( $query_items['page'] ) ) ? (int) $query_items['page'] : 1;

			$per_page = ( ! empty( $query_items['per_page'] ) ) ? (int) $query_items['per_page'] : 10;

			$total_items = ( ! empty( $query_items['total_items'] ) ) ? (int) $query_items['total_items'] : 0;

			if ( 1 === $current_page ) {

				$start_index = 1;

			} else {

				$start_index = ( ( $current_page - 1 ) * $per_page );

			} // End if

			$end_index = ( ( $current_page ) * $per_page );

			if ( $end_index > $total_items ) {

				$end_index = $total_items;

			} // end if

			$next_page = ( $current_page + 1 );

			$previous_page = ( $current_page - 1 );

			include __DIR__ . '/displays/pagination.php';

		} // End if

	} // End the_pagination


	private function parse_shortcode_atts( $atts ) {

		if ( ! empty( $atts['taxonomies'] ) ) {

			$atts['taxonomies'] = $this->parse_shortcode_taxonomy_atts( $atts );

		} // end if

		return $atts;

	} // End parse_shortcode_atts


	private function parse_shortcode_taxonomy_atts( $atts ) {

		$taxonomies = array();

		$shortcode_taxonomies = $atts['taxonomies'];

		$taxonomy_sets = explode( '},{', $shortcode_taxonomies );

		foreach ( $taxonomy_sets as $taxonomy_set ) {

			$taxonomy_set = str_replace( array( '{', '}' ), '', $taxonomy_set );

			$taxonomy_group = explode( '|', $taxonomy_set );

			if ( ! empty( $taxonomy_group ) ) {

				if ( ! empty( $taxonomy_group[0] ) ) {

					$taxonomy = array(
						'terms'    => ( ! empty( $taxonomy_group[1] ) ) ? $taxonomy_group[1] : '',
						'relation' => ( ! empty( $taxonomy_group[2] ) ) ? $taxonomy_group[2] : 'OR',
					);

					$taxonomies[ $taxonomy_group[0] ] = $taxonomy;

				} // End if
			} // end if
		} // End foreach

		return $taxonomies;

	} // End parse_shortcode_taxonomy_atts


	private function get_request_atts( $atts ) {

		if ( ! empty( $_REQUEST['pf_search'] ) ) {

			$atts['s'] = sanitize_text_field( $_REQUEST['pf_search'] );

		} // End if

		if ( ! empty( $_REQUEST['pf_page'] ) ) {

			$atts['page'] = sanitize_text_field( $_REQUEST['pf_page'] );

		} // End if

		if ( ! empty( $_REQUEST['taxonomies'] ) ) {

			if ( empty( $atts['taxonomies'] ) || ! is_array( $atts['taxonomies'] ) ) {

				$atts['taxonomies'] = array();

			} // End if

			foreach ( $_REQUEST['taxonomies'] as $taxonomy => $slug ) {

				$clean_tax = sanitize_text_field( $taxonomy );

				$clean_slug = sanitize_text_field( $slug );

				$atts['taxonomies'][ $clean_tax ] = $clean_slug;

			} // End foreach
		} // End if

		return $atts;

	}


	private function get_query_items( $atts ) {

		$default_query = array(
			'per_page'      => 0,
			'total_items'   => 0,
			'page'          => 1,
			'items'         => array(),
			'pages'         => 1,
		);

		if ( ! empty( $atts['host'] ) ) {

			// This is a REST request

		} else {

			// This is a local query
			$query = $this->get_local_query_items( $atts );

		} // end if

		$query_items = array_merge( $default_query, $query );

		return $query_items;

	} // End get_query_items


	private function get_local_query_items( $atts ) {

		$query_items = array(
			'items'       => array(),
			'page'        => ( ! empty( $atts['page'] ) ) ? $atts['page'] : 1,
		);

		$query_args = $this->get_local_query_args( $atts );

		$the_query = new \WP_Query( $query_args );

		$query_items['total_items'] = $the_query->found_posts;
		$query_items['pages']       = $the_query->max_num_pages;
		$query_items['paged']       = ( ! empty( $query_args['paged'] ) ) ? $query_args['paged'] : 1;
		$query_items['per_page']    = ( ! empty( $query_args['posts_per_page'] ) ) ? $query_args['posts_per_page'] : 10;

		// The Loop
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {

				$the_query->the_post();

				$post_id = get_the_ID();

				$item = array(
					'title'     => get_the_title(),
					'author'    => get_the_author_meta( 'display_name' ),
					'date'      => get_the_date(),
					'has_image' => false,
					'image'     => array(),
					'link'      => get_the_permalink(),
				);

				if ( has_post_thumbnail() ) {

					$item['has_image'] = true;

					$item['image'] = array(
						'thumbnail' => get_the_post_thumbnail_url( $post_id ),
						'medium'    => get_the_post_thumbnail_url( $post_id, 'medium' ),
						'large'     => get_the_post_thumbnail_url( $post_id, 'large' ),
						'full'      => get_the_post_thumbnail_url( $post_id, 'full' ),
					);
				} // End if

				ob_start();

				the_content();

				$item['content'] = ob_get_clean();

				ob_start();

				the_excerpt();

				$item['excerpt'] = ob_get_clean();

				$query_items['items'][ $post_id ] = $item;

			} // End while

			wp_reset_postdata();

		} // End if

		return $query_items;

	}

	private function get_remote_query_items( $atts ) {

	}


	private function get_filters_array( $atts ) {

		$filters_array = array();

		if ( ! empty( $atts['taxonomy_filters'] ) ) {

			$filters_set = explode( '},{', $atts['taxonomy_filters'] );

			foreach ( $filters_set as $filter ) {

				$filter = str_replace( array( '{', '}' ), '', $filter );

				$filter_group = explode( '|', $filter );

				if ( ! empty( $filter_group ) ) {

					$taxonomy = ( ! empty( $filter_group[0] ) ) ? $filter_group[0] : 'category';
					$terms = ( ! empty( $filter_group[2] ) ) ? explode( ',', $filter_group[2] ) : array();

					$filter_array = array(
						'taxonomy'       => $taxonomy,
						'label'          => ( ! empty( $filter_group[1] ) ) ? $filter_group[1] : 'Filter By:',
						'terms'          => $terms,
						'current_value'  => '',
						'term_options'   => $this->get_filter_term_options( $taxonomy, $terms ),
					);

					if ( isset( $_REQUEST['taxonomies'][ $taxonomy ] ) && ! empty( $_REQUEST['taxonomies'][ $taxonomy ] ) ) {

						$filter_array['current_value'] = sanitize_text_field( $_REQUEST['taxonomies'][ $taxonomy ] );

					} // End if

					$filters_array[] = $filter_array;

				} // End if
			} // End foreach
		} // End if

		return $filters_array;

	} // End get_filters_html


	private function get_filter_term_options( $taxonomy, $term_ids ) {

		$term_options = array();

		if ( ! empty( $term_ids ) ) {

			foreach ( $term_ids as $term_id ) {

				$term = get_term_by( 'id', $term_id, $taxonomy );

				$term_options[ $term->slug ] = $term->name;

			} // End foreach
		} else {

			$args = array();

			$terms = get_terms( $taxonomy, $args );

			if ( is_array( $terms ) ) {

				foreach ( $terms as $index => $term ) {

					$term_options[ $term->slug ] = $term->name;

				} // End foreach
			} // End if
		} // End if

		return $term_options;

	} // End get_filter_term_options


	private function the_items_html( $items, $atts ) {

		echo '<div class="core-post-feed-items">';

		$display = ( ! empty( $atts['display'] ) ) ? $atts['display'] : 'promo';

		if ( ! empty( $items ) ) {

			switch ( $display ) {

				default:
					$this->the_promo_display( $items, $atts );
					break;

			} // End switch
		} else {

			include __DIR__ . '/displays/no-items-found.php';

		} // End if

		echo '</div>';

	} // end get_items_html


	private function the_promo_display( $items, $atts ) {

		foreach ( $items as $post_id => $item ) {

			$title             = ( ! empty( $item['title'] ) ) ? $item['title'] : '';
			$title_tag         = ( ! empty( $atts['title_tag'] ) ) ? $atts['title_tag'] : 'h3';
			$content           = ( ! empty( $item['content'] ) ) ? $item['content'] : '';
			$link              = ( ! empty( $item['link'] ) ) ? $item['link'] : '';
			$author            = ( ! empty( $item['author'] ) ) ? $item['author'] : '';
			$date              = ( ! empty( $item['date'] ) ) ? $item['date'] : '';
			$image_placeholder = ( ! empty( $item['show_image_placeholder'] ) ) ? $item['show_image_placeholder'] : '';
			$excerpt           = $this->get_item_excerpt( $item, $atts );
			$image             = $this->get_item_image( $item, $atts );
			$meta              = $this->get_item_meta( $item, $atts );

			include __DIR__ . '/displays/promo.php';

		} // End foreach

	} // End get_promo_display


	private function get_item_meta( $item, $atts ) {

		$meta = array();

		if ( ! empty( $item['author'] ) && ! empty( $atts['show_author'] ) ) {

			$meta[] = '<span class="item-author">Posted by ' . $item['author'] . '</span>';

		} // End if

		if ( ! empty( $item['date'] ) && ! empty( $atts['show_date'] ) ) {

			$meta[] = '<span class="item-date">' . $item['date'] . '</span>';

		} // End if

		return $meta;

	} // End get_item_meta


	private function get_item_image( $item, $atts ) {

		$image = '';

		if ( ! empty( $item['has_image'] ) && ! empty( $item['image'] ) ) {

			$size = ( ! empty( $item['image_size'] ) ) ? $item['image_size'] : 'medium';

			if ( ! empty( $item['image'][ $size ] ) ) {

				$image = $item['image'][ $size ];

			} // End if
		} // End if

		return $image;

	} // End if


	private function get_item_excerpt( $item, $atts ) {

		$excerpt = ( ! empty( $item['excerpt'] ) ) ? $item['excerpt'] : '';

		if ( ! empty( $atts['excerpt_length'] ) ) {

			$excerpt = wp_trim_words( $excerpt, $atts['excerpt_length'] );

		} // End if

		return $excerpt;

	} // End get_item_excerpt


	/*private function get_local_items( $atts ) {

		$items = array();

		$query_args = $this->get_local_query_args( $atts );

		$the_query = new \WP_Query( $query_args );

		// The Loop
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {

				$the_query->the_post();

				$post_id = get_the_ID();

				$item = array(
					'title'     => get_the_title(),
					'author'    => get_the_author_meta( 'display_name' ),
					'date'      => get_the_date(),
					'has_image' => false,
					'image'     => array(),
					'link'      => get_the_permalink(),
				);

				if ( has_post_thumbnail() ) {

					$item['has_image'] = true;

					$item['image'] = array(
						'thumbnail' => the_post_thumbnail_url(),
						'medium'    => the_post_thumbnail_url( 'medium' ),
						'large'     => the_post_thumbnail_url( 'large' ),
						'full'      => the_post_thumbnail_url( 'full' ),
					);
				} // End if

				ob_start();

				the_content();

				$item['content'] = ob_get_clean();

				ob_start();

				the_excerpt();

				$item['excerpt'] = ob_get_clean();

				$items[ $post_id ] = $item;

			} // End while

			wp_reset_postdata();

		} // End if

		return $items;

	} // End get_local_items*/


	private function get_local_query_args( $atts ) {

		$query_args = array(
			'post_type'      => $atts['post_type'],
			'post_status'    => $atts['post_status'],
			'posts_per_page' => $atts['count'],
			'order_by'       => $atts['order_by'],
			'order'          => $atts['order'],
			'paged'          => $atts['page'],
		);

		if ( ! empty( $atts['s'] ) ) {

			$query_args['s'] = $atts['s'];

		} // End if

		if ( ! empty( $atts['offset'] ) && ( 2 > $query_args['paged'] ) ) {

			$query_args['offset'] = $atts['offset'];

		} // End if

		$taxonomy_query = $this->get_local_taxonomy_query( $atts );

		if ( ! empty( $taxonomy_query ) ) {

			$query_args['tax_query'] = $taxonomy_query;

			$query_args['tax_query']['relation'] = $atts['tax_query_relation'];

		} // End if

		//var_dump( $query_args );

		return $query_args;

	} // End get_local_query_args


	private function get_local_taxonomy_query( $atts ) {

		$taxonomy_query = array();

		if ( ! empty( $atts['tags'] ) ) {

			$tag_terms = explode( ',', $atts['tags'] );

			$tag_query = array(
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $tag_terms,
			);

			$taxonomy_query[] = $tag_query;

		} // End if

		if ( ! empty( $atts['categories'] ) ) {

			$category_terms = explode( ',', $atts['categories'] );

			$category_query = array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category_terms,
			);

			$taxonomy_query[] = $category_query;

		} // End if

		if ( ! empty( $atts['taxonomies'] ) && is_array( $atts['taxonomies'] ) ) {

			foreach ( $atts['taxonomies'] as $taxonomy => $tax ) {

				if ( ! empty( $tax ) ) {

					if ( is_array( $tax ) && ! empty( $tax['terms'] ) ) {

						$terms = sanitize_text_field( $tax['terms'] );

						$terms = explode( ',', $terms );

						$tax_query = array(
							'taxonomy' => sanitize_text_field( $taxonomy ),
							'field'    => 'term_id',
							'terms'    => $terms,
						);

						$taxonomy_query[] = $tax_query;

					} else {

						$tax_query = array(
							'taxonomy' => sanitize_text_field( $taxonomy ),
							'field'    => 'slug',
							'terms'    => sanitize_text_field( $tax ),
						);

						$taxonomy_query[] = $tax_query;

					}// End if
				} // End if
			} // End foreach
		} // End if

		return $taxonomy_query;

	} // get_local_taxonomy_query


} // End Sub_Layouts

$ccore_post_feed_module = new Post_Feed_Module();
