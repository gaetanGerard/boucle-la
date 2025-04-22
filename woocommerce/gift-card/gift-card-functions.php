<?php
// Generate a unique coupon code when a gift card is purchased
add_action('woocommerce_new_order', function ($order_id) {
    $order = wc_get_order($order_id);
    if (!$order)
        return;
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        if ($product && $product->get_type() === 'gift_card') {
            // Generate a unique coupon code
            $code = 'GC-' . strtoupper(wp_generate_password(10, false, false));
            $amount = $item->get_total();
            $validity_months = get_post_meta($product->get_id(), '_gift_card_validity_months', true);
            $validity_months = $validity_months ? intval($validity_months) : 12;
            // Calculate expiry date
            $now = new DateTime('now', wp_timezone());
            $expiry = $now->modify("+{$validity_months} months")->format('Y-m-d');
            // Create the coupon
            $coupon_id = wp_insert_post(array(
                'post_title' => $code,
                'post_content' => __('Carte cadeau générée automatiquement', 'bo-theme'),
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
                'post_type' => 'shop_coupon',
            ));
            if ($coupon_id) {
                update_post_meta($coupon_id, 'discount_type', 'fixed_cart');
                update_post_meta($coupon_id, 'coupon_amount', $amount);
                update_post_meta($coupon_id, 'individual_use', 'no');
                update_post_meta($coupon_id, 'usage_limit', 1);
                update_post_meta($coupon_id, 'date_expires', strtotime($expiry));
                update_post_meta($coupon_id, 'gift_card_order_id', $order_id);
                update_post_meta($coupon_id, 'gift_card_product_id', $product->get_id());
                wc_add_order_item_meta($item_id, '_gift_card_code', $code);
                $order->add_order_note(sprintf(__('Carte cadeau générée : %s (valeur : %s €, expiration : %s)', 'bo-theme'), $code, wc_price($amount), $expiry));
            }
        }
    }
});

// Add the validity period in the order details for gift cards
add_action('woocommerce_after_order_itemmeta', function ($item_id, $item, $product) {
    if ($product && $product->get_type() === 'gift_card') {
        $gift_card_code = wc_get_order_item_meta($item_id, '_gift_card_code', true);
        if ($gift_card_code) {
            $coupon = get_page_by_title($gift_card_code, OBJECT, 'shop_coupon');
            if ($coupon) {
                $expiry_timestamp = get_post_meta($coupon->ID, 'date_expires', true);
                if ($expiry_timestamp) {
                    $expiry = date_i18n(get_option('date_format'), $expiry_timestamp);
                    echo '<p><strong>' . __('Validité jusqu\'au', 'bo-theme') . ':</strong> ' . esc_html($expiry) . '</p>';
                }
            }
        }
    }
}, 10, 3);

// display gift card code with a custom title in the order details
add_filter('woocommerce_order_item_display_meta_key', function ($display_key, $meta, $item) {
    if ($meta->key === '_gift_card_code') {
        return __('Code carte cadeau', 'bo-theme');
    }
    return $display_key;
}, 10, 3);

// Rename the gift card fields in the order admin
add_filter('woocommerce_order_item_display_meta_key', function ($display_key, $meta, $item) {
    switch ($meta->key) {
        case '_gift_card_amount':
            return __('Carte cadeau total', 'bo-theme');
        case '_gift_card_sender':
            return __('Carte cadeau de', 'bo-theme');
        case '_gift_card_recipient':
            return __('Carte cadeau pour', 'bo-theme');
        case '_gift_card_email':
            return __('Email', 'bo-theme');
        case '_gift_card_message':
            return __('Message', 'bo-theme');
    }
    return $display_key;
}, 10, 3);

// Format the gift card amount in the order details
add_filter('woocommerce_order_item_display_meta_value', function ($display_value, $meta, $item) {
    if ($meta->key === '_gift_card_amount') {
        return wc_price($meta->value);
    }
    return $display_value;
}, 10, 3);

// Deal with the custom amount for the gift card when adding to cart
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['gift_card_amount'])) {
        $cart_item_data['gift_card_amount'] = floatval($_POST['gift_card_amount']);
    }
    if (isset($_POST['gift_card_sender'])) {
        $cart_item_data['gift_card_sender'] = sanitize_text_field($_POST['gift_card_sender']);
    }
    if (isset($_POST['gift_card_recipient'])) {
        $cart_item_data['gift_card_recipient'] = sanitize_text_field($_POST['gift_card_recipient']);
    }
    if (isset($_POST['gift_card_email'])) {
        $cart_item_data['gift_card_email'] = sanitize_email($_POST['gift_card_email']);
    }
    if (isset($_POST['gift_card_message'])) {
        $cart_item_data['gift_card_message'] = sanitize_textarea_field($_POST['gift_card_message']);
    }
    return $cart_item_data;
}, 10, 3);

// Display the custom amount in the cart
add_filter('woocommerce_get_cart_item_from_session', function ($cart_item, $values) {
    if (isset($values['gift_card_amount'])) {
        $cart_item['gift_card_amount'] = $values['gift_card_amount'];
    }
    if (isset($values['gift_card_sender'])) {
        $cart_item['gift_card_sender'] = $values['gift_card_sender'];
    }
    if (isset($values['gift_card_recipient'])) {
        $cart_item['gift_card_recipient'] = $values['gift_card_recipient'];
    }
    if (isset($values['gift_card_email'])) {
        $cart_item['gift_card_email'] = $values['gift_card_email'];
    }
    if (isset($values['gift_card_message'])) {
        $cart_item['gift_card_message'] = $values['gift_card_message'];
    }
    return $cart_item;
}, 10, 2);

// Define the price of the gift card product according to the amount entered
// (this is a workaround to set the price of the product in the cart)
add_action('woocommerce_before_calculate_totals', function ($cart) {
    if (is_admin() && !defined('DOING_AJAX'))
        return;
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['gift_card_amount']) && $cart_item['data']->get_type() === 'gift_card') {
            $cart_item['data']->set_price($cart_item['gift_card_amount']);
        }
    }
});

// Display the custom amount in the cart and order
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (isset($cart_item['gift_card_amount'])) {
        $item_data[] = array(
            'name' => __('Montant carte cadeau', 'bo-theme'),
            'value' => wc_price($cart_item['gift_card_amount'])
        );
    }
    if (isset($cart_item['gift_card_sender'])) {
        $item_data[] = array(
            'name' => __('Offert par', 'bo-theme'),
            'value' => esc_html($cart_item['gift_card_sender'])
        );
    }
    if (isset($cart_item['gift_card_recipient'])) {
        $item_data[] = array(
            'name' => __('Destinataire', 'bo-theme'),
            'value' => esc_html($cart_item['gift_card_recipient'])
        );
    }
    if (isset($cart_item['gift_card_email'])) {
        $item_data[] = array(
            'name' => __('Email du destinataire', 'bo-theme'),
            'value' => esc_html($cart_item['gift_card_email'])
        );
    }
    if (isset($cart_item['gift_card_message']) && $cart_item['gift_card_message']) {
        $item_data[] = array(
            'name' => __('Message', 'bo-theme'),
            'value' => esc_html($cart_item['gift_card_message'])
        );
    }
    return $item_data;
}, 10, 2);

// Save the custom fields in the order item meta
add_action('woocommerce_add_order_item_meta', function ($item_id, $values) {
    if (isset($values['gift_card_amount'])) {
        wc_add_order_item_meta($item_id, '_gift_card_amount', $values['gift_card_amount']);
    }
    if (isset($values['gift_card_sender'])) {
        wc_add_order_item_meta($item_id, '_gift_card_sender', $values['gift_card_sender']);
    }
    if (isset($values['gift_card_recipient'])) {
        wc_add_order_item_meta($item_id, '_gift_card_recipient', $values['gift_card_recipient']);
    }
    if (isset($values['gift_card_email'])) {
        wc_add_order_item_meta($item_id, '_gift_card_email', $values['gift_card_email']);
    }
    if (isset($values['gift_card_message'])) {
        wc_add_order_item_meta($item_id, '_gift_card_message', $values['gift_card_message']);
    }
}, 10, 2);

// Send the gift card code by email after payment
add_action('woocommerce_order_status_completed', function ($order_id) {
    $order = wc_get_order($order_id);
    if (!$order)
        return;
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if ($product && $product->get_type() === 'gift_card') {
            $recipient_email = wc_get_order_item_meta($item->get_id(), '_gift_card_email', true);
            $gift_card_code = wc_get_order_item_meta($item->get_id(), '_gift_card_code', true);
            $amount = wc_get_order_item_meta($item->get_id(), '_gift_card_amount', true);
            $expiry = '';
            $message = wc_get_order_item_meta($item->get_id(), '_gift_card_message', true);
            $recipient_name = wc_get_order_item_meta($item->get_id(), '_gift_card_recipient', true);
            $coupon = get_page_by_title($gift_card_code, OBJECT, 'shop_coupon');
            if ($coupon) {
                $expiry_timestamp = get_post_meta($coupon->ID, 'date_expires', true);
                if ($expiry_timestamp) {
                    $expiry = date_i18n(get_option('date_format'), $expiry_timestamp);
                }
            }
            if ($recipient_email && $gift_card_code) {
                $subject = __('Votre carte cadeau', 'bo-theme');
                $mailer = WC()->mailer();
                $html_message = wc_get_template_html(
                    'emails/email-gift-card.php',
                    [
                        'gift_card_code' => $gift_card_code,
                        'amount' => wc_price($amount),
                        'expiry' => $expiry,
                        'order' => $order,
                        'recipient_name' => $recipient_name,
                        'message' => $message,
                    ]
                );
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $mailer->send($recipient_email, $subject, $html_message, $headers);
            }
        }
    }
});
