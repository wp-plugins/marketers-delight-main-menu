<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Checks if Main Menu has any active fields. This gets tricky.
 *
 * @since 1.0
 */

function md_has_main_menu() {
	global $wp_query;

	$site_add = get_theme_mod( 'md_layout_main_menu_enable' );

	$single           = get_post_meta( $wp_query->get_queried_object_id(), 'md_layout_main_menu', true );
	$single['add']    = isset( $single['add'] ) ? $single['add'] : '';
	$single['remove'] = isset( $single['remove'] ) ? $single['remove'] : '';

	if ( is_single() && ! empty( $site_add ) && ! empty( $single['remove'] ) )
		return false;
	elseif (
		(
			( ( ! empty( $site_add ) && is_singular() ) || ( is_home() || is_archive() ) ) ||
			( ! empty ( $single['add'] ) && is_singular() )
		) &&

		( md_main_menu_has_menu( 'main' )   ||
		  md_main_menu_has_menu( 'social' ) ||
		  md_has_menu_search()              ||
		  has_action( 'md_hook_main_menu_content' )
		)
	)
		return true;
}


/**
 * Counts how many fields are active in Main menu.
 *
 * @since 1.0
 */

function md_main_menu_items() {
	return count( array_filter( array(
		md_main_menu_has_menu( 'main' ),
		md_main_menu_has_menu( 'social' ),
		md_has_menu_search()
	) ) );
}


/**
 * Checks if menu exists. This is a more thorough check
 * than has_nav_menu() because it also checks if the active
 * menu has any menu items.
 *
 * @since 1.0
 */

function md_main_menu_has_menu( $menu ) {
	$has_items = wp_nav_menu( array( 'theme_location' => $menu, 'fallback_cb' => false, 'echo' => false ) );

	if ( has_nav_menu( $menu ) && ! empty( $has_items ) )
		return true;
}


/**
 * Load searchform template. The searchform template can be
 * overriden in your child/parent theme's folder by dropping
 * templates/search-form-main-menu.php into it.
 *
 * @since 1.0
 */

function md_main_menu_search() {
	$path = 'templates/searchform-main-menu.php';

	if ( $template = locate_template( $path ) )
		load_template( $template );
	else
		load_template( MD_MAIN_MENU_DIR . $path );
}


/**
 * Check if menu has search bar enabled from Customizer.
 *
 * @since 1.0
 */

function md_has_menu_search() {
	if ( ! get_theme_mod( 'md_main_menu_search' ) )
		return true;
}


/**
 * Outputs classes that control the menu triggers.
 *
 * @since 1.0
 */

function md_menu_triggers_classes() {
	return ( 'columns-' . md_main_menu_items() ) . ( ! md_has_menu_search() ? ' close-on-desktop' : '' ) . ( md_main_menu_has_menu( 'social' ) ? ' main-menu-triggers-sep' : '' );
}


/**
 * Returns custom page nav menu.
 *
 * @since 1.0
 */

function md_main_menu_custom_menu() {
	global $wp_query;

	return get_post_meta( $wp_query->get_queried_object_id(), 'md_layout_main_menu_menu', true );
}


/**
 * Outputs the menu name assigned to the specified Menu area.
 *
 * @since 1.0
 */

function md_get_menu_name( $menu ) {
	$menus       = get_nav_menu_locations();
	$menu_object = wp_get_nav_menu_object( $menus[$menu] );
	$menu_name   = isset( $menu_object->name ) ? $menu_object->name : __( 'Menu', 'md-main-menu' );

	return esc_html( $menu_name );
}