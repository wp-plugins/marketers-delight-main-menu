<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Main Menu Customizer settings
 *
 * @since 1.0
 */

function md_main_menu_customizer( $wp ) {

	// Enable Sitewide

	$wp->add_setting( 'md_layout_main_menu_enable', array(
		'sanitize_callback' => 'md_sanitize_checkbox'
	) );

	$wp->add_control( 'md_layout_main_menu_enable', array(
		'type'    => 'checkbox',
		'label'   => 'Main Menu: Enable Sitewide',
		'section' => 'md_layout',
		'priority' => 15
	) );

	// Remove Search

	$wp->add_setting( 'md_main_menu_search', array( 'sanitize_callback' => 'md_main_menu_sanitize_checkbox' ) );

	$wp->add_control( 'md_main_menu_search', array(
		'type'     => 'checkbox',
		'label'    => __( 'Main Menu: Remove Search Bar', 'md-main-menu' ),
		'section'  => 'md_layout',
		'priority' => 20
	) );

}

add_action( 'customize_register', 'md_main_menu_customizer' );


/**
 * Validate Main Menu Customizer settings
 *
 * @since 1.0
 */

function md_main_menu_sanitize_checkbox( $input ) {
	return $input ? 1 : 0;
}