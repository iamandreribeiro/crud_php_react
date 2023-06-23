<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

require_once 'users.php';
require_once 'phones.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'));
    echo json_encode($data);

    $name = $data->objetoCadastro->name;
    $cpf = $data->objetoCadastro->cpf;
    $rg = $data->objetoCadastro->rg;
    $cep = $data->objetoCadastro->cep;
    $logradouro = $data->objetoCadastro->logradouro;
    $complemento = $data->objetoCadastro->complemento;
    $setor = $data->objetoCadastro->setor;
    $cidade = $data->objetoCadastro->cidade;
    $uf = $data->objetoCadastro->uf;
    $phones = $data->objetoCadastro->phones;

    echo json_encode($phones);

    $insert = new Users();
    $insert->setNome($name);
    $insert->setCpf($cpf);
    $insert->setRg($rg);
    $insert->setCep($cep);
    $insert->setLogradouro($logradouro);
    $insert->setComplemento($complemento);
    $insert->setSetor($setor);
    $insert->setCidade($cidade);
    $insert->setUf($uf);
    $insert->setPhones($phones);
    $insert->insert();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $data = $pdo->query('SELECT users.*, json_agg(json_build_object(\'phoneNumber\', phone."phoneNumber", \'phoneDescription\', phone."phoneDescription")) AS phones FROM users LEFT JOIN phone ON users.id=phone."userId" group by 1,2,3,4,5,6,7 order by users.id asc')->fetchAll();

    $result = json_encode($data);
    echo $result;
    // $result = json_encode($data);
    // echo $result;
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $pessoa = new Users();
    $telefone = new Telefone();
    $filePath = $_SERVER['REQUEST_URI'];
    $filePath = explode("/", $filePath);
    $userId = $filePath[count($filePath) - 1];

    echo $userId;

    $delete = $pessoa->deleteUser($userId);
    // $delete = $telefone->deletePhone();
}

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $pessoa = new Users();
    $telefone = new Telefone();
    $filePath = $_SERVER['REQUEST_URI'];
    $filePath = explode("/", $filePath);
    $data = json_decode(file_get_contents('php://input'));
    $userId = $filePath[count($filePath) - 1];
    echo json_encode($data);

    $name = $data->objetoCadastro->name;
    $cpf = $data->objetoCadastro->cpf;
    $rg = $data->objetoCadastro->rg;
    $cep = $data->objetoCadastro->cep;
    $logradouro = $data->objetoCadastro->logradouro;
    $complemento = $data->objetoCadastro->complemento;
    $setor = $data->objetoCadastro->setor;
    $cidade = $data->objetoCadastro->cidade;
    $uf = $data->objetoCadastro->uf;
    $phones = $data->objetoCadastro->phones;

    echo json_encode($phones);

    $insert = new Users();
    $insert->setNome($name);
    $insert->setCpf($cpf);
    $insert->setRg($rg);
    $insert->setCep($cep);
    $insert->setLogradouro($logradouro);
    $insert->setComplemento($complemento);
    $insert->setSetor($setor);
    $insert->setCidade($cidade);
    $insert->setUf($uf);
    $insert->setPhones($phones);
    $insert->update($userId);

    $telefone->deletePhone($userId);

    $insert->insertPhones($userId);
}

?>