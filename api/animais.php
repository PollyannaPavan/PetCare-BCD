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

    $sql = "INSERT INTO animais
            (nome, especie, raca, data_nascimento, tutor_id)
            VALUES (?, ?, ?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["especie"],
        $dados["raca"],
        $dados["data_nascimento"],
        $dados["tutor_id"]
    ]);

    echo json_encode(["Mensagem" => "Animal cadastrado!"]);
}

// Verifica se o método é GET
if ($metodo == "GET") {

    // Busca animal pelo ID
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM animais WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$id]);

        $animal = $comando->fetch(PDO::FETCH_ASSOC);

        if ($animal) {
            echo json_encode($animal);
        } else {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Animal não encontrado!"]);
        }

    // Busca todos os animais
    } else {
        $sql = "SELECT * FROM animais ORDER BY id";
        $comando = $pdo->query($sql);
        $animais = $comando->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($animais);
    }
}

// Verifica se o método é PUT
if ($metodo == "PUT") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "UPDATE animais
            SET nome = ?, especie = ?, raca = ?,
                data_nascimento = ?, tutor_id = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["especie"],
        $dados["raca"],
        $dados["data_nascimento"],
        $dados["tutor_id"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Animal atualizado!"]);
}

// Verifica se o método é DELETE
if ($metodo == "DELETE") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "DELETE FROM animais WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([$dados["id"]]);

    echo json_encode(["Mensagem" => "Animal excluído!"]);
}
?>
