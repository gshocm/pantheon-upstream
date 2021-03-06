<?php

// includes/gle-options-zigzagpress

/**
 * Prevent direct access to this file.
 *
 * @since 1.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Third meta box - optional: setting up the setting fields & labels.
 *    For supported 'ZigZagPress' child themes with CPTs.
 *
 * @since 1.6.0
 *
 * @see   DDW_GLE_Plugin_Settings::help() in /includes/gle-admin-options.php
 *
 * @uses  post_type_exists()
 * @uses  ddw_genesis_layout_extras_option()
 * @uses  CHILD_THEME_NAME
 */
function ddw_genesis_layout_extras_box_zigzagpress() {

	/** Description - user info: Child Theme generated special Custom Post Type sections */
	echo '<h4>' . __( 'Special Custom Post Type Sections', 'genesis-layout-extras' ) . '</h4>';

		echo '<p><span class="description">' . __( 'Here you can set up a <strong>default</strong> layout option for various extra archive pages generated by Custom Post Types which were set by child themes.', 'genesis-layout-extras' ) . ' ' . sprintf(
				/* translators: %1$s - opening HTML code tag / %2$s - closing HTML code tag / %3$s - label "Genesis layout settings" */
				__( '%1$sGenesis Default%2$s in the drop-down menus below always means the chosen default layout option in the regular %3$s.', 'genesis-layout-extras' ),
				'<code style="font-style: normal; color: #333;">',
				'</code>',
				'<a href="' . esc_url( admin_url( 'admin.php?page=genesis#genesis-theme-settings-layout' ) ) . '">' . __( 'Genesis layout settings', 'genesis-layout-extras' ) . '</a>'
			) . '</span></p>';

	/** Child Themes by ZigZagPress: Bijou, Engrave, Eshop, Megalithe, Single, Solo, Tequila, Vanilla */
	if ( post_type_exists( 'portfolio' ) ) {

		if ( CHILD_THEME_NAME == 'Megalithe' ) {
			$gle_zzp_theme_check = 'Megalithe';
		} elseif ( CHILD_THEME_NAME == 'Engrave Theme' ) {
			$gle_zzp_theme_check = 'Engrave';
		} elseif ( CHILD_THEME_NAME == 'Vanilla' ) {
			$gle_zzp_theme_check = 'Vanilla';
		} elseif ( CHILD_THEME_NAME == 'Solo' ) {
			$gle_zzp_theme_check = 'Solo';
		} elseif ( CHILD_THEME_NAME == 'Bijou' ) {
			$gle_zzp_theme_check = 'Bijou';
		} elseif ( CHILD_THEME_NAME == 'Eshop' ) {
			$gle_zzp_theme_check = 'Eshop';
		} elseif ( CHILD_THEME_NAME == 'Single' ) {
			$gle_zzp_theme_check = 'Single';
		} elseif ( CHILD_THEME_NAME == 'Tequila' ) {
			$gle_zzp_theme_check = 'Tequila';
		}

		$gle_zzp_theme = sprintf(
			/* translators: %s - name of a child theme from ZigZagPress brand */
			__( 'Child Theme: %s by ZigZagPress', 'genesis-layout-extras' ),
			$gle_zzp_theme_check
		);

		echo '<hr class="div" />';

		echo '<h4>' . $gle_zzp_theme . '</h4>';

			ddw_genesis_layout_extras_option(
				__( 'Portfolio Post Type Layout (archive)', 'genesis-layout-extras' ) . ': ',
				'ddw_genesis_layout_cpt_child_portfolio'
			);

			ddw_genesis_layout_extras_option(
				__( 'Portfolio Categories Taxonomy Layout', 'genesis-layout-extras' ) . ': ',
				'ddw_genesis_layout_cpt_child_portfolio_category'
			);

			ddw_gle_save_button();

	}  // end-if zigzagpress portfolio check

}  // end function
