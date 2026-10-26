<?php
require_once __DIR__ . '/Connexion/connexion.php';
require_once __DIR__ . '/cacheDonnees.php';
require_once __DIR__ . '/../Entity/voiture.php';

class transactionVoiture {
    private $db;

    public function __construct() {
        $this->db = connexion::getConnexion();
    }

    public function getAll() {
        $rows = cacheDonnees::remember('voitures', function () {
            $req = $this->db->query("SELECT * FROM voiture");
            return $req->fetchAll(PDO::FETCH_ASSOC);
        });

        $voitures = array();
        foreach ($rows as $row) {
            $voiture = new voiture();
            $voiture->setId($row['id']);
            $voiture->setNumero($row['numero']);
            $voiture->setType($row['type']);
            $voiture->setMarque($row['marque']);
            $voiture->setIdPers($row['idPers']);
            $voitures[] = $voiture;
        }
        return $voitures;
    }

    public function getByPersonne($idPers) {
        return array_values(array_filter($this->getAll(), function ($voiture) use ($idPers) {
            return (int) $voiture->getIdPers() === (int) $idPers;
        }));
    }

    public function add($numero, $type, $marque, $idPers) {
        $req = $this->db->prepare("INSERT INTO voiture (numero, type, marque, idPers) VALUES (?, ?, ?, ?)");
        $success = $req->execute([$numero, $type, $marque, $idPers]);
        if ($success) {
            cacheDonnees::invalidate('voitures');
        }
        return $success;
    }
}
?>