<?php
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
<head><title>Accueil</title></head>
<body>
    <form method="GET" action="showVoiturePersonne.php">
        <input type="submit" name="b1" value="Retour"><br>
    </form>
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
            echo "<tr>
                    <td> $id </td>
                    <td> $numero </td>
                    <td> $type </td>
                    <td> $marque </td>
                    <td> </td>
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