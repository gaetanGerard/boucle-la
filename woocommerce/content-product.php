<?php
defined('ABSPATH') || exit;

global $product;

if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
	return;
}
?>

<li <?php wc_product_class('product-card'); ?>>

	<!-- Link for open a product -->
	<?php do_action('woocommerce_before_shop_loop_item'); ?>

	<!-- Image -->
	<div class="product-image">
		<?php do_action('woocommerce_before_shop_loop_item_title'); ?>
	</div>

	<!-- Title -->
	<h2 class="text-sm font-medium text-gray-900 mb-1">
		<?php do_action('woocommerce_shop_loop_item_title'); ?>
	</h2>

	<!-- Price -->
	<div class="text-pink-700 text-sm font-semibold mb-3">
		<?php do_action('woocommerce_after_shop_loop_item_title'); ?>
	</div>

	<!-- Closing link with Add to cart button -->
	<?php do_action('woocommerce_after_shop_loop_item'); ?>

</li>