<?php
include('..\..\..\GestionVoiture\Controller\controllerPersonne.php');
	$supp= new controllerPersonne();
	$supp->deletePersonne($_GET['id']);
	header('Location:showPersonne.php');
?>