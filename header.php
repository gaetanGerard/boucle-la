<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package bo-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bo-theme' ); ?></a>

    <header id="masthead" class="site-header bg-black text-white">
        <div class="px-4 flex items-center justify-end gap-4">
            <div class="flex-1">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'left-menu',
                        'menu_id'        => 'left-menu',
                        'container'      => false,
                        'menu_class'     => 'flex text-lg font-medium justify-end gap-10 m-0',
                    )
                );
                ?>
            </div>
            <div class="site-branding flex-shrink-0 mx-10">
                <?php the_custom_logo(); ?>
            </div>
			<div class="flex-1 flex justify-between w-full">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'right-menu',
                        'menu_id'        => 'right-menu',
                        'container'      => false,
                        'menu_class'     => 'flex text-lg font-medium justify-start gap-10 m-0',
                    )
                );
                ?>
            <div class="flex items-center justify-self-end">
                <a href="#" class="text-white text-2xl">
					TEMP
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
			</div>
        </div>
    </header>
</div>
