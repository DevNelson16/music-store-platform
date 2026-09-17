<?php
session_start();
require '../../conexao/db.php';
$res = $pdo->query("SELECT * FROM products");

while ($row = $res->fetch()) {
    echo "<div>
            <h3>{$row['name']}</h3>
            <p>{$row['price']}€</p>
            <a href='add_to_cart.php?id={$row['id']}'>Adicionar</a>
          </div>";
}
?>
