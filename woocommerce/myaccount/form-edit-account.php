<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

$title = 'Détails du compte';
$message = 'Modifiez ici vos informations personnelles, votre adresse e-mail et votre mot de passe. Toutes les modifications seront prises en compte lors de votre prochaine connexion.';
include __DIR__ . '/account-content-header.php';

/**
 * Hook - woocommerce_before_edit_account_form.
 *
 * @since 2.6.0
 */
do_action('woocommerce_before_edit_account_form');
?>

<div class="account-form-card">
	<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

		<?php do_action('woocommerce_edit_account_form_start'); ?>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="account_first_name"><?php esc_html_e('First name', 'woocommerce'); ?>&nbsp;<span
					class="required" aria-hidden="true">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name"
				id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>"
				aria-required="true" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
			<label for="account_last_name"><?php esc_html_e('Last name', 'woocommerce'); ?>&nbsp;<span class="required"
					aria-hidden="true">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name"
				id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>"
				aria-required="true" />
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span
					class="required" aria-hidden="true">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name"
				id="account_display_name" aria-describedby="account_display_name_description"
				value="<?php echo esc_attr($user->display_name); ?>" aria-required="true" /> <span
				id="account_display_name_description"><em><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?></em></span>
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required"
					aria-hidden="true">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email"
				id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>"
				aria-required="true" />
		</p>

		<?php do_action('woocommerce_edit_account_form_fields'); ?>

		<fieldset>
			<legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-row">
			<div class="password-label-row">
				<label
					for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
				<button type="button" class="toggle-password-visibility" data-target="password_current"
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
			<div class="password-input-wrapper">
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
					name="password_current" id="password_current" autocomplete="off" />
			</div>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-row">
			<div class="password-label-row">
				<label
					for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
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
			<div class="password-input-wrapper">
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
					name="password_1" id="password_1" autocomplete="off" />
			</div>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-row">
			<div class="password-label-row">
				<label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
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
			<div class="password-input-wrapper">
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
					name="password_2" id="password_2" autocomplete="off" />
			</div>
			</p>
		</fieldset>
		<div class="clear"></div>

		<?php do_action('woocommerce_edit_account_form'); ?>

		<p>
			<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
			<button type="submit"
				class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> account-form-btn"
				name="save_account_details"
				value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
			<input type="hidden" name="action" value="save_account_details" />
		</p>

		<?php do_action('woocommerce_edit_account_form_end'); ?>
	</form>
</div>

<?php do_action('woocommerce_after_edit_account_form'); ?>