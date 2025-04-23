<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined('ABSPATH') || exit;

$title = 'Mes adresses';
$message = 'Gérez ici vos adresses de facturation et de livraison. Ces informations seront utilisées par défaut lors de vos commandes.';
include __DIR__ . '/account-content-header.php';

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __('Billing address', 'woocommerce'),
			'shipping' => __('Shipping address', 'woocommerce'),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __('Billing address', 'woocommerce'),
		),
		$customer_id
	);
}

$oldcol = 1;
$col = 1;
?>

<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()): ?>
	<div class="address-addresses-grid">
	<?php endif; ?>

	<?php foreach ($get_addresses as $name => $address_title): ?>
		<?php
		$col = $col * -1;
		$oldcol = $oldcol * -1;
		$fields = array(
			'nom' => get_user_meta($customer_id, $name . '_last_name', true),
			'prénom' => get_user_meta($customer_id, $name . '_first_name', true),
			'adresse' => get_user_meta($customer_id, $name . '_address_1', true),
			'adresse (complément)' => get_user_meta($customer_id, $name . '_address_2', true),
			'ville' => get_user_meta($customer_id, $name . '_city', true),
			'code postal' => get_user_meta($customer_id, $name . '_postcode', true),
			'état/province' => '',
			'pays' => '',
		);
		$state = get_user_meta($customer_id, $name . '_state', true);
		$country = get_user_meta($customer_id, $name . '_country', true);
		$fields['état/province'] = $state ? (isset(WC()->countries->get_states($country)[$state]) ? WC()->countries->get_states($country)[$state] : $state) : '';
		$fields['pays'] = $country ? (isset(WC()->countries->countries[$country]) ? WC()->countries->countries[$country] : $country) : '';
		?>

		<div class="address-card">
			<header class="address-card-header">
				<h2 class="address-title"><?php echo esc_html($address_title); ?></h2>
				<a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>"
					class="address-edit-btn button">
					<?php
					$has_address = false;
					foreach ($fields as $value) {
						if (!empty($value)) {
							$has_address = true;
							break;
						}
					}
					if ($has_address) {
						printf(esc_html__('Edit %s', 'woocommerce'), esc_html($address_title));
					} else {
						if ($name === 'billing') {
							echo esc_html__('Ajouter une adresse de facturation', 'bo-theme');
						} elseif ($name === 'shipping') {
							echo esc_html__('Ajouter une adresse de livraison', 'bo-theme');
						} else {
							echo esc_html__('Ajouter une adresse', 'bo-theme');
						}
					}
					?>
				</a>
			</header>
			<address class="address-content">
				<?php
				echo '<div class="address-extra-fields">';
				foreach ($fields as $label => $value) {
					if (!empty($value)) {
						echo '<div class="address-field-row"><strong>' . ucfirst($label) . ' :</strong><span>' . esc_html($value) . '</span></div>';
					}
				}
				echo '</div>';
				do_action('woocommerce_my_account_after_my_address', $name);
				?>
			</address>
		</div>

	<?php endforeach; ?>

	<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()): ?>
	</div>
<?php endif; ?>