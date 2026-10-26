<?php
include_once(__DIR__ . '/../Modele/Repository/transactionVoiture.php');

class controllerVoiture {
    private $repo;

    public function __construct() {
        $this->repo = new transactionVoiture();
    }

    public function allVoiture() {
        return $this->repo->getAll();
    }

    public function selectVoiture($idPers) {
        return $this->repo->getByPersonne($idPers);
    }

    public function addVoiture($numero, $type, $marque, $idPers) {
        return $this->repo->add($numero, $type, $marque, $idPers);
    }
}
?>