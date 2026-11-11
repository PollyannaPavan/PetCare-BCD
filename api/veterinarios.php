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

    if (empty($dados["email"]) || empty($dados["senha"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o e-mail e a senha!"]);
        exit;
    }

    $senha = password_hash($dados["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO veterinarios (nome, crmv, telefone, email, senha)
            VALUES (?, ?, ?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["crmv"],
        $dados["telefone"],
        $dados["email"],
        $senha
    ]);

    echo json_encode(["Mensagem" => "Veterinário cadastrado!"]);
}

// GET - Consultar veterinários
if ($metodo == "GET") {
    if (isset($_GET["id"])) {
        $sql = "SELECT id, nome, crmv, telefone, email
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
        $sql = "SELECT id, nome, crmv, telefone, email
                FROM veterinarios ORDER BY id";
        $comando = $pdo->query($sql);
        echo json_encode($comando->fetchAll(PDO::FETCH_ASSOC));
    }
}

// PUT - Atualizar veterinário
if ($metodo == "PUT") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (!empty($dados["senha"])) {
        $senha = password_hash($dados["senha"], PASSWORD_DEFAULT);

        $sql = "UPDATE veterinarios
                SET nome = ?, crmv = ?, telefone = ?, email = ?, senha = ?
                WHERE id = ?";

        $valores = [
            $dados["nome"],
            $dados["crmv"],
            $dados["telefone"],
            $dados["email"],
            $senha,
            $dados["id"]
        ];
    } else {
        $sql = "UPDATE veterinarios
                SET nome = ?, crmv = ?, telefone = ?, email = ?
                WHERE id = ?";

        $valores = [
            $dados["nome"],
            $dados["crmv"],
            $dados["telefone"],
            $dados["email"],
            $dados["id"]
        ];
    }

    $comando = $pdo->prepare($sql);
    $comando->execute($valores);

    echo json_encode(["Mensagem" => "Veterinário atualizado!"]);
}

// DELETE - Excluir veterinário
if ($metodo == "DELETE") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $sql = "DELETE FROM veterinarios WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([$dados["id"]]);

    echo json_encode(["Mensagem" => "Veterinário excluído!"]);
}
?>
