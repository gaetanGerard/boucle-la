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
    // Clear values if not a POST (ex: after a failed registration or direct access)
    foreach ($fields as $key => &$val) {
        $val = '';
    }
    unset($val);
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
        <div class="step-info step-info-active">
            <div class="step-number">2</div>
            <div class="step-text">Informations personnelles</div>
        </div>
        <div class="step-info">
            <div class="step-number">3</div>
            <div class="step-text">Mot de passe</div>
        </div>
    </div>
</div>
<form method="post" class="register-step-form large-form">
    <h2>Étape 2 : Informations personnelles</h2>
    <?php foreach ($errors as $error): ?>
        <div class="form-error"><?php echo esc_html($error); ?></div>
    <?php endforeach; ?>
    <div class="form-group">
        <p><label>Prénom *</label><br><input type="text" placeholder="John" name="first_name" required
                value="<?php echo esc_attr($fields['first_name']); ?>"></p>
        <p><label>Nom *</label><br><input type="text" placeholder="Doe" name="last_name" required
                value="<?php echo esc_attr($fields['last_name']); ?>"></p>
    </div>
    <div class="form-group">
        <p><label>Nom affiché</label><br><input type="text" name="display_name"
                value="<?php echo esc_attr($fields['display_name']); ?>" placeholder="Nom affiché sur le site"></p>
    </div>
    <div class="form-group-full">
        <p><label>Adresse (rue) *</label><br><input type="text" placeholder="Rue de boucle-la" name="address_1" required
                value="<?php echo esc_attr($fields['address_1']); ?>"></p>
    </div>
    <div class="form-group">
        <p><label>Numéro de bâtiment *</label><br><input type="text" placeholder="1" name="building_number" required
                value="<?php echo esc_attr($fields['building_number']); ?>"></p>
        <p><label>Numéro d'appartement</label><br><input type="text" placeholder="1" name="apartment_number"
                value="<?php echo esc_attr($fields['apartment_number']); ?>"></p>
    </div>
    <div class="form-group">
        <p><label>Code postal *</label><br><input type="text" placeholder="1234" name="postcode" required
                value="<?php echo esc_attr($fields['postcode']); ?>"></p>
        <p><label>Ville *</label><br><input type="text" placeholder="ville" name="city" required
                value="<?php echo esc_attr($fields['city']); ?>"></p>
    </div>
    <div class="form-group">
        <p><label>Province/État *</label><br><input type="text" placeholder="votre province/états" name="state" required
                value="<?php echo esc_attr($fields['state']); ?>"></p>
        <p><label>Pays *</label><br>
            <select name="country" required>
                <option value="">Sélectionnez un pays</option>
                <optgroup label="Principal zone de livraison">
                    <option value="Belgique" <?php if ($fields['country'] === 'Belgique')
                        echo 'selected'; ?>>Belgique
                    </option>
                    <option value="France" <?php if ($fields['country'] === 'France')
                        echo 'selected'; ?>>France</option>
                    <option value="Luxembourg" <?php if ($fields['country'] === 'Luxembourg')
                        echo 'selected'; ?>>
                        Luxembourg</option>
                    <option value="Allemagne" <?php if ($fields['country'] === 'Allemagne')
                        echo 'selected'; ?>>Allemagne
                    </option>
                    <option value="Pays-Bas" <?php if ($fields['country'] === 'Pays-Bas')
                        echo 'selected'; ?>>Pays-Bas
                    </option>
                    <option value="Suisse" <?php if ($fields['country'] === 'Suisse')
                        echo 'selected'; ?>>Suisse</option>
                </optgroup>
                <optgroup label="Autres pays">
                    <?php
                    $all_countries = [
                        'Afghanistan',
                        'Afrique du Sud',
                        'Albanie',
                        'Algérie',
                        'Andorre',
                        'Angola',
                        'Antigua-et-Barbuda',
                        'Arabie saoudite',
                        'Argentine',
                        'Arménie',
                        'Australie',
                        'Autriche',
                        'Azerbaïdjan',
                        'Bahamas',
                        'Bahreïn',
                        'Bangladesh',
                        'Barbade',
                        'Biélorussie',
                        'Bélize',
                        'Bénin',
                        'Bhoutan',
                        'Bolivie',
                        'Bosnie-Herzégovine',
                        'Botswana',
                        'Brésil',
                        'Brunei',
                        'Bulgarie',
                        'Burkina Faso',
                        'Burundi',
                        'Cambodge',
                        'Cameroun',
                        'Canada',
                        'Cap-Vert',
                        'République centrafricaine',
                        'Chili',
                        'Chine',
                        'Chypre',
                        'Colombie',
                        'Comores',
                        'Congo',
                        'République du Congo',
                        'Corée du Nord',
                        'Corée du Sud',
                        'Costa Rica',
                        'Côte d’Ivoire',
                        'Croatie',
                        'Cuba',
                        'Danemark',
                        'Djibouti',
                        'Dominique',
                        'Égypte',
                        'Émirats arabes unis',
                        'Équateur',
                        'Érythrée',
                        'Espagne',
                        'Estonie',
                        'Eswatini',
                        'États-Unis',
                        'Éthiopie',
                        'Fidji',
                        'Finlande',
                        'Gabon',
                        'Gambie',
                        'Géorgie',
                        'Ghana',
                        'Grèce',
                        'Grenade',
                        'Guatemala',
                        'Guinée',
                        'Guinée-Bissau',
                        'Guinée équatoriale',
                        'Guyana',
                        'Haïti',
                        'Honduras',
                        'Hongrie',
                        'Inde',
                        'Indonésie',
                        'Irak',
                        'Iran',
                        'Irlande',
                        'Islande',
                        'Israël',
                        'Italie',
                        'Jamaïque',
                        'Japon',
                        'Jordanie',
                        'Kazakhstan',
                        'Kenya',
                        'Kirghizistan',
                        'Kiribati',
                        'Koweït',
                        'Laos',
                        'Lesotho',
                        'Lettonie',
                        'Liban',
                        'Libéria',
                        'Libye',
                        'Liechtenstein',
                        'Lituanie',
                        'Macédoine du Nord',
                        'Madagascar',
                        'Malaisie',
                        'Malawi',
                        'Maldives',
                        'Mali',
                        'Malte',
                        'Maroc',
                        'Îles Marshall',
                        'Maurice',
                        'Mauritanie',
                        'Mexique',
                        'Micronésie',
                        'Moldavie',
                        'Monaco',
                        'Mongolie',
                        'Monténégro',
                        'Mozambique',
                        'Myanmar',
                        'Namibie',
                        'Nauru',
                        'Népal',
                        'Nicaragua',
                        'Niger',
                        'Nigéria',
                        'Norvège',
                        'Nouvelle-Zélande',
                        'Oman',
                        'Ouganda',
                        'Ouzbékistan',
                        'Pakistan',
                        'Palaos',
                        'Palestine',
                        'Panama',
                        'Papouasie-Nouvelle-Guinée',
                        'Paraguay',
                        'Pérou',
                        'Philippines',
                        'Pologne',
                        'Portugal',
                        'Qatar',
                        'Roumanie',
                        'Royaume-Uni',
                        'Russie',
                        'Saint-Kitts-et-Nevis',
                        'Saint-Marin',
                        'Saint-Vincent-et-les-Grenadines',
                        'Sainte-Lucie',
                        'Salomon',
                        'Salvador',
                        'Samoa',
                        'Sao Tomé-et-Principe',
                        'Sénégal',
                        'Serbie',
                        'Seychelles',
                        'Sierra Leone',
                        'Singapour',
                        'Slovaquie',
                        'Slovénie',
                        'Somalie',
                        'Soudan',
                        'Soudan du Sud',
                        'Sri Lanka',
                        'Suède',
                        'Suriname',
                        'Syrie',
                        'Tadjikistan',
                        'Tanzanie',
                        'Tchad',
                        'République tchèque',
                        'Thaïlande',
                        'Timor oriental',
                        'Togo',
                        'Tonga',
                        'Trinité-et-Tobago',
                        'Tunisie',
                        'Turkménistan',
                        'Turquie',
                        'Tuvalu',
                        'Ukraine',
                        'Uruguay',
                        'Vanuatu',
                        'Vatican',
                        'Venezuela',
                        'Viêt Nam',
                        'Yémen',
                        'Zambie',
                        'Zimbabwe',
                    ];
                    $highlighted = ['Belgique', 'France', 'Luxembourg', 'Allemagne', 'Pays-Bas', 'Suisse'];
                    foreach ($all_countries as $country) {
                        if (!in_array($country, $highlighted)) {
                            $selected = ($fields['country'] === $country) ? 'selected' : '';
                            echo '<option value="' . esc_attr($country) . '" ' . $selected . '>' . esc_html($country) . '</option>';
                        }
                    }
                    ?>
                </optgroup>
            </select>
        </p>
    </div>
    <div class="form-group btn-group">
        <a href="/register/?step=1" class="register-step-btn">Précédent</a>
        <button type="submit">Suivant</button>
    </div>

</form>