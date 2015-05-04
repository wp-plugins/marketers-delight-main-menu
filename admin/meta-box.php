<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Adds meta box settings on Edit screen to hide the Main Menu on a page-per-page basis.
 * Field save data is added to md_addons array upon plugin activation.
 *
 * @since 1.0
 */

class md_main_menu extends md_api {

	/**
	 * Creates options environment and adds fields to Layout Meta Box in theme.
	 *
	 * @since 1.0
	 */

	public function construct() {
		$this->suite = $this->_id = 'md_layout';

		$this->meta_box = array();

		$this->site = get_theme_mod( 'md_layout_main_menu_enable' );

		add_action( 'md_layout_after_header', array( $this, 'fields' ) );
	}


	/**
	 * Print toggle script to admin footer.
	 *
	 * @since 1.0
	 */

	public function admin_print_footer_scripts() { ?>

		<script>

			( function() {

				<?php if ( ! empty( $this->site ) ) : ?>

					document.getElementById( 'md_layout_main_menu_remove' ).onchange = function( e ) {
						document.getElementById( 'main-menu-options' ).style.display = this.checked ? 'none' : 'block';
					}

				<?php else : ?>

					document.getElementById( 'md_layout_main_menu_add' ).onchange = function( e ) {
						document.getElementById( 'main-menu-options' ).style.display = this.checked ? 'block' : 'none';
					}

				<?php endif; ?>

			} )();

		</script>

	<?php }


	/**
	 * Build meta box form settings.
	 *
	 * @since 1.0
	 */

	public function fields() {
		$post_type = get_post_type();

		$nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		$menus     = array( '' => __( 'Select a custom menu&hellip;', 'md-main-menu' ) );

		foreach ( $nav_menus as $menu )
			$menus[$menu->slug] = $menu->name;

		$main_menu = get_post_meta( get_the_ID(), 'md_layout_main_menu', true );

		$main_menu['add']    = isset( $main_menu['add'] ) ? $main_menu['add'] : '';
		$main_menu['remove'] = isset( $main_menu['remove'] ) ? $main_menu['remove'] : '';

		$display =
			( empty( $this->site ) && ! empty( $main_menu['add'] ) ) ||
			( ! empty( $this->site ) && empty( $main_menu['remove'] ) )
		? 'block' : 'none';

		$main_menu_meta = empty( $this->site ) ?
			array( 'add'    => __( 'Add <b>Main Menu</b>', 'md-main-menu' ) )
		:
			array( 'remove' => __( 'Remove <b>Main Menu</b>', 'md-main-menu' ) );
	?>

		<!-- Add / Remove -->

		<tr>
			<td>

				<p class="md-title"><?php _e( 'Main Menu', 'md' ); ?></p>

				<?php $this->field( 'checkbox', 'main_menu', $main_menu_meta ); ?>

				<p id="main-menu-options" style="display: <?php echo $display; ?>; margin-top: 10px;">
					<?php $this->field( 'select', 'main_menu_menu', array_merge(
						array( '' => __( 'Set a custom menu', 'md-main-menu' ) ),
						$menus
					) ); ?>
				</p>

			</td>
		</tr>

	<?php }
}

new md_main_menu;