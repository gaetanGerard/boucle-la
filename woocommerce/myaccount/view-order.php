<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

if (method_exists($order, 'get_notes')) {
	$notes = $order->get_notes();
} else {
	$notes = $order->get_customer_order_notes();
}

$order_number = $order->get_order_number();
$order_date = $order->get_date_created();
$order_status = wc_get_order_status_name($order->get_status());
$order_status_slug = $order->get_status();

$months = array(
	'January' => 'janvier',
	'February' => 'février',
	'March' => 'mars',
	'April' => 'avril',
	'May' => 'mai',
	'June' => 'juin',
	'July' => 'juillet',
	'August' => 'août',
	'September' => 'septembre',
	'October' => 'octobre',
	'November' => 'novembre',
	'December' => 'décembre'
);
$date_obj = $order_date ? $order_date->date_i18n('j F Y') : '';
foreach ($months as $en => $fr) {
	$date_obj = str_replace($en, $fr, $date_obj);
}
$subtitle = 'Commande effectuée le ' . $date_obj;

$status_colors = [
	'completed' => '#22c55e',
	'processing' => '#3b82f6',
	'on-hold' => '#fbbf24',
	'cancelled' => '#ef4444',
	'refunded' => '#6b7280',
	'failed' => '#ef4444',
	'pending' => '#f59e42',
];
$status_color = isset($status_colors[$order_status_slug]) ? $status_colors[$order_status_slug] : '#64748b';

$back_url = wc_get_account_endpoint_url('orders');

$title = 'Commande N°' . $order_number;
$status = $order_status;

include __DIR__ . '/account-content-header.php';

?>
<table
	class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
	<thead>
		<tr>
			<th><?php esc_html_e('Produit', 'woocommerce'); ?></th>
			<th><?php esc_html_e('Prix unitaire HT', 'woocommerce'); ?></th>
			<th><?php esc_html_e('Quantité', 'woocommerce'); ?></th>
			<th><?php esc_html_e('Total HT', 'woocommerce'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($order->get_items() as $item_id => $item):
			$product = $item->get_product();
			$qty = $item->get_quantity();
			$total_ht = $item->get_subtotal();
			$prix_unitaire_ht = $qty > 0 ? $total_ht / $qty : 0;
			?>
			<tr>
				<td data-title="<?php esc_attr_e('Produit', 'woocommerce'); ?>:">
					<?php echo esc_html($item->get_name()); ?>
				</td>
				<td data-title="<?php esc_attr_e('Prix unitaire HT', 'woocommerce'); ?>:">
					<?php echo wc_price($prix_unitaire_ht); ?>
				</td>
				<td data-title="<?php esc_attr_e('Quantité', 'woocommerce'); ?>:">
					<?php echo esc_html($qty); ?>
				</td>
				<td data-title="<?php esc_attr_e('Total HT', 'woocommerce'); ?>:">
					<?php echo wc_price($total_ht); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php
$subtotal_ht = $order->get_subtotal();
$shipping_total = $order->get_shipping_total();
$total_ttc = $order->get_total();
$taxes = $order->get_taxes();
$tva_label = 'TVA';
$tva_percent = null;
$tva_amount = 0;
if (!empty($taxes)) {
	foreach ($taxes as $tax) {
		if ($tax->get_rate_percent() !== '') {
			$tva_percent = floatval($tax->get_rate_percent());
			$tva_label = $tax->get_label();
			$tva_amount += floatval($tax->get_tax_total()) + floatval($tax->get_shipping_tax_total());
			break;
		}
	}
}
?>
<table class="woocommerce-order-totals-table">
	<tbody>
		<tr>
			<th><?php esc_html_e('Sous-total HT', 'woocommerce'); ?></th>
			<td><?php echo wc_price($subtotal_ht); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Frais de livraison', 'woocommerce'); ?></th>
			<td>
				<?php echo $shipping_total !== null ? wc_price($shipping_total) : '—'; ?>
			</td>
		</tr>
		<tr>
			<th>
				<?php echo esc_html($tva_label); ?>
				<?php if ($tva_percent !== null): ?>
					(<?php echo esc_html(number_format($tva_percent, 2)); ?>%)
				<?php endif; ?>
			</th>
			<td>
				<?php echo $tva_amount ? wc_price($tva_amount) : '—'; ?>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Total TTC', 'woocommerce'); ?></th>
			<td><strong><?php echo wc_price($total_ttc); ?></strong></td>
		</tr>
	</tbody>
</table>

<h2><?php esc_html_e('Historique de la commande', 'woocommerce'); ?></h2>
<table
	class="woocommerce-orders-table woocommerce-order-history-table shop_table shop_table_responsive my_account_orders account-orders-table">
	<thead>
		<tr>
			<th><?php esc_html_e('Date', 'woocommerce'); ?></th>
			<th><?php esc_html_e('Statut', 'woocommerce'); ?></th>
			<th><?php esc_html_e('Message', 'woocommerce'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td data-title="<?php esc_attr_e('Date', 'woocommerce'); ?>:">
				<?php echo esc_html($order_date ? $order_date->date_i18n(get_option('date_format') . ' ' . get_option('time_format')) : ''); ?>
			</td>
			<td data-title="<?php esc_attr_e('Statut', 'woocommerce'); ?>:">
				<?php esc_html_e('Création de la commande', 'woocommerce'); ?>
			</td>
			<td data-title="<?php esc_attr_e('Message', 'woocommerce'); ?>:">
				<?php echo esc_html($order_status); ?>
			</td>
		</tr>
		<?php if (!empty($notes)): ?>
			<?php foreach ($notes as $note): ?>
				<?php
				$content = wptexturize($note->comment_content);
				$is_status_change = false;
				$status_label = '';
				if (preg_match('/Statut de la commande changé de (.+) à (.+)/i', $content, $matches)) {
					$is_status_change = true;
					$status_label = sprintf(__('Changement de statut : %s', 'woocommerce'), $matches[2]);
				}
				?>
				<tr>
					<td data-title="<?php esc_attr_e('Date', 'woocommerce'); ?>:">
						<?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($note->comment_date)); ?>
					</td>
					<td data-title="<?php esc_attr_e('Statut', 'woocommerce'); ?>:">
						<?php echo $is_status_change ? esc_html($status_label) : esc_html__('Mise à jour', 'woocommerce'); ?>
					</td>
					<td data-title="<?php esc_attr_e('Message', 'woocommerce'); ?>:">
						<?php echo wpautop($content); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

<?php
$billing_address = array(
	'nom' => $order->get_billing_last_name(),
	'prénom' => $order->get_billing_first_name(),
	'adresse' => $order->get_billing_address_1(),
	'adresse (complément)' => $order->get_billing_address_2(),
	'ville' => $order->get_billing_city(),
	'code postal' => $order->get_billing_postcode(),
	'état/province' => '',
	'pays' => '',
	'email' => $order->get_billing_email(),
	'téléphone' => $order->get_billing_phone(),
);
$shipping_address = array(
	'nom' => $order->get_shipping_last_name(),
	'prénom' => $order->get_shipping_first_name(),
	'adresse' => $order->get_shipping_address_1(),
	'adresse (complément)' => $order->get_shipping_address_2(),
	'ville' => $order->get_shipping_city(),
	'code postal' => $order->get_shipping_postcode(),
	'état/province' => '',
	'pays' => '',
);

$billing_state = $order->get_billing_state();
$billing_country = $order->get_billing_country();
$shipping_state = $order->get_shipping_state();
$shipping_country = $order->get_shipping_country();

$billing_address['état/province'] = $billing_state ? (isset(WC()->countries->get_states($billing_country)[$billing_state]) ? WC()->countries->get_states($billing_country)[$billing_state] : $billing_state) : '';
$billing_address['pays'] = $billing_country ? (isset(WC()->countries->countries[$billing_country]) ? WC()->countries->countries[$billing_country] : $billing_country) : '';
$shipping_address['état/province'] = $shipping_state ? (isset(WC()->countries->get_states($shipping_country)[$shipping_state]) ? WC()->countries->get_states($shipping_country)[$shipping_state] : $shipping_state) : '';
$shipping_address['pays'] = $shipping_country ? (isset(WC()->countries->countries[$shipping_country]) ? WC()->countries->countries[$shipping_country] : $shipping_country) : '';

$addresses = [
	'billing' => ['title' => 'Adresse de facturation', 'fields' => $billing_address],
	'shipping' => ['title' => 'Adresse de livraison', 'fields' => $shipping_address],
];
?>

<div class="address-addresses-grid view-order-address-addresses-grid">
	<?php foreach ($addresses as $type => $data): ?>
		<div class="address-card">
			<header class="address-card-header">
				<h2 class="address-title"><?php echo esc_html($data['title']); ?></h2>
			</header>
			<address class="address-content">
				<div class="address-extra-fields">
					<?php foreach ($data['fields'] as $label => $value): ?>
						<?php if (!empty($value)): ?>
							<div class="address-field-row">
								<strong><?php echo ucfirst(esc_html($label)); ?> :</strong>
								<span><?php echo esc_html($value); ?></span>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</address>
		</div>
	<?php endforeach; ?>
</div>