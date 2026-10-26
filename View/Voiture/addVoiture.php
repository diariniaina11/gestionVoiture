<?php
include_once(__DIR__ . '/../../Controller/controllerVoiture.php');
$ajout = new controllerVoiture();
session_start();

if (isset($_GET['b1'])) {
    if ($_GET['z1'] == "" || $_GET['z2'] == "" || $_GET['z3'] == "") {
        header('Location: addVoiture.php');
        exit();
    } else {
        $idPers = $_SESSION['idPers'];
        $numero = $_GET['z1'];
        $type = $_GET['z2'];
        $marque = $_GET['z3'];
        $ajout->addVoiture($numero, $type, $marque, $idPers);
        session_destroy();
        header('Location: ../Personne/showPersonne.php');
        exit();
    }
} else {
    $_SESSION['idPers'] = $_GET['idPers'];
}
?>
<html>
<head><title>Ajout Voiture</title></head>
<body>
    <form method="GET" action="addVoiture.php">
        <table>
            <tr><td>Numero</td><td><input type="text" name="z1"></td></tr>
            <tr><td>Type</td><td><input type="text" name="z2"></td></tr>
            <tr><td>Marque</td><td><input type="text" name="z3"></td></tr>
            <tr><td><input type="submit" name="b1" value="Ajouter"></td></tr>
        </table>
    </form>
</body>
</html>