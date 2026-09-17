<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: cart.php'); exit; }


$qtys = $_POST['qty'] ?? [];
foreach ($qtys as $id => $q) {
$id = (int)$id; $q = max(1, (int)$q);
if (isset($_SESSION['cart'][$id])) {
$_SESSION['cart'][$id]['qty'] = $q;
}
}
header('Location: cart.php');
exit;