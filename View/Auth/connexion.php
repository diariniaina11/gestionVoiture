<?php
require_once __DIR__ . '/../../Controller/controllerUser.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$email = '';
$registered = isset($_GET['inscription']) && $_GET['inscription'] === 'ok';

if (isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!formValidation::hasValidCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null)) {
        $error = 'Le formulaire a expiré. Veuillez le soumettre à nouveau.';
    } elseif (!formValidation::isValidEmail($email) ||
        !is_string($password) ||
        $password === '' ||
        strlen($password) > 72) {
        $error = 'Adresse e-mail ou mot de passe incorrect.';
    } else {
        $userController = new controllerUser();
        $user = $userController->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: ../../index.php');
            exit();
        }
        $error = 'Adresse e-mail ou mot de passe incorrect.';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion | GestionVoiture</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="auth-page">
    <main class="auth-card glass-card">
        <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
        <p class="eyebrow">BON RETOUR</p>
        <h1>Connectez-vous</h1>
        <p class="muted">Retrouvez votre espace de gestion automobile.</p>

        <?php if ($registered): ?>
            <p class="notice notice-success" role="status">Votre compte a été créé. Vous pouvez vous connecter.</p>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form method="post" action="connexion.php" class="form-stack">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(formValidation::csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
            <label for="email">Adresse e-mail</label>
            <input id="email" name="email" type="email" maxlength="254" autocomplete="email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" maxlength="72" autocomplete="current-password" required>
            <button class="button button-primary button-full" type="submit">Se connecter</button>
        </form>

        <p class="auth-switch">Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
    </main>
</body>
</html>
