<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( 'w-[250px] bg-white rounded-lg shadow-sm p-4 text-center flex flex-col items-center justify-between transition hover:shadow-md', $product ); ?>>

	<!-- Lien ouverture produit -->
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<!-- Image produit -->
	<div class="mb-3 w-full">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
	</div>

	<!-- Titre -->
	<h2 class="text-sm font-medium text-gray-900 mb-1">
		<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
	</h2>

	<!-- Prix -->
	<div class="text-pink-700 text-sm font-semibold mb-3">
		<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
	</div>

	<!-- Bouton Ajouter au panier -->
	<div class="flex items-center justify-center gap-2">
		<button class="w-7 h-7 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition text-lg leading-none">−</button>
		<span class="w-6 text-center text-sm">0</span>
		<button class="w-7 h-7 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition text-lg leading-none">+</button>
	</div>

	<!-- Fermeture lien et ajout au panier Woo -->
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>
