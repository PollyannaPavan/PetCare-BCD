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

// Verifica se o método é POST
if ($metodo == "POST") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

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

// Verifica se o método é GET
if ($metodo == "GET") {

    // Busca veterinário pelo ID
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM veterinarios WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$id]);

        $veterinario = $comando->fetch(PDO::FETCH_ASSOC);

        if ($veterinario) {
            echo json_encode($veterinario);
        } else {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Veterinário não encontrado!"]);
        }

    // Busca todos os veterinários
    } else {
        $sql = "SELECT * FROM veterinarios ORDER BY id";
        $comando = $pdo->query($sql);
        $veterinarios = $comando->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($veterinarios);
    }
}

// Verifica se o método é PUT
if ($metodo == "PUT") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "UPDATE veterinarios
            SET nome = ?, crmv = ?, telefone = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["crmv"],
        $dados["telefone"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Veterinário atualizado!"]);
}

// Verifica se o método é DELETE
if ($metodo == "DELETE") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "DELETE FROM veterinarios WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([$dados["id"]]);

    echo json_encode(["Mensagem" => "Veterinário excluído!"]);
}
?>
