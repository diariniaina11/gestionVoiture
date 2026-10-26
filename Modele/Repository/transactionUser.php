<?php
require_once __DIR__ . '/Connexion/connexion.php';

class transactionUser {
    private $db;

    public function __construct() {
        $this->db = connexion::getConnexion();
    }

    public function findByEmail($email) {
        $query = $this->db->prepare('SELECT id, email, `password` FROM `user` WHERE email = ?');
        $query->execute(array($email));
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function create($email, $passwordHash) {
        $query = $this->db->prepare('INSERT INTO `user` (email, `password`) VALUES (?, ?)');
        return $query->execute(array($email, $passwordHash));
    }
}
