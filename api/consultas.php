<?php
declare(strict_types=1);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

// Verifica se o método é POST
if ($metodo === "POST") {
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
        $dados["status"] ?? "Agendada"
    ]);

    echo json_encode(["Mensagem" => "Consulta cadastrada!"]);
    exit;
}

// Verifica se o método é GET
if ($metodo === "GET") {

    // Busca consulta pelo ID
    if ($id > 0) {
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
        exit;
    }

    // Busca todas as consultas
    $sql = "SELECT * FROM consultas ORDER BY id";
    $comando = $pdo->query($sql);
    $consultas = $comando->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($consultas);
    exit;
}

// Verifica se o método é PUT
if ($metodo === "PUT") {

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o ID pela URL!"]);
        exit;
    }

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
        $id
    ]);

    if ($comando->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["Mensagem" => "Consulta não encontrada!"]);
        exit;
    }

    echo json_encode(["Mensagem" => "Consulta atualizada!"]);
    exit;
}

// Verifica se o método é DELETE
if ($metodo === "DELETE") {

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o ID pela URL!"]);
        exit;
    }

    $sql = "DELETE FROM consultas WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([$id]);

    if ($comando->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["Mensagem" => "Consulta não encontrada!"]);
        exit;
    }

    echo json_encode(["Mensagem" => "Consulta excluída!"]);
    exit;
}

// Método não permitido
http_response_code(405);
echo json_encode(["Mensagem" => "Método não permitido!"]);
?>
