<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $mensagem = ['tipo' => 'erro', 'texto' => "Por favor, informe seu e-mail."];
    } else {
        // Procura o usuário no banco
        $stmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(TRIM(email)) = LOWER(?)");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Gera token único
            $token = bin2hex(random_bytes(50));
            $expiracao = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Insere na tabela de recuperação
            $stmt = $pdo->prepare("INSERT INTO recuperacao_senha (email, token, expiracao) VALUES (?, ?, ?)");
            $stmt->execute([$email, $token, $expiracao]);

            // Gera link de redefinição
            $link = "http://localhost/Projeto%20final%20do%20terceiro%20modulo/redefinir_senha.php?token=$token";

            // Para teste local, exibimos o link na tela
            $mensagem = ['tipo' => 'sucesso', 'texto' => "Link de recuperação gerado com sucesso!<br>Link: <a href='$link'>$link</a>"];
        } else {
            $mensagem = ['tipo' => 'erro', 'texto' => "E-mail não encontrado."];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar Senha</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="pg-recuperar-senha">

<div class="container h-100 d-flex align-items-center justify-content-center">
    <div class="card p-4">
        <h2 class="mb-4 text-center">Recuperar Senha</h2>

        <?php if ($mensagem): ?>
            <div class="alert alert-<?= $mensagem['tipo'] === 'sucesso' ? 'success' : 'danger' ?>">
                <?= $mensagem['texto'] ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3 text-start">
                <label class="form-label">E-mail:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn-custom btn-enviar">Enviar Link de Recuperação</button>
            <a href="../index.php" class="btn-custom btn-voltar">Voltar</a>
        </form>
    </div>
</div>

</body>
</html>
