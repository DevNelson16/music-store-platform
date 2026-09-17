<?php
require_once __DIR__ . '/../../conexao/db.php';

// Defina o email e senha do admin
$email = 'admin@loja.com';
$password = password_hash('admin123', PASSWORD_DEFAULT); // Senha: admin123
$role = 'admin';

// Verifica se já existe o admin
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo "Admin já existe!";
    exit;
}

// Insere o admin
$pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)")->execute([$email, $password, $role]);
echo "Admin criado com sucesso!";
