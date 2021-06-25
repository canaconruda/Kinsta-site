<header id="masthead" class="site-header header-2" role="banner" style="<?php freshio_header_styles(); ?>">
	
	<?php if (freshio_get_theme_option('welcome-message') ):?>
	<div class="header-top desktop-hide-down">
		<div class="container">
			<div class="row align-items-center">
				<div class="column-6 column-tablet-8">
					<?php
					freshio_site_welcome();
					?>
				</div>				
			</div>
		</div>
	</div>
	<?php endif;?>
	<div class="header-main">
		<div class="inner">
			<div class="left">
				<?php

				freshio_site_branding();
				if (freshio_is_woocommerce_activated()) {
					?>
					<div class="site-header-cart header-cart-mobile">
						<?php freshio_cart_link(); ?>
					</div>
					<?php
				}
				freshio_mobile_nav_button();
				?>
			</div>
			<div class="center desktop-hide-down">
				<?php
				if (freshio_is_woocommerce_activated()) {
					freshio_product_search();
				} else {
					?>
					<div class="site-search">
						<?php get_search_form(); ?>
					</div>
					<?php
				}
				?>
			</div>
			<div class="right desktop-hide-down">
				<div class="header-group-action">
					<?php
					freshio_header_contact_info();
					freshio_header_account();
					if (freshio_is_woocommerce_activated()) {
						freshio_header_wishlist();
						freshio_header_cart();
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom desktop-hide-down header-navigation-background">
		<div class="inner">
			<div class="left">
				<?php freshio_vertical_navigation() ?>
			</div>
			<div class="right">
				<?php freshio_primary_navigation(); ?>
			</div>
		</div>
	</div>
</header><!-- #masthead -->
