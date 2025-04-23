<?php
defined('ABSPATH') || exit;

$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)): ?>
	<div class="accordion-tabs">
		<?php foreach ($product_tabs as $key => $tab): ?>
			<div class="accordion-tab">
				<button class="accordion-trigger" type="button" data-toggle="<?php echo esc_attr($key); ?>">
					<?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
					<span class="toggle-icon">+</span>
				</button>

				<div class="accordion-content hidden" id="tab-<?php echo esc_attr($key); ?>">
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