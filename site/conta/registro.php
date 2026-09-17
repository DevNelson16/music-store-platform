<?php
// Conexão com o banco de dados (ligação central)
$host = "localhost";
$user = "root";
$password_db = "";
$database = "banda_db";

$conn = new mysqli($host, $user, $password_db, $database);

if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$mensagem = "";
$mensagem_tipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Verificar se username ou email já existem
    $check = $conn->prepare("SELECT id FROM users_banda WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensagem = "Nome de usuário ou email já existe. Tente outro.";
        $mensagem_tipo = "danger";
    } else {
        // Inserir usuário na tabela correta
        $stmt = $conn->prepare("INSERT INTO users_banda (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $mensagem = "Registado com sucesso. <a href='../index.php' class='alert-link'>Ir para o login</a>";
            $mensagem_tipo = "success";
        } else {
            $mensagem = "Erro ao registar: " . $stmt->error;
            $mensagem_tipo = "danger";
        }

        $stmt->close();
    }

    $check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="pg-registro">
    <div class="container">
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= $mensagem_tipo ?> mt-4 text-center" role="alert">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h4 class="form-title">Criar Conta</h4>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome de Usuário</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Registar</button>
                <a href="../index.php" class="btn btn-secondary w-100">Voltar</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>