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
<form method="post" class="register-step-form">
    <h2>Étape 3 : Mot de passe et validation</h2>
    <?php foreach ($errors as $error): ?>
        <div class="form-error"><?php echo esc_html($error); ?></div>
    <?php endforeach; ?>
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
    <button type="submit">S'enregistrer</button>
</form>