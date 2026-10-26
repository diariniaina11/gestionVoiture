<?php
require_once __DIR__ . '/../Auth/guard.php';
require_once __DIR__ . '/../../Configuration/formValidation.php';
include_once(__DIR__ . '/../../Controller/controllerPersonne.php');

$ajout = new controllerPersonne();
$resultat = array();
$resultat = $ajout->allPersonne();

if (isset($_GET['b1'])) {
    header('Location: addPersonne.php');
    exit();
}
?>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/jquery.dataTables.min.css">
</head>
<body>
    <main class="app-shell">
    <header class="topbar">
        <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
        <nav class="topbar-nav"><a href="../Voiture/showVoiture.php">Voitures</a><a href="../Auth/deconnexion.php">Déconnexion</a></nav>
    </header>
    <section class="panel">
    <div class="panel-heading">
        <h1>Personnes</h1>
        <a class="button button-primary" href="addPersonne.php">Ajouter une personne</a>
    </div>
    <table id='tab' class='display'>
        <thead>
            <tr>
                <td>IdPers</td>
                <td>Nom</td>
                <td>Prenom</td>
                <td>Adresse</td>
                <td>Action Personne</td>
                <td>Action Voiture</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($resultat as $res) {
                $id = $res->getId();
                $nom = $res->getNom();
                $prenom = $res->getPrenom();
                $adresse = $res->getAdresse();

                $escape = function ($value) {
                    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
                };
                ?>
                <tr>
                    <td><?php echo $escape($id); ?></td>
                    <td><?php echo $escape($nom); ?></td>
                    <td><?php echo $escape($prenom); ?></td>
                    <td><?php echo $escape($adresse); ?></td>
                    <td>
                        <a href="./updatePersonne.php?id=<?php echo rawurlencode((string) $id); ?>">Modifier</a><br>
                        <form method="post" action="deletePersonne.php" onsubmit="return confirm('Supprimer cette personne et ses voitures ?');">
                            <input type="hidden" name="id" value="<?php echo $escape($id); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(formValidation::csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                    <td>
                        <a href="../Voiture/addVoiture.php?idPers=<?php echo rawurlencode((string) $id); ?>">Ajouter voiture</a><br>
                        <a href="../Voiture/showVoiturePersonne.php?idPers=<?php echo rawurlencode((string) $id); ?>">Afficher voitures</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <script type="text/javascript" src='../DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../tableau.js"></script>
    </section>
    </main>
</body>
</html>