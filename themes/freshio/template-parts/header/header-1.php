<header id="masthead" class="site-header header-1" role="banner" style="<?php freshio_header_styles(); ?>">
	<?php if (freshio_get_theme_option('welcome-message') || freshio_get_theme_option('custom-link')):?>
	<div class="header-top desktop-hide-down">
		<div class="container">
			<div class="row align-items-center">
				<div class="column-6 column-tablet-8">
					<?php
					freshio_site_welcome();
					?>
				</div>
				<div class="column-6 column-tablet-4">
					<?php freshio_header_custom_link(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif;?>
	<div class="header-main">
		<div class="container inner">
			<div class="header-left">
				<?php
				freshio_mobile_nav_button();
				freshio_site_branding();
				if (freshio_is_woocommerce_activated()) {
					?>
					<div class="site-header-cart header-cart-mobile">
						<?php freshio_cart_link(); ?>
					</div>
					<?php
				}
				?>
			</div>
			<div class="header-center d-flex align-items-center desktop-hide-down">
				<?php
				freshio_primary_navigation();

				?>
			</div>
			<div class="header-right tablet-hide-down desktop-hide-down">
				<div class="header-group-action">
					<?php
					freshio_header_search_button();
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
</header><!-- #masthead -->
