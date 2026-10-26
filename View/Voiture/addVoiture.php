<?php
require_once __DIR__ . '/../Auth/guard.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';
include_once(__DIR__ . '/../../Controller/controllerVoiture.php');
include_once(__DIR__ . '/../../Controller/controllerPersonne.php');
$ajout = new controllerVoiture();
$personnes = new controllerPersonne();
$error = '';
$numero = '';
$type = '';
$marque = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = isset($_POST['z1']) && is_string($_POST['z1']) ? trim($_POST['z1']) : '';
    $type = isset($_POST['z2']) && is_string($_POST['z2']) ? trim($_POST['z2']) : '';
    $marque = isset($_POST['z3']) && is_string($_POST['z3']) ? $_POST['z3'] : '';
    $personneExiste = false;
    if (isset($_SESSION['idPers']) &&
        (is_int($_SESSION['idPers']) || is_string($_SESSION['idPers'])) &&
        filter_var($_SESSION['idPers'], FILTER_VALIDATE_INT) !== false) {
        foreach ($personnes->allPersonne() as $personne) {
            if ((int) $personne->getId() === (int) $_SESSION['idPers']) {
                $personneExiste = true;
                break;
            }
        }
    }

    if (!formValidation::hasValidCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null)) {
        $error = 'Le formulaire a expiré. Veuillez le soumettre à nouveau.';
    } elseif (!$personneExiste) {
        $error = 'La personne sélectionnée est introuvable. Revenez à la liste et sélectionnez une personne.';
    } elseif (!formValidation::isValidVehicleNumber($numero)) {
        $error = 'Le numéro est obligatoire (10 caractères maximum, lettres, chiffres, espaces ou tirets).';
    } elseif (!formValidation::isValidVehicleType($type)) {
        $error = 'Le type est obligatoire (20 caractères maximum).';
    } elseif (!formValidation::isValidVehicleBrand($marque)) {
        $error = 'Veuillez choisir une marque reconnue dans la liste.';
    } else {
        $idPers = (int) $_SESSION['idPers'];
        $ajout->addVoiture($numero, $type, $marque, $idPers);
        unset($_SESSION['idPers']);
        header('Location: ../Personne/showPersonne.php');
        exit();
    }
} else {
    if (!isset($_GET['idPers']) ||
        (!is_string($_GET['idPers']) && !is_int($_GET['idPers'])) ||
        filter_var($_GET['idPers'], FILTER_VALIDATE_INT) === false ||
        (int) $_GET['idPers'] < 1) {
        header('Location: ../Personne/showPersonne.php');
        exit();
    }
    $_SESSION['idPers'] = (int) $_GET['idPers'];
}
?>
<html>
<head><title>Ajout Voiture</title><link rel="stylesheet" href="../style.css"></head>
<body>
    <main class="app-shell">
        <header class="topbar">
            <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
            <nav class="topbar-nav"><a href="../Personne/showPersonne.php">Personnes</a><a href="../Auth/deconnexion.php">Déconnexion</a></nav>
        </header>
        <section class="panel">
            <h1>Ajouter une voiture</h1>
            <?php if ($error !== ''): ?>
                <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form method="post" action="addVoiture.php" class="form-stack">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(formValidation::csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                <label for="numero">Numéro</label><input id="numero" type="text" name="z1" maxlength="10" pattern="[A-Za-zÀ-ÿ0-9 -]+" required value="<?php echo htmlspecialchars($numero, ENT_QUOTES, 'UTF-8'); ?>">
                <label for="type">Type</label><input id="type" type="text" name="z2" maxlength="20" pattern="[A-Za-zÀ-ÿ0-9 .-]+" required value="<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?>">
                <label for="marque">Marque</label>
                <select id="marque" name="z3" required>
                    <option value="">Sélectionnez une marque reconnue</option>
                    <?php foreach (formValidation::vehicleBrands() as $brand): ?>
                        <option value="<?php echo htmlspecialchars($brand, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $marque === $brand ? ' selected' : ''; ?>><?php echo htmlspecialchars($brand, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="action-links"><button class="button button-primary" type="submit">Ajouter</button><a class="button" href="../Personne/showPersonne.php">Annuler</a></div>
            </form>
        </section>
    </main>
</body>
</html>