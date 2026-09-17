<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach($cart as $it) $total += $it['price'] * $it['qty'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"><title>Carrinho</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="pg-cart">
<h1>Seu Carrinho</h1>
<p><a class="button" href="loja_online.php">Continuar compras</a></p>


<?php if (empty($cart)): ?>
<p>O carrinho está vazio.</p>
<?php else: ?>
<form method="post" action="update_cart.php">
<table class="cart-table">
<thead><tr><th>Produto</th><th>Preço</th><th>Qtd</th><th>Subtotal</th><th>Remover</th></tr></thead>
<tbody>
<?php foreach($cart as $id => $it): ?>
<tr>
<td><?php echo htmlspecialchars($it['name']); ?></td>
<td><?php echo number_format($it['price'],2,',','.'); ?> €</td>
<td><input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $it['qty']; ?>" min="1"></td>
<td><?php echo number_format($it['price']*$it['qty'],2,',','.'); ?> €</td>
<td><a href="remove_item.php?id=<?php echo $id; ?>">Remover</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<p>Total: <strong><?php echo number_format($total,2,',','.'); ?> €</strong></p>
<div class="actions">
<button class="button" type="submit">Atualizar Quantidades</button>
<a class="button" href="checkout.php">Finalizar Compra</a>
</div>
</form>
<?php endif; ?>
</body>
</html>