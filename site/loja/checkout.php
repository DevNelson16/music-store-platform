<?php
session_start();require '../../conexao/db.php';
$cart=$_SESSION['cart']??[];
if(empty($cart)){header('Location: cart.php');exit;}


$total=0;foreach($cart as $it)$total+=$it['price']*$it['qty'];
$pdo->prepare('INSERT INTO orders(total) VALUES(?)')->execute([$total]);
$orderId=$pdo->lastInsertId();
$stm=$pdo->prepare('INSERT INTO order_items(order_id,product_id,qty,price) VALUES(?,?,?,?)');
foreach($cart as $it){
$stm->execute([$orderId,$it['id'],$it['qty'],$it['price']]);
}
unset($_SESSION['cart']);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Obrigado</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="pg-checkout">
<h1>Compra finalizada</h1>
<p>Encomenda Nº <?=$orderId?> concluída. Total: <strong><?=number_format($total,2,',','.')?> €</strong></p>
<p><a class="button" href="loja_online.php">Voltar à loja</a></p>
</body>
</html>
            <h1>Obrigado Volte sempre!</h1>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        &copy; 2025 Criado por Nelson Geovetty. Todos os direitos reservados.
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>