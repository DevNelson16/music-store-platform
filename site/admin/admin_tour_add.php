<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data['date'])){
    $stmt = $pdo->prepare("INSERT INTO tour_dates (date) VALUES (?)");
    $stmt->execute([$data['date']]);
}
