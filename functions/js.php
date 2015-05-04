<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This function prints inline JavaScript to the
 * site's footer based on which settings are enabled.
 *
 * printing all this inline to the footer feels dirty... look into it.
 * maybe just a wp_localize_script to a js file thing
 *
 * @since 1.0
 */

if ( ! function_exists( 'md_main_menu_js' ) ) :

	function md_main_menu_js() {
		if ( ! md_has_main_menu() )
			return;
	?>

		<script>

			<?php if ( md_has_menu_search() ) : ?>

				/* Search */

				document.getElementById( 'menu-desktop-trigger-search' ).onclick = function( e ) {
					apollo.removeClass( document.getElementById( 'main-menu-search' ), 'close-on-desktop' );
					apollo.addClass( document.getElementById( 'menu-desktop-trigger-search' ), 'close-on-desktop' );
					apollo.addClass( document.getElementById( 'main-menu-side' ), 'main-menu-side-search' );

					<?php if ( md_has_menu( 'social' ) ) : ?>
						// social
						apollo.addClass( document.getElementById( 'main-menu-social' ), 'close-on-desktop' );
					<?php endif; ?>

					document.getElementById( 'menu-search-input' ).focus();

					e.preventDefault();
				}

				document.getElementById( 'menu-trigger-search' ).onclick = function( e ) {
					// search
					apollo.toggleClass( document.getElementById( 'menu-trigger-search' ), 'menu-trigger-active' );
					apollo.toggleClass( document.getElementById( 'main-menu-search' ), 'close-on-max' );

					<?php if ( md_has_menu( 'social' ) ) : ?>
						// social
						apollo.removeClass( document.getElementById( 'menu-trigger-social' ), 'menu-trigger-active' );
						apollo.addClass( document.getElementById( 'main-menu-social' ), 'close-on-max' );
					<?php endif; ?>

					<?php if ( md_has_menu( 'main' ) ) : ?>
						// menu
						apollo.removeClass( document.getElementById( 'menu-trigger-menu' ), 'menu-trigger-active' );
						apollo.addClass( document.getElementById( 'main-menu-menu' ), 'close-on-max' );
					<?php endif; ?>

					document.getElementById( 'menu-search-input' ).focus();

					e.preventDefault();
				}

				document.onclick = function( e ) {
					var target = e.target || e.srcElement;

					do {
						if ( document.getElementById( 'main-menu' ) === target )
							return;

						target = target.parentNode;
					}
					while ( target ) {
						apollo.addClass( document.getElementById( 'main-menu-search' ), 'close-on-desktop' );
						apollo.removeClass( document.getElementById( 'menu-desktop-trigger-search' ), 'close-on-desktop' );
						apollo.removeClass( document.getElementById( 'main-menu-side' ), 'main-menu-side-search' );

						// search
//						apollo.addClass( document.getElementById( 'main-menu-search' ), 'close-on-desktop' );
						apollo.addClass( document.getElementById( 'main-menu-search' ), 'close-on-max' );
						apollo.removeClass( document.getElementById( 'menu-trigger-search' ), 'menu-trigger-active' );

						<?php if ( md_has_menu( 'social' ) ) : ?>
							// social
							apollo.removeClass( document.getElementById( 'main-menu-social' ), 'close-on-desktop' );
						<?php endif; ?>
					}
				}

			<?php endif; ?>

			<?php if ( md_has_menu( 'main' ) ) : ?>

				/* Main Menu */

				document.getElementById( 'menu-trigger-menu' ).onclick = function( e ) {

					apollo.toggleClass( document.getElementById( 'main-menu-menu' ), 'close-on-max' );
					apollo.toggleClass( document.getElementById( 'menu-trigger-menu' ), 'menu-trigger-active' );

					<?php if ( md_has_menu_search() ) : ?>
						// search
						apollo.addClass( document.getElementById( 'main-menu-search' ), 'close-on-max' );
						apollo.removeClass( document.getElementById( 'menu-trigger-search' ), 'menu-trigger-active' );
					<?php endif; ?>

					<?php if ( md_has_menu( 'social' ) ) : ?>
						// social
						apollo.addClass( document.getElementById( 'main-menu-social' ), 'close-on-max' );
						apollo.removeClass( document.getElementById( 'menu-trigger-social' ), 'menu-trigger-active' );
					<?php endif; ?>

					e.preventDefault();
				}

			<?php endif; ?>

			<?php if ( md_has_menu( 'social' ) ) : ?>

				/* Social */

				document.getElementById( 'menu-trigger-social' ).onclick = function( e ) {

					apollo.toggleClass( document.getElementById( 'main-menu-social' ), 'close-on-max' );
					apollo.toggleClass( document.getElementById( 'menu-trigger-social' ), 'menu-trigger-active' );

					<?php if ( md_has_menu( 'main' ) ) : ?>
						// main menu
						apollo.addClass( document.getElementById( 'main-menu-menu' ), 'close-on-max' );
						apollo.removeClass( document.getElementById( 'menu-trigger-menu' ), 'menu-trigger-active' );
					<?php endif; ?>

					<?php if ( md_has_menu_search() ) : ?>
						// search
						apollo.addClass( document.getElementById( 'main-menu-search' ), 'close-on-max' );
						apollo.removeClass( document.getElementById( 'menu-trigger-search' ), 'menu-trigger-active' );
					<?php endif; ?>

					e.preventDefault();
				}

			<?php endif; ?>

		</script>

	<?php }

endif;

add_action( 'md_hook_js', 'md_main_menu_js' );