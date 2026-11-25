<?php
declare(strict_types=1);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    exit;
}

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

// POST - Cadastrar veterinário
if ($metodo == "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (empty($dados["nome"]) || empty($dados["crmv"]) || empty($dados["telefone"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Preencha todos os campos!"]);
        exit;
    }

    $sql = "INSERT INTO veterinarios (nome, crmv, telefone)
            VALUES (?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["crmv"],
        $dados["telefone"]
    ]);

    echo json_encode(["Mensagem" => "Veterinário cadastrado!"]);
}

// GET - Consultar veterinários
elseif ($metodo == "GET") {
    if (isset($_GET["id"])) {
        $sql = "SELECT id, nome, crmv, telefone
                FROM veterinarios WHERE id = ?";

        $comando = $pdo->prepare($sql);
        $comando->execute([$_GET["id"]]);

        $veterinario = $comando->fetch(PDO::FETCH_ASSOC);

        if ($veterinario) {
            echo json_encode($veterinario);
        } else {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Veterinário não encontrado!"]);
        }
    } else {
        $sql = "SELECT id, nome, crmv, telefone
                FROM veterinarios ORDER BY id";

        $comando = $pdo->query($sql);
        echo json_encode($comando->fetchAll(PDO::FETCH_ASSOC));
    }
}

// PUT - Atualizar veterinário
elseif ($metodo == "PUT") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (empty($_GET["id"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o ID do veterinário!"]);
        exit;
    }

    if (empty($dados["nome"]) || empty($dados["crmv"]) || empty($dados["telefone"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Preencha todos os campos!"]);
        exit;
    }

    $sql = "UPDATE veterinarios
            SET nome = ?, crmv = ?, telefone = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["crmv"],
        $dados["telefone"],
        $_GET["id"]
    ]);

    echo json_encode(["Mensagem" => "Veterinário atualizado!"]);
}

// DELETE - Excluir veterinário
elseif ($metodo == "DELETE") {
    if (empty($_GET["id"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o ID do veterinário!"]);
        exit;
    }

    $sql = "DELETE FROM veterinarios WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([$_GET["id"]]);

    echo json_encode(["Mensagem" => "Veterinário excluído!"]);
}
?>