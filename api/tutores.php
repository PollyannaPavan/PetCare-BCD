<?php
declare(strict_types=1);

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];
$id = $_GET["id"] ?? null;

// POST - Cadastrar tutor
if ($metodo == "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $sql = "INSERT INTO tutores (nome, telefone, email)
            VALUES (?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["telefone"],
        $dados["email"]
    ]);

    echo json_encode(["Mensagem" => "Novo tutor cadastrado!"]);
}

// GET - Consultar tutores
if ($metodo == "GET") {
    if ($id) {
        $sql = "SELECT * FROM tutores WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$id]);

        echo json_encode($comando->fetch(PDO::FETCH_ASSOC));
    } else {
        $sql = "SELECT * FROM tutores ORDER BY id";
        $comando = $pdo->query($sql);

        echo json_encode($comando->fetchAll(PDO::FETCH_ASSOC));
    }
}

// PUT - Atualizar tutor
if ($metodo == "PUT") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $sql = "UPDATE tutores
            SET nome = ?, telefone = ?, email = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["telefone"],
        $dados["email"],
        $id
    ]);

    echo json_encode(["Mensagem" => "Tutor atualizado com sucesso!"]);
}

// DELETE - Excluir tutor
if ($metodo == "DELETE") {
    $sql = "DELETE FROM tutores WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([$id]);

    echo json_encode(["Mensagem" => "Tutor excluído com sucesso!"]);
}
?>