<?php
if (!isset($_SESSION['register']['first_name'])) {
    header('Location: ?step=2');
    exit;
}
$errors = [];
$password = '';
$password_confirm = '';
$terms = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    $terms = !empty($_POST['terms']);
    if (empty($password) || empty($password_confirm)) {
        $errors[] = 'Veuillez remplir les deux champs mot de passe.';
    } elseif ($password !== $password_confirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
        $errors[] = 'Le mot de passe doit faire au moins 8 caractères, contenir un chiffre et un caractère spécial.';
    }
    if (!$terms) {
        $errors[] = 'Vous devez accepter les termes et conditions.';
    }
    if (empty($errors)) {
        $email = $_SESSION['register']['email'];
        $username = $email;
        $user_id = wc_create_new_customer($email, $username, $password);
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, 'first_name', $_SESSION['register']['first_name']);
            update_user_meta($user_id, 'last_name', $_SESSION['register']['last_name']);
            update_user_meta($user_id, 'display_name', $_SESSION['register']['display_name'] ?: $_SESSION['register']['first_name']);
            update_user_meta($user_id, 'billing_address_1', $_SESSION['register']['address_1']);
            update_user_meta($user_id, 'billing_address_2', trim($_SESSION['register']['building_number'] . ' ' . $_SESSION['register']['apartment_number']));
            update_user_meta($user_id, 'billing_postcode', $_SESSION['register']['postcode']);
            update_user_meta($user_id, 'billing_city', $_SESSION['register']['city']);
            update_user_meta($user_id, 'billing_state', $_SESSION['register']['state']);
            update_user_meta($user_id, 'billing_country', $_SESSION['register']['country']);
            wp_update_user(['ID' => $user_id, 'display_name' => $_SESSION['register']['display_name'] ?: $_SESSION['register']['first_name']]);
            wc_set_customer_auth_cookie($user_id);
            unset($_SESSION['register']);
            wp_redirect(wc_get_page_permalink('myaccount'));
            exit;
        } else {
            $errors[] = $user_id->get_error_message();
        }
    }
}
?>
<div class="register-infos-container">
    <div class="register-infos-header">
        <h1>Créer votre comptre</h1>
        <p>Déjà un compte ? <a href="/login">Connectez-vous</a>.</p>
    </div>
    <div class="steps-info-container">
        <div class="step-info">
            <div class="step-number">1</div>
            <div class="step-text">Email</div>
        </div>
        <div class="step-info">
            <div class="step-number">2</div>
            <div class="step-text">Informations personnelles</div>
        </div>
        <div class="step-info step-info-active">
            <div class="step-number">3</div>
            <div class="step-text">Mot de passe</div>
        </div>
    </div>
</div>
<form method="post" class="register-step-form large-form">
    <h2>Étape 3 : Mot de passe et validation</h2>
    <?php
    $email_exists_error = false;
    foreach ($errors as $error): ?>
        <div class="form-error"><?php echo esc_html($error); ?></div>
        <?php
        if (stripos($error, 'email') !== false) {
            $email_exists_error = true;
        }
        ?>
    <?php endforeach; ?>
    <?php if ($email_exists_error): ?>
        <div class="lost-password-link" style="text-align:center;margin-top:0.5rem;">
            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>">Mot de passe oublié&nbsp;?</a>
        </div>
    <?php endif; ?>
    <p>
        <label>Mot de passe *</label><br>
        <input type="password" name="password" required>
    </p>
    <p>
        <label>Confirmez le mot de passe *</label><br>
        <input type="password" name="password_confirm" required>
    </p>
    <p>
        <label><input type="checkbox" name="terms" value="1" <?php if ($terms)
            echo 'checked'; ?>> J'accepte les <a
                href="/termes-et-conditions" target="_blank">termes et conditions</a> *</label>
    </p>
    <div class="form-group btn-group">
        <a href="/register/?step=2" class="register-step-btn">Précédent</a>
        <button type="submit">S'enregistrer</button>
    </div>
</form>