<?php
/**
 * bo-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bo-theme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function bo_theme_setup()
{
	load_theme_textdomain('bo-theme', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// Register multiple navigation menus
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'bo-theme'),
			'left-menu' => __('Left Menu', 'bo-theme'),
			'right-menu' => __('Right Menu', 'bo-theme')
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

	add_theme_support('customize-selective-refresh-widgets');

	// Support du logo personnalisé
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'bo_theme_setup');

/**
 * Set the content width in pixels.
 */
function bo_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('bo_theme_content_width', 640);
}
add_action('after_setup_theme', 'bo_theme_content_width', 0);

/**
 * Register widget area.
 */
function bo_theme_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'bo-theme'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'bo-theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
	register_sidebar(array(
		'name' => 'Footer Widget Area',
		'id' => 'footer-widget-area',
		'before_widget' => '<div class="footer-widget flex justify-center items-center">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="footer-widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init', 'bo_theme_widgets_init');

remove_all_actions('woocommerce_after_shop_loop_item');

// change style of the button for the product card
// Add a condition to check if the product is in stock or not
// If the product is not in stock, add a class to the button and change the text
add_action('woocommerce_after_shop_loop_item', function () {
	global $product;

	if (!$product->is_in_stock()) {
		echo apply_filters(
			'woocommerce_loop_add_to_cart_link',
			sprintf(
				'<a href="#" class="button add_to_cart_button disabled" style="pointer-events: none; background-color: #ccc; color: #666;" aria-disabled="true">%s</a>',
				esc_html__('Rupture de stock', 'woocommerce')
			),
			$product
		);
	} else {
		echo apply_filters(
			'woocommerce_loop_add_to_cart_link',
			sprintf(
				'<a href="%s" data-quantity="1" class="button add_to_cart_button" %s>%s</a>',
				esc_url($product->add_to_cart_url()),
				wc_implode_html_attributes(array(
					'data-product_id' => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label' => $product->add_to_cart_description(),
					'rel' => 'nofollow',
				)),
				esc_html($product->add_to_cart_text())
			),
			$product
		);
	}
}, 10);


// Add font from googlefont
function bo_theme_enqueue_fonts()
{
	wp_enqueue_style(
		'bo-theme-fonts',
		'https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
		false
	);
}
add_action('wp_enqueue_scripts', 'bo_theme_enqueue_fonts');


// Pass the amount of product in the url
add_filter('loop_shop_per_page', function ($cols) {
	if (isset($_GET['products_per_page'])) {
		$per_page = intval($_GET['products_per_page']);

		$allowed = [12, 24, 48, 96];
		if (in_array($per_page, $allowed)) {
			return $per_page;
		}
	}

	return $cols;
}, 20);


remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// Wrap the native woocommerce filter inside a div
// and add a custom select for the number of products per page
add_action('woocommerce_before_shop_loop', function () {
	echo '<div class="shop-controls-wrapper">';

	woocommerce_catalog_ordering();

	$options = [12, 24, 48, 96];
	$current = isset($_GET['products_per_page']) ? intval($_GET['products_per_page']) : '';

	$query_args = '';
	foreach ($_GET as $key => $value) {
		if ($key === 'products_per_page')
			continue;
		$query_args .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
	}

	echo '<form method="get" class="products-per-page-form" style="margin: 0;">';
	echo $query_args;
	echo '<label for="products_per_page" class="screen-reader-text">Produits par page</label>';
	echo '<select name="products_per_page" id="products_per_page" onchange="this.form.submit()">';
	foreach ($options as $opt) {
		printf(
			'<option value="%1$d"%2$s>%1$d produits</option>',
			$opt,
			selected($current, $opt, false)
		);
	}
	echo '</select>';
	echo '</form>';

	echo '</div>';
}, 20);

// Create a Toast for woocommerce to notify the user when an action is done
// like adding a product to the cart or removing it
// remove the default woocommerce messages
add_action('wp_footer', function () {
	?>
	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const messages = document.querySelectorAll('.woocommerce-message');

			messages.forEach((msg) => {
				const toast = document.createElement('div');
				toast.className = 'toast-woocommerce';

				toast.innerHTML = `
			<svg class="toast-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
			</svg>
			<div class="toast-text">${msg.innerHTML}</div>
		  `;

				document.body.appendChild(toast);
				msg.remove();
				setTimeout(() => {
					toast.style.opacity = '0';
					toast.style.transition = 'opacity 0.4s ease';
					setTimeout(() => toast.remove(), 400);
				}, 4000);
			});
		});
	</script>
	<?php
});

// Ajax function to remove a product from the cart
add_action('wp_ajax_remove_from_cart', 'gg_remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'gg_remove_from_cart');
function gg_remove_from_cart()
{
	if (!isset($_POST['cart_item_key'])) {
		wp_send_json_error(['message' => 'Clé du panier manquante.']);
	}

	$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
	$removed = WC()->cart->remove_cart_item($cart_item_key);

	if ($removed) {
		$cart_count = WC()->cart->get_cart_contents_count();
		$cart_html = '';

		ob_start();
		get_template_part('partials/cart-panel-body');
		$cart_html = ob_get_clean();

		wp_send_json_success([
			'cart_count' => $cart_count,
			'cart_html' => $cart_html,
			'cart_total' => WC()->cart->get_cart_total(),
			'message' => $cart_count === 0 ? 'Votre panier est actuellement vide.' : '',
		]);
	} else {
		wp_send_json_error(['message' => 'Impossible de supprimer cet article.']);
	}
}

// AJAX function to increase quantity of a cart item
add_action('wp_ajax_increase_cart_item', 'gg_increase_cart_item');
add_action('wp_ajax_nopriv_increase_cart_item', 'gg_increase_cart_item');
function gg_increase_cart_item()
{
	if (!isset($_POST['cart_item_key'])) {
		wp_send_json_error(['message' => 'Clé du panier manquante.']);
	}
	$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
	$items = WC()->cart->get_cart();
	if (empty($items[$cart_item_key])) {
		wp_send_json_error(['message' => 'Article introuvable.']);
	}
	$current_qty = $items[$cart_item_key]['quantity'];
	// Increase quantity by 1 and refresh totals
	WC()->cart->set_quantity($cart_item_key, $current_qty + 1, true);
	wp_send_json_success();
}

// AJAX function to decrease quantity of a cart item
add_action('wp_ajax_decrease_cart_item', 'gg_decrease_cart_item');
add_action('wp_ajax_nopriv_decrease_cart_item', 'gg_decrease_cart_item');
function gg_decrease_cart_item()
{
	if (empty($_POST['cart_item_key'])) {
		wp_send_json_error(['message' => 'Clé du panier manquante.']);
	}
	$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
	$cart = WC()->cart->get_cart();
	if (empty($cart[$cart_item_key])) {
		wp_send_json_error(['message' => 'Article introuvable.']);
	}
	$current_qty = $cart[$cart_item_key]['quantity'];
	if ($current_qty <= 1) {
		// Remove item if quantity would drop to zero
		WC()->cart->remove_cart_item($cart_item_key);
	} else {
		// Decrease quantity by 1
		WC()->cart->set_quantity($cart_item_key, $current_qty - 1, true);
	}
	wp_send_json_success();
}

// Update the cart panel HTML after adding a product to the cart
add_filter('woocommerce_add_to_cart_fragments', 'gg_update_cart_panel_html');
function gg_update_cart_panel_html($fragments)
{
	// Cart panel body
	ob_start();
	get_template_part('partials/cart-panel-body');
	$fragments['div.cart-panel-body'] = ob_get_clean();

	// Cart total only
	ob_start();
	?>
	<span class="custom-cart-total">
		<?php echo WC()->cart->get_cart_total(); ?>
	</span>
	<?php
	$fragments['span.custom-cart-total'] = ob_get_clean();

	// Cart count fragment
	$cart_count = WC()->cart->get_cart_contents_count();
	if ($cart_count > 0) {
		ob_start();
		?>
		<span class="cart-count"><?php echo $cart_count; ?></span>
		<?php
		$fragments['span.cart-count'] = ob_get_clean();
	} else {
		$fragments['span.cart-count'] = '';
	}

	return $fragments;
}



// Apply color customizations in the head
function bo_theme_customize_nav_colors()
{
	$nav_link_color = get_theme_mod('nav_link_color', '#0073aa');
	$nav_link_color_light = get_theme_mod('nav_link_color_light', '#000000');
	$nav_link_hover_color = get_theme_mod('nav_link_hover_color', '#005177');
	$button_color = get_theme_mod('button_color', '#ee0e5b');
	$button_hover = get_theme_mod('button_hover_color', '#f23b78');
	?>
	<style type="text/css">
		#masthead a,
		#menu-footer-menu li a {
			color:
				<?php echo esc_attr($nav_link_color); ?>
			;
		}

		.product-content a {
			color:
				<?php echo esc_attr($nav_link_color_light); ?>
			;
		}

		#masthead a:hover,
		.footer-widgets a:hover,
		#menu-footer-menu li a:hover,
		.product-content a:hover {
			color:
				<?php echo esc_attr($nav_link_hover_color); ?>
			;
			text-decoration: underline;
		}

		.price {
			color:
				<?php echo esc_attr($nav_link_hover_color); ?>
			;
		}

		.site-header,
		.footer-widgets {
			background-color:
				<?php echo get_theme_mod('nav_background_color', '#000000'); ?>
				!important;
		}

		.wp-block-button__link,
		.add_to_cart_button,
		.btn-style {
			background-color:
				<?php echo esc_html($button_color); ?>
			;
			color:
				<?php echo esc_html($nav_link_color); ?>
				!important;
			border-radius: 0;
			transition: background-color 0.3s ease;
			padding: 0.5rem 1rem;
		}

		.wp-block-button__link:hover,
		.add_to_cart_button:hover,
		.btn-style:hover {
			background-color:
				<?php echo esc_html($button_hover); ?>
				!important;
			color:
				<?php echo esc_html($nav_link_color); ?>
				!important;
		}

		.wp-block-group {
			padding: 0 !important;
		}

		.btn-product-delete {
			background-color:
				<?php echo esc_html($button_color); ?>
			;
			color:
				<?php echo esc_html($nav_link_color); ?>
				!important;
		}

		.btn-product-delete:hover {
			background-color:
				<?php echo esc_html($button_hover); ?>
				!important;
			color:
				<?php echo esc_html($nav_link_color); ?>
				!important;
		}
	</style>
	<?php
}
add_action('wp_head', 'bo_theme_customize_nav_colors');

function gg_enqueue_cart_fragments()
{
	if (is_cart() || is_checkout())
		return;

	wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'gg_enqueue_cart_fragments', 20);

/**
 * Enqueue scripts and styles.
 */
function bo_theme_scripts()
{
	wp_enqueue_style('bo-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('bo-theme-style', 'rtl', 'replace');

	wp_enqueue_style('bo-theme-reset', get_template_directory_uri() . '/css/reset.css', array(), _S_VERSION);
	wp_enqueue_script('bo-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'bo_theme_scripts');

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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Redirect to the current page after adding a product to the cart.
// This prevents the behavior of adding a product to the cart when page is refreshed.
add_action('woocommerce_add_to_cart_redirect', 'bo_theme_add_to_cart_redirect');

function bo_theme_add_to_cart_redirect($url = false)
{
	// If URL is set respect if
	if (!empty($url)) {
		return $url;
	}

	// Redirect to predvious URL
	if (isset($_SERVER['HTTP_REFERER'])) {
		return esc_url($_SERVER['HTTP_REFERER']);
	}

	// If nothing back to home
	return home_url('/');
}