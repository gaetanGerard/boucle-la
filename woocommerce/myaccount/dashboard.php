<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);

$title = 'Tableau de bord';
$message = sprintf(
	wp_kses(__('Hello %1$s (not %1$s? <a href="%2$s">Se déconnecter</a>)', 'woocommerce'), $allowed_html),
	'<strong>' . esc_html($current_user->display_name) . '</strong>',
	esc_url(wc_logout_url())
);
$message .= '<br>À partir du tableau de bord de votre compte, vous pouvez visualiser vos commandes récentes, gérer vos adresses de livraison et de facturation ainsi que changer votre mot de passe et les détails de votre compte.';
include __DIR__ . '/account-content-header.php';

/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_dashboard');

do_action('woocommerce_before_my_account');
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
