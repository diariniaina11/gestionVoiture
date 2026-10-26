<?php
require_once __DIR__ . '/../Auth/guard.php';
include_once(__DIR__ . '/../../Controller/controllerVoiture.php');
$voitures = new controllerVoiture();
$resultat = $voitures->allVoiture();
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
    <div class="panel-heading"><h1>Voitures</h1></div>
    <table id='tab' class='display'>
        <thead>
            <tr>
                <td>Id</td>
                <td>Numero</td>
                <td>Type</td>
                <td>Marque</td>
                <td>IdPers</td>
                <td>Action Voiture</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($resultat as $res) {
            $ids = $res->getId();
            $numeros = $res->getNumero();
            $types = $res->getType();
            $marques = $res->getMarque();
            $idPerss = $res->getIdPers();
            $escape = function ($value) {
                return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
            };
            echo "<tr>
                    <td>" . $escape($ids) . "</td>
                    <td>" . $escape($numeros) . "</td>
                    <td>" . $escape($types) . "</td>
                    <td>" . $escape($marques) . "</td>
                    <td>" . $escape($idPerss) . "</td>
                    <td> </td>
                  </tr>";
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