<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined('ABSPATH') || exit;

$page_title = ('billing' === $load_address) ? esc_html__('Billing address', 'woocommerce') : esc_html__('Shipping address', 'woocommerce');

do_action('woocommerce_before_edit_account_address_form'); ?>

<?php if (!$load_address): ?>
	<?php wc_get_template('myaccount/my-address.php'); ?>
<?php else: ?>

	<div class="account-form-card">
		<form method="post" novalidate class="woocommerce-EditAddressForm edit-address">

			<h2><?php echo apply_filters('woocommerce_my_account_edit_address_title', $page_title, $load_address); ?></h2>
			<?php // @codingStandardsIgnoreLine ?>

			<div class="woocommerce-address-fields">
				<?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

				<div class="woocommerce-address-fields__field-wrapper">
					<?php
					foreach ($address as $key => $field) {
						// Ajout des classes pour harmoniser le style avec form-edit-account.php
						if (!isset($field['class']))
							$field['class'] = array();
						$field['class'][] = 'woocommerce-form-row';
						$field['input_class'][] = 'woocommerce-Input';
						// Appliquer le style custom au select si le type est défini et vaut 'select'
						if (isset($field['type']) && $field['type'] === 'select') {
							$field['input_class'][] = 'profile-select-style';
						}
						woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
					}
					?>
				</div>

				<?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>

				<p>
					<button type="submit"
						class="woocommerce-Button button account-form-btn<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
						name="save_address"
						value="<?php esc_attr_e('Save address', 'woocommerce'); ?>"><?php esc_html_e('Save address', 'woocommerce'); ?></button>
					<?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
					<input type="hidden" name="action" value="edit_address" />
				</p>
			</div>

		</form>
	</div>

<?php endif; ?>

<?php do_action('woocommerce_after_edit_account_address_form'); ?>