<?php
require_once __DIR__ . '/../Modele/Repository/transactionUser.php';

class controllerUser {
    private $repo;

    public function __construct() {
        $this->repo = new transactionUser();
    }

    public function findByEmail($email) {
        return $this->repo->findByEmail($email);
    }

    public function create($email, $passwordHash) {
        return $this->repo->create($email, $passwordHash);
    }
}
