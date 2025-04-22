<?php
/**
 * Email template for sending gift card details.
 *
 * @package BoucleLa
 */

if (!defined('ABSPATH')) {
    exit;
}
do_action('woocommerce_email_header', esc_html__('Votre carte cadeau', 'bo-theme'), isset($email) ? $email : null);
?>

<p><?php esc_html_e('Vous avez reçu une carte cadeau.', 'bo-theme'); ?></p>

<table cellpadding="0" cellspacing="0"
    style="width: 100%; background: #f9f9f9; border-radius: 8px; margin-bottom: 20px;">
    <tr>
        <td style="padding: 30px 40px; text-align: center;">
            <h2 style="color: #7f54b3; font-size: 28px; margin: 0 0 20px; font-weight: 600; letter-spacing: 1px;">
                <?php esc_html_e('Code de la carte cadeau', 'bo-theme'); ?>
            </h2>
            <div
                style="display: inline-block; background: #f3f3f3; border: 2px dashed #7f54b3; border-radius: 6px; padding: 18px 32px; font-size: 24px; color: #7f54b3; font-weight: bold; letter-spacing: 2px; margin-bottom: 18px;">
                <?php echo esc_html($gift_card_code); ?>
            </div>
            <p style="font-size: 18px; color: #333; margin: 18px 0 8px;">
                <strong><?php esc_html_e('Montant :', 'bo-theme'); ?></strong>
                <?php echo esc_html(strip_tags((string) $amount)); ?>
            </p>
            <?php if (!empty($expiry)): ?>
                <p style="font-size: 16px; color: #666; margin: 0 0 8px;">
                    <strong><?php esc_html_e('Valide jusqu’au :', 'bo-theme'); ?></strong> <?php echo esc_html($expiry); ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($recipient_name)): ?>
                <p style="font-size: 16px; color: #666; margin: 0 0 8px;">
                    <strong><?php esc_html_e('Pour :', 'bo-theme'); ?></strong> <?php echo esc_html($recipient_name); ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($message)): ?>
                <p style="font-size: 16px; color: #666; margin: 0 0 8px;">
                    <strong><?php esc_html_e('Message :', 'bo-theme'); ?></strong> <?php echo esc_html($message); ?>
                </p>
            <?php endif; ?>
        </td>
    </tr>
</table>

<p style="text-align: center; color: #888; font-size: 14px; margin-top: 30px;">
    <?php esc_html_e('Merci pour votre achat !', 'bo-theme'); ?>
</p>

<?php
do_action('woocommerce_email_footer', isset($email) ? $email : null);