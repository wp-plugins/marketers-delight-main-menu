<nav id="main-menu" class="main-menu box-sec <?php echo md_main_menu_has_menu( 'main' ) ? 'has-menu-main' : 'main-menu-simple block-single-tb text-center'; ?>">

	<div class="inner">

		<?php if ( md_main_menu_items() ) : // does the main menu have any content? ?>

			<!-- Triggers -->

			<div id="main-menu-triggers" class="main-menu-triggers close-on-desktop <?php echo md_menu_triggers_classes(); ?>">

				<?php if ( md_main_menu_has_menu( 'main' ) ) : ?>

					<!-- Menu Main Trigger -->

					<span id="menu-trigger-menu" class="menu-trigger-menu menu-trigger col">
						<i class="md-icon md-icon-menu"></i> <span class="menu-trigger-text close-on-mobile"><?php echo md_get_menu_name( 'main' ); ?></span>
					</span>

				<?php endif; ?>

				<?php do_action( 'md_hook_main_menu_triggers' ); ?>

				<?php if ( md_has_menu_search() ) : ?>

					<!-- Search Trigger -->

					<span id="menu-trigger-search" class="menu-trigger-search menu-trigger col">
						<i class="md-icon md-icon-search"></i> <span class="menu-trigger-text close-on-desktop close-on-mobile"><?php _e( 'Search', 'kol-main-menu' ); ?></span>
					</span>

				<?php endif; ?>

				<?php if ( md_main_menu_has_menu( 'social' ) ) : ?>

					<!-- Social Trigger -->

					<span id="menu-trigger-social" class="menu-trigger-social menu-trigger col">
						<i class="md-icon md-icon-user-add"></i> <span class="menu-trigger-text close-on-mobile"><?php echo md_get_menu_name( 'social' ); ?></span>
					</span>

				<?php endif; ?>

			</div>

			<?php if ( md_main_menu_has_menu( 'main' ) ) : ?>

				<!-- Menu Main -->

				<?php wp_nav_menu( array(
					'theme_location' => 'main',
					'menu'           => md_main_menu_custom_menu(),
					'container'      => false,
					'fallback_cb'    => false,
					'items_wrap'     => '<ul id="main-menu-menu" class="%2$s menu-main menu-content menu close-on-max">%3$s</ul>',
					'walker'         => new md_main_menu_walker( true, true )
				) ); ?>

			<?php endif; ?>

			<div id="main-menu-side" class="main-menu-side clear">

				<?php if ( md_has_menu_search() ) : ?>

					<!-- Search Form -->

					<?php md_main_menu_search(); ?>

				<?php endif; ?>

				<?php if ( md_main_menu_has_menu( 'social' ) ) : ?>

					<!-- Social Menu -->

					<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'container'      => false,
						'fallback_cb'    => false,
						'menu_id'        => 'main-menu-social',
						'menu_class'     => 'menu-social menu menu-content close-on-max',
						'depth'          => 1,
						'walker'         => new md_main_menu_walker( false )
					) ); ?>

				<?php endif; ?>

			</div>

			<?php do_action( 'md_hook_main_menu_content' ); ?>

		<?php endif; ?>

	</div>

</nav>