<?php
include_once(__DIR__ . '/../Modele/Repository/transactionPersonne.php');
 
class controllerPersonne {
    private $repo;

    public function __construct() {
        $this->repo = new transactionPersonne();
    }

    public function allPersonne() {
        return $this->repo->getAll();
    }

    public function addPersonnes($nom, $prenom, $adresse) {
        return $this->repo->add($nom, $prenom, $adresse);
    }

    public function updatePersonne($id, $nom, $prenom, $adresse) {
        return $this->repo->update($id, $nom, $prenom, $adresse);
    }

    public function deletePersonne($id) {
        return $this->repo->delete($id);
    }
}
?>