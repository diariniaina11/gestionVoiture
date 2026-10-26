<?php
require_once __DIR__ . '/../Auth/guard.php';
include_once(__DIR__ . '/../../Controller/controllerVoiture.php');

if (isset($_GET['b1'])) {
    header('Location: ../Personne/showPersonne.php');
    exit();
} else {
    $ajout = new controllerVoiture();
    $idPers = $_GET['idPers'];
    $resultat = $ajout->selectVoiture($idPers);
}
?>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <main class="app-shell">
    <header class="topbar">
        <a class="brand" href="../../index.php"><span class="brand-mark">GV</span> GestionVoiture</a>
        <nav class="topbar-nav"><a href="../Personne/showPersonne.php">Personnes</a><a href="../Auth/deconnexion.php">Déconnexion</a></nav>
    </header>
    <section class="panel">
    <div class="panel-heading"><h1>Voitures de la personne</h1><a class="button" href="../Personne/showPersonne.php">Retour</a></div>
    <table id='tab' class='display'>
        <thead>
            <tr>
                <td>Id</td>
                <td>Numero</td>
                <td>Type</td>
                <td>Marque</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($resultat as $res) {
            $id = $res->getId();
            $numero = $res->getNumero();
            $type = $res->getType();
            $marque = $res->getMarque();
            echo '<tr>
                    <td>' . htmlspecialchars((string) $id, ENT_QUOTES, 'UTF-8') . '</td>
                    <td>' . htmlspecialchars((string) $numero, ENT_QUOTES, 'UTF-8') . '</td>
                    <td>' . htmlspecialchars((string) $type, ENT_QUOTES, 'UTF-8') . '</td>
                    <td>' . htmlspecialchars((string) $marque, ENT_QUOTES, 'UTF-8') . '</td>
                    <td> </td>
                  </tr>';
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