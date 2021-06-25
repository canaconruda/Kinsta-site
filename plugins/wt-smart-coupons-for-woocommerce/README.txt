=== Smart Coupons for WooCommerce ===
Contributors: webtoffee
Donate link:https://www.webtoffee.com/plugins/
Tags: smart coupons, advanced coupons, woocommerce smart coupons, coupons, woocommerce, url coupons for woocommerce, extended coupons, gift coupons, auto coupons, smart coupons for woocommerce,  url coupons, signup coupons, coupon banner, Buy one get one free
Requires at least: 3.3
Tested up to: 5.7
Stable tag: 1.3.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

 Add advanced options to WooCommerce coupons for better coupon management. Create coupon restrictions, auto-apply coupons, giveaway offers, and more.

== Description ==

Add advanced options to WooCommerce coupons for better WooCommerce coupon management. Create coupon restrictions, auto-apply coupons, giveaway offers, and more.

Everyone loves to get more than what they pay for. Smart coupons for WooCommerce provide additional features with default WooCommerce coupons to get more conversions.

With Smart coupons for WooCommerce you will be able to:

* Create smart coupons that can be applied automatically when a product is added to the cart.
* Make the WooCommerce discount coupons available in the user’s account so that they can view applicable coupons from My Account > My Coupon.
* Restrict coupon usage on the basis of products or categories that they can be applied to.
* Easily create WooCommerce quantity discounts. Filter coupons further with maximum or minimum quantity/amount of products purchased.
* Issue coupons with various checkout options precisely with the shipping method, payment method, or applicable roles.
* Embed multiple giveaway products in a coupon.
* Customize coupon appearance with extensive categorized coupon styling options for expired, used, and active coupons.
* Create duplicate coupons using the same parameters as existing ones using this free coupon plugin WooCommerce.
* Omit coupons from applying for specific products.


== NEED FOR WOOCOMMERCE SMART COUPONS PLUGIN ==

The success of every online store depends hugely on how well they market their products. Even if your store sells higher quality products at a reasonable price, improper marketing will keep your sales always on the downside. Thus coming up with the most appropriate marketing strategies from time to time is necessary to keep your store on the move. This WooCommerce Smart coupon plugin is an essential tool for this.

If you are looking for the smartest way to market your products you should go for a WooCommerce advanced coupons plugin - Smart Coupons for WooCommerce.

People always love getting more than what they pay for. Hence, coupons without a doubt help your store to improve sales by establishing a new customer base. Well-organized coupon management will also help you by retaining your existing customers. This, in turn, arises the need for an effective coupon management system for your WooCommerce store and that is what you will accomplish by having WooCommerce smart coupons plugin in your store.

== HOW SMART COUPONS OR ADVANCED COUPONS BENEFITS YOUR WOOCOMMERCE STORE ==

Easily apply coupons: Each Coupon has a coupon code associated with it. Usually, Customers are required to enter this code in the allowed field for applying a coupon to their purchase. However, This task can be made shorter by smart coupons as it displays all the coupons available for the customer on the Cart & My Account page to easily apply them.

Absolute self-management of everything related to coupons: Everything related to coupons will be managed automatically. The issuing of product coupons, coupon removal, etc will be managed on its own thereby reducing the workload of the store admin.

Promote specific payment or shipping methods: Provide coupons based on payment or shipping methods that are most likely suitable for your business needs. This could also give room for partnership options with the respective vendor from a business perspective.

Duplicate coupons: The option to duplicate coupons makes things easier since you don’t have to necessarily create them as long as most of the criteria are the same. Then you just need to duplicate an existing coupon and make minor alterations.

To get more details on how to set up this WooCommerce Smart Coupons plugin, please read [Smart Coupons for WooCommerce user guide](https://www.webtoffee.com/smart-coupons-for-woocommerce-userguide/ "Smart Coupons for WooCommerce user guide")

<blockquote>

= PREMIUM VERSION FEATURES =

* Configure the coupons with extensive usage restrictions and checkout options
* Create and manage WooCommerce bulk discount coupons with add to store/email/export to CSV options
* Giveaway free products with Woo commerce coupons
* Import coupons, Duplicate WordPress coupons
* Ability to impose coupon usage restrictions on the basis of the country/location precisely with shipping or billing address apart from the default restrictions.
* Giveaway multiple free products with coupons.
* Generate and manage bulk discount coupons with add to store/email/ export to CSV options.
* Provision to upload and import coupons by simultaneously emailing it directly to the recipients.
* Create and design gift vouchers of any amount range by associating a store credit product.
* Manage store credits – create/purchase/transaction history/issue refunds/email.
* Categorized view of Active/Used/Expired coupons from My Account > My Coupon.
* Provision to use Combo coupon for purchase.
* Option to exclude a product from coupon/s.
* Shortcode for displaying coupons on any page.
* Get x% discount on your nth purchase coupon
* Checkout/cart abandoned coupon
* Signup coupon

</blockquote>

For complete list of features and details, please visit [Smart Coupons for WooCommerce](https://www.webtoffee.com/product/smart-coupons-for-woocommerce/)


== URL coupon ==

URL Coupons help you add a unique URL to any coupon in your e-commerce store. Clicking this URL ensures that the underlying coupon is applied as per its respective configuration e.g allow discounts, giveaway free product whatever the case may be.

Usage: {site_url}/?wt_coupon={coupon_code}

e.g, https://www.webtoffee.com/cart/?wt_coupon=flat30

A URL coupon that offers a flat 30% discount at www.webtoffee.com, coupon_code = FLAT30, site_url(preferably cart page) = https://www.webtoffee.com/cart

<blockquote>

= PREMIUM VERSION FEATURES =

* Pass coupon via a link that will redirect to the cart/checkout page with products added into it.
* Ability to create customized URL with personalized text. For example, www.mystore.com/happybirthday.
* Embed URL coupon in a QRCode

</blockquote>
For a complete list of features and details, please visit [URL Coupons for WooCommerce](https://www.webtoffee.com/product/url-coupons-for-woocommerce/)


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `wt-smart-coupon.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates



== Frequently Asked Questions ==

= Does this provide an option for payment method based discount? =

Yes.

= Does it support coupon duplication? =

Yes, in-order to duplicate a coupon, go to WooCommerce > Coupons. Find the coupon you wish to duplicate. Hover on the coupon and select Duplicate

= How to hide my coupons in my account list =

Please try adding below code snippet to your active child theme’s functions.php

`add_filter('woocommerce_account_menu_items','wt_removed_un_wanted_my_account_tabs',100,1);
function wt_removed_un_wanted_my_account_tabs( $items ) {
   if( isset($items['wt-smart-coupon']) ) unset( $items['wt-smart-coupon'] );
   return $items;
}`

== Screenshots ==

1. Checkout Options for WooCommerce smart coupons
2. WooCommerce smart coupons give away products
3. WordPress coupon usage restrictions
4. My WordPress Coupon
5. WooCommerce discount coupon styling
6. Store credit coupon maker

== Changelog ==

= 1.3.0 =
* Tested OK with WC 5.2

= 1.2.9 =
* Tested OK with WP 5.7.0
* Tested OK with WC 5.1.0

= 1.2.8 =
* Fix: Auto apply of coupons fails when email restriction was added.
* Tested OK with WC 4.9.0
* Tested OK with WP 5.6.0

= 1.2.7 =
* Fix: Auto apply coupon of fixed amount discount on subscription sign up fee is taking cart total to 0
* Tested OK with WC 4.7.0
* Tested OK with WP 5.5.3

= 1.2.6 =
* Improvement: display coupon based on user roles
* Fix: Auto coupons are not applied properly after changing the payment method
* Tested OK with WP 5.5.2
* Tested OK with WC 4.5.2

= 1.2.5 =
* [Fix] Auto coupons are not applied properly.
* Tested OK with WC 4.2.0

= 1.2.4 =
* [Fix] The auto coupon is not applied if the checkout page is directly visited after the product has added to the cart.
* [Fix] Fixed languages translation issues.
* Tested OK with WC 4.1.0
* Updated translation files

= 1.2.3 =
* [Fix] - Memory limit exceeded error when a large number of auto coupons are present.
* Added a filter `wt_smartcoupon_max_auto_coupons_limit` to limit the maximum number of auto coupons that can be applied

= 1.2.2 =
* Tested OK with WP 5.4

= 1.2.1 =
* Tested OK with WC 3.9.2
* [fix] Giveaway product is not removed from the cart even if all the applied coupon products are removed
* [fix] Smart coupon start date is not working properly

= 1.2.0 =
* [Improvement] Security

= 1.1.9 =
* Tested OK with WooCommerce 3.8.1
* Removed Quantity updation for Giveway item 

= 1.1.8 =
* Tested OK with WP 5.3
* [update] Content update
* [update] Activare Woocommerce Coupon module on pugin activation.
* [fix] Fixed issues in discount calculation for giveaway product.


= 1.1.7 =
* Tested OK with WP 5.2.4
* Tested OK with WC 3.8.0
* [update] Fixed Currency position all over the plugin. Thanks @imborx reporting issue.
* [update] Added filter for formatted text "wt_smart_coupon_meta_data"

= 1.1.6 =
* Tested OK with WP 5.2.3


= 1.1.5 =
* WPML compatiablity
* Content update

= 1.1.4 =
* Implemented URL coupon
* Content update

= 1.1.3 =
* Implemented Startdate for coupon.
* Tested ok with WC 3.6.4
* Tested ok with WordPress 5.2.1
* Content Update.


= 1.1.2 =
* Fixed PHP Warning in Exclude Product section.
* Tested ok with WC 3.6.2
* Content Update.


= 1.1.1 =
* Ability to omit coupon from applying for specific products.
* Tested ok with WC 3.6.1

= 1.1.0 =
* Included option to automatically apply coupon.
* Tested ok with WP 5.1.1 and WC 3.5.7

= 1.0.1 =
* Customize myCoupon Styles.
* Readme updates.

= 1.0.0 =
* Updated Language translation

= 0.0.9 =
* Additional filters in usage restriction by product/min-max subtotal/min-max quantity
* Giveaway free products(simple products)
* Option to list applicable coupons under users My account->My Coupons
* Categorized view of Active/Used/Expired coupons
* Tested OK with latest version of WordPress and WooCommerce

= 0.0.8 =
* Updated read me - tested OK with latest version of WP and WC

= 0.0.7 =
* Content updates.
* Tested OK with Wordpress 5.0.2
* Tested OK with WC 3.5.3

= 0.0.6 =
* Content updates.

= 0.0.5 =
* Content updates.

= 0.0.4 =
* Content updates.

= 0.0.3 =
* Tested OK with WC 3.5.1.

= 0.0.2 =
* Tested OK with WC 3.4.4.

= 0.0.1 =
* Initial commit.

== Upgrade Notice ==

= 1.3.0 =
* Tested OK with WC 5.2

