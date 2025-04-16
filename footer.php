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

<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
    <div class="footer-widgets">
        <?php dynamic_sidebar( 'footer-widget-area' ); ?>
    </div>
<?php endif; ?>


</div><!-- #page -->

<script>
// Toggle mobile menu visibility - START
document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('-translate-x-full');
});

document.getElementById('close-mobile-menu').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.add('-translate-x-full');
});
// Toggle mobile menu visibility - END

// JS to handle add product to cart
jQuery(document.body).on('added_to_cart', function() {
    jQuery(document.body).trigger('wc_fragment_refresh');
});

document.addEventListener('DOMContentLoaded', function () {
    const cartPanel = document.getElementById('cart-panel');

    // Ensure the cart panel is closed by default
    cartPanel.classList.add('-translate-x-full');

    const cartToggleButtons = [
        document.getElementById('shopping-cart-menu-toggle-desktop'),
        document.getElementById('shopping-cart-menu-toggle-mobile')
    ];
    const closeCartButton = document.getElementById('close-cart-panel');

    cartToggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            cartPanel.classList.toggle('-translate-x-full');
        });
    });

    closeCartButton.addEventListener('click', () => {
        cartPanel.classList.add('-translate-x-full');
    });

    document.addEventListener('click', (event) => {
        if (!cartPanel.contains(event.target) && !cartToggleButtons.some(button => button.contains(event.target))) {
            cartPanel.classList.add('-translate-x-full');
        }
    });
});
</script>

<?php wp_footer(); ?>

</body>
</html>
