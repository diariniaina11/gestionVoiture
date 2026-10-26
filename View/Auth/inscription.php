<?php
require_once __DIR__ . '/../../Controller/controllerUser.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$email = '';

if (isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmation = isset($_POST['confirmation']) ? $_POST['confirmation'] : '';

    if (!formValidation::hasValidCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null)) {
        $error = 'Le formulaire a expiré. Veuillez le soumettre à nouveau.';
    } elseif (!formValidation::isValidEmail($email)) {
        $error = 'Veuillez saisir une adresse e-mail valide.';
    } elseif (!formValidation::isValidPassword($password)) {
        $error = 'Le mot de passe doit contenir entre 8 et 72 caractères.';
    } elseif ($password !== $confirmation) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        $userController = new controllerUser();
        if ($userController->findByEmail($email)) {
            $error = 'Cette adresse e-mail est déjà utilisée.';
        } else {
            $userController->create($email, password_hash($password, PASSWORD_DEFAULT));
            header('Location: connexion.php?inscription=ok');
            exit();
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un compte | GestionVoiture</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="auth-page">
    <main class="auth-card glass-card">
        <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
        <p class="eyebrow">NOUVEAU COMPTE</p>
        <h1>Rejoignez votre espace</h1>
        <p class="muted">Créez votre compte pour gérer votre parc automobile.</p>

        <?php if ($error !== ''): ?>
            <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form method="post" action="inscription.php" class="form-stack">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(formValidation::csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
            <label for="email">Adresse e-mail</label>
            <input id="email" name="email" type="email" maxlength="254" autocomplete="email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" minlength="8" maxlength="72" autocomplete="new-password" required>
            <label for="confirmation">Confirmer le mot de passe</label>
            <input id="confirmation" name="confirmation" type="password" minlength="8" maxlength="72" autocomplete="new-password" required>
            <button class="button button-primary button-full" type="submit">Créer mon compte</button>
        </form>

        <p class="auth-switch">Vous avez déjà un compte ? <a href="connexion.php">Se connecter</a></p>
    </main>
</body>
</html>
