<?php
include_once(__DIR__ . '/../../Controller/controllerVoiture.php');
$voitures = new controllerVoiture();
$resultat = $voitures->allVoiture();
?>
<html>
<head><title>Accueil</title></head>
<body>
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
            echo "<tr>
                    <td> $ids </td>
                    <td> $numeros </td>
                    <td> $types </td>
                    <td> $marques </td>
                    <td> $idPerss </td>
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