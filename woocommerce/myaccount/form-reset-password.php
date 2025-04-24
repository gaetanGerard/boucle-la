<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_reset_password_form');
?>

<div class="reset-password-container">
	<div class="reset-password-form-card">
		<form method="post" class="woocommerce-ResetPassword lost_reset_password">
			<fieldset>
				<legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>
				<p><?php echo apply_filters('woocommerce_reset_password_message', esc_html__('Enter a new password below.', 'woocommerce')); ?>
				</p>
				<div class="input-container-reset">
					<p
						class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-row-reset">
					<div class="password-label-row-reset">
						<label for="password_1"><?php esc_html_e('New password', 'woocommerce'); ?>&nbsp;<span
								class="required" aria-hidden="true">*</span></label>
						<button type="button" class="toggle-password-visibility" data-target="password_1"
							aria-label="Afficher/Masquer le mot de passe">
							<span class="icon-eye">
								<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
									stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
									<circle cx="12" cy="12" r="3"></circle>
								</svg>
							</span>
							<span class="icon-eye-off" style="display:none;">
								<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
									stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path
										d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.81 21.81 0 0 1 5.06-6.06M1 1l22 22">
									</path>
									<path d="M9.53 9.53A3.5 3.5 0 0 0 12 15.5c1.38 0 2.63-.56 3.54-1.47"></path>
								</svg>
							</span>
						</button>
					</div>
				</div>
				<div class="input-container-reset">
					<div class="password-input-wrapper-reset">
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text"
							name="password_1" id="password_1" autocomplete="new-password" required
							aria-required="true" />
					</div>
					</p>
					<p
						class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-row-reset">
					<div class="password-label-row-reset">
						<label for="password_2"><?php esc_html_e('Re-enter new password', 'woocommerce'); ?>&nbsp;<span
								class="required" aria-hidden="true">*</span></label>
						<button type="button" class="toggle-password-visibility" data-target="password_2"
							aria-label="Afficher/Masquer le mot de passe">
							<span class="icon-eye">
								<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
									stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
									<circle cx="12" cy="12" r="3"></circle>
								</svg>
							</span>
							<span class="icon-eye-off" style="display:none;">
								<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
									stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path
										d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.81 21.81 0 0 1 5.06-6.06M1 1l22 22">
									</path>
									<path d="M9.53 9.53A3.5 3.5 0 0 0 12 15.5c1.38 0 2.63-.56 3.54-1.47"></path>
								</svg>
							</span>
						</button>
					</div>
					<div class="password-input-wrapper-reset">
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text"
							name="password_2" id="password_2" autocomplete="new-password" required
							aria-required="true" />
					</div>
					</p>
				</div>
			</fieldset>
			<input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>" />
			<input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>" />
			<div class="clear"></div>
			<?php do_action('woocommerce_resetpassword_form'); ?>
			<p class="woocommerce-form-row form-row">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit"
					class="woocommerce-Button btn-style button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> reset-password-btn"
					value="<?php esc_attr_e('Save', 'woocommerce'); ?>"><?php esc_html_e('Save', 'woocommerce'); ?></button>
			</p>
			<?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
		</form>
	</div>
</div>


<?php
do_action('woocommerce_after_reset_password_form');
