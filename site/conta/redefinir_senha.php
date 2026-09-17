<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

$mensagem = '';
$mostrar_form = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token existe e não expirou
    $stmt = $pdo->prepare("SELECT * FROM recuperacao_senha WHERE token = ? AND expiracao > NOW()");
    $stmt->execute([$token]);
    $registro = $stmt->fetch();

    if ($registro) {
        $mostrar_form = true;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nova_senha = $_POST['senha'] ?? '';
            $confirmar_senha = $_POST['confirmar_senha'] ?? '';

            if (empty($nova_senha) || empty($confirmar_senha)) {
                $mensagem = ['tipo' => 'erro', 'texto' => "Preencha todos os campos."];
            } elseif ($nova_senha !== $confirmar_senha) {
                $mensagem = ['tipo' => 'erro', 'texto' => "As senhas não coincidem."];
            } else {
                // Atualiza a senha no banco (com hash)
                $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET senha = ? WHERE email = ?");
                $stmt->execute([$senha_hash, $registro['email']]);

                // Remove token usado
                $stmt = $pdo->prepare("DELETE FROM recuperacao_senha WHERE token = ?");
                $stmt->execute([$token]);

                $mensagem = ['tipo' => 'sucesso', 'texto' => "Senha alterada com sucesso! Você já pode fazer login."];
                $mostrar_form = false;
            }
        }
    } else {
        $mensagem = ['tipo' => 'erro', 'texto' => "Token inválido ou expirado."];
    }
} else {
    $mensagem = ['tipo' => 'erro', 'texto' => "Token não informado."];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Redefinir Senha</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
.card { border-radius: 12px; box-sizing: border-box;}
