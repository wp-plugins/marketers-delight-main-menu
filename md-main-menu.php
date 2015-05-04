<?php
/**
 * Plugin Name: Marketers Delight Main Menu
 * Plugin URI: https://kolakube.com/
 * Description: Display a menu with dropdown navigation, social media icons, a search bar, and more to your site. This plugin requires the Marketers Delight Theme and Plugin to be installed and updated to the latest version.
 * Version: 1.0.1
 * Author: Alex Mangini
 * Author URI: https://kolakube.com/about/
 * Author email: alexfrais@gmail.com
 * Requires at least: WordPress 3.8
 * Text Domain: md-main-menu
 *
 * This plugin is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see http://www.gnu.org/licenses/.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Constants

define( 'MD_MAIN_MENU_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'MD_MAIN_MENU_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );


/**
 * Initializes the Main menu.
 *
 * @since 1.0
 */

class md_main_menu_init {

	public function __construct() {
		load_plugin_textdomain( 'md-main-menu', false, MD_MAIN_MENU_DIR . 'languages/' );
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}


	/**
	 * Loads all the important stuff that make this plugin run.
	 *
	 * @since 1.0
	 */

	public function init() {
		if ( class_exists( 'md_api' ) )
			require_once( 'admin/meta-box.php' );

		require_once( 'admin/customizer.php' );
		require_once( 'functions/template-functions.php' );
		require_once( 'functions/js.php' );
		require_once( 'functions/walker.php' );

		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'md_hook_after_header', array( $this, 'display' ) );
	}


	/**
	 * Add Main Menu data to Addons data array.
	 *
	 * @since 1.0
	 */

	public function activate() {
		global $wp_query;

		$data = get_option( 'md_addons' );
		$id   = $wp_query->get_queried_object_id();

		$nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		$menus     = array();

		foreach ( $nav_menus as $menu )
			$menus[] = $menu->slug;

		$data['layout']['meta'] = array(
			'md_layout_main_menu' => array(
				'type'    => 'checkbox',
				'options' => array( 'add', 'remove' )
			),
			'md_layout_main_menu_menu' => array(
				'type'    => 'select',
				'options' => $menus
			)
		);

		$data['layout']['global'] = array(
			'main_menu' => array(
				'site'  => array(
					'add' => get_theme_mod( 'md_layout_main_menu_enable' )
				),
				'single' => get_post_meta( $id, 'md_layout_main_menu', true )
			)
		);

		update_option( 'md_addons', $data );
	}


	/**
	 * Remove Main Menu data from Addons data array.
	 *
	 * @since 1.0
	 */

	public function deactivate() {
		$data = get_option( 'md_addons' );

		unset( $data['layout']['meta']['md_layout_main_menu'] );
		unset( $data['layout']['meta']['md_layout_main_menu_menu'] );
		unset( $data['layout']['global']['main_menu'] );

		update_option( 'md_addons', $data );
	}


	/**
	 * Registers menus.
	 *
	 * @since 1.0
	 */

	public function register_menus() {
		register_nav_menus( array(
			'main'   => __( 'Main Menu', 'md-main-menu' ),
			'social' => __( 'Social Media Menu', 'md-main-menu' )
		) );
	}


	/**
	 * Enqueue stylesheet where it's needed.
	 *
	 * @since 1.0
	 */

	public function enqueue() {
		if ( ! md_has_main_menu() )
			return;

		$css = ! file_exists( get_stylesheet_directory() . '/css/main-menu.css' ) ? MD_MAIN_MENU_URL . 'css/main-menu.css' : get_stylesheet_directory_uri() . '/css/main-menu.css';

		wp_enqueue_style( 'main-menu', $css, array(), '1.0', 'all' );
	}


	/**
	 * Load main menu template file. This template file can
	 * be overwritten in a parent/child theme by recreating
	 * the file structure and copying the code into your theme.
	 *
	 * @since 1.0
	 */

	public function display() {
		if ( ! md_has_main_menu() )
			return;

		$path = 'templates/main-menu.php';

		if ( $template = locate_template( $path ) )
			load_template( $template );
		else
			load_template( dirname( __FILE__ ) . "/$path" );
	}

}

$main_menu = new md_main_menu_init;