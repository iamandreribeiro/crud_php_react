<?php
require_once 'db.php';
class Users
{
    public $name;
    public $cpf;
    public $rg;
    public $cep;
    public $logradouro;
    public $complemento;
    public $setor;
    public $cidade;
    public $uf;
    public $phones;
    public function __construct()
    {
    }

    public function insert()
    {
        global $pdo;
        $query = "INSERT INTO users (name, cpf, rg, cep, logradouro, complemento, setor, cidade, uf) 
              VALUES (:name, :cpf, :rg, :cep, :logradouro, :complemento, :setor, :cidade, :uf) 
              RETURNING id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':cpf', $this->cpf);
        $stmt->bindValue(':rg', $this->rg);
        $stmt->bindValue(':cep', $this->cep);
        $stmt->bindValue(':logradouro', $this->logradouro);
        $stmt->bindValue(':complemento', $this->complemento);
        $stmt->bindValue(':setor', $this->setor);
        $stmt->bindValue(':cidade', $this->cidade);
        $stmt->bindValue(':uf', $this->uf);
        $stmt->execute();

        $lastInsertId = $stmt->fetchColumn();

        $this->insertPhones($lastInsertId);

        return $lastInsertId;
    }


    public function select()
    {
        global $pdo;
        $pdo->query("SELECT * FROM users")->fetchAll();
    }

    public function update($userId)
    {
        global $pdo;
        $query = ("UPDATE users SET name=:name, cpf=:cpf, rg=:rg, cep=:cep, logradouro=:logradouro, complemento=:complemento, setor=:setor, cidade=:cidade, uf=:uf WHERE id=:userId;");

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':cpf', $this->cpf);
        $stmt->bindValue(':rg', $this->rg);
        $stmt->bindValue(':cep', $this->cep);
        $stmt->bindValue(':logradouro', $this->logradouro);
        $stmt->bindValue(':complemento', $this->complemento);
        $stmt->bindValue(':setor', $this->setor);
        $stmt->bindValue(':cidade', $this->cidade);
        $stmt->bindValue(':uf', $this->uf);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
    }

    public function insertPhones($userId)
    {
        global $pdo;

        for ($i = 0; $i < count($this->phones); $i++) {
            if (!isset($this->phones[$i]->phoneDescription) || empty($this->phones[$i]->phoneDescription)) {
                continue;
            }

            if (!isset($this->phones[$i]->phoneNumber) || empty($this->phones[$i]->phoneNumber)) {
                continue;
            }
            
            $query = 'INSERT INTO phone ("phoneNumber", "phoneDescription", "userId")
                VALUES (:telefone, :descricao, :userid)';

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':telefone', $this->phones[$i]->phoneNumber);
            $stmt->bindValue(':descricao', $this->phones[$i]->phoneDescription);
            $stmt->bindValue(':userid', $userId);
            $stmt->execute();
        }
    }

    public function deleteUser($userId)
    {
        global $pdo;
        $telefone = new Telefone();
        $telefone->deletePhone($userId);
        $pdo->query("DELETE FROM users WHERE id=$userId");
    }

    public function getNome()
    {
        return $this->name;
    }

    public function setNome($name)
    {
        $this->name = $name;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }
    public function getComplemento()
    {
        return $this->complemento;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }
    public function getSetor()
    {
        return $this->setor;
    }

    public function setSetor($setor)
    {
        $this->setor = $setor;
    }
    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }
    public function getUf()
    {
        return $this->uf;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    public function setPhones($phones)
    {
        $this->phones = $phones;
    }
}
?>