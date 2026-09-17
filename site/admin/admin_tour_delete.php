<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data['id'])){
    $stmt = $pdo->prepare("DELETE FROM tour_dates WHERE id=?");
    $stmt->execute([$data['id']]);
}
