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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bo-theme' ); ?></a>

    <header id="masthead" class="site-header bg-black text-white fixed top-0 left-0 z-10 w-full">
    <div class="px-4 flex items-center justify-between relative h-[100px] md:h-[120px] shadow-lg">
        <!-- Menu hamburger (mobile only) -->
        <div class="lg:hidden flex text-white text-2xl order-3">
            <button id="shopping-cart-menu-toggle" class="bg-transparent border-none cursor-pointer text-white text-2xl ml-4 relative">
                <i class="fas fa-shopping-cart relative">
                    <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                        <span class="cart-count absolute bottom-[-10px] right-[-10px] bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                    <?php endif; ?>
                </i>
            </button>
            <button id="mobile-menu-toggle" class="bg-transparent border-none cursor-pointer text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Left menu (desktop only) -->
        <div class="hidden lg:flex flex-1 justify-end order-1">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'left-menu',
                'menu_id'        => 'left-menu',
                'container'      => false,
                'menu_class'     => 'flex text-lg font-medium gap-10 m-0',
            ));
            ?>
        </div>

        <!-- Logo -->
        <div class="site-branding mx-10 w-[80px] md:w-[100px] flex-shrink-0 order-2">
            <?php the_custom_logo(); ?>
        </div>

        <!-- Right menu (desktop only) -->
        <div class="hidden lg:flex flex-1 justify-start items-center order-3">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'right-menu',
                'menu_id'        => 'right-menu',
                'container'      => false,
                'menu_class'     => 'flex text-lg font-medium gap-10 m-0',
            ));
            ?>
            <button id="shopping-cart-menu-toggle" class="bg-transparent border-none cursor-pointer text-white text-2xl ml-4 relative">
                <i class="fas fa-shopping-cart relative">
                    <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                        <span class="cart-count absolute bottom-[-10px] right-[-10px] bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                    <?php endif; ?>
                </i>
            </button>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <nav id="mobile-menu" class="lg:hidden fixed inset-0 bg-black text-white transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex flex-col px-4 py-16 space-y-4">
            <div class="flex flex-row-reverse justify-between text-white text-2xl gap-4">
                <div class="site-branding mx-10 w-[80px] md:w-[100px] flex-shrink-0 order-2">
                    <?php the_custom_logo(); ?>
                </div>
                <button id="close-mobile-menu" class="text-white text-2xl self-end bg-transparent border-none cursor-pointer mb-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="flex-1">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'left-menu',
                    'menu_id'        => 'mobile-left-menu',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-4',
                ));
                wp_nav_menu(array(
                    'theme_location' => 'right-menu',
                    'menu_id'        => 'mobile-right-menu',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-4',
                ));
                ?>
            </div>
        </div>
    </nav>
</header>
</div>
