<?php

session_start();

require_once __DIR__ . '/../../conexao/db.php';


// Pesquisa e categoria

$search = $_GET['search'] ?? '';

$category = $_GET['category'] ?? '';



$sql = "SELECT * FROM products WHERE 1";

$params = [];



if(!empty($search)){

    $sql .= " AND name LIKE ?";

    $params[] = "%".$search."%";

}



if(!empty($category)){

    $sql .= " AND category = ?";

    $params[] = $category;

}



$stmt = $pdo->prepare($sql);

$stmt->execute($params);


$products = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Banda Favorita - Loja Online</title>


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


        <link rel="stylesheet" href="../css/style.css">
</head>



<body class="pg-loja-online">



    <header class="py-3">


        <div class="container">


            <nav class="navbar navbar-expand-lg navbar-dark">


                <a class="navbar-brand" href="../index2.php">

                    <img src="../img/logo.jpg">

                </a>



                <button class="navbar-toggler"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal">


                    <span class="navbar-toggler-icon"></span>


                </button>




                <div class="collapse navbar-collapse" id="menuPrincipal">


                    <ul class="navbar-nav ms-auto">


                        <li class="nav-item">
                            <a href="../index2.php" class="nav-link">
                                Início
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="../sobre.php" class="nav-link">
                                Sobre
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="../galeria/albuns.php" class="nav-link">
                                Álbuns
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="../eventos/tour.php" class="nav-link">
                                Turnê
                            </a>
                        </li>

                         <li class="nav-item">
                            <a href="../eventos/tickets.php" class="nav-link">
                                Bilhete
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="../contactos/contactos.php" class="nav-link">
                                Contato
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="loja_online.php" class="nav-link active">
                                Loja Online
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="../admin/login_admin.php" class="nav-link">
                                Admin
                            </a>
                        </li>


                    </ul>


                </div>


            </nav>


        </div>


    </header>





    <main class="container my-5">


        <div class="page-title">

            <h1>

                🛒 Loja Oficial

            </h1>


            <p>

                Produtos oficiais da banda

            </p>


        </div>






        <div class="row g-4 products">



            <?php foreach ($products as $p): ?>



                <div class="col-lg-3 col-md-4 col-sm-6">



                    <div class="card h-100">



                        <img
                            src="../img/<?= htmlspecialchars(basename($p['image'])); ?>"
                            alt="<?= htmlspecialchars($p['name']); ?>">





                        <div class="card-body d-flex flex-column">



                            <h5 class="card-title">

                                <?= htmlspecialchars($p['name']); ?>

                            </h5>



                            <p class="price">

                                <?= number_format($p['price'], 2, ",", "."); ?> €

                            </p>




                            <form method="post"
                                action="add_to_cart.php"
                                class="add-cart-form mt-auto">


                                <input type="hidden"
                                    name="id"
                                    value="<?= (int)$p['id']; ?>">



                                <input type="number"
                                    name="qty"
                                    value="1"
                                    min="1"
                                    class="form-control mb-3">



                                <button class="btn btn-warning w-100">

                                    🛒 Adicionar ao carrinho

                                </button>



                            </form>



                        </div>



                    </div>



                </div>



            <?php endforeach; ?>



        </div>



    </main>





    <footer class="text-white text-center p-4">


        © <?= date('Y'); ?> Banda Favorita - Todos os direitos reservados


    </footer>






    <div class="cart-float">


        <a href="cart.php">


            🛒

            <span id="cart-count">

                <?= isset($_SESSION['cart'])
                    ? array_sum(array_column($_SESSION['cart'], 'qty'))
                    : 0; ?>

            </span>


        </a>


    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    <script>
        document.addEventListener("DOMContentLoaded", () => {


            document.querySelectorAll(".add-cart-form")
                .forEach(form => {


                    form.addEventListener("submit", function(e) {


                        e.preventDefault();



                        let formData = new FormData(this);



                        fetch("add_to_cart.php", {

                                method: "POST",

                                body: formData


                            })


                            .then(res => res.text())

                            .then(() => {


                                let cart = document.getElementById("cart-count");


                                let qty = parseInt(formData.get("qty"));


                                cart.innerText = parseInt(cart.innerText) + qty;


                            });



                    });



                });



        });
    </script>



</body>

</html>