<?php
declare(strict_types=1);

session_start();

header("Content-Type: application/json");

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo === "GET") {
    if (!isset($_SESSION["usuario_id"])) {
        http_response_code(401);
        echo json_encode(["erro" => "Usuário não está conectado."]);
        exit;
    }

    echo json_encode([
        "id" => $_SESSION["usuario_id"],
        "nome" => $_SESSION["usuario_nome"],
        "tipo" => $_SESSION["usuario_tipo"]
    ]);

    exit;
}

if ($metodo === "POST") {
    $_SESSION = [];
    session_destroy();

    echo json_encode(["mensagem" => "Sessão encerrada."]);
    exit;
}

http_response_code(405);
echo json_encode(["erro" => "Método não permitido."]);