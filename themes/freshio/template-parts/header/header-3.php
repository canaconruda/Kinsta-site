<header id="masthead" class="site-header header-3" role="banner" style="<?php freshio_header_styles(); ?>">
	<div class="header-container">
		<div class="header-main container">
			<div class="row align-items-center header-top">
				<div class="left column-12 column-desktop-4 desktop-hide-down">
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
				<div class="center column-12 column-desktop-4">
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
				<div class="right column-desktop-4 desktop-hide-down">
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
			<div class="header-navigation desktop-hide-down">
				<?php freshio_primary_navigation(); ?>
			</div>
		</div>
	</div>
</header>
