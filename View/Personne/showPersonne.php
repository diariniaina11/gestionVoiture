<?php
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
</head>
<body>
    <form method="GET" action="showPersonne.php">
        <input type="submit" name="b1" value="Ajout Personne"><br>
    </form>
    
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

                echo "<tr>
                        <td> $id </td>
                        <td> $nom </td>
                        <td> $prenom </td>
                        <td> $adresse </td>
                        <td> 
                            <a href=\"./updatePersonne.php?id=$id&nom=$nom&prenom=$prenom&adresse=$adresse\">Modifier</a><br>
                            <a href=\"./deletePersonne.php?id=$id\">Supprimer</a><br>
                        </td>
                        <td>
                            <a href=\"../voiture/addVoiture.php?idPers=$id\">Ajouter Voiture</a><br>
                            <a href=\"../voiture/showVoiturePersonne.php?idPers=$id\">Afficher Voiture</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <script type="text/javascript" src='../DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../tableau.js"></script>
    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/jquery.dataTables.min.css">
</body>
</html>