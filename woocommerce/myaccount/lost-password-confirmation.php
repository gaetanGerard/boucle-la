<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

defined('ABSPATH') || exit;

wc_print_notice(esc_html__("L'email pour réinitialiser votre mot de passe a été envoyer.", 'woocommerce'));
?>

<?php do_action('woocommerce_before_lost_password_confirmation_message'); ?>
<div class="lost-password-page">
    <div class="confirm-msg-container">
        <p class="confirm-msg">
            <?php echo esc_html(apply_filters('woocommerce_lost_password_confirmation_message', esc_html__("Un e-mail de réinitialisation de mot de passe a été envoyé à l'adresse e-mail enregistrée pour votre compte, mais il faudra peut-être quelques minutes pour qu'il apparaisse dans votre boîte de réception. Veuillez patienter au moins 10 minutes avant de tenter une nouvelle réinitialisation.", 'woocommerce'))); ?>
        </p>
        <a href="/" class="btn-style">Retour à l'accueil</a>
    </div>
</div>


<?php do_action('woocommerce_after_lost_password_confirmation_message'); ?>