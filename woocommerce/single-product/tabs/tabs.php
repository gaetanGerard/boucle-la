<?php
defined('ABSPATH') || exit;

$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)): ?>
	<div class="accordion-tabs w-full">
		<?php foreach ($product_tabs as $key => $tab): ?>
			<div class="accordion-tab border-b">
				<button class="accordion-trigger w-full text-left py-4 flex items-center justify-between text-lg font-bold"
					type="button" data-toggle="<?php echo esc_attr($key); ?>">
					<?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
					<span class="toggle-icon">+</span>
				</button>

				<div class="accordion-content hidden px-4 pb-6" id="tab-<?php echo esc_attr($key); ?>">
					<?php
					if (isset($tab['callback'])) {
						call_user_func($tab['callback'], $key, $tab);
					}
					?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>