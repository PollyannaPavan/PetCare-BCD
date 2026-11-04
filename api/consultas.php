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

    $sql = "INSERT INTO consultas
            (animal_id, veterinario_id, data_consulta, motivo, status)
            VALUES (?, ?, ?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["animal_id"],
        $dados["veterinario_id"],
        $dados["data_consulta"],
        $dados["motivo"],
        $dados["status"]
    ]);

    echo json_encode(["Mensagem" => "Consulta cadastrada!"]);
}

// Verifica se o método é GET
if ($metodo == "GET") {

    // Busca consulta pelo ID
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM consultas WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$id]);

        $consulta = $comando->fetch(PDO::FETCH_ASSOC);

        if ($consulta) {
            echo json_encode($consulta);
        } else {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Consulta não encontrada!"]);
        }

    // Busca todas as consultas
    } else {
        $sql = "SELECT * FROM consultas ORDER BY id";
        $comando = $pdo->query($sql);
        $consultas = $comando->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($consultas);
    }
}

// Verifica se o método é PUT
if ($metodo == "PUT") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "UPDATE consultas
            SET animal_id = ?, veterinario_id = ?,
                data_consulta = ?, motivo = ?, status = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["animal_id"],
        $dados["veterinario_id"],
        $dados["data_consulta"],
        $dados["motivo"],
        $dados["status"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Consulta atualizada!"]);
}

// Verifica se o método é DELETE
if ($metodo == "DELETE") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "DELETE FROM consultas WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([$dados["id"]]);

    echo json_encode(["Mensagem" => "Consulta excluída!"]);
}
?>
