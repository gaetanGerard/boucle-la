<?php global $product; ?>

<div class="csp-single-product-wrapper">
	<div class="csp-single-product-container">
		<div class="csp-product-image" id="openImageModal">
			<?php echo woocommerce_get_product_thumbnail('full'); ?>
		</div>
		<div id="imageModal">
			<div class="modal-content">
				<button id="closeImageModal" class="close-btn">&times;</button>
				<img src="<?php echo wp_get_attachment_image_url($product->get_image_id(), 'full'); ?>"
					alt="Image produit" />
			</div>
		</div>

		<div class="csp-product-info">
			<?php if (!$product->is_in_stock()): ?>
				<div class="csp-out-of-stock"><?php _e('Rupture de stock', 'woocommerce'); ?></div>
			<?php endif; ?>

			<h1 class="csp-product-title"><?php the_title(); ?></h1>

			<div class="csp-product-price"><?php echo $product->get_price_html(); ?></div>

			<div class="csp-short-description">
				<?php echo apply_filters('woocommerce_short_description', $post->post_excerpt); ?>
			</div>

			<div class="csp-product-categories">
				<strong>Catégorie :</strong> <?php echo wc_get_product_category_list($product->get_id()); ?>
			</div>

			<form class="cart"
				action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
				method="post" enctype="multipart/form-data">

				<?php do_action('woocommerce_before_add_to_cart_button'); ?>

				<?php if ($product->is_in_stock()): ?>
					<?php
					woocommerce_quantity_input([
						'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
						'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
					]);
					?>
				<?php else: ?>
					<input type="number" class="qty" value="0" min="0" disabled
						style="background-color: #f3f3f3; cursor: not-allowed; opacity: 0.6;" />
				<?php endif; ?>

				<?php
				$button_text = !$product->is_in_stock() ? __('Rupture de stock', 'woocommerce') : $product->single_add_to_cart_text();
				$button_classes = 'single_add_to_cart_button button alt';
				if (!$product->is_in_stock()) {
					$button_classes .= ' disabled';
				}
				?>

				<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
					class="<?php echo esc_attr($button_classes); ?>" <?php echo !$product->is_in_stock() ? 'disabled' : ''; ?>>
					<?php echo esc_html($button_text); ?>
				</button>

				<?php do_action('woocommerce_after_add_to_cart_button'); ?>
			</form>
		</div>
	</div>
</div>

<?php do_action('woocommerce_after_single_product_summary'); ?>