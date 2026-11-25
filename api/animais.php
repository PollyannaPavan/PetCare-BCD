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

// POST - Cadastrar animal
if ($metodo === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (empty($dados["nome"]) || empty($dados["especie"]) || empty($dados["tutor_id"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Preencha os campos obrigatórios!"]);
        exit;
    }

    $sql = "INSERT INTO animais
            (nome, especie, raca, data_nascimento, tutor_id)
            VALUES (?, ?, ?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["especie"],
        $dados["raca"] ?? null,
        !empty($dados["data_nascimento"]) ? $dados["data_nascimento"] : null,
        $dados["tutor_id"]
    ]);

    echo json_encode(["Mensagem" => "Animal cadastrado!"]);
    exit;
}

// GET - Buscar animal por ID ou listar todos
if ($metodo === "GET") {
    if ($id > 0) {
        $sql = "SELECT * FROM animais WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$id]);

        $animal = $comando->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Animal não encontrado!"]);
            exit;
        }

        echo json_encode($animal);
        exit;
    }

    $sql = "SELECT * FROM animais ORDER BY id";
    $comando = $pdo->query($sql);
    echo json_encode($comando->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// PUT - Atualizar animal
if ($metodo === "PUT") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o ID do animal na URL!"]);
        exit;
    }

    if (empty($dados["nome"]) || empty($dados["especie"]) || empty($dados["tutor_id"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Preencha os campos obrigatórios!"]);
        exit;
    }

    $verificar = $pdo->prepare("SELECT id FROM animais WHERE id = ?");
    $verificar->execute([$id]);

    if (!$verificar->fetch()) {
        http_response_code(404);
        echo json_encode(["Mensagem" => "Animal não encontrado!"]);
        exit;
    }

    $sql = "UPDATE animais
            SET nome = ?, especie = ?, raca = ?,
                data_nascimento = ?, tutor_id = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["especie"],
        $dados["raca"] ?? null,
        !empty($dados["data_nascimento"]) ? $dados["data_nascimento"] : null,
        $dados["tutor_id"],
        $id
    ]);

    echo json_encode(["Mensagem" => "Animal atualizado!"]);
    exit;
}

// DELETE - Excluir animal
if ($metodo === "DELETE") {
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe o ID do animal na URL!"]);
        exit;
    }

    $comando = $pdo->prepare("DELETE FROM animais WHERE id = ?");
    $comando->execute([$id]);

    if ($comando->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["Mensagem" => "Animal não encontrado!"]);
        exit;
    }

    echo json_encode(["Mensagem" => "Animal excluído!"]);
    exit;
}

// Método não permitido
http_response_code(405);
echo json_encode(["Mensagem" => "Método não permitido!"]);
?>
