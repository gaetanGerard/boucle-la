<?php
/**
 * bo-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bo-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function bo_theme_setup() {
	load_theme_textdomain( 'bo-theme', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	// Register multiple navigation menus
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'bo-theme' ),
			'left-menu'  => __( 'Left Menu', 'bo-theme' ),
			'right-menu' => __( 'Right Menu', 'bo-theme' )
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'bo_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	// Support du logo personnalisé
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'bo_theme_setup' );

/**
 * Set the content width in pixels.
 */
function bo_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bo_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'bo_theme_content_width', 0 );

/**
 * Register widget area.
 */
function bo_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bo-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bo-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
    register_sidebar( array(
        'name'          => 'Footer Widget Area',
        'id'            => 'footer-widget-area',
        'before_widget' => '<div class="footer-widget flex justify-center items-center">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'bo_theme_widgets_init' );

// Add font from googlefont
function bo_theme_enqueue_fonts() {
    wp_enqueue_style(
        'bo-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
        false
    );
}
add_action( 'wp_enqueue_scripts', 'bo_theme_enqueue_fonts' );

// Apply color customizations in the head
function bo_theme_customize_nav_colors() {
    $nav_link_color = get_theme_mod( 'nav_link_color', '#0073aa' );
    $nav_link_hover_color = get_theme_mod( 'nav_link_hover_color', '#005177' );
	$button_color = get_theme_mod( 'button_color', '#ee0e5b' );
    $button_hover = get_theme_mod( 'button_hover_color', '#f23b78' );
    ?>
    <style type="text/css">
        #masthead a {
            color: <?php echo esc_attr( $nav_link_color ); ?>;
        }
        #masthead a:hover, .footer-widgets a:hover {
            color: <?php echo esc_attr( $nav_link_hover_color ); ?>;
			text-decoration: underline;
        }
		#shopping-cart-menu-toggle:hover {
			color: <?php echo esc_attr( $nav_link_hover_color ); ?>;
		}
		.site-header, .footer-widgets {
            background-color: <?php echo get_theme_mod( 'nav_background_color', '#000000' ); ?> !important;
        }
		.wp-block-button__link {
            background-color: <?php echo esc_html( $button_color ); ?>;
            color: <?php echo esc_html( $nav_link_color ); ?> !important;
            border-radius: 0;
            transition: background-color 0.3s ease;
        }
        .wp-block-button__link:hover {
            background-color: <?php echo esc_html( $button_hover ); ?> !important;
			color: <?php echo esc_html( $nav_link_color ); ?> !important;
        }
		.wp-block-group {
			padding: 0 !important;
		}
    </style>
    <?php
}
add_action( 'wp_head', 'bo_theme_customize_nav_colors' );


/**
 * Enqueue scripts and styles.
 */
function bo_theme_scripts() {
	wp_enqueue_style( 'bo-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'bo-theme-style', 'rtl', 'replace' );

	wp_enqueue_style( 'bo-theme-reset', get_template_directory_uri() . '/css/reset.css', array(), _S_VERSION );
	wp_enqueue_script( 'bo-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bo_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}