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
    const cartToggleButtons = [
        document.getElementById('shopping-cart-menu-toggle-desktop'),
        document.getElementById('shopping-cart-menu-toggle-mobile')
    ];
    const closeCartButton = document.getElementById('close-cart-panel');

    if (cartPanel && cartToggleButtons.every(button => button)) {
        console.log('Cart panel and toggle buttons found.');

        cartToggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                console.log('Toggle button clicked.');
                cartPanel.classList.add('cart-panel-open');
                console.log('cart-panel-open class added:', cartPanel.classList.contains('cart-panel-open'));
            });
        });

        if (closeCartButton) {
            closeCartButton.addEventListener('click', () => {
                console.log('Close button clicked.');
                cartPanel.classList.remove('cart-panel-open');
                console.log('cart-panel-open class removed:', !cartPanel.classList.contains('cart-panel-open'));
            });
        }

        document.addEventListener('click', (event) => {
            if (!cartPanel.contains(event.target) && !cartToggleButtons.some(button => button.contains(event.target))) {
                console.log('Clicked outside cart panel.');
                cartPanel.classList.remove('cart-panel-open');
                console.log('cart-panel-open class removed:', !cartPanel.classList.contains('cart-panel-open'));
            }
        });
    } else {
        console.error('Cart panel or toggle buttons not found.');
    }
});
</script>

<?php wp_footer(); ?>

</body>
</html>
