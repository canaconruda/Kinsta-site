<?php
if(isset($primary) && $primary){
    $cssCode .= <<<CSS
        .freshio-product-pagination .product-item .freshio-product-pagination__title:hover, .freshio-product-pagination .product-item .price, .freshio-product-pagination .product-item .price ins, ul.products li.product .price,
ul.products .wc-block-grid__product .price,
.wc-block-grid__products li.product .price,
.wc-block-grid__products .wc-block-grid__product .price, ul.products li.product .price ins,
ul.products .wc-block-grid__product .price ins,
.wc-block-grid__products li.product .price ins,
.wc-block-grid__products .wc-block-grid__product .price ins, ul.products a[class*="product_type_"]:hover,
.wc-block-grid__products a[class*="product_type_"]:hover,
.product-list a[class*="product_type_"]:hover, .single-product div.product form.cart table.group_table .woocommerce-grouped-product-list-item__label a:hover, .single-product div.product form.cart table.group_table .woocommerce-grouped-product-list-item__price ins .woocommerce-Price-amount, .single-product div.product form.cart table.group_table .woocommerce-Price-amount, .single-product div.product .entry-summary .yith-wcwl-add-to-wishlist > div > a:hover, .single-product div.product .entry-summary .compare:hover, .single-product div.product p.price, .single-product div.product p.price ins, .single-product div.product .single_variation .price, .single-product div.product .single_variation .price ins, .single-product div.product .woocommerce-product-rating a:hover, .single-product div.product .product_meta .sku_wrapper a:hover,
.single-product div.product .product_meta .posted_in a:hover,
.single-product div.product .product_meta .tagged_as a:hover, .single-product .woocommerce-tabs ul.tabs li.active a, .freshio-sticky-add-to-cart__content-price, .freshio-sticky-add-to-cart__content-price ins, .product_list_widget .product-content .amount, .widget_shopping_cart .mini_cart_item .quantity .amount, .widget_product_categories ul.product-categories li::before, .widget_product_categories ul.product-categories li.current-cat a, .widget_price_filter .price_slider_amount .button:hover, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li.chosen .freshio-image-type .image-name, table.cart td.product-remove a.remove:hover:before, table.cart td.product-remove a.remove:active:before, .cart_totals .order-total .amount, ul#shipping_method input[type="radio"]:first-child:checked + label:after, #order_review .woocommerce-checkout-review-order-table .order-total .amount, #payment .payment_methods li.woocommerce-PaymentMethod > input[type=radio]:first-child:checked + label::before, #payment .payment_methods li.wc_payment_method > input[type=radio]:first-child:checked + label::before, .woocommerce-order .woocommerce-table--order-details tfoot tr:last-child .amount, #yith-quick-view-modal.open p.price, #yith-quick-view-modal.open p.price ins, .hentry .entry-content .woocommerce-MyAccount-navigation ul li.woocommerce-MyAccount-navigation-link.is-active a, .product-list .price, .product-list .price ins, .product-list .woocommerce-loop-product__title a:hover, table.wishlist_table tbody td.product-price, table.wishlist_table tbody td.product-price ins .amount, ul.wishlist_table.mobile td.value span.amount, ul.wishlist_table.mobile td.value ins .amount, .filter-toggle:focus, .filter-toggle:hover, .filter-close:hover, .freshio-dropdown-filter-wrap .widget a:not(.button):hover, .single-product div.product .entry-summary .wooscp-btn:hover,
.single-product div.product .entry-summary .woosw-btn:hover {
    color: $primary; 
}
CSS;

}
if(isset($primary) && $primary){
    $cssCode .= <<<CSS
        .shop-action .yith-wcqv-button:hover,
.shop-action .yith-wcwl-add-to-wishlist > div > a:hover,
.shop-action .compare:hover, .single-product div.product form.cart table.woocommerce-grouped-product-list .woocommerce-grouped-product-list-item__quantity a.button:hover, .single-product div.product .single_add_to_cart_button, .single-product .woocommerce-tabs ul.tabs li a:before, .freshio-sticky-add-to-cart .freshio-sticky-add-to-cart__content-button, .widget_price_filter .ui-slider .ui-slider-handle, .widget_price_filter .ui-slider .ui-slider-range, .yith_woocompare_colorbox #cboxLoadedContent ::-webkit-scrollbar-thumb, .yith_woocompare_colorbox #cboxLoadedContent :window-inactive::-webkit-scrollbar-thumb, table.wishlist_table td.product-add-to-cart a.add_to_cart:hover, ul.wishlist_table.mobile .product-add-to-cart a.button:hover, .shop-action .wooscp-btn:hover,
.shop-action .woosq-btn:hover,
.shop-action .woosw-btn:hover {
    background-color: $primary; 
}
CSS;

}
if(isset($primary) && $primary){
    $cssCode .= <<<CSS
        .shop-action .yith-wcqv-button:hover,
.shop-action .yith-wcwl-add-to-wishlist > div > a:hover,
.shop-action .compare:hover, .widget_price_filter .ui-slider .ui-slider-handle, table.cart td.actions .coupon .input-text:focus, .checkout_coupon .input-text:focus, .hidden-title-form input[type='text']:focus, .site-header-cart-side .widget_shopping_cart .buttons a.checkout, .shop-action .wooscp-btn:hover,
.shop-action .woosq-btn:hover,
.shop-action .woosw-btn:hover {
    border-color: $primary; 
}
CSS;

}
if(isset($primary) && $primary){
    $cssCode .= <<<CSS
        .site-header-cart .widget.widget_shopping_cart {
    border-top-color: $primary; 
}
CSS;

}
if(isset($primary_hover) && $primary_hover){
    $cssCode .= <<<CSS
        .freshio-product-pagination a:hover, ul.products li.product h2 a:hover,
ul.products li.product h3 a:hover,
ul.products li.product .woocommerce-loop-product__title a:hover,
ul.products li.product .wc-block-grid__product-title a:hover,
ul.products .wc-block-grid__product h2 a:hover,
ul.products .wc-block-grid__product h3 a:hover,
ul.products .wc-block-grid__product .woocommerce-loop-product__title a:hover,
ul.products .wc-block-grid__product .wc-block-grid__product-title a:hover,
.wc-block-grid__products li.product h2 a:hover,
.wc-block-grid__products li.product h3 a:hover,
.wc-block-grid__products li.product .woocommerce-loop-product__title a:hover,
.wc-block-grid__products li.product .wc-block-grid__product-title a:hover,
.wc-block-grid__products .wc-block-grid__product h2 a:hover,
.wc-block-grid__products .wc-block-grid__product h3 a:hover,
.wc-block-grid__products .wc-block-grid__product .woocommerce-loop-product__title a:hover,
.wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-title a:hover, ul.products li.product .posted-in a:hover,
ul.products .wc-block-grid__product .posted-in a:hover,
.wc-block-grid__products li.product .posted-in a:hover,
.wc-block-grid__products .wc-block-grid__product .posted-in a:hover, .single-product div.product form.cart .quantity button:hover, .single-product .woocommerce-tabs ul.tabs li a:hover, .sizechart-popup .sizechart-close:hover i, .sizechart-button:hover, .product_list_widget .product-title span:hover, .product_list_widget a:hover, .widget_shopping_cart .mini_cart_item a:hover, .widget_shopping_cart .buttons a:not(.checkout):hover, table.cart td.product-name a:hover, .woocommerce-order .woocommerce-table--order-details .product-name a:hover, .hentry .entry-content .woocommerce-MyAccount-navigation ul li.woocommerce-MyAccount-navigation-link a:hover, .yith_woocompare_colorbox #cboxClose:hover:before, .yith_woocompare_colorbox #cboxClose:active:before, .product-list .posted-in a:hover, .wishlist-title.wishlist-title-with-form h2:hover {
    color: $primary_hover; 
}
CSS;

}
if(isset($primary_hover) && $primary_hover){
    $cssCode .= <<<CSS
        .single-product div.product .single_add_to_cart_button:hover, .freshio-sticky-add-to-cart .freshio-sticky-add-to-cart__content-button:hover, body #yith-woocompare table.compare-list tr.add-to-cart a:hover, body #yith-woocompare table.compare-list tr.add-to-cart a:active {
    background-color: $primary_hover; 
}
CSS;

}
if(isset($primary_hover) && $primary_hover){
    $cssCode .= <<<CSS
        .yith_woocompare_colorbox #cboxClose:hover:before, .yith_woocompare_colorbox #cboxClose:active:before {
    border-color: $primary_hover; 
}
CSS;

}
if(isset($body) && $body){
    $cssCode .= <<<CSS
        .form-row .select2-container--default .select2-selection--single .select2-selection__rendered, p.stars a::before, p.stars a:hover ~ a::before, p.stars.selected a.active ~ a::before, .single-product div.product form.cart table.variations td.value ul li.variable-item.disabled .variable-item-span, .single-product div.product .woocommerce-product-details__short-description, table.woocommerce-checkout-review-order-table .variation,
table.woocommerce-checkout-review-order-table .product-quantity, .woocommerce-order .woocommerce-table--order-details .product-name a, form.woocommerce-form-login .woocommerce-LostPassword a, .yith_woocompare_colorbox #cboxClose:before, table.wishlist_table td.product-stock-status .wishlist-in-stock, ul.wishlist_table.mobile .item-wrapper .product-name h3:before, ul.wishlist_table.mobile .remove_from_wishlist:before {
    color: $body; 
}
CSS;

}
if(isset($body) && $body){
    $cssCode .= <<<CSS
        .yith_woocompare_colorbox #cboxClose:before {
    border-color: $body; 
}
CSS;

}
if(isset($heading) && $heading){
    $cssCode .= <<<CSS
        .site-header-cart .cart-contents::before, .freshio-handheld-footer-bar ul li > a:before, .freshio-handheld-footer-bar ul li > a .title, .form-row label, .freshio-product-pagination a:nth-child(2):hover, .freshio-product-pagination .product-item .freshio-product-pagination__title, .single-product div.product .summary.entry-summary .yith-wcwl-add-to-wishlist, .single-product div.product form.cart .quantity .qty, .single-product div.product form.cart table.group_table .woocommerce-grouped-product-list-item__label a, .single-product div.product form.cart table.variations td.label label, .single-product div.product form.cart table.variations td.value ul li.variable-item .variable-item-span, .single-product .woocommerce-tabs ul.tabs li a, #reviews .commentlist li p.meta strong, table.shop_attributes th, .freshio-sticky-add-to-cart__content-title strong, .sizechart-popup .sizechart-close i, .sizechart-button, .product_list_widget .product-title span, .widget_shopping_cart .mini_cart_item a, .widget_shopping_cart .mini_cart_item .quantity, .widget_shopping_cart p.total strong, .widget_shopping_cart p.total .amount, .widget_shopping_cart .buttons a:not(.checkout), .widget_price_filter .price_slider_amount .price_label, .widget_price_filter .price_slider_amount .price_label span, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-image-type .image-name, table.cart th, table.cart tr td[data-title]::before, table.cart td.product-name a, table.cart td.product-price .amount, table.cart td.product-quantity .qty, table.cart td.product-subtotal .amount, .cart_totals table th, .cart_totals .cart-subtotal .amount, ul#shipping_method input[type="radio"] + label, .woocommerce-cart .cart-empty, #order_review .woocommerce-checkout-review-order-table th, #order_review .woocommerce-checkout-review-order-table .amount, #payment .payment_methods li > label, table.woocommerce-checkout-review-order-table .product-name, .woocommerce-order .woocommerce-table--order-details th, .woocommerce-order .woocommerce-table--order-details tfoot, form.woocommerce-form-track-order label, #yith-quick-view-close:hover, .hentry .entry-content .woocommerce-MyAccount-navigation ul li.woocommerce-MyAccount-navigation-link a, ul.order_details li strong, .woocommerce-MyAccount-content table th, .woocommerce-MyAccount-content .order_details a:not(.button), .woocommerce-MyAccount-content .order_details tfoot .amount, .wcml-horizontal-list li.wcml-cs-active-currency a,
.wcml-vertical-list li.wcml-cs-active-currency a, .site-header-cart-side .cart-side-title, .site-header-cart-side .close-cart-side, .freshio-dropdown-filter-wrap .widget a:not(.button), .filter-toggle-dropdown, .filter-toggle-dropdown:focus, .filter-toggle-dropdown:hover, .woosw-list table.woosw-content-items .woosw-content-item .woosw-content-item--add p > a,
.woosw-area .woosw-inner .woosw-content .woosw-content-mid table.woosw-content-items .woosw-content-item .woosw-content-item--add p > a {
    color: $heading; 
}
CSS;

}
if(isset($heading) && $heading){
    $cssCode .= <<<CSS
        .single-product div.product form.cart table.woocommerce-grouped-product-list .woocommerce-grouped-product-list-item__quantity a.button, table.wishlist_table td.product-add-to-cart a.add_to_cart, ul.wishlist_table.mobile .product-add-to-cart a.button, .site-header-cart-side .close-cart-side:before, .site-header-cart-side .close-cart-side:after {
    background-color: $heading; 
}
CSS;

}
if(isset($heading) && $heading){
    $cssCode .= <<<CSS
        .single-product div.product form.cart table.variations td.value ul li.variable-item:hover, .single-product div.product form.cart table.variations td.value ul li.variable-item.selected, form.woocommerce-checkout input[type='text']:focus,
form.woocommerce-checkout input[type='number']:focus,
form.woocommerce-checkout input[type='email']:focus,
form.woocommerce-checkout input[type='tel']:focus,
form.woocommerce-checkout input[type='url']:focus,
form.woocommerce-checkout input[type='password']:focus,
form.woocommerce-checkout input[type='search']:focus,
form.woocommerce-checkout textarea:focus,
form.woocommerce-checkout select:focus,
form.woocommerce-checkout .input-text:focus {
    border-color: $heading; 
}
CSS;

}
if(isset($light) && $light){
    $cssCode .= <<<CSS
        .freshio-product-pagination .product-item .price del, ul.products li.product .price del,
ul.products .wc-block-grid__product .price del,
.wc-block-grid__products li.product .price del,
.wc-block-grid__products .wc-block-grid__product .price del, ul.products li.product .posted-in,
ul.products .wc-block-grid__product .posted-in,
.wc-block-grid__products li.product .posted-in,
.wc-block-grid__products .wc-block-grid__product .posted-in, ul.products li.product .posted-in a,
ul.products .wc-block-grid__product .posted-in a,
.wc-block-grid__products li.product .posted-in a,
.wc-block-grid__products .wc-block-grid__product .posted-in a, .single-product div.product form.cart table.group_table .woocommerce-grouped-product-list-item__price del .woocommerce-Price-amount, .single-product div.product p.price del, .single-product div.product .single_variation .price del, .single-product div.product .woocommerce-product-rating a, .single-product div.product .product_meta .sku_wrapper > *,
.single-product div.product .product_meta .posted_in > *,
.single-product div.product .product_meta .tagged_as > *, #reviews .commentlist li time, .freshio-sticky-add-to-cart__content-price del, .freshio-sticky-add-to-cart__content-title, .product_list_widget .product-content del, .product_list_widget .product-content del .amount, .widget_rating_filter .wc-layered-nav-rating a, .widget_product_categories ul.product-categories li, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-image-type .image-count, #yith-quick-view-modal.open p.price del, .woocommerce-MyAccount-content .order_details .product-quantity, .product-list .posted-in a, .product-list .price del, table.wishlist_table tbody td.product-price del .amount, ul.wishlist_table.mobile td.value del .amount {
    color: $light; 
}
CSS;

}
if(isset($light) && $light){
    $cssCode .= <<<CSS
        ul.products li.product .price:after,
ul.products .wc-block-grid__product .price:after,
.wc-block-grid__products li.product .price:after,
.wc-block-grid__products .wc-block-grid__product .price:after, .stock.out-of-stock, .product-list a[class*="product_type_"]:before {
    background-color: $light; 
}
CSS;

}
if(isset($dark) && $dark){
    $cssCode .= <<<CSS
        .site-header-cart .cart-contents .amount, .gridlist-toggle a.active, .gridlist-toggle a:hover, .freshio-product-pagination a, .freshio-sorting .woocommerce-ordering select, .woocommerce-result-count, ul.products li.product h2 a,
ul.products li.product h3 a,
ul.products li.product .woocommerce-loop-product__title a,
ul.products li.product .wc-block-grid__product-title a,
ul.products .wc-block-grid__product h2 a,
ul.products .wc-block-grid__product h3 a,
ul.products .wc-block-grid__product .woocommerce-loop-product__title a,
ul.products .wc-block-grid__product .wc-block-grid__product-title a,
.wc-block-grid__products li.product h2 a,
.wc-block-grid__products li.product h3 a,
.wc-block-grid__products li.product .woocommerce-loop-product__title a,
.wc-block-grid__products li.product .wc-block-grid__product-title a,
.wc-block-grid__products .wc-block-grid__product h2 a,
.wc-block-grid__products .wc-block-grid__product h3 a,
.wc-block-grid__products .wc-block-grid__product .woocommerce-loop-product__title a,
.wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-title a, ul.products a[class*="product_type_"],
.wc-block-grid__products a[class*="product_type_"],
.product-list a[class*="product_type_"], .single-product div.product .woocommerce-product-gallery .flex-control-thumbs .slick-prev:before, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs .slick-next:before, .single-product div.product .entry-summary .yith-wcwl-add-to-wishlist > div > a, .single-product div.product .entry-summary .compare, .single-product div.product .product_meta .sku_wrapper,
.single-product div.product .product_meta .posted_in,
.single-product div.product .product_meta .tagged_as, .stock.in-stock, .freshio-sticky-add-to-cart__content-title span, .widget_price_filter .price_slider_amount .button, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-button-type:hover, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li.chosen .freshio-button-type, .product-list .woocommerce-loop-product__title a, .filter-toggle, .filter-close, .single-product div.product .entry-summary .wooscp-btn,
.single-product div.product .entry-summary .woosw-btn {
    color: $dark; 
}
CSS;

}
if(isset($dark) && $dark){
    $cssCode .= <<<CSS
        .single-product div.product form.cart .quantity .qty:focus, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-button-type:hover, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li.chosen .freshio-button-type, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-color-type:after {
    border-color: $dark; 
}
CSS;

}
if(isset($border) && $border){
    $cssCode .= <<<CSS
        .single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__wrapper, .single-product div.product .woocommerce-product-gallery .flex-viewport {
    color: $border; 
}
CSS;

}
if(isset($border) && $border){
    $cssCode .= <<<CSS
        .related > h2:first-child:before,
.upsells > h2:first-child:before, .related > h2:first-child:after,
.upsells > h2:first-child:after, .single-product div.product form.cart table.variations td.value ul li.variable-item.disabled:after, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-color-type {
    background-color: $border; 
}
CSS;

}
if(isset($border) && $border){
    $cssCode .= <<<CSS
        .form-row .select2-container--default .select2-selection--single, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs .slick-prev, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs .slick-next, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs li img, .single-product div.product form.cart .quantity .qty, .single-product div.product form.cart table.group_table tr, .single-product div.product form.cart table.variations td.value ul li.variable-item, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-button-type, table.cart tr td, table.cart td.actions .coupon, table.cart td.actions .coupon .input-text, .cart_totals, .site-header-cart .widget_shopping_cart, .checkout_coupon .input-text, form.woocommerce-checkout input[type='text'],
form.woocommerce-checkout input[type='number'],
form.woocommerce-checkout input[type='email'],
form.woocommerce-checkout input[type='tel'],
form.woocommerce-checkout input[type='url'],
form.woocommerce-checkout input[type='password'],
form.woocommerce-checkout input[type='search'],
form.woocommerce-checkout textarea,
form.woocommerce-checkout select,
form.woocommerce-checkout .input-text, #order_review, .yith-wcqv-wrapper .woocommerce-product-gallery__wrapper, ul.order_details li, .product-list .product-image, .wcml-dropdown li,
.wcml-dropdown .wcml-cs-submenu li, table.wishlist_table tbody tr {
    border-color: $border; 
}
CSS;

}
if(isset($border) && $border){
    $cssCode .= <<<CSS
        .freshio-handheld-footer-bar, .single-product div.product .product_meta, .widget_shopping_cart p.total, .cart_totals .order-total, #order_review .woocommerce-checkout-review-order-table th, #order_review .woocommerce-checkout-review-order-table td, .woocommerce-order .woocommerce-table--order-details td, .woocommerce-order .woocommerce-table--order-details th, .hentry .entry-content .woocommerce-MyAccount-navigation ul {
    border-top-color: $border; 
}
CSS;

}
if(isset($border) && $border){
    $cssCode .= <<<CSS
        .freshio-sorting, .single-product .woocommerce-tabs ul.tabs, .single-product.freshio-full-width-content div.product .related:after, .single-product.freshio-full-width-content div.product .up-sells:after, .single-product.freshio-full-width-content .woocommerce-tabs ul.tabs:before, .product_list_widget li, .widget_shopping_cart .mini_cart_item, table.cart thead, table.cart .cart_item, .cart_totals > h2, .cart_totals .cart-subtotal, #payment .payment_methods > .woocommerce-PaymentMethod,
#payment .payment_methods > .wc_payment_method, .woocommerce-order .woocommerce-table--order-details thead td,
.woocommerce-order .woocommerce-table--order-details thead th, .hentry .entry-content .woocommerce-MyAccount-navigation ul li, .product-item-search, .freshio-canvas-filter .widget .widget-title, .site-header-cart-side .cart-side-heading {
    border-bottom-color: $border; 
}
CSS;

}
if(isset($border) && $border){
    $cssCode .= <<<CSS
        .freshio-handheld-footer-bar ul li > a, .login-form-col {
    border-right-color: $border; 
}
CSS;

}
if(isset($background) && $background){
    $cssCode .= <<<CSS
        .site-header-cart .widget_shopping_cart, .freshio-handheld-footer-bar ul li > a, .freshio-handheld-footer-bar ul li.search .site-search, .form-row .select2-container--default .select2-selection--single, ul.products li.product .product-block,
ul.products .wc-block-grid__product .product-block,
.wc-block-grid__products li.product .product-block,
.wc-block-grid__products .wc-block-grid__product .product-block, .freshio-sticky-add-to-cart, .checkout-review-order-table-wrapper, #order_review, #yith-quick-view-modal .yith-wcqv-main, .site-header-cart-side {
    background-color: $background; 
}
CSS;

}
if(isset($background2) && $background2){
    $cssCode .= <<<CSS
        .single-product div.product .inventory_status {
    color: $background2; 
}
CSS;

}
if(isset($white) && $white){
    $cssCode .= <<<CSS
        .stock.out-of-stock, table.wishlist_table td.product-name a.add_to_cart_button {
    color: $white; 
}
CSS;

}
if(isset($white) && $white){
    $cssCode .= <<<CSS
        .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li .freshio-color-type:hover, .freshio_widget_layered_nav ul.woocommerce-widget-layered-nav-list li.chosen .freshio-color-type {
    background-color: $white; 
}
CSS;

}

return $cssCode;
