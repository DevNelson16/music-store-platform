<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login_admin.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$album = $pdo->query("SELECT * FROM albums WHERE id=$id")->fetch();

if ($album) {
    if(file_exists('../uploads/albums/'.$album['image'])) unlink('../uploads/albums/'.$album['image']);
    $stmt = $pdo->prepare("DELETE FROM albums WHERE id=?");
    $stmt->execute([$id]);
}

header('Location: admin.php');
exit;
