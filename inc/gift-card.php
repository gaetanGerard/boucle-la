<?php

add_filter('woocommerce_add_to_cart_validation', 'validate_custom_gift_card_fields', 10, 3);
add_filter('woocommerce_add_cart_item_data', 'add_gift_card_fields_to_cart', 10, 2);
add_filter('woocommerce_get_item_data', 'display_gift_card_fields_in_cart', 10, 2);
add_action('woocommerce_before_calculate_totals', 'set_custom_gift_card_price', 10, 1);

// 1. Validate Fields function
function validate_custom_gift_card_fields($passed, $product_id, $quantity)
{
    $product = wc_get_product($product_id);
    if ($product && $product->get_slug() === 'carte-cadeau') {
        if (empty($_POST['gift_card_amount']) || floatval($_POST['gift_card_amount']) < 5) {
            wc_add_notice('Le montant minimum est de 5€.', 'error');
            return false;
        }
        if (empty($_POST['gift_card_sender']) || empty($_POST['gift_card_recipient']) || empty($_POST['gift_card_email'])) {
            wc_add_notice('Veuillez remplir tous les champs obligatoires.', 'error');
            return false;
        }
    }
    return $passed;
}

// 2. Add to Cart function
function add_gift_card_fields_to_cart($cart_item_data, $product_id)
{
    $product = wc_get_product($product_id);
    if ($product && $product->get_slug() === 'carte-cadeau') {
        $cart_item_data['gift_card'] = [
            'sender' => sanitize_text_field($_POST['gift_card_sender']),
            'recipient' => sanitize_text_field($_POST['gift_card_recipient']),
            'email' => sanitize_email($_POST['gift_card_email']),
            'message' => sanitize_textarea_field($_POST['gift_card_message']),
            'amount' => floatval($_POST['gift_card_amount']),
        ];

        $cart_item_data['unique_key'] = md5(microtime() . rand());
    }
    return $cart_item_data;
}

// 3. Show in Cart function
function display_gift_card_fields_in_cart($item_data, $cart_item)
{
    if (isset($cart_item['gift_card'])) {
        $item_data[] = ['name' => 'Offert par', 'value' => $cart_item['gift_card']['sender']];
        $item_data[] = ['name' => 'Destinataire', 'value' => $cart_item['gift_card']['recipient']];
        $item_data[] = ['name' => 'Email', 'value' => $cart_item['gift_card']['email']];
        if (!empty($cart_item['gift_card']['message'])) {
            $item_data[] = ['name' => 'Message', 'value' => $cart_item['gift_card']['message']];
        }
        $item_data[] = ['name' => 'Montant offert', 'value' => wc_price($cart_item['gift_card']['amount'])];
    }
    return $item_data;
}

// 4. Apply custom price of gift cart as price of item
function set_custom_gift_card_price($cart)
{
    if (is_admin() && !defined('DOING_AJAX'))
        return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['gift_card']['amount'])) {
            $cart_item['data']->set_price($cart_item['gift_card']['amount']);
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'set_custom_gift_card_price', 10, 1);
