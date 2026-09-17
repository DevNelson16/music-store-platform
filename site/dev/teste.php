<?php
require_once __DIR__ . '/../../conexao/db.php';

// Hash do banco
$hash = '$2y$10$V8b4T9j3A7hRZ5fnlUkH3OCufTjqVAdKtC7ZZyYUSI.6KzH02SGWm';

// Senha que vais testar
$senha = '123456';

if (password_verify($senha, $hash)) {
    echo "Senha correta!";
} else {
    echo "Senha inválida!";
}
?>