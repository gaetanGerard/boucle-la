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

$notes = $order->get_customer_order_notes();

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
<?php if ($notes): ?>
	<h2><?php esc_html_e('Order updates', 'woocommerce'); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ($notes as $note): ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta">
							<?php echo date_i18n(esc_html__('l jS \o\f F Y, h:ia', 'woocommerce'), strtotime($note->comment_date)); ?>
						</p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wpautop(wptexturize($note->comment_content)); ?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action('woocommerce_view_order', $order_id); ?>