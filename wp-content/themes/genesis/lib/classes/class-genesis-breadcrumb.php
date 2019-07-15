<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Breadcrumbs
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

/**
 * Class to control breadcrumbs display.
 *
 * Private properties will be set to private when WordPress requires PHP 5.2.
 * If you change a private property expect that change to break Genesis in the future.
 *
 * @since 1.5.0
 *
 * @package Genesis\Breadcrumbs
 */
class Genesis_Breadcrumb {

	/**
	 * Settings array, a merge of provided values and defaults.
	 *
	 * @since 1.5.0
	 *
	 * @var array Holds the breadcrumb arguments
	 */
	protected $args = array();

	/**
	 * Constructor. Set up cacheable values and settings.
	 *
	 * @since 1.5.0
	 */
	public function __construct() {

		// Default arguments.
		$this->args = require GENESIS_CONFIG_DIR . '/breadcrumbs.php';

	}

	/**
	 * Return the final completed breadcrumb in markup wrapper.
	 *
	 * @since 1.5.0
	 *
	 * @param array $args Breadcrumb arguments.
	 * @return string HTML markup for final completed markup.
	 */
	public function get_output( $args = array() ) {

		/**
		 * Filter the Genesis breadcrumb arguments.
		 *
		 * @since 1.5.0
		 *
		 * @param array $args {
		 *      Arguments for generating breadcrumbs.
		 *
		 *      @type string $home                    Homepage link text.
		 *      @type string $sep                     Separator.
		 *      @type string $list_set                List format separator.
		 *      @type string $prefix                  Prefix before breadcrumb list.
		 *      @type string $suffix                  Suffix after breadcrumb list.
		 *      @type bool   $heirarchial_attachments Whether attachments are hierarchical.
		 *      @type bool   $heirarchial_categories  Whether categories are hierarchical.
		 *      @type array $labels                   Labels including the following keys: 'prefix', 'author', 'category',
		 *                                            'tag', 'date', 'search', 'tax', 'post_type', '404'.
		 * }
		 */
		$this->args = apply_filters( 'genesis_breadcrumb_args', wp_parse_args( $args, $this->args ) );

		return $this->args['prefix'] . $this->args['labels']['prefix'] . $this->build_crumbs() . $this->args['suffix'];

	}

	/**
	 * Echo the final completed breadcrumb in markup wrapper.
	 *
	 * @since 1.5.0
	 *
	 * @param array $args Breadcrumb arguments.
	 */
	public function output( $args = array() ) {

		echo $this->get_output( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- We need raw output here.

	}

	/**
	 * Return the correct crumbs for this query, combined together.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for the crumbs, combined together.
	 */
	protected function build_crumbs() {

		$crumbs[] = $this->get_home_crumb();

		if ( is_home() ) {
			$crumbs[] = $this->get_blog_crumb();
		} elseif ( is_search() ) {
			$crumbs[] = $this->get_search_crumb();
		} elseif ( is_404() ) {
			$crumbs[] = $this->get_404_crumb();
		} elseif ( is_page() && ! is_front_page() ) {
			$crumbs[] = $this->get_page_crumb();
		} elseif ( is_archive() ) {
			$crumbs[] = $this->get_archive_crumb();
		} elseif ( is_singular() ) {
			$crumbs[] = $this->get_single_crumb();
		}

		/**
		 * Filter the Genesis breadcrumbs.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumbs HTML markup for the breadcrumbs.
		 * @param array  $args   Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		$crumbs = apply_filters( 'genesis_build_crumbs', $crumbs, $this->args );

		return implode( $this->args['sep'], array_filter( $crumbs ) );

	}

	/**
	 * Return archive breadcrumb.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for archive breadcrumb.
	 */
	protected function get_archive_crumb() {

		$crumb = '';

		if ( is_category() ) {
			$crumb = $this->get_category_crumb();
		} elseif ( is_tag() ) {
			$crumb = $this->get_tag_crumb();
		} elseif ( is_tax() ) {
			$crumb = $this->get_tax_crumb();
		} elseif ( is_year() ) {
			$crumb = $this->get_year_crumb();
		} elseif ( is_month() ) {
			$crumb = $this->get_month_crumb();
		} elseif ( is_day() ) {
			$crumb = $this->get_day_crumb();
		} elseif ( is_author() ) {
			$crumb = $this->get_author_crumb();
		} elseif ( is_post_type_archive() ) {
			$crumb = $this->get_post_type_crumb();
		}

		/**
		 * Filter the Genesis archive breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the archive breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_archive_crumb', $crumb, $this->args );

	}

	/**
	 * Get single breadcrumb, including any parent crumbs.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for single breadcrumb, including any parent breadcrumbs.
	 */
	protected function get_single_crumb() {

		if ( is_attachment() ) {
			$crumb = $this->get_attachment_crumb();
		} elseif ( is_singular( 'post' ) ) {
			$crumb = $this->get_post_crumb();
		} else {
			$crumb = $this->get_cpt_crumb();
		}

		/**
		 * Filter the Genesis single breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the single breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_single_crumb', $crumb, $this->args );

	}

	/**
	 * Return home breadcrumb.
	 *
	 * Default is Home, linked on all occasions except when is_home() is true.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for home breadcrumb.
	 */
	protected function get_home_crumb() {

		$url   = $this->page_shown_on_front() ? get_permalink( get_option( 'page_on_front' ) ) : trailingslashit( home_url() );
		$crumb = ( is_home() && is_front_page() ) ? $this->args['home'] : $this->get_breadcrumb_link( $url, '', $this->args['home'] );

		/**
		 * Filter the Genesis home breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the home breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_home_crumb', $crumb, $this->args );

	}

	/**
	 * Return blog posts page breadcrumb.
	 *
	 * Defaults to the home crumb (later removed as a duplicate). If using a
	 * static front page, then the title of the Page is returned.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for blog posts page breadcrumb.
	 */
	protected function get_blog_crumb() {

		$crumb = $this->get_home_crumb();
		if ( $this->page_shown_on_front() ) {
			$crumb = get_the_title( get_option( 'page_for_posts' ) );
		}

		/**
		 * Filter the Genesis blog posts breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the blog posts breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_blog_crumb', $crumb, $this->args );

	}

	/**
	 * Return search results page breadcrumb.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for search results page breadcrumb.
	 */
	protected function get_search_crumb() {

		$crumb = $this->args['labels']['search'] . '"' . esc_html( apply_filters( 'the_search_query', get_search_query() ) ) . '"'; // WPCS: prefix ok.

		/**
		 * Filter the Search page breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the search page breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_search_crumb', $crumb, $this->args );

	}

	/**
	 * Return 404 (page not found) breadcrumb.
	 *
	 * @since 1.5.0
	 *
	 * @return string HTML markup for 404 (page not found) breadcrumb.
	 */
	protected function get_404_crumb() {

		$crumb = $this->args['labels']['404'];

		/**
		 * Filter the 404 page breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the 404 page breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_404_crumb', $crumb, $this->args );

	}

	/**
	 * Return content page breadcrumb.
	 *
	 * @since 1.5.0
	 *
	 * @global WP_Query $wp_query Query object.
	 *
	 * @return string HTML markup for a page breadcrumb.
	 */
	protected function get_page_crumb() {

		global $wp_query;

		if ( $this->page_shown_on_front() && is_front_page() ) {
			// Don't do anything - we're on the front page and we've already dealt with that elsewhere.
			$crumb = $this->get_home_crumb();
		} else {
			$post = $wp_query->get_queried_object();

			if ( $post->post_parent ) {
				if ( isset( $post->ancestors ) ) {
					if ( is_array( $post->ancestors ) ) {
						$ancestors = array_values( $post->ancestors );
					} else {
						$ancestors = array( $post->ancestors );
					}
				} else {
					$ancestors = array( $post->post_parent );
				}

				$crumbs = array();
				foreach ( $ancestors as $ancestor ) {
					array_unshift(
						$crumbs,
						$this->get_breadcrumb_link(
							get_permalink( $ancestor ),
							'',
							get_the_title( $ancestor )
						)
					);
				}

				// Add the current page title.
				$crumbs[] = get_the_title( $post->ID );

				$crumb = implode( $this->args['sep'], $crumbs );
			} else {
				// If this is a top level Page, it's simple to output the breadcrumb.
				$crumb = get_the_title();
			}
		}

		/**
		 * Filter the content page breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $crumb HTML markup for the content page breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_page_crumb', $crumb, $this->args );

	}

	/**
	 * Get breadcrumb for single attachment, including any parent crumbs.
	 *
	 * @since 2.0.0
	 *
	 * @return string HTML markup for a single attachment breadcrumb, including any parent breadcrumbs.
	 */
	protected function get_attachment_crumb() {

		$post = get_post();

		$crumb = '';
		if ( $post->post_parent && $this->args['heirarchial_attachments'] ) {
			// If showing attachment parent.
			$attachment_parent = get_post( $post->post_parent );
			$crumb             = $this->get_breadcrumb_link(
				get_permalink( $post->post_parent ),
				'',
				$attachment_parent->post_title,
				$this->args['sep']
			);
		}
		$crumb .= single_post_title( '', false );

		/**
		 * Filter the Genesis attachment breadcrumb.
		 *
		 * @since 2.5.0
		 *
		 * @param string $crumb HTML markup for the attachment breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_attachment_crumb', $crumb, $this->args );

	}

	/**
	 * Get breadcrumb for single post, including any parent (category) crumbs.
	 *
	 * @since 2.0.0
	 *
	 * @return string HTML markup for a single post breadcrumb, including any parent (category) breadcrumbs.
	 */
	protected function get_post_crumb() {

		$categories = get_the_category();

		$cat_crumb = '';

		if ( 1 === count( $categories ) ) {
			// If in single category, show it, and any parent categories.
			$cat_crumb = $this->get_term_parents( $categories[0]->cat_ID, 'category', true ) . $this->args['sep'];
		}
		if ( count( $categories ) > 1 ) {
			if ( $this->args['heirarchial_categories'] ) {
				// Show parent categories - see if one is marked as primary and try to use that.
				$primary_category_id = get_post_meta( get_the_ID(), '_category_permalink', true ); // Support for sCategory Permalink plugin.
				if ( ! $primary_category_id && function_exists( 'yoast_get_primary_term_id' ) ) {
					// Support for Yoast SEO plugin, even if the Yoast Breadcrumb feature is not enabled.
					$primary_category_id = yoast_get_primary_term_id();
				}
				if ( $primary_category_id ) {
					$cat_crumb = $this->get_term_parents( $primary_category_id, 'category', true ) . $this->args['sep'];
				} else {
					$cat_crumb = $this->get_term_parents( $categories[0]->cat_ID, 'category', true ) . $this->args['sep'];
				}
			} else {
				$crumbs = array();
				// Don't show parent categories (unless the post happen to be explicitly in them).
				foreach ( $categories as $category ) {
					$crumbs[] = $this->get_breadcrumb_link(
						get_category_link( $category->term_id ),
						'',
						$category->name
					);
				}
				$cat_crumb = implode( $this->args['list_sep'], $crumbs ) . $this->args['sep'];
			}
		}
		$crumb = $cat_crumb . single_post_title( '', false );

		/**
		 * Filter the Genesis post breadcrumb.
		 *
		 * @since 2.5.0
		 *
		 * @param string $crumb HTML markup for the post breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_post_crumb', $crumb, $this->args, $cat_crumb );

	}

	/**
	 * Get breadcrumb for single custom post type entry, including any parent (CPT name) crumbs.
	 *
	 * @since 2.0.0
	 *
	 * @return string HTML markup for a single custom post type entry breadcrumb, including
	 *                any parent (CPT name) breadcrumbs.
	 */
	protected function get_cpt_crumb() {

		$post_type        = get_query_var( 'post_type' );
		$post_type_object = get_post_type_object( $post_type );

		if ( null === $post_type_object ) {
			return '';
		}

		$cpt_archive_link = get_post_type_archive_link( $post_type );
		if ( $cpt_archive_link ) {
			$crumb = $this->get_breadcrumb_link(
				$cpt_archive_link,
				'',
				$post_type_object->labels->name
			);
		} else {
			$crumb = $post_type_object->labels->name;
		}

		$crumb .= $this->args['sep'] . single_post_title( '', false );

		/**
		 * Filter the Genesis CPT breadcrumb.
		 *
		 * @since 2.5.0
		 *
		 * @param string $crumb HTML markup for the CPT breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_cpt_crumb', $crumb, $this->args );

	}

	/**
	 * Return the category archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @return string HTML markup for a category archive breadcrumb.
	 */
	protected function get_category_crumb() {

		$crumb = $this->args['labels']['category'] . $this->get_term_parents( get_query_var( 'cat' ), 'category' );

		/**
		 * Filter the category archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the category archive crumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_category_crumb', $crumb, $this->args );

	}

	/**
	 * Return the tag archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @return string HTML markup for a tag archive breadcrumb.
	 */
	protected function get_tag_crumb() {

		$crumb = $this->args['labels']['tag'] . single_term_title( '', false );

		/**
		 * Filter the tag archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the tag archive crumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_tag_crumb', $crumb, $this->args );

	}

	/**
	 * Return the taxonomy archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @global WP_Query $wp_query Query object.
	 *
	 * @return string HTML markup for a taxonomy archive breadcrumb.
	 */
	protected function get_tax_crumb() {

		global $wp_query;

		$term  = $wp_query->get_queried_object();
		$crumb = $this->args['labels']['tax'] . $this->get_term_parents( $term->term_id, $term->taxonomy );

		/**
		 * Filter the taxonomy archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the taxonomy archive breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_tax_crumb', $crumb, $this->args );

	}

	/**
	 * Return the year archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @return string HTML markup for a year archive breadcrumb.
	 */
	protected function get_year_crumb() {

		$year = get_query_var( 'm' ) ? get_query_var( 'm' ) : get_query_var( 'year' );

		$crumb = $this->args['labels']['date'] . $year;

		/**
		 * Filter the year archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the year archive breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_year_crumb', $crumb, $this->args );

	}

	/**
	 * Return the month archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @return string HTML markup for a month archive breadcrumb.
	 */
	protected function get_month_crumb() {

		$year = get_query_var( 'm' ) ? mb_substr( get_query_var( 'm' ), 0, 4 ) : get_query_var( 'year' );

		$crumb  = $this->get_breadcrumb_link(
			get_year_link( $year ),
			'',
			$year,
			$this->args['sep']
		);
		$crumb .= $this->args['labels']['date'] . single_month_title( ' ', false );

		/**
		 * Filter the month archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the month archive breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_month_crumb', $crumb, $this->args );

	}

	/**
	 * Return the day archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @global mixed $wp_locale The locale object, used for getting the
	 *                          auto-translated name of the month for month or
	 *                          day archives.
	 *
	 * @return string HTML markup for a day archive breadcrumb.
	 */
	protected function get_day_crumb() {

		global $wp_locale;

		$year  = get_query_var( 'm' ) ? mb_substr( get_query_var( 'm' ), 0, 4 ) : get_query_var( 'year' );
		$month = get_query_var( 'm' ) ? mb_substr( get_query_var( 'm' ), 4, 2 ) : get_query_var( 'monthnum' );
		$day   = get_query_var( 'm' ) ? mb_substr( get_query_var( 'm' ), 6, 2 ) : get_query_var( 'day' );

		$crumb  = $this->get_breadcrumb_link(
			get_year_link( $year ),
			'',
			$year,
			$this->args['sep']
		);
		$crumb .= $this->get_breadcrumb_link(
			get_month_link( $year, $month ),
			'',
			$wp_locale->get_month( $month ),
			$this->args['sep']
		);
		$crumb .= $this->args['labels']['date'] . $day . date( 'S', mktime( 0, 0, 0, 1, $day ) );

		/**
		 * Filter the day archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the day archive breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_day_crumb', $crumb, $this->args );

	}

	/**
	 * Return the author archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @global WP_Query $wp_query Query object.
	 *
	 * @return string HTML markup for an author archive breadcrumb.
	 */
	protected function get_author_crumb() {

		global $wp_query;

		$crumb = $this->args['labels']['author'] . esc_html( $wp_query->queried_object->display_name );

		/**
		 * Filter the author archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the author archive crumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_author_crumb', $crumb, $this->args );

	}

	/**
	 * Return the post type archive crumb.
	 *
	 * @since 1.9.0
	 *
	 * @return string HTML markup for a post type archive breadcrumb.
	 */
	protected function get_post_type_crumb() {

		$crumb = $this->args['labels']['post_type'] . esc_html( post_type_archive_title( '', false ) );

		/**
		 * Filter the post type archive breadcrumb.
		 *
		 * @since 1.9.0
		 *
		 * @param string $crumb HTML markup for the post type archive breadcrumb.
		 * @param array  $args  Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		return apply_filters( 'genesis_post_type_crumb', $crumb, $this->args );

	}

	/**
	 * Return recursive linked crumbs of category, tag or custom taxonomy parents.
	 *
	 * @since 1.5.0
	 *
	 * @param int    $parent_id Initial ID of object to get parents of.
	 * @param string $taxonomy  Name of the taxonomy. May be 'category', 'post_tag' or something custom.
	 * @param bool   $link      Whether to link last item in chain. Default false.
	 * @param array  $visited   Array of IDs already included in the chain.
	 *
	 * @return string HTML markup of recursive linked crumbs of category, tag or custom taxonomy parents.
	 */
	protected function get_term_parents( $parent_id, $taxonomy, $link = false, array $visited = array() ) {

		$parent = get_term( (int) $parent_id, $taxonomy );

		if ( is_wp_error( $parent ) ) {
			return '';
		}

		if ( $parent->parent && ( $parent->parent !== $parent->term_id ) && ! in_array( $parent->parent, $visited, true ) ) {
			$visited[] = $parent->parent;
			$chain[]   = $this->get_term_parents( $parent->parent, $taxonomy, true, $visited );
		}

		if ( $link && ! is_wp_error( get_term_link( get_term( $parent->term_id, $taxonomy ), $taxonomy ) ) ) {
			$chain[] = $this->get_breadcrumb_link(
				get_term_link( get_term( $parent->term_id, $taxonomy ), $taxonomy ),
				'',
				$parent->name
			);
		} else {
			$chain[] = $parent->name;
		}

		return implode( $this->args['sep'], $chain );

	}

	/**
	 * Return markup for the wrapped link text.
	 *
	 * @since 2.7.0
	 *
	 * @param string $content The content to be wrapped.
	 * @return string HTML markup for wrapped link text.
	 */
	protected function get_breadcrumb_link_text( $content ) {

		return genesis_markup(
			array(
				'open'    => '<span %s>',
				'close'   => '</span>',
				'content' => $content,
				'context' => 'breadcrumb-link-text-wrap',
				'echo'    => false,
			)
		);

	}

	/**
	 * Return markup for a meta tag for each breadcrumb item.
	 *
	 * @since 2.7.0
	 *
	 * @return string HTML markup for meta tag.
	 */
	protected function get_breadcrumb_link_meta() {

		return genesis_markup(
			array(
				'open'    => '<meta %s>',
				'context' => 'breadcrumb-link-wrap-meta',
				'echo'    => false,
			)
		);

	}

	/**
	 * Return markup for a link wrap for each breadcrumb link.
	 *
	 * @since 2.7.0
	 *
	 * @param string $content The content to be wrapped.
	 * @return string HTML markup for link wrap.
	 */
	protected function get_breadcrumb_link_wrap( $content ) {

		return genesis_markup(
			array(
				'open'    => '<span %s>',
				'close'   => '</span>',
				'content' => $content,
				'context' => 'breadcrumb-link-wrap',
				'echo'    => false,
			)
		);

	}

	/**
	 * Return anchor link for a single crumb.
	 *
	 * @since 1.5.0
	 *
	 * @param string      $url     URL for href attribute.
	 * @param string      $title   Title attribute.
	 * @param string      $content Linked content.
	 * @param bool|string $sep     Optional. Separator. Default is empty string.
	 *
	 * @return string HTML markup for anchor link and optional separator.
	 */
	protected function get_breadcrumb_link( $url, $title, $content, $sep = '' ) {

		// Empty title, for backward compatibility.
		$title = '';

		$link = genesis_markup(
			array(
				'open'    => '<a %s>',
				'close'   => '</a>',
				'content' => $this->get_breadcrumb_link_text( $content ),
				'context' => 'breadcrumb-link',
				'params'  => array(
					'href' => $url,
				),
				'echo'    => false,
			)
		);

		/**
		 * Filter the anchor link for a single breadcrumb.
		 *
		 * @since 1.5.0
		 *
		 * @param string $link    HTML markup for anchor link, before optional separator is added.
		 * @param string $url     URL for href attribute.
		 * @param string $title   Title attribute.
		 * @param string $content Link content.
		 * @param array  $args    Arguments used to generate the breadcrumbs. Documented in Genesis_Breadcrumbs::get_output().
		 */
		$link = apply_filters( 'genesis_breadcrumb_link', $link, $url, $title, $content, $this->args );

		// Append meta tag to link markup.
		$link .= $this->get_breadcrumb_link_meta();

		// Wrap link.
		$link = $this->get_breadcrumb_link_wrap( $link );

		if ( $sep ) {
			$link .= $sep;
		}

		return $link;

	}

	/**
	 * Determine if static page is shown on front page.
	 *
	 * @return bool True if page is shown on front, false otherwise.
	 */
	protected function page_shown_on_front() {
		return 'page' === get_option( 'show_on_front' );
	}

}
