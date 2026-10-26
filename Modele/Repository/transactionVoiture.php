<?php
require_once __DIR__ . '/Connexion/connexion.php';
require_once __DIR__ . '/../Entity/voiture.php';

class transactionVoiture {
    private $db;

    public function __construct() {
        $this->db = connexion::getConnexion();
    }

    public function getAll() {
        $req = $this->db->query("SELECT * FROM voiture");
        return $req->fetchAll(PDO::FETCH_CLASS, 'voiture');
    }

    public function getByPersonne($idPers) {
        $req = $this->db->prepare("SELECT * FROM voiture WHERE idPers = ?");
        $req->execute([$idPers]);
        return $req->fetchAll(PDO::FETCH_CLASS, 'voiture');
    }

    public function add($numero, $type, $marque, $idPers) {
        $req = $this->db->prepare("INSERT INTO voiture (numero, type, marque, idPers) VALUES (?, ?, ?, ?)");
        return $req->execute([$numero, $type, $marque, $idPers]);
    }
}
?>