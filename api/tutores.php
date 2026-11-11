<?php
declare(strict_types=1);

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

// POST - Cadastrar tutor
if ($metodo == "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (empty($dados["senha"])) {
        http_response_code(400);
        echo json_encode(["Mensagem" => "Informe uma senha!"]);
        exit;
    }

    $senha = password_hash($dados["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO tutores (nome, telefone, email, senha)
            VALUES (?, ?, ?, ?)";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["telefone"],
        $dados["email"],
        $senha
    ]);

    echo json_encode(["Mensagem" => "Novo tutor cadastrado!"]);
}

// GET - Consultar tutores
if ($metodo == "GET") {
    if (isset($_GET["id"])) {
        $sql = "SELECT id, nome, telefone, email
                FROM tutores WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$_GET["id"]]);

        $tutor = $comando->fetch(PDO::FETCH_ASSOC);

        if ($tutor) {
            echo json_encode($tutor);
        } else {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Tutor não encontrado!"]);
        }
    } else {
        $sql = "SELECT id, nome, telefone, email
                FROM tutores ORDER BY id";
        $comando = $pdo->query($sql);
        echo json_encode($comando->fetchAll(PDO::FETCH_ASSOC));
    }
}

// PUT - Atualizar tutor
if ($metodo == "PUT") {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (!empty($dados["senha"])) {
        $senha = password_hash($dados["senha"], PASSWORD_DEFAULT);

        $sql = "UPDATE tutores
                SET nome = ?, telefone = ?, email = ?, senha = ?
                WHERE id = ?";

        $valores = [
            $dados["nome"],
            $dados["telefone"],
            $dados["email"],
            $senha,
            $dados["id"]
        ];
    } else {
        $sql = "UPDATE tutores
                SET nome = ?, telefone = ?, email = ?
                WHERE id = ?";

        $valores = [
            $dados["nome"],
            $dados["telefone"],
            $dados["email"],
            $dados["id"]
        ];
    }

    $comando = $pdo->prepare($sql);
    $comando->execute($valores);

    echo json_encode(["Mensagem" => "Tutor atualizado com sucesso!"]);
}

// DELETE - Excluir tutor
if ($metodo == "DELETE") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $sql = "DELETE FROM tutores WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([$dados["id"]]);

    echo json_encode(["Mensagem" => "Tutor excluído com sucesso!"]);
}
?>
