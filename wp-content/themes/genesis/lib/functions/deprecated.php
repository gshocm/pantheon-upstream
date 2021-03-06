<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Deprecated
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

/**
 * Filter the Primary Navigation menu items, appending either RSS links, search form, twitter link, or today's date.
 *
 * @since 1.0.0
 * @deprecated 3.0.0
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 * @return string HTML string of list items with optional nav extras.
 *                Return early unmodified if first Genesis version is higher than 2.0.2.
 */
function genesis_nav_right( $menu, stdClass $args ) {

	_deprecated_function( __FUNCTION__, '3.0.0' );

	// Only allow if using 2.0.2 or lower.
	if ( genesis_first_version_compare( '2.0.2', '>' ) ) {
		return $menu;
	}

	if ( 'primary' !== $args->theme_location || ! genesis_get_option( 'nav_extras' ) ) {
		return $menu;
	}

	switch ( genesis_get_option( 'nav_extras' ) ) {
		case 'rss':
			$rss   = '<a rel="nofollow" href="' . get_bloginfo( 'rss2_url' ) . '">' . __( 'Posts', 'genesis' ) . '</a>';
			$rss  .= '<a rel="nofollow" href="' . get_bloginfo( 'comments_rss2_url' ) . '">' . __( 'Comments', 'genesis' ) . '</a>';
			$menu .= '<li class="right rss">' . $rss . '</li>';
			break;
		case 'search':
			$menu .= '<li class="right search">' . get_search_form( false ) . '</li>';
			break;
		case 'twitter':
			$menu .= sprintf( '<li class="right twitter"><a href="%s">%s</a></li>', esc_url( 'https://twitter.com/' . genesis_get_option( 'nav_extras_twitter_id' ) ), esc_html( genesis_get_option( 'nav_extras_twitter_text' ) ) );
			break;
		case 'date':
			$menu .= '<li class="right date">' . date_i18n( get_option( 'date_format' ) ) . '</li>';
			break;
	}

	return $menu;

}

/**
 * XHTML 1.0 Transitional doctype markup.
 *
 * @since 2.0.0
 * @deprecated 3.0.0
 */
function genesis_xhtml_doctype() {

	_deprecated_function( __FUNCTION__, '3.0.0', 'genesis_html5_doctype' );

	genesis_html5_doctype();

}

/**
 * XHTML loop.
 *
 * This is called by {@link genesis_standard_loop()} if the child theme does not support HTML5.
 *
 * It is a standard loop, and is meant to be executed, without modification, in most circumstances where content needs
 * to be displayed.
 *
 * It outputs basic wrapping HTML, but uses hooks to do most of its content output like title, content, post information
 * and comments.
 *
 * The action hooks called are:
 *
 *  - `genesis_before_post`
 *  - `genesis_before_post_title`
 *  - `genesis_post_title`
 *  - `genesis_after_post_title`
 *  - `genesis_before_post_content`
 *  - `genesis_post_content`
 *  - `genesis_after_post_content`
 *  - `genesis_after_post`
 *  - `genesis_after_endwhile`
 *  - `genesis_loop_else` (only if no posts were found)
 *
 * @since 2.0.0
 * @deprecated 3.0.0
 *
 * @global int $loop_counter Increments on each loop pass.
 */
function genesis_legacy_loop() {

	_deprecated_function( __FUNCTION__, '3.0.0', 'genesis_standard_loop' );

	genesis_standard_loop();

}

/**
 * Filter the default comment form arguments, used by `comment_form()`.
 *
 * Applies only to XHTML child themes, since Genesis uses default HTML5 comment form where possible.
 *
 * Applies `genesis_comment_form_args` filter.
 *
 * @since 1.8.0
 * @deprecated 3.0.0
 *
 * @global string $user_identity Display name of the user.
 *
 * @param array $defaults Comment form default arguments.
 * @return array Filtered comment form default arguments.
 */
function genesis_comment_form_args( array $defaults ) {

	_deprecated_function( __FUNCTION__, '3.0.0' );

	return $defaults;

}

/**
 * Comment callback for {@link genesis_default_list_comments()} if HTML5 is not active.
 *
 * Does `genesis_before_comment` and `genesis_after_comment` actions.
 *
 * Applies `comment_author_says_text` and `genesis_comment_awaiting_moderation` filters.
 *
 * @since 1.0.0
 * @deprecated 3.0.0
 *
 * @param stdClass $comment Comment object.
 * @param array    $args    Comment args.
 * @param int      $depth   Depth of current comment.
 */
function genesis_comment_callback( $comment, array $args, $depth ) {

	_deprecated_function( __FUNCTION__, '3.0.0', 'genesis_html5_comment_callback' );

	genesis_html5_comment_callback( $comment, $args, $depth );

}

/**
 * Produces the "Return to Top" link.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   href (link url, default is fragment identifier '#wrap'),
 *   nofollow (boolean for whether to make the link include the rel="nofollow"
 *     attribute. Default is true),
 *   text (Link text, default is 'Return to top of page').
 *
 * Output passes through `genesis_footer_backtotop_shortcode` filter before returning.
 *
 * @since 1.1.0
 * @deprecated 3.0.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Output for `footer_backtotop` shortcode.
 */
function genesis_footer_backtotop_shortcode( $atts ) {

	_deprecated_function( __FUNCTION__, '3.0.0' );

	$defaults = array(
		'after'    => '',
		'before'   => '',
		'href'     => '#wrap',
		'nofollow' => true,
		'text'     => __( 'Return to top of page', 'genesis' ),
	);

	$atts = shortcode_atts( $defaults, $atts, 'footer_backtotop' );

	return apply_filters( 'genesis_footer_backtotop_shortcode', '', $atts );

}

/**
 * Deprecated. Displays the notice that the theme settings were successfully updated to the latest version.
 *
 * Currently only used for pre-release update notices.
 *
 * @since 1.2.0
 * @deprecated 2.10.1
 */
function genesis_upgraded_notice() {
	 _deprecated_function( __FUNCTION__, '2.10.1' );
}

/**
 * Deprecated. Redirect the user back to the "What's New" page, refreshing the data and notifying the user that they have
 * successfully updated.
 *
 * @since 1.6.0
 * @deprecated 2.10.1
 */
function genesis_upgrade_redirect() {
	_deprecated_function( __FUNCTION__, '2.10.1' );
}

/**
 * Deprecated. Replace the default search form with a Genesis-specific form.
 *
 * `get_search_form()` suggested as replacement.
 *
 * In order to avoid an infinite loop if this function is used as a callback for the `get_search_form` filter, we load `searchform.php` directly,
 * rather than use the suggested replacement `get_search_form()`.
 *
 * @since 1.0.0
 * @deprecated 2.7.0
 */
function genesis_search_form() {

	_deprecated_function( __FUNCTION__, '2.7.0', 'get_search_form()' );

	$search_form_template = locate_template( 'searchform.php' );
	ob_start();
	require $search_form_template;
	$form = ob_get_clean();

	return $form;

}

/**
 * Deprecated. Genesis now (as of 2.7.0) uses semantic versioning, and will no longer redirect to different pages based on major/minor version status.
 *
 * Determine if a version string is considered a major release under Genesis rules.
 *
 * For Genesis, a release of something like 2.5.0 is a major release version, as is 2.6.0.
 * 2.5.1 or 2.6.2 is considered a minor release version.
 *
 * All values of `PARENT_THEME_VERSION` are given as 3 digits (5 characters), x.y.z. The major
 * release after 2.9.0 will be 3.0.0, and not 2.10.0 - Genesis does not follow semantic versioning.
 *
 * As such, we can simply check if the 4th and 5th characters until the end, are `.0`. This means
 * that a value of `2.6.0-dev` will NOT be counted as a major version.
 *
 * @since 2.6.0
 *
 * @param string $version Version number.
 * @return bool True if version has `.0` as 4th and 5th character onwards, false otherwise.
 */
function genesis_is_major_version( $version ) {

	_deprecated_function( __FUNCTION__, '2.7.0' );
	return '.0' === substr( $version, 3 );

}

/**
 * Deprecated. Output the title, wrapped in title tags.
 *
 * @since 2.1.0
 * @deprecated 2.6.0
 */
function genesis_do_title() {

	_deprecated_function( __FUNCTION__, '2.6.0', "add_theme_support( 'title-tag' )" );

	if ( get_theme_support( 'title-tag' ) ) {
		return;
	}
	echo '<title>';
	wp_title( '' );
	echo '</title>';

}

/**
 * Deprecated. Legacy filter function that would return a filtered document title.
 *
 * @since 1.0.0
 * @deprecated 2.6.0
 *
 * @param string $title       Existing page title.
 * @param string $sep         Optional. Separator character(s).
 * @param string $seplocation Optional. Separator location - "left" or "right".
 * @return string Page title.
 */
function genesis_default_title( $title, $sep = '&raquo;', $seplocation = '' ) {

	_deprecated_function( __FUNCTION__, '2.6.0', 'Genesis_SEO_Document_Title_Parts' );

	return $title;

}

/**
 * Deprecated. Return registered image sizes.
 *
 * Return a two-dimensional array of just the additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since 1.0.0
 * @deprecated 2.5.0
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 *
 * @return array Two-dimensional, with `width`, `height` and `crop` sub-keys.
 */
function genesis_get_additional_image_sizes() {

	_deprecated_function( __FUNCTION__, '2.5.0', 'wp_get_additional_image_sizes' );

	return wp_get_additional_image_sizes();
}

/**
 * Deprecated. A list of Genesis contributors for the current development cycle.
 *
 * @since 2.0.0
 * @deprecated 2.5.0
 *
 * @return array List of contributors.
 */
function genesis_contributors() {

	_deprecated_function( __FUNCTION__, '2.5.0', 'Genesis_Contributors::find_contributors' );

	$people               = require GENESIS_CONFIG_DIR . '/contributors.php';
	$genesis_contributors = new Genesis_Contributors( $people );

	// The original function didn't contain the logic to shuffle the list, so we use the un-shuffled list here.
	foreach ( $genesis_contributors->find_by_role( 'contributor' ) as $key => $contributor ) {
		// The collection object currently returns an array of Genesis_Contributor object, so it can't
		// support a to_array() method where this logic would go.
		$contributors[ $key ]['name']     = $contributor->get_name();
		$contributors[ $key ]['url']      = $contributor->get_profile_url();
		$contributors[ $key ]['gravatar'] = $contributor->get_avatar_url();
	}

	return $contributors;
}

/**
 * Deprecated. Register the scripts that Genesis will use.
 *
 * @since 2.0.0
 * @deprecated 2.5.0
 */
function genesis_register_scripts() {

	_deprecated_function( __FUNCTION__, '2.5.0' );

}

/**
 * Deprecated. Enqueue the scripts used on the front-end of the site.
 *
 * Includes comment-reply, superfish and the superfish arguments.
 *
 * Applies the `genesis_superfish_enabled`, and `genesis_superfish_args_uri`. filter.
 *
 * @since 1.0.0
 * @deprecated 2.5.0
 */
function genesis_load_scripts() {

	_deprecated_function( __FUNCTION__, '2.5.0' );

}

/**
 * Deprecated. Conditionally enqueue the scripts used in the admin.
 *
 * Includes Thickbox, theme preview and a Genesis script (actually enqueued in genesis_load_admin_js()).
 *
 * @since 1.0.0
 * @deprecated 2.5.0
 *
 * @param string $hook_suffix Admin page identifier.
 */
function genesis_load_admin_scripts( $hook_suffix ) {

	_deprecated_function( __FUNCTION__, '2.5.0' );

}

/**
 * Deprecated. Enqueues the custom script used in the admin, and localizes several strings or values used in the scripts.
 *
 * Applies the `genesis_toggles` filter to toggleable admin settings, so plugin developers can add their own without
 * having to recreate the whole setup.
 *
 * @since 1.8.0
 * @deprecated 2.5.0
 */
function genesis_load_admin_js() {

	_deprecated_function( __FUNCTION__, '2.5.0', 'genesis_scripts()->enqueue_and_localize_admin_scripts()' );

	genesis_scripts()->enqueue_and_localize_admin_scripts();

}

/**
 * Deprecated. Load the html5 shiv for IE8 and below. Can't enqueue with IE conditionals.
 *
 * @since 2.0.0
 * @deprecated 2.3.0
 */
function genesis_html5_ie_fix() {

	_deprecated_function( __FUNCTION__, '2.3.0' );

}

/**
 * Deprecated. Echo custom rel="author" link tag.
 *
 * If the appropriate information has been entered, either for the homepage author, or for an individual post/page
 * author, echo a custom rel="author" link.
 *
 * @since 1.9.0
 * @deprecated 2.2.0
 */
function genesis_rel_author() {

	_deprecated_function( __FUNCTION__, '2.2.0' );

}

/**
 * Deprecated. Echo custom rel="publisher" link tag.
 *
 * If the appropriate information has been entered and we are viewing the front page, echo a custom rel="publisher" link.
 *
 * @since 2.0.2
 * @deprecated 2.2.0
 */
function genesis_rel_publisher() {

	_deprecated_function( __FUNCTION__, '2.2.0' );

}

/**
 * Deprecated. Echo or return a pages or categories menu.
 *
 * The array of menu arguments (and their defaults) are:
 *
 *  - theme_location => ''
 *  - type           => 'pages'
 *  - sort_column    => 'menu_order, post_title'
 *  - menu_id        => false
 *  - menu_class     => 'nav'
 *  - echo           => true
 *  - link_before    => ''
 *  - link_after     => ''
 *
 * Themes can short-circuit the function early by filtering on `genesis_pre_nav` or on the string of list items via
 * `genesis_nav_items`. They can also filter the complete menu markup via `genesis_nav`. The `$args` (merged with
 * defaults) are available for all filters.
 *
 * @since 1.0.0
 * @deprecated 2.2.0
 *
 * @see genesis_do_nav()
 * @see genesis_do_subnav()
 *
 * @param array $args Menu arguments.
 * @return null|string HTML for menu, unless `genesis_pre_nav` filter returns something truthy.
 */
function genesis_nav( $args = array() ) {

	_deprecated_function( __FUNCTION__, '2.2.0', 'genesis_nav_menu' );

	if ( isset( $args['context'] ) ) {
		_deprecated_argument( __FUNCTION__, '1.2', esc_html__( 'The argument, "context", has been replaced with "theme_location" in the $args array.', 'genesis' ) );
	}

	// Default arguments.
	$defaults = array(
		'theme_location' => '',
		'type'           => 'pages',
		'sort_column'    => 'menu_order, post_title',
		'menu_id'        => false,
		'menu_class'     => 'nav',
		'echo'           => true,
		'link_before'    => '',
		'link_after'     => '',
	);

	$defaults = apply_filters( 'genesis_nav_default_args', $defaults );
	$args     = wp_parse_args( $args, $defaults );

	// Allow child theme to short-circuit this function.
	$pre = apply_filters( 'genesis_pre_nav', false, $args );
	if ( $pre ) {
		return $pre;
	}

	$menu = '';

	$list_args = $args;

	// Show Home in the menu (mostly copied from WP source).
	if ( isset( $args['show_home'] ) && ! empty( $args['show_home'] ) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] ) {
			$text = apply_filters( 'genesis_nav_home_text', __( 'Home', 'genesis' ), $args );
		} else {
			$text = $args['show_home'];
		}

		if ( is_front_page() && ! is_paged() ) {
			$class = 'class="home current_page_item"';
		} else {
			$class = 'class="home"';
		}

		$home = '<li ' . $class . '><a href="' . trailingslashit( home_url() ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';

		$menu .= genesis_get_seo_option( 'nofollow_home_link' ) ? genesis_rel_nofollow( $home ) : $home;

		// If the front page is a page, add it to the exclude list.
		if ( 'pages' === $args['type'] && 'page' === get_option( 'show_on_front' ) ) {
			$list_args['exclude'] .= $list_args['exclude'] ? ',' : '';

			$list_args['exclude'] .= get_option( 'page_on_front' );
		}
	}

	$list_args['echo']     = false;
	$list_args['title_li'] = '';

	// Add menu items.
	if ( 'pages' === $args['type'] ) {
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages( $list_args ) );
	} elseif ( 'categories' === $args['type'] ) {
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_categories( $list_args ) );
	}

	// Apply filters to the nav items.
	$menu = apply_filters( 'genesis_nav_items', $menu, $args );

	$menu_class = $args['menu_class'] ? ' class="' . esc_attr( $args['menu_class'] ) . '"' : '';
	$menu_id    = $args['menu_id'] ? ' id="' . esc_attr( $args['menu_id'] ) . '"' : '';

	if ( $menu ) {
		$menu = '<ul' . $menu_id . $menu_class . '>' . $menu . '</ul>';
	}

	// Apply filters to the final nav output.
	$menu = apply_filters( 'genesis_nav', $menu, $args );

	if ( $args['echo'] ) {
		echo $menu;

		return null;
	} else {
		return $menu;
	}

}

/**
 * Deprecated. Wraps the page title in a `title` element.
 *
 * Only applies, if not currently in admin, or for a feed.
 *
 * @since 1.3.0
 * @deprecated 2.1.0
 *
 * @param string $title Page title.
 *  @return string Plain text title if feed or WP admin, or title in HTML markup.
 */
function genesis_doctitle_wrap( $title ) {

	_deprecated_function( __FUNCTION__, '2.1.0' );

	return is_feed() || is_admin() ? $title : sprintf( "<title>%s</title>\n", $title );

}

/**
 * Deprecated. Push individual setting (or group of setting) into an options db entry stored as an array.
 *
 * @since 1.7.0
 * @deprecated 2.1.0
 *
 * @param string|array $new     New settings. Can be a string, or an array.
 * @param string       $setting Optional. Settings field name. Default is GENESIS_SETTINGS_FIELD.
 */
function _genesis_update_settings( $new, $setting = null ) {

	_deprecated_function( __FUNCTION__, '2.1.0', 'genesis_update_setting' );

	genesis_update_settings( $new, $setting );

}

/**
 * Deprecated. Used to output archive pagination in older/newer format.
 *
 * Should now use `genesis_prev_next_posts_nav()` instead.
 *
 * @since 1.0.0
 * @deprecated 2.0.0
 */
function genesis_older_newer_posts_nav() {

	_deprecated_function( __FUNCTION__, '2.0.0', 'genesis_prev_next_posts_nav' );

	genesis_prev_next_posts_nav();

}

/**
 * Deprecated. Show Parent and Child information in the document head if specified by the user.
 *
 * This can be helpful for diagnosing problems with the theme, because you can easily determine if anything is out of
 * date, needs to be updated.
 *
 * @since 1.0.0
 * @deprecated 2.0.0
 *
 * @return void Return early if `show_info` setting is falsy, or not a child theme.
 */
function genesis_show_theme_info_in_head() {

	_deprecated_function( __FUNCTION__, '2.0.0', esc_html__( 'data in style sheet files', 'genesis' ) );

	if ( ! genesis_get_option( 'show_info' ) ) {
		return;
	}

	// Show Parent Info.
	echo "\n" . '<!-- Theme Information -->' . "\n";
	echo '<meta name="wp_template" content="' . esc_attr( PARENT_THEME_NAME ) . ' ' . esc_attr( PARENT_THEME_VERSION ) . '" />' . "\n";

	// If there is no child theme, don't continue.
	if ( ! is_child_theme() ) {
		return;
	}

	// Show Child Info.
	$child_info = wp_get_theme();
	echo '<meta name="wp_theme" content="' . esc_attr( $child_info['Name'] ) . ' ' . esc_attr( $child_info['Version'] ) . '" />' . "\n";

}

/**
 * Deprecated. Helper function for dealing with entities.
 *
 * It passes text through the g_ent filter so that entities can be converted on-the-fly.
 *
 * @since 1.5.0
 * @deprecated 2.0.0
 *
 * @param string $text Optional string containing an entity.
 * @return mixed Return a string by default, but might be filtered to return another type.
 */
function g_ent( $text = '' ) { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- Deprecated function name.

	_deprecated_function( __FUNCTION__, '2.0.0', esc_html__( 'decimal or hexidecimal entities', 'genesis' ) );

	return apply_filters( 'g_ent', $text ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Deprecated filter name.

}

/**
 * Deprecated. Remove the Genesis theme files from the Theme Editor, except when Genesis is the current theme.
 *
 * @since 1.4.0
 * @deprecated 2.0.0
 */
function genesis_theme_files_to_edit() {

	_deprecated_function( __FUNCTION__, '2.0.0' );

}

/**
 * Deprecated. Add links to the contents of a tweet.
 *
 * Takes the content of a tweet, detects @replies, #hashtags, and http:// URLs, and links them appropriately.
 *
 * @since 1.1.0
 * @deprecated 2.0.0
 *
 * @link http://www.snipe.net/2009/09/php-twitter-clickable-links/
 *
 * @param string $text A string representing the content of a tweet.
 * @return string Tweet content with added links.
 */
function genesis_tweet_linkify( $text ) {

	_deprecated_function( __FUNCTION__, '2.0.0' );

	$text = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", '\\1<a href="\\2" target="_blank" rel="noopener noreferrer">\\2</a>', $text );
	$text = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", '\\1<a href="http://\\2" target="_blank" rel="noopener noreferrer">\\2</a>', $text );
	$text = preg_replace( '/@(\w+)/', '<a href="http://www.twitter.com/\\1" target="_blank" rel="noopener noreferrer">@\\1</a>', $text );
	$text = preg_replace( '/#(\w+)/', '<a href="http://search.twitter.com/search?q=\\1" target="_blank" rel="noopener noreferrer">#\\1</a>', $text );

	return $text;

}

/**
 * Deprecated. Provide a callback function for the custom header admin page.
 *
 * @since 1.6.0
 * @deprecated 2.0.0
 */
function genesis_custom_header_admin_style() {

	_deprecated_function( __FUNCTION__, '2.0.0' );

}
