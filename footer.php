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

<?php if (is_active_sidebar('footer-widget-area')): ?>
    <div class="footer-widgets">
        <?php dynamic_sidebar('footer-widget-area'); ?>
    </div>
<?php endif; ?>


</div><!-- #page -->

<script>
    // Toggle mobile menu visibility - START
    document.getElementById('mobile-menu-toggle').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('mobile-menu-open');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.remove('mobile-menu-open');
    });
    // Toggle mobile menu visibility - END

    // JS to handle add product to cart
    jQuery(document.body).on('added_to_cart', function () {
        jQuery(document.body).trigger('wc_fragment_refresh');
    });

    // Handle toggle cart panel visibility
    document.addEventListener('DOMContentLoaded', function () {
        const cartPanel = document.getElementById('cart-panel');
        const cartToggleButtons = [
            document.getElementById('shopping-cart-menu-toggle-desktop'),
            document.getElementById('shopping-cart-menu-toggle-mobile')
        ];
        const closeCartButton = document.getElementById('close-cart-panel');

        if (cartPanel && cartToggleButtons.every(button => button)) {

            cartToggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    cartPanel.classList.add('cart-panel-open');
                });
            });

            if (closeCartButton) {
                closeCartButton.addEventListener('click', () => {
                    cartPanel.classList.remove('cart-panel-open');
                });
            }

            document.addEventListener('click', (event) => {
                if (!cartPanel.contains(event.target) && !cartToggleButtons.some(button => button.contains(event.target))) {
                    cartPanel.classList.remove('cart-panel-open');
                }
            });
        } else {
            console.error('Cart panel or toggle buttons not found.');
        }
    });

    // Handle open cart panel or redirect from checkout
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const cartPanel = document.getElementById('cart-panel');
        const cartToggleButtons = [
            document.getElementById('shopping-cart-menu-toggle-desktop'),
            document.getElementById('shopping-cart-menu-toggle-mobile')
        ];
        if (urlParams.get('open_cart') === '1' && cartPanel) {
            cartPanel.classList.add('cart-panel-open');
        }
        // Not the much clean feature but force the user to be redirect to shop page if click
        // to open the cart while being on the checkout Page
        // beceause Ajax functionality is not working on checkout page
        if (document.body.classList.contains('woocommerce-checkout')) {
            cartToggleButtons.forEach(function (button) {
                if (button) {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        window.location.href = '/boutique?open_cart=1';
                    });
                }
            });
        }
    });

    // Handle remove item from cart via AJAX
    jQuery(function ($) {
        $(document).on('click', '.btn-remove-item-from-cart', function (event) {
            event.preventDefault();
            var cartKey = $(this).closest('.product-card').data('cart-item-key');
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
                action: 'remove_from_cart',
                cart_item_key: cartKey
            }, function (response) {
                if (response.success) {
                    $(document.body).trigger('wc_fragment_refresh');
                } else {
                    alert(response.data.message || '<?php esc_html_e('Erreur lors de la suppression du produit.', 'bo-theme'); ?>');
                }
            });
        });
    });

    // Handle increase/decrease item quantity or amount via AJAX
    jQuery(function ($) {
        $(document).on('click', '.btn-increase-item-in-cart', function (event) {
            event.preventDefault();
            var cartKey = $(this).closest('.product-card').data('cart-item-key');
            increaseItem(cartKey);
        });

        $(document).on('click', '.btn-decrease-item-in-cart', function (event) {
            event.preventDefault();
            var cartKey = $(this).closest('.product-card').data('cart-item-key');
            decreaseItem(cartKey);
        });

        // Function for Increase QTY or Amount
        function increaseItem(cartKey) {
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
                action: 'increase_cart_item',
                cart_item_key: cartKey
            }, function (response) {
                if (response.success) {
                    $(document.body).trigger('wc_fragment_refresh');
                } else {
                    alert(response.data.message || 'Erreur lors de l\'augmentation du produit.');
                }
            });
        }

        // function for Decrease QTY or Amount
        function decreaseItem(cartKey) {
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
                action: 'decrease_cart_item',
                cart_item_key: cartKey
            }, function (response) {
                if (response.success) {
                    $(document.body).trigger('wc_fragment_refresh');
                } else {
                    alert(response.data.message || 'Erreur lors de la mise à jour du panier.');
                }
            });
        }
    });

    // Woocomerce Toast Notification for Product Page and Gift Card
    // A problem occur with my current toast solution, my solution show for a short time the native solution
    // of Woocmmerce but that is not alright so I completely deactivated it
    // The problem occur when I click on the button "Ajouter au panier" for a single product or gift card as the call
    // use post the toast solution cannot work after try different solution this one is the only one I managed to make it work
    // ! I think this solution should be consider as temporary as its implys a lot of code
    // ! as a V2 I should find a way to completely remove my toast and only use the native solution of woocommerce
    // ! but in accordance with the design of my website
    jQuery(function ($) {
        // Show Toast Notification
        function showWooToast(message) {
            var toast = $('<div class="toast-woocommerce"></div>');
            toast.html(`
                <svg class="toast-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <div class="toast-text">${message}</div>
            `);
            $('body').append(toast);
            setTimeout(function () {
                toast.css('opacity', '0');
                toast.css('transition', 'opacity 0.4s ease');
                setTimeout(function () { toast.remove(); }, 400);
            }, 4000);
        }

        // Detect on which page we are on
        var isSingleProduct = $('body').hasClass('single-product');
        var isGiftCard = $('.gift-card-form').length > 0;
        if (isSingleProduct || isGiftCard) {
            // 1. Store a message in localStorage when add item to cart
            var $form = isGiftCard ? $('form.gift-card-form') : $('form.cart');
            $form.on('submit', function (e) {
                var msg = $('.single-product .product_title').text() || 'Produit ajouté au panier !';
                localStorage.setItem('woo_add_to_cart_message', msg + ' ajouté au panier !');
            });
            // 2. After page have reloaded (or even on initial loading), check if a message is in localStorage
            // and show it if it exists
            // 3. Remove the message from localStorage after showing it
            $(function () {
                var msg = localStorage.getItem('woo_add_to_cart_message');
                if (msg) {
                    showWooToast(msg);
                    setTimeout(function () {
                        localStorage.removeItem('woo_add_to_cart_message');
                    }, 4000);
                }
            });
        }
    });

    // Handle Accordeon Tabs
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.accordion-trigger').forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.nextElementSibling;
                content.classList.toggle('hidden');
                const icon = btn.querySelector('.toggle-icon');
                icon.textContent = content.classList.contains('hidden') ? '+' : '–';
            });
        });
    });

    // Handle Open Image Modal for Zoom
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById("openImageModal");
        const modal = document.getElementById("imageModal");
        const closeBtn = document.getElementById("closeImageModal");

        openBtn?.addEventListener("click", () => {
            modal?.classList.add("active");
        });

        closeBtn?.addEventListener("click", () => {
            modal?.classList.remove("active");
        });

        modal?.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.remove("active");
            }
        });
    });

    // Button to handle password visibility
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password-visibility').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const targetId = btn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const eye = btn.querySelector('.icon-eye');
                const eyeOff = btn.querySelector('.icon-eye-off');
                if (input.type === 'password') {
                    input.type = 'text';
                    eye.style.display = 'none';
                    eyeOff.style.display = '';
                } else {
                    input.type = 'password';
                    eye.style.display = '';
                    eyeOff.style.display = 'none';
                }
            });
        });
    });

    // Anonymous function to handle translation of WooCommerce blocks text (Checkout so far)
    (function () {
        function translateBlocksText(node) {
            document.querySelectorAll('button, a').forEach(function (el) {
                if (el.textContent.trim() === 'Add a coupon') {
                    el.textContent = 'Ajouter un code promo';
                }
            });
            document.querySelectorAll('*').forEach(function (el) {
                if (el.textContent.trim() === 'Delivery') {
                    el.textContent = 'Livraison';
                }
            });
            document.querySelectorAll('*').forEach(function (el) {
                if (el.textContent.trim() === 'You are currently checking out as a guest.') {
                    el.textContent = 'Vous êtes actuellement en train de passer à la caisse en tant qu\'invité.';
                }
            });
            document.querySelectorAll('*').forEach(function (el) {
                if (el.textContent.trim() === 'Enter the address where you want your order delivered.') {
                    el.textContent = 'Entrez l\'adresse où vous souhaitez que votre commande soit livrée.';
                }
            });
            document.querySelectorAll('.wc-block-components-checkbox__label').forEach(function (el) {
                if (el.textContent.trim() === 'Create an account with Boucle-la') {
                    el.textContent = 'Créez un compte avec Boucle-la';
                }
            });
            document.querySelectorAll('.wc-block-components-checkbox__label div').forEach(function (el) {
                if (el.textContent.trim() === 'I would like to receive exclusive emails with discounts and product information') {
                    el.textContent = 'J’aimerais recevoir des e-mails exclusifs avec des réductions et des informations sur les produits';
                }
            });
            document.querySelectorAll('.wc-block-components-address-form__address_2-toggle').forEach(function (el) {
                if (el.textContent.trim() === '+ Add appartement, suite, etc.') {
                    el.textContent = '+ Ajouter appartement, suite, etc.';
                }
            });
            document.querySelectorAll('.wc-block-checkout__login-prompt').forEach(function (el) {
                if (el.textContent.trim() === 'Identification') {
                    el.textContent = 'S\'identifier';
                }
            });
            document.querySelectorAll('.wc-block-components-totals-item__label').forEach(function (el) {
                if (el.textContent.trim() === 'Remise&nbsp;') {
                    el.textContent = 'Remise';
                }
            });
            document.querySelectorAll('.wc-block-components-checkout-step__description span').forEach(function (el) {
                if (el.textContent.trim() === 'Use another payment method.') {
                    el.textContent = 'Utiliser un autre moyen de paiement.';
                }
            });
            document.querySelectorAll('.wc-block-components-panel__button').forEach(function (el) {
                el.childNodes.forEach(function (node) {
                    if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() === 'Add a coupon') {
                        node.textContent = 'Ajouter un coupon';
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            translateBlocksText(document.body);
        });

        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                translateBlocksText(mutation.target);
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    })();

</script>

<?php wp_footer(); ?>

</body>

</html>