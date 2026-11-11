<?php
declare(strict_types=1);

session_start();

header("Content-Type: application/json");

require "conexao.php";

$dados = json_decode(file_get_contents("php://input"), true);

$tipo = $dados["tipo"] ?? "";
$email = trim($dados["email"] ?? "");
$senha = $dados["senha"] ?? "";

if (!$email || !$senha || !in_array($tipo, ["tutor", "veterinario"], true)) {
    http_response_code(400);
    echo json_encode(["erro" => "Preencha todos os campos."]);
    exit;
}

if ($tipo === "tutor") {
    $sql = "SELECT id, nome, email, senha FROM tutores WHERE email = :email";
} else {
    $sql = "SELECT id, nome, email, senha FROM veterinarios WHERE email = :email";
}

$stmt = $pdo->prepare($sql);
$stmt->execute(["email" => $email]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || !password_verify($senha, $usuario["senha"] ?? "")) {
    http_response_code(401);
    echo json_encode(["erro" => "E-mail ou senha incorretos."]);
    exit;
}

session_regenerate_id(true);

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["usuario_nome"] = $usuario["nome"];
$_SESSION["usuario_tipo"] = $tipo;

$pagina = $tipo === "tutor"
    ? "painel-tutor.html"
    : "painel-veterinario.html";

echo json_encode([
    "mensagem" => "Login realizado com sucesso!",
    "pagina" => $pagina
]);
