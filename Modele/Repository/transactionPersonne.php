<?php
include_once(__DIR__ . '/Connexion/connexion.php');
include_once(__DIR__ . '/cacheDonnees.php');
include_once(__DIR__ . '/../Entity/personne.php');

class transactionPersonne {
    private $db;

    public function __construct() {
        $this->db = connexion::getConnexion();
    }

    public function getAll() {
        $rows = cacheDonnees::remember('personnes', function () {
            $req = $this->db->query("SELECT * FROM personne");
            return $req->fetchAll(PDO::FETCH_ASSOC);
        });

        $personnes = array();
        foreach ($rows as $row) {
            $personne = new personne();
            $personne->setId($row['id']);
            $personne->setNom($row['nom']);
            $personne->setPrenom($row['prenom']);
            $personne->setAdresse($row['adresse']);
            $personnes[] = $personne;
        }
        return $personnes;
    }

    public function add($nom, $prenom, $adresse) {
        $req = $this->db->prepare("INSERT INTO personne (nom, prenom, adresse) VALUES (?, ?, ?)");
        $success = $req->execute([$nom, $prenom, $adresse]);
        if ($success) {
            cacheDonnees::invalidate('personnes');
        }
        return $success;
    }

    public function update($id, $nom, $prenom, $adresse) {
        $req = $this->db->prepare("UPDATE personne SET nom = ?, prenom = ?, adresse = ? WHERE id = ?");
        $success = $req->execute([$nom, $prenom, $adresse, $id]);
        if ($success) {
            cacheDonnees::invalidate('personnes');
        }
        return $success;
    }

    public function delete($id) {
        $req = $this->db->prepare("DELETE FROM personne WHERE id = ?");
        $success = $req->execute([$id]);
        if ($success) {
            cacheDonnees::invalidate('personnes');
            cacheDonnees::invalidate('voitures');
        }
        return $success;
    }
}
?>