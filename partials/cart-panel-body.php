<?php
if (!function_exists('WC') || !WC()->cart instanceof WC_Cart) {
    echo '<p>Erreur : le panier n’est pas disponible.</p>';
    return;
}
?>

<div class="cart-panel-body<?php echo WC()->cart->is_empty() ? ' empty-cart' : ''; ?>">
    <?php if (WC()->cart->is_empty()): ?>
        <p><?php esc_html_e('Votre panier est actuellement vide.', 'bo-theme'); ?></p>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button btn-style">
            <?php esc_html_e('Aller à la boutique', 'bo-theme'); ?>
        </a>
    <?php else: ?>
        <h2 class="cart-panel-title">Votre panier</h2>
        <ul class="cart-items">
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                $product = $cart_item['data'];
                $product_name = $product->get_name();

                if (isset($cart_item['gift_card']['amount'])) {
                    $product_price = wc_price($cart_item['gift_card']['amount']);
                } else {
                    $product_price = wc_price($product->get_price());
                }

                $product_quantity = $cart_item['quantity'];
                $product_permalink = $product->is_visible() ? $product->get_permalink() : '';
                $product_image = $product->get_image('thumbnail');
                ?>
                <li class="product-card" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                    <div class="product-container">
                        <div class="product-img">
                            <?php echo $product_image; ?>
                        </div>
                        <div class="product-content">
                            <?php if ($product_permalink): ?>
                                <a href="<?php echo esc_url($product_permalink); ?>" class="product-link">
                                    <?php echo esc_html($product_name); ?>
                                </a>
                            <?php else: ?>
                                <span class="product-title"><?php echo esc_html($product_name); ?></span>
                            <?php endif; ?>

                            <?php if ($product->get_type() === 'gift_card'): ?>
                                <?php
                                if (isset($cart_item['gift_card_amount'])) {
                                    echo '<div class="product-meta">Montant : ' . wc_price($cart_item['gift_card_amount']) . '</div>';
                                }
                                if (isset($cart_item['gift_card_sender'])) {
                                    echo '<div class="product-meta">Offert par : ' . esc_html($cart_item['gift_card_sender']) . '</div>';
                                }
                                if (isset($cart_item['gift_card_recipient'])) {
                                    echo '<div class="product-meta">Destinataire : ' . esc_html($cart_item['gift_card_recipient']) . '</div>';
                                }
                                if (isset($cart_item['gift_card_email'])) {
                                    echo '<div class="product-meta">Email : ' . esc_html($cart_item['gift_card_email']) . '</div>';
                                }
                                if (isset($cart_item['gift_card_message']) && $cart_item['gift_card_message']) {
                                    echo '<div class="product-meta">Message : ' . esc_html($cart_item['gift_card_message']) . '</div>';
                                }
                                ?>
                            <?php else: ?>
                                <span class="product-meta">
                                    <?php echo $product_price; ?>
                                </span>
                            <?php endif; ?>
                            <span class="product-meta">
                                <?php esc_html_e('Quantité :', 'bo-theme'); ?>         <?php echo esc_html($product_quantity); ?>
                            </span>
                        </div>
                    </div>

                    <div class="product-container-for-add-more-or-remove-qty">
                        <button class="button btn-decrease-item-in-cart btn-product btn-product-qty" type="button">-</button>
                        <button class="button btn-increase-item-in-cart btn-product btn-product-qty" type="button">+</button>
                        <button class="button btn-remove-item-from-cart btn-product btn-product-delete" type="button">X</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="cart-total">
            <span>
                <?php esc_html_e('Total :', 'bo-theme'); ?>
                <span class="custom-cart-total">
                    <?php echo WC()->cart->get_cart_total(); ?>
                </span>
            </span>
            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="button btn-style">
                <?php esc_html_e('Commander', 'bo-theme'); ?>
            </a>
        </div>
    <?php endif; ?>
</div>