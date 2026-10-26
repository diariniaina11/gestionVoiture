<?php
require_once __DIR__ . '/../Auth/guard.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';
include_once(__DIR__ . '/../../Controller/controllerPersonne.php');
$ajout = new controllerPersonne();
$error = '';
$nom = '';
$prenom = '';
$adresse = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['z1']) && is_string($_POST['z1']) ? trim($_POST['z1']) : '';
    $prenom = isset($_POST['z2']) && is_string($_POST['z2']) ? trim($_POST['z2']) : '';
    $adresse = isset($_POST['z3']) && is_string($_POST['z3']) ? trim($_POST['z3']) : '';
    if (!formValidation::hasValidCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null)) {
        $error = 'Le formulaire a expiré. Veuillez le soumettre à nouveau.';
    } elseif (formValidation::isValidText($nom, 50) &&
        formValidation::isValidText($prenom, 50) &&
        formValidation::isValidText($adresse, 100)) {
        $ajout->addPersonnes($nom, $prenom, $adresse);
        header('Location: showPersonne.php');
        exit();
    } else {
        $error = 'Le nom et le prénom doivent contenir au plus 50 caractères et l’adresse au plus 100 caractères.';
    }
    $error = 'Tous les champs sont obligatoires.';
}
?>
<html>
<head><title>Ajout Personne</title><link rel="stylesheet" href="../style.css"></head>
<body>
    <main class="app-shell">
        <header class="topbar">
            <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
            <nav class="topbar-nav"><a href="showPersonne.php">Personnes</a><a href="../Auth/deconnexion.php">Déconnexion</a></nav>
        </header>
        <section class="panel">
            <h1>Ajouter une personne</h1>
            <?php if ($error !== ''): ?>
                <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form method="post" action="addPersonne.php" class="form-stack">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(formValidation::csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                <label for="nom">Nom</label><input id="nom" type="text" name="z1" maxlength="50" required value="<?php echo htmlspecialchars($nom, ENT_QUOTES, 'UTF-8'); ?>">
                <label for="prenom">Prénom</label><input id="prenom" type="text" name="z2" maxlength="50" required value="<?php echo htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8'); ?>">
                <label for="adresse">Adresse</label><input id="adresse" type="text" name="z3" maxlength="100" required value="<?php echo htmlspecialchars($adresse, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="action-links"><button class="button button-primary" type="submit">Ajouter</button><a class="button" href="showPersonne.php">Annuler</a></div>
            </form>
        </section>
    </main>
</body>
</html>