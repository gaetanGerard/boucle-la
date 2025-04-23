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
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'bo-theme'); ?></a>

        <header id="masthead" class="site-header">
            <div class="header-inner">
                <!-- Menu hamburger -->
                <div class="menu-hamburger">
                    <button id="shopping-cart-menu-toggle-desktop" class="btn-icon">
                        <i class="fas fa-shopping-cart">
                            <?php if (WC()->cart->get_cart_contents_count() > 0): ?>
                                <span class="cart-count">
                                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                                </span>
                            <?php endif; ?>
                        </i>
                    </button>
                    <button id="mobile-menu-toggle" class="btn-icon">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Left menu -->
                <div class="header-left-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'left-menu',
                        'menu_id' => 'left-menu',
                        'container' => false,
                        'menu_class' => 'header-menu',
                    ));
                    ?>
                </div>

                <!-- Logo -->
                <div class="header-logo">
                    <?php the_custom_logo(); ?>
                </div>

                <!-- Right menu -->
                <div class="header-right-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'right-menu',
                        'menu_id' => 'right-menu',
                        'container' => false,
                        'menu_class' => 'header-menu',
                    ));
                    ?>
                    <button id="shopping-cart-menu-toggle-mobile" class="btn-icon">
                        <i class="fas fa-shopping-cart">
                            <?php if (WC()->cart->get_cart_contents_count() > 0): ?>
                                <span class="cart-count">
                                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                                </span>
                            <?php endif; ?>
                        </i>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <nav id="mobile-menu" class="mobile-menu">
                <div class="mobile-menu-inner">
                    <div class="mobile-menu-header">
                        <div class="header-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                        <button id="close-mobile-menu" class="btn-icon btn-close-mobile-menu">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mobile-menu-content">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'left-menu',
                            'menu_id' => 'mobile-left-menu',
                            'container' => false,
                            'menu_class' => 'mobile-header-menu',
                        ));
                        wp_nav_menu(array(
                            'theme_location' => 'right-menu',
                            'menu_id' => 'mobile-right-menu',
                            'container' => false,
                            'menu_class' => 'mobile-header-menu',
                        ));
                        ?>
                    </div>
                </div>
            </nav>
        </header>

        <div id="cart-panel" class="cart-panel">
            <div class="cart-panel-header">
                <div class="header-logo">
                    <?php the_custom_logo(); ?>
                </div>
                <button id="close-cart-panel" class="btn-icon btn-close-cart-panel">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php get_template_part('partials/cart-panel-body'); ?>
        </div>
    </div>
</body>

</html>