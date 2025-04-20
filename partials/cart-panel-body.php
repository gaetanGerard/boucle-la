<?php
if (!function_exists('WC') || !WC()->cart instanceof WC_Cart) {
    echo '<p>Erreur : le panier n’est pas disponible.</p>';
    return;
}
?>

<div
    class="cart-panel-body flex-1 flex flex-col items-center <?php echo WC()->cart->is_empty() ? 'justify-center empty-cart' : 'justify-start'; ?> space-y-4 w-full px-4">
    <?php if (WC()->cart->is_empty()): ?>
        <p><?php esc_html_e('Votre panier est actuellement vide.', 'bo-theme'); ?></p>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button btn-style">
            <?php esc_html_e('Aller à la boutique', 'bo-theme'); ?>
        </a>
    <?php else: ?>
        <h2 class="text-center text-3xl font-bold">Votre panier</h2>

        <ul class="cart-items w-full space-y-4">
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
                                <a href="<?php echo esc_url($product_permalink); ?>"
                                    class="text-black hover:underline block font-bold">
                                    <?php echo esc_html($product_name); ?>
                                </a>
                            <?php else: ?>
                                <span class="font-bold"><?php echo esc_html($product_name); ?></span>
                            <?php endif; ?>

                            <span class="text-gray-400 block">
                                <?php echo $product_price; ?>
                            </span>
                            <span class="text-gray-400 block">
                                <?php esc_html_e('Quantité :', 'bo-theme'); ?>         <?php echo esc_html($product_quantity); ?>
                            </span>
                        </div>
                    </div>

                    <div class="product-container-for-add-more-or-remove-qty w-1/4">
                        <button class="button btn-decrease-item-in-cart btn-product btn-product-qty" type="button">-</button>
                        <button class="button btn-increase-item-in-cart btn-product btn-product-qty" type="button">+</button>
                        <button class="button btn-remove-item-from-cart btn-product btn-product-delete" type="button">X</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="cart-total w-full mt-4 flex justify-between items-center pt-4">
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