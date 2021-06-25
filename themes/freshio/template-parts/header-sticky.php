<?php
$show_sticky      = freshio_get_theme_option( 'show-header-sticky', true );
$sticky_animation = freshio_get_theme_option( 'header-sticky-animation', true );
$class            = $sticky_animation ? 'header-sticky hide-scroll-down' : 'header-sticky';
if ( $show_sticky == true ) {
	wp_enqueue_script( 'freshio-sticky-header' );
	?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <div class="col-full">
            <div class="header-group-layout">
				<?php

				freshio_site_branding();
				freshio_primary_navigation();
				?>
                <div class="header-group-action desktop-hide-down">
					<?php
					freshio_header_search_button();
					freshio_header_account();
					if ( freshio_is_woocommerce_activated() ) {
						freshio_header_wishlist();
						freshio_header_cart();
					}
					?>
                </div>
				<?php
				if ( freshio_is_woocommerce_activated() ) {
					?>
                    <div class="site-header-cart header-cart-mobile">
						<?php freshio_cart_link(); ?>
                    </div>
					<?php
				}
				freshio_mobile_nav_button();
				?>

            </div>
        </div>
    </div>
	<?php
}
?>
