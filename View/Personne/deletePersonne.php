<?php
require_once __DIR__ . '/../Auth/guard.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !formValidation::hasValidCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null) ||
    !isset($_POST['id']) ||
    (!is_string($_POST['id']) && !is_int($_POST['id'])) ||
    filter_var($_POST['id'], FILTER_VALIDATE_INT) === false ||
    (int) $_POST['id'] < 1) {
    http_response_code(400);
    ?>
    <!doctype html>
    <html lang="fr">
    <head><meta charset="utf-8"><title>Requête invalide</title><link rel="stylesheet" href="../style.css"></head>
    <body><main class="app-shell"><section class="panel">
        <h1>Requête invalide</h1>
        <p>Le formulaire a expiré ou les données envoyées sont invalides. Revenez à la liste des personnes et réessayez.</p>
        <a class="button" href="showPersonne.php">Retour aux personnes</a>
    </section></main></body>
    </html>
    <?php
    exit();
}

require_once __DIR__ . '/../../Controller/controllerPersonne.php';
$controller = new controllerPersonne();
$controller->deletePersonne((int) $_POST['id']);
header('Location: showPersonne.php');
exit();
