<?php
session_start();
require '../../conexao/db.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
header('Location: ../index.php'); exit;
}


$id = (int)($_POST['id'] ?? 0);
$qty = max(1, (int)($_POST['qty'] ?? 1));


$stm = $pdo->prepare('SELECT id,name,price FROM products WHERE id = ?');
$stm->execute([$id]);
$product = $stm->fetch();
if (!$product) { header('Location: ../index.php'); exit; }


if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];


// se já existe, incrementa
if (isset($_SESSION['cart'][$id])) {
$_SESSION['cart'][$id]['qty'] += $qty;
} else {
$_SESSION['cart'][$id] = [
'id' => $product['id'],
'name' => $product['name'],
'price' => $product['price'],
'qty' => $qty
];
}


header('Location: cart.php');
exit;