<?php

// Désactivation de la logique d'ajout au panier pour la carte cadeau (tout le code gift_card)
// add_filter('woocommerce_add_to_cart_validation', 'validate_custom_gift_card_fields', 10, 3);
// add_filter('woocommerce_add_cart_item_data', 'add_gift_card_fields_to_cart', 10, 2);
// add_filter('woocommerce_get_item_data', 'display_gift_card_fields_in_cart', 10, 2);
// add_action('woocommerce_before_calculate_totals', 'set_custom_gift_card_price', 10, 1);

// function validate_custom_gift_card_fields($passed, $product_id, $quantity) { /* ... */ }
// function add_gift_card_fields_to_cart($cart_item_data, $product_id) { /* ... */ }
// function display_gift_card_fields_in_cart($item_data, $cart_item) { /* ... */ }
// function set_custom_gift_card_price($cart) { /* ... */ }
// add_action('woocommerce_before_calculate_totals', 'set_custom_gift_card_price', 10, 1);
