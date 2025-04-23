<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bo-theme
 */

get_header();
?>
<main id="primary" class="site-main page-404-wrapper">
	<img src="<?php echo get_template_directory_uri(); ?>/img/404.jpg" alt="404 Not Found" />
	<h1>Oops la page que vous recherchez n'existe pas&nbsp;!</h1>
	<a href="/" class="btn-home">Retour à l'accueil</a>
</main>
<?php
get_footer();
