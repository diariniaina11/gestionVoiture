<?php
include_once(__DIR__ . '/Connexion/connexion.php');
include_once(__DIR__ . '/../Entity/personne.php');

class transactionPersonne {
    private $db;

    public function __construct() {
        $this->db = connexion::getConnexion();
    }

    public function getAll() {
        $req = $this->db->query("SELECT * FROM personne");
        return $req->fetchAll(PDO::FETCH_CLASS, 'personne');
    }

    public function add($nom, $prenom, $adresse) {
        $req = $this->db->prepare("INSERT INTO personne (nom, prenom, adresse) VALUES (?, ?, ?)");
        return $req->execute([$nom, $prenom, $adresse]);
    }

    public function update($id, $nom, $prenom, $adresse) {
        $req = $this->db->prepare("UPDATE personne SET nom = ?, prenom = ?, adresse = ? WHERE id = ?");
        return $req->execute([$nom, $prenom, $adresse, $id]);
    }

    public function delete($id) {
        $req = $this->db->prepare("DELETE FROM personne WHERE id = ?");
        return $req->execute([$id]);
    }
}
?>