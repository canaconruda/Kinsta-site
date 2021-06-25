<header id="masthead" class="site-header header-4" role="banner" style="<?php freshio_header_styles(); ?>">
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
	<div class="header-main">
		<div class="container">
			<div class="row align-items-center">
				<div class="left column-12 column-desktop-3">
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
				<div class="center column-desktop-6 desktop-hide-down">
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
				<div class="right column-desktop-3 desktop-hide-down">
					<div class="header-group-action">
						<?php
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
	</div>
	<div class="header-bottom desktop-hide-down header-navigation-background">
		<div class="container">
			<div class="inner">
				<div class="left">
					<?php freshio_vertical_navigation() ?>
				</div>
				<div class="right">
					<?php
					freshio_primary_navigation();
					freshio_header_contact_info();
					?>
				</div>
			</div>
		</div>

	</div>
</header><!-- #masthead -->
