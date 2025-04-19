<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bo-theme
 */

?>

<?php if (is_active_sidebar('footer-widget-area')): ?>
    <div class="footer-widgets">
        <?php dynamic_sidebar('footer-widget-area'); ?>
    </div>
<?php endif; ?>


</div><!-- #page -->

<script>
    // Toggle mobile menu visibility - START
    document.getElementById('mobile-menu-toggle').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('-translate-x-full');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.add('-translate-x-full');
    });
    // Toggle mobile menu visibility - END

    // JS to handle add product to cart
    jQuery(document.body).on('added_to_cart', function () {
        jQuery(document.body).trigger('wc_fragment_refresh');
    });

    // Handle toggle cart panel visibility
    document.addEventListener('DOMContentLoaded', function () {
        const cartPanel = document.getElementById('cart-panel');
        const cartToggleButtons = [
            document.getElementById('shopping-cart-menu-toggle-desktop'),
            document.getElementById('shopping-cart-menu-toggle-mobile')
        ];
        const closeCartButton = document.getElementById('close-cart-panel');

        if (cartPanel && cartToggleButtons.every(button => button)) {

            cartToggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    cartPanel.classList.add('cart-panel-open');
                });
            });

            if (closeCartButton) {
                closeCartButton.addEventListener('click', () => {
                    cartPanel.classList.remove('cart-panel-open');
                });
            }

            document.addEventListener('click', (event) => {
                if (!cartPanel.contains(event.target) && !cartToggleButtons.some(button => button.contains(event.target))) {
                    cartPanel.classList.remove('cart-panel-open');
                }
            });
        } else {
            console.error('Cart panel or toggle buttons not found.');
        }
    });

    // Handle remove item from cart via AJAX
    jQuery(function ($) {
        $(document).on('click', '.btn-remove-item-from-cart', function (event) {
            event.preventDefault();
            var cartKey = $(this).closest('.product-card').data('cart-item-key');
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
                action: 'remove_from_cart',
                cart_item_key: cartKey
            }, function (response) {
                if (response.success) {
                    // Refresh WooCommerce cart fragments (cart body, total, count)
                    $(document.body).trigger('wc_fragment_refresh');
                } else {
                    alert(response.data.message || '<?php esc_html_e('Erreur lors de la suppression du produit.', 'bo-theme'); ?>');
                }
            });
        });
    });

    // Handle increase item quantity via AJAX
    jQuery(function ($) {
        $(document).on('click', '.btn-increase-item-in-cart', function (event) {
            event.preventDefault();
            var cartKey = $(this).closest('.product-card').data('cart-item-key');
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
                action: 'increase_cart_item',
                cart_item_key: cartKey
            }, function (response) {
                if (response.success) {
                    $(document.body).trigger('wc_fragment_refresh');
                } else {
                    alert(response.data.message || 'Erreur lors de l\'augmentation du produit.');
                }
            });
        });
    });

    // Handle decrease item quantity via AJAX
    jQuery(function ($) {
        $(document).on('click', '.btn-decrease-item-in-cart', function (event) {
            event.preventDefault();
            var cartKey = $(this).closest('.product-card').data('cart-item-key');
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
                action: 'decrease_cart_item',
                cart_item_key: cartKey
            }, function (response) {
                if (response.success) {
                    $(document.body).trigger('wc_fragment_refresh');
                } else {
                    alert(response.data.message || 'Erreur lors de la mise à jour du panier.');
                }
            });
        });
    });
</script>

<?php wp_footer(); ?>

</body>

</html>