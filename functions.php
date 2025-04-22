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
add_action('wp_ajax_remove_from_cart', 'bo_theme_remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'bo_theme_remove_from_cart');
function bo_theme_remove_from_cart()
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

// AJAX function to increase quantity or gift card amount
add_action('wp_ajax_increase_cart_item', 'bo_theme_increase_cart_item');
add_action('wp_ajax_nopriv_increase_cart_item', 'bo_theme_increase_cart_item');
function bo_theme_increase_cart_item()
{
	if (!isset($_POST['cart_item_key'])) {
		wp_send_json_error(['message' => 'Clé du panier manquante.']);
	}
	$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
	$items = WC()->cart->get_cart();

	if (empty($items[$cart_item_key])) {
		wp_send_json_error(['message' => 'Article introuvable.']);
	}

	$cart_item = $items[$cart_item_key];
	$product = $cart_item['data'];

	if ($product && method_exists($product, 'get_type') && $product->get_type() === 'gift_card') {
		$current_amount = isset($cart_item['gift_card_amount']) ? floatval($cart_item['gift_card_amount']) : floatval($product->get_price());
		$new_amount = $current_amount + 5;
		$cart_item['gift_card_amount'] = $new_amount;
		$product->set_price($new_amount);
		WC()->cart->cart_contents[$cart_item_key] = $cart_item;
		WC()->cart->calculate_totals();
	} else {
		$current_qty = $cart_item['quantity'];
		WC()->cart->set_quantity($cart_item_key, $current_qty + 1, true);
	}
	wp_send_json_success();
}

// AJAX function to decrease quantity or gift card amount
add_action('wp_ajax_decrease_cart_item', 'bo_theme_decrease_cart_item');
add_action('wp_ajax_nopriv_decrease_cart_item', 'bo_theme_decrease_cart_item');
function bo_theme_decrease_cart_item()
{
	if (empty($_POST['cart_item_key'])) {
		wp_send_json_error(['message' => 'Clé du panier manquante.']);
	}
	$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
	$cart = WC()->cart->get_cart();

	if (empty($cart[$cart_item_key])) {
		wp_send_json_error(['message' => 'Article introuvable.']);
	}

	$cart_item = $cart[$cart_item_key];
	$product = $cart_item['data'];

	if ($product && method_exists($product, 'get_type') && $product->get_type() === 'gift_card') {
		$current_amount = isset($cart_item['gift_card_amount']) ? floatval($cart_item['gift_card_amount']) : floatval($product->get_price());
		$new_amount = $current_amount - 5;
		if ($new_amount < 5) {
			$new_amount = 5;
		}
		$cart_item['gift_card_amount'] = $new_amount;
		$product->set_price($new_amount);
		WC()->cart->cart_contents[$cart_item_key] = $cart_item;
		WC()->cart->calculate_totals();
	} else {
		$current_qty = $cart_item['quantity'];
		if ($current_qty <= 1) {
			WC()->cart->remove_cart_item($cart_item_key);
		} else {
			WC()->cart->set_quantity($cart_item_key, $current_qty - 1, true);
		}
		WC()->cart->calculate_totals();
	}
	wp_send_json_success();
}



//
//
// Section to handle Product Tab and WYSIWYG editor for the composition of the product
// START
//
// Update the cart panel HTML after adding a product to the cart
add_filter('woocommerce_add_to_cart_fragments', 'bo_theme_update_cart_panel_html');
function bo_theme_update_cart_panel_html($fragments)
{
	ob_start();
	get_template_part('partials/cart-panel-body');
	$fragments['div.cart-panel-body'] = ob_get_clean();
	ob_start();
	?>
	<span class="custom-cart-total">
		<?php echo WC()->cart->get_cart_total(); ?>
	</span>
	<?php
	$fragments['span.custom-cart-total'] = ob_get_clean();

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
// Add a custom tabs for the composition of the product
add_filter('woocommerce_product_tabs', 'bo_theme_add_composition_tab');
function bo_theme_add_composition_tab($tabs)
{
	global $product;

	$composition = get_post_meta($product->get_id(), '_composition', true);

	if (!empty($composition)) {
		$tabs['composition'] = array(
			'title' => __('Composition', 'bo-theme'),
			'priority' => 25,
			'callback' => 'bo_theme_composition_tab_content'
		);
	}

	return $tabs;
}
function bo_theme_composition_tab_content()
{
	global $post;

	$composition = get_post_meta($post->ID, '_composition', true);

	if (!empty($composition)) {
		echo wp_kses_post($composition);
	}
}
// Add a WYSIWYG editor for the composition tab in admin
add_action('add_meta_boxes', 'bo_theme_add_composition_metabox');
function bo_theme_add_composition_metabox()
{
	add_meta_box(
		'bo_theme_composition_metabox',
		__('Composition du produit', 'bo-theme'),
		'bo_theme_render_composition_metabox',
		'product',
		'normal',
		'default'
	);
}
function bo_theme_render_composition_metabox($post)
{
	$composition = get_post_meta($post->ID, '_composition', true);

	wp_editor(
		$composition,
		'bo_theme_composition_editor',
		array(
			'textarea_name' => '_composition',
			'media_buttons' => true,
			'textarea_rows' => 10,
		)
	);
}
// Composition in Admin save content
add_action('save_post', 'bo_theme_save_composition_metabox');
function bo_theme_save_composition_metabox($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	if (!isset($_POST['_composition']))
		return;

	update_post_meta($post_id, '_composition', wp_kses_post($_POST['_composition']));
}
//
//
// Section to handle Product Tab and WYSIWYG editor for the composition of the product
// END
//

// Handle Gift Cards Features
require get_template_directory() . '/inc/gift-card.php';


//
//
// Section to Account Feature like Register/Login and MyAccount
// START
//



// If user is logged in, change the account menu item to display the user name
add_filter('wp_nav_menu_objects', function ($items) {
	if (!is_user_logged_in())
		return $items;
	$user = wp_get_current_user();
	$display_name = $user->display_name ? $user->display_name : $user->user_login;
	$account_url = wc_get_page_permalink('myaccount');
	$login_url = site_url('/login');
	foreach ($items as $item) {
		if (isset($item->url)) {
			$item_url = untrailingslashit($item->url);
			if ($item_url === untrailingslashit($login_url) || $item_url === untrailingslashit($account_url)) {
				$item->title = esc_html($display_name);
				$item->url = $account_url;
			}
		}
	}
	return $items;
});



// Force redirect to home page after logout using wp_logout hook
add_action('wp_logout', function () {
	wp_redirect(home_url('/'));
	exit;
});

// Shortcode [woocommerce_login_form] Only Login Form
function custom_woocommerce_login_form()
{
	if (is_user_logged_in()) {
		return '<p>' . __('Vous êtes déjà connecté.', 'bo-theme') . '</p>';
	}
	ob_start();
	woocommerce_login_form([
		'redirect' => wc_get_page_permalink('myaccount'),
		'hidden' => false
	]);
	?>
	<div style="margin-top:1rem;">
		<a href="<?php echo esc_url(site_url('/register')); ?>"
			class="button"><?php _e('Créer un compte', 'bo-theme'); ?></a>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('woocommerce_login_form', 'custom_woocommerce_login_form');

// Shortcode [multi_step_register_form] Display Multi Step Register Form
function bo_theme_multi_step_register_form_shortcode()
{
	ob_start();
	include get_template_directory() . '/woocommerce/auth/register.php';
	return ob_get_clean();
}
add_shortcode('multi_step_register_form', 'bo_theme_multi_step_register_form_shortcode');

//
//
// Section to Account Feature like Register/Login and MyAccount
// END
//

//
//
// Section to Handle Customization of the theme like button color, nav color, etc.
// START
//



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

		.product-content a,
		.category-link,
		.csp-product-categories a {
			color:
				<?php echo esc_attr($nav_link_color_light); ?>
			;
		}

		#masthead a:hover,
		.footer-widgets a:hover,
		#menu-footer-menu li a:hover,
		.product-content a:hover,
		.category-link:hover,
		.csp-product-categories a:hover {
			color:
				<?php echo esc_attr($nav_link_hover_color); ?>
				!important;
			text-decoration: underline !important;
		}

		.price,
		.csp-product-price {
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

		/* Some button do not require to have their background set with the !important For example the disabled button have the same class if i Force the bg-color I face a problem with the disabled */
		.wp-block-button__link,
		.add_to_cart_button,
		.btn-style,
		.category-link-active,
		.single_add_to_cart_button,
		.page-numbers.current,
		.gift-card-button,
		.forminator-button,
		input.tnp-submit {
			background-color:
				<?php echo esc_html($button_color); ?>
			;
			color:
				<?php echo esc_html($nav_link_color); ?>
				!important;
			border-radius: 0 !important;
			transition: background-color 0.3s ease !important;
			padding: 0.5rem 1rem !important;
			border: none;
			cursor: pointer;
			text-decoration: none !important;
		}

		/* Buttons that require to have their bg-color set with important That is usually the case for button that come from a plugin where I have no control over the feDiffuseLighting */
		input.tnp-submit {
			background-color:
				<?php echo esc_html($button_color); ?>
				!important;
			color:
				<?php echo esc_html($nav_link_color); ?>
				!important;
			padding: 0.5rem 1rem !important;
			border: none !important;
		}

		.wp-block-button__link:hover,
		.add_to_cart_button:hover,
		.btn-style:hover,
		.category-link-active:hover,
		.single_add_to_cart_button:hover,
		.page-numbers.current:hover,
		.gift-card-button:hover,
		.forminator-button:hover,
		input.tnp-submit:hover {
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

function bo_theme_enqueue_cart_fragments()
{
	if (is_cart() || is_checkout())
		return;

	wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'bo_theme_enqueue_cart_fragments', 20);

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


// Redirect Section
//
// START
//

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

// Redirect /panier to the shop page if no referer is set or if the referer is /panier
add_action('template_redirect', function () {
	if (is_cart()) {
		$redirect_url = wp_get_referer();
		if (!$redirect_url && !empty($_SERVER['HTTP_REFERER'])) {
			$redirect_url = $_SERVER['HTTP_REFERER'];
		}
		if (!$redirect_url || strpos($redirect_url, '/panier') !== false) {
			$shop_url = wc_get_page_permalink('shop');
			if (empty($shop_url) || get_post_status(url_to_postid($shop_url)) !== 'publish') {
				$redirect_url = home_url('/');
			} else {
				$redirect_url = $shop_url;
			}
		}
		$redirect_url = add_query_arg('open_cart', '1', $redirect_url);
		wp_redirect($redirect_url);
		exit;
	}
});

// Redirect Section
//
// END
//
