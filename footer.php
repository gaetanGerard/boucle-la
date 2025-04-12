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
document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('-translate-x-full'); // Ouvre le menu en supprimant la classe
});

document.getElementById('close-mobile-menu').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.add('-translate-x-full'); // Ferme le menu en ajoutant la classe
});
</script>

<?php wp_footer(); ?>

</body>
</html>
