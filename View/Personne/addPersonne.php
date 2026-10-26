<?php
include_once(__DIR__ . '/../../Controller/controllerPersonne.php');
$ajout = new controllerPersonne();

if (isset($_GET['b1'])) {
    if ($_GET['z1'] == "") {
        header('Location: addPersonne.php');
        exit();
    } else {
        $nom = $_GET['z1'];
        $prenom = $_GET['z2'];
        $adresse = $_GET['z3'];
        $ajout->addPersonnes($nom, $prenom, $adresse);
        header('Location: showPersonne.php');
        exit();
    }
}
?>
<html>
<head><title>Ajout Personne</title></head>
<body>
    <form method="GET" action="addPersonne.php">
        <table>
            <tr><td>Nom</td><td><input type="text" name="z1"></td></tr>
            <tr><td>Prenom</td><td><input type="text" name="z2"></td></tr>
            <tr><td>Adresse</td><td><input type="text" name="z3"></td></tr>
            <tr><td><input type="submit" name="b1" value="Ajouter"></td></tr>
        </table>
    </form>
</body>
</html>