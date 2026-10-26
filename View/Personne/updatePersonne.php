<?php
require_once __DIR__ . '/../Auth/guard.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';
include_once(__DIR__ . '/../../Controller/controllerPersonne.php');

$controller = new controllerPersonne();
$error = '';
$rawId = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$validatedId = is_string($rawId) || is_int($rawId) ? filter_var($rawId, FILTER_VALIDATE_INT) : false;
$id = $validatedId === false ? 0 : (int) $validatedId;
$nom = '';
$prenom = '';
$adresse = '';
$personneExiste = false;
if ($id > 0) {
    foreach ($controller->allPersonne() as $personne) {
        if ((int) $personne->getId() === $id) {
            $personneExiste = true;
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $nom = $personne->getNom();
                $prenom = $personne->getPrenom();
                $adresse = $personne->getAdresse();
            }
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) && is_string($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) && is_string($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $adresse = isset($_POST['adresse']) && is_string($_POST['adresse']) ? trim($_POST['adresse']) : '';
    if (!formValidation::hasValidCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null)) {
        $error = 'Le formulaire a expiré. Veuillez le soumettre à nouveau.';
    } elseif (!$personneExiste) {
        $error = 'La personne à modifier est introuvable.';
    } elseif (!formValidation::isValidText($nom, 50) ||
        !formValidation::isValidText($prenom, 50) ||
        !formValidation::isValidText($adresse, 100)) {
        $error = 'Le nom et le prénom doivent contenir au plus 50 caractères et l’adresse au plus 100 caractères.';
    } else {
        $controller->updatePersonne($id, $nom, $prenom, $adresse);
        header('Location: showPersonne.php');
        exit();
    }
} elseif (!$personneExiste) {
    header('Location: showPersonne.php');
    exit();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier une personne | GestionVoiture</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <main class="app-shell">
        <header class="topbar">
            <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
            <nav class="topbar-nav"><a href="showPersonne.php">Personnes</a><a href="../Auth/deconnexion.php">Déconnexion</a></nav>
        </header>
        <section class="panel">
            <h1>Modifier une personne</h1>
            <?php if ($error !== ''): ?>
                <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form method="post" action="updatePersonne.php" class="form-stack">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(formValidation::csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                <label for="nom">Nom</label>
                <input id="nom" name="nom" type="text" maxlength="50" required value="<?php echo htmlspecialchars($nom, ENT_QUOTES, 'UTF-8'); ?>">
                <label for="prenom">Prénom</label>
                <input id="prenom" name="prenom" type="text" maxlength="50" required value="<?php echo htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8'); ?>">
                <label for="adresse">Adresse</label>
                <input id="adresse" name="adresse" type="text" maxlength="100" required value="<?php echo htmlspecialchars($adresse, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="action-links">
                    <button class="button button-primary" type="submit">Enregistrer</button>
                    <a class="button" href="showPersonne.php">Annuler</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
