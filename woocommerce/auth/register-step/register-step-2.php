<?php
if (!isset($_SESSION['register']['email'])) {
    header('Location: ?step=1');
    exit;
}
$errors = [];
$fields = [
    'first_name' => '',
    'display_name' => '',
    'last_name' => '',
    'address_1' => '',
    'building_number' => '',
    'apartment_number' => '',
    'postcode' => '',
    'city' => '',
    'state' => '',
    'country' => '',
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($fields as $key => &$val) {
        $val = trim(isset($_POST[$key]) ? $_POST[$key] : '');
        if (!in_array($key, ['apartment_number', 'display_name']) && empty($val)) {
            $errors[] = 'Le champ ' . $key . ' est obligatoire.';
        }
    }
    unset($val);
    if (empty($errors)) {
        $_SESSION['register'] = array_merge($_SESSION['register'], $fields);
        header('Location: ?step=3');
        exit;
    }
} else {
    foreach ($fields as $key => &$val) {
        $val = isset($_SESSION['register'][$key]) ? $_SESSION['register'][$key] : '';
    }
    unset($val);
}
?>
<form method="post" class="register-step-form">
    <h2>Étape 2 : Informations personnelles</h2>
    <?php foreach ($errors as $error): ?>
        <div class="form-error"><?php echo esc_html($error); ?></div>
    <?php endforeach; ?>
    <p><label>Prénom *</label><br><input type="text" name="first_name" required
            value="<?php echo esc_attr($fields['first_name']); ?>"></p>
    <p><label>Nom affiché</label><br><input type="text" name="display_name"
            value="<?php echo esc_attr($fields['display_name']); ?>" placeholder="Nom affiché sur le site"></p>
    <p><label>Nom *</label><br><input type="text" name="last_name" required
            value="<?php echo esc_attr($fields['last_name']); ?>"></p>
    <p><label>Adresse (rue) *</label><br><input type="text" name="address_1" required
            value="<?php echo esc_attr($fields['address_1']); ?>"></p>
    <p><label>Numéro de bâtiment *</label><br><input type="text" name="building_number" required
            value="<?php echo esc_attr($fields['building_number']); ?>"></p>
    <p><label>Numéro d'appartement</label><br><input type="text" name="apartment_number"
            value="<?php echo esc_attr($fields['apartment_number']); ?>"></p>
    <p><label>Code postal *</label><br><input type="text" name="postcode" required
            value="<?php echo esc_attr($fields['postcode']); ?>"></p>
    <p><label>Ville *</label><br><input type="text" name="city" required
            value="<?php echo esc_attr($fields['city']); ?>"></p>
    <p><label>Province/État *</label><br><input type="text" name="state" required
            value="<?php echo esc_attr($fields['state']); ?>"></p>
    <p><label>Pays *</label><br><input type="text" name="country" required
            value="<?php echo esc_attr($fields['country']); ?>"></p>
    <button type="submit">Suivant</button>
</form>