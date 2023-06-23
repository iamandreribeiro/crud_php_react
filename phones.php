<?php
class Telefone {
    public $telefone;
    public $descricao;

    public function __construct() {        
    }

    public function deletePhone($userId) {
        global $pdo;
        $query = ('DELETE FROM phone WHERE "userId"=:userid;');

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userid', $userId);
        $stmt->execute();
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}
?>