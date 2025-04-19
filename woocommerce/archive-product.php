<?php
defined('ABSPATH') || exit;

get_header('shop');

do_action('woocommerce_before_main_content');


if (woocommerce_product_loop()) {
	do_action('woocommerce_before_shop_loop');
	?>

	<div class="shop-layout">

		<!-- Categories -->
		<aside>
			<h2>Filtrer par catégorie :</h2>
			<ul>
				<?php
				$product_categories = get_terms(array(
					'taxonomy' => 'product_cat',
					'orderby' => 'name',
					'hide_empty' => true,
				));

				if (!empty($product_categories) && !is_wp_error($product_categories)) {
					$current_cat = get_queried_object();
					echo '<li><a href="' . get_permalink(wc_get_page_id('shop')) . '" class="' . (!is_product_category() ? 'category-link-active' : 'category-link ') . '">Toutes les BO (' . wc_get_loop_prop('total') . ')</a></li>';

					foreach ($product_categories as $category) {
						$category_link = get_term_link($category);
						$is_current = (isset($current_cat->term_id) && $current_cat->term_id === $category->term_id) ? 'category-link-active' : 'category-link';
						echo '<li><a href="' . esc_url($category_link) . '" class=" ' . $is_current . '">' . esc_html($category->name) . ' (' . $category->count . ')</a></li>';
					}
				}
				?>
			</ul>
		</aside>

		<!-- Main Product Area -->
		<div class="product-list">
			<!-- Products List -->
			<?php
			woocommerce_product_loop_start();

			if (wc_get_loop_prop('total')) {
				while (have_posts()) {
					the_post();
					do_action('woocommerce_shop_loop');
					wc_get_template_part('content', 'product');
				}
			}

			woocommerce_product_loop_end();
			?>
		</div>
	</div>
	<!-- Pagination -->
	<?php do_action('woocommerce_after_shop_loop'); ?>

	<?php
} else {
	do_action('woocommerce_no_products_found');
}

do_action('woocommerce_after_main_content');
do_action('woocommerce_sidebar');

get_footer('shop');
