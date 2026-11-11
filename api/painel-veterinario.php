<?php
declare(strict_types=1);

session_start();

header("Content-Type: application/json");

require "conexao.php";

if (!isset($_SESSION["usuario_id"]) ||
    $_SESSION["usuario_tipo"] !== "veterinario") {
    http_response_code(401);
    echo json_encode(["erro" => "Acesso não autorizado."]);
    exit;
}

$sql = "SELECT
            c.id,
            a.nome AS animal,
            a.especie,
            a.raca,
            t.nome AS tutor,
            t.telefone,
            c.data_consulta,
            c.motivo,
            c.status
        FROM consultas c
        INNER JOIN animais a ON c.animal_id = a.id
        INNER JOIN tutores t ON a.tutor_id = t.id
        WHERE c.veterinario_id = :id
        ORDER BY c.data_consulta";

$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_SESSION["usuario_id"]]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
