<?php
// Ce fichier est requis pour que le thème soit valide
get_header(); ?>

<main>
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Aucun contenu trouvé.</p>
    <?php endif; ?>
</main>

<?php get_footer();
