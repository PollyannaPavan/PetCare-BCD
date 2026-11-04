<?php
declare(strict_types=1);

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

// Verifica se o método é POST
if ($metodo == "POST") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

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

// Verifica se o método é GET
if ($metodo == "GET") {

    // Busca tutor pelo ID
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM tutores WHERE id = ?";
        $comando = $pdo->prepare($sql);
        $comando->execute([$id]);

        $tutor = $comando->fetch(PDO::FETCH_ASSOC);

        if ($tutor) {
            echo json_encode($tutor);
        } else {
            http_response_code(404);
            echo json_encode(["Mensagem" => "Tutor não encontrado!"]);
        }

    // Busca todos os tutores
    } else {
        $sql = "SELECT * FROM tutores ORDER BY id";
        $comando = $pdo->query($sql);
        $tutores = $comando->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($tutores);
    }
}

// Verifica se o método é PUT
if ($metodo == "PUT") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "UPDATE tutores
            SET nome = ?, telefone = ?, email = ?
            WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["nome"],
        $dados["telefone"],
        $dados["email"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Tutor atualizado com sucesso!"]);
}

// Verifica se o método é DELETE
if ($metodo == "DELETE") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "DELETE FROM tutores WHERE id = ?";

    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Tutor excluído com sucesso!"]);
}
?>
