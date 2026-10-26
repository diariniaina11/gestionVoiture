<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['z1'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: View/Auth/connexion.php');
        exit();
    }
    if ($_GET['z1'] === 'personnes') {
        header('Location: View/Personne/showPersonne.php');
        exit();
    }
    if ($_GET['z1'] === 'voitures') {
        header('Location: View/Voiture/showVoiture.php');
        exit();
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GestionVoiture | Tableau de bord</title>
    <link rel="stylesheet" href="View/style.css">
</head>
<body>
    <main class="app-shell">
        <header class="topbar">
            <a class="brand" href="index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
            <nav class="topbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="muted"><?php echo htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <a href="View/Auth/deconnexion.php">Déconnexion</a>
                <?php else: ?>
                    <a href="View/Auth/connexion.php">Connexion</a>
                    <a class="button button-primary" href="View/Auth/inscription.php">Créer un compte</a>
                <?php endif; ?>
            </nav>
        </header>

        <section class="welcome">
            <p class="eyebrow">VOTRE ESPACE DE GESTION</p>
            <h1><?php echo isset($_SESSION['user_id']) ? 'Tout votre parc, au même endroit.' : 'Une gestion automobile plus simple.'; ?></h1>
            <p class="muted"><?php echo isset($_SESSION['user_id']) ? 'Gérez vos personnes et leurs véhicules depuis votre tableau de bord.' : 'Connectez-vous ou créez un compte pour accéder à votre espace.'; ?></p>
        </section>

        <?php if (isset($_SESSION['user_id'])): ?>
            <section class="panel">
                <div class="panel-heading">
                    <h2>Gestion du parc</h2>
                    <div class="action-links">
                        <form method="get" action="index.php"><button class="button button-primary" type="submit" name="z1" value="personnes">Gérer les personnes</button></form>
                        <form method="get" action="index.php"><button class="button" type="submit" name="z1" value="voitures">Afficher les voitures</button></form>
                    </div>
                </div>
                <p class="muted">Choisissez une section pour consulter et gérer les données de votre parc automobile.</p>
            </section>
        <?php else: ?>
            <section class="panel">
                <h2>Commencez maintenant</h2>
                <p class="muted">Votre compte vous permettra de retrouver les données de gestion des personnes et des véhicules.</p>
                <div class="action-links">
                    <a class="button button-primary" href="View/Auth/inscription.php">Créer un compte</a>
                    <a class="button" href="View/Auth/connexion.php">Se connecter</a>
                </div>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
