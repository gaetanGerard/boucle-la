<?php
if (!isset($_SESSION['register'])) {
    $_SESSION['register'] = [];
}
$errors = [];
$email = '';
$email_confirm = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $email_confirm = trim(isset($_POST['email_confirm']) ? $_POST['email_confirm'] : '');
    if (empty($email) || empty($email_confirm)) {
        $errors[] = 'Veuillez remplir les deux champs email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !filter_var($email_confirm, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Les adresses email doivent être valides.';
    } elseif ($email !== $email_confirm) {
        $errors[] = 'Les adresses email ne correspondent pas.';
    }
    if (empty($errors)) {
        $_SESSION['register']['email'] = $email;
        header('Location: ?step=2');
        exit;
    }
}
?>
<form method="post" class="register-step-form">
    <h2>Étape 1 : Votre email</h2>
    <?php foreach ($errors as $error): ?>
        <div class="form-error"><?php echo esc_html($error); ?></div>
    <?php endforeach; ?>
    <p>
        <label>Email *</label><br>
        <input type="email" name="email" required value="<?php echo esc_attr($email); ?>">
    </p>
    <p>
        <label>Confirmez l'email *</label><br>
        <input type="email" name="email_confirm" required value="<?php echo esc_attr($email_confirm); ?>">
    </p>
    <button type="submit">Suivant</button>
</form>