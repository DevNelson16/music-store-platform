<?php

session_start();

require '../../conexao/db.php';


if(!isset($_GET['id'])){

    header("Location: loja_online.php");
    exit;

}


$id = $_GET['id'];



$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE id = ?
");


$stmt->execute([$id]);


$product = $stmt->fetch();



if(!$product){

    echo "Produto não encontrado";
    exit;

}


?>


<!DOCTYPE html>
<html lang="pt">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">


<title><?= htmlspecialchars($product['name']) ?></title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="../css/style.css">
</head>



<body class="pg-produto">



<header class="py-3">

<div class="container">


<nav class="navbar navbar-expand-lg navbar-dark">


<a class="navbar-brand" href="loja_online.php">

<img src="../img/logo.jpg" width="100">

</a>



<button class="navbar-toggler"
data-bs-toggle="collapse"
data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>



<div class="collapse navbar-collapse" id="menu">


<ul class="navbar-nav ms-auto">


<li class="nav-item">
<a class="nav-link" href="../index2.php">
Início
</a>
</li>


<li class="nav-item">
<a class="nav-link" href="loja_online.php">
Loja
</a>
</li>


<li class="nav-item">
<a class="nav-link" href="cart.php">
Carrinho 🛒
</a>
</li>


</ul>


</div>


</nav>


</div>


</header>





<main class="container">


<div class="product-box">


<div class="row align-items-center">



<div class="col-md-6">


<img 

src="../img/<?= htmlspecialchars(basename($product['image'])) ?>"

class="product-img">


</div>




<div class="col-md-6">


<h1>

<?= htmlspecialchars($product['name']) ?>

</h1>



<p>

<?= nl2br(htmlspecialchars($product['description'])) ?>

</p>



<div class="price">

<?= number_format($product['price'],2,",",".") ?> €

</div>



<form action="add_to_cart.php" method="POST" class="mt-4">


<input type="hidden" 
name="id"
value="<?= $product['id'] ?>">



<label>

Quantidade

</label>


<input 

type="number"

name="qty"

value="1"

min="1"

class="form-control mb-3">



<button class="btn btn-cart w-100">

Adicionar ao carrinho

</button>


</form>



</div>



</div>


</div>


</main>





<footer>

© <?= date("Y") ?> Banda Favorita

</footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>