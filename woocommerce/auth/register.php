<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (is_user_logged_in()) {
    echo '<p>' . __('Vous êtes déjà connecté.', 'bo-theme') . '</p>';
    return;
}

$step = isset($_GET['step']) ? intval($_GET['step']) : 1;
$step = max(1, min(3, $step));

$step_file = __DIR__ . '/register-step/register-step-' . $step . '.php';
if (file_exists($step_file)) {
    include $step_file;
} else {
    echo '<p>Erreur : étape inconnue.</p>';
}