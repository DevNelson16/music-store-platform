<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

// Verifica se o usuário é admin
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Verifica se recebeu o ID do produto
if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit;
}

$id = (int) $_GET['id'];

// Deleta o produto
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

// Redireciona de volta para o admin
header('Location: admin.php');
exit;
?>
