<?php
declare(strict_types=1);

session_start();

header("Content-Type: application/json");

require "conexao.php";

if (!isset($_SESSION["usuario_id"]) ||
    $_SESSION["usuario_tipo"] !== "tutor") {
    http_response_code(401);
    echo json_encode(["erro" => "Acesso não autorizado."]);
    exit;
}

$sql = "SELECT
            a.id,
            a.nome AS animal,
            a.especie,
            a.raca,
            c.data_consulta,
            c.motivo,
            c.status,
            v.nome AS veterinario
        FROM animais a
        LEFT JOIN consultas c ON a.id = c.animal_id
        LEFT JOIN veterinarios v ON c.veterinario_id = v.id
        WHERE a.tutor_id = :id
        ORDER BY c.data_consulta";

$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_SESSION["usuario_id"]]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
