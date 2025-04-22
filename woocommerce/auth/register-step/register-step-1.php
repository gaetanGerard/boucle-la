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
<div class="register-infos-container">
    <div class="register-infos-header">
        <h1>Créer votre comptre</h1>
        <p>Déjà un compte ? <a href="/login">Connectez-vous</a>.</p>
    </div>
    <div class="steps-info-container">
        <div class="step-info step-info-active">
            <div class="step-number">1</div>
            <div class="step-text">Email</div>
        </div>
        <div class="step-info">
            <div class="step-number">2</div>
            <div class="step-text">Informations personnelles</div>
        </div>
        <div class="step-info">
            <div class="step-number">3</div>
            <div class="step-text">Mot de passe</div>
        </div>
    </div>
</div>
<form method="post" class="register-step-form">
    <h2>Étape 1 : Votre email</h2>
    <?php foreach ($errors as $error): ?>
        <div class="form-error"><?php echo esc_html($error); ?></div>
    <?php endforeach; ?>
    <p>
        <label>Email *</label><br>
        <input type="email" name="email" placeholder="john.doe@email.com" required
            value="<?php echo esc_attr($email); ?>">
    </p>
    <p>
        <label>Confirmez l'email *</label><br>
        <input type="email" name="email_confirm" placeholder="john.doe@email.com" required
            value="<?php echo esc_attr($email_confirm); ?>">
    </p>
    <button type="submit">Suivant</button>
</form>