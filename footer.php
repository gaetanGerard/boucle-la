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
window.document.addEventListener(
  'wc-blocks_product_list_rendered',
  ( e ) => {
    const { collection } = e.detail;
    console.log( collection ) // -> collection name, e.g. woocommerce/product-collection/on-sale
  }
);

jQuery(document.body).on('added_to_cart', function() {
    jQuery(document.body).trigger('wc_fragment_refresh');
});

</script>

<?php wp_footer(); ?>

</body>
</html>
