<?php
require_once __DIR__ . '/../../conexao/db.php';
$albums = $pdo->query("SELECT * FROM albums ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Banda Favorita - Álbuns</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">

    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KEY.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../css/style.css">
</head>

<body class="pg-albuns">

    <header class="bg-dark text-white py-3">
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark">

                <a class="navbar-brand" href="#">
                    <img src="../img/logo.jpg" alt="Logo da Banda Força Suprema">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuPrincipal">

                    <ul class="navbar-nav ms-auto text-end">

                        <li class="nav-item">
                            <a href="../index2.php" class="nav-link">Início</a>
                        </li>

                        <li class="nav-item">
                            <a href="../sobre.php" class="nav-link">Sobre</a>
                        </li>

                        <li class="nav-item">
                            <a href="albuns.php" class="nav-link active">Álbuns</a>
                        </li>

                        <li class="nav-item">
                            <a href="../eventos/tour.php" class="nav-link">Turnê</a>
                        </li>

                        <li class="nav-item">
                            <a href="../eventos/tickets.php" class="nav-link">Bilhetes</a>
                        </li>

                        <li class="nav-item">
                            <a href="../contactos/contactos.php" class="nav-link">Contacto</a>
                        </li>

                        <li class="nav-item">
                            <a href="../loja/loja_online.php" class="nav-link">Loja Online</a>
                        </li>

                        <li class="nav-item">
                            <a href="../admin/login_admin.php" class="nav-link">Admin</a>
                        </li>

                        <li class="nav-item">
                            <a href="../conta/sair.php" class="nav-link">Sair</a>
                        </li>

                    </ul>

                </div>

            </nav>

        </div>
    </header>

    <main>

        <h1 class="h1_albuns">Álbuns da Banda</h1>
        <h2>Galeria de Fotos</h2>

        <div class="gallery">

            <?php foreach ($albums as $alb): ?>

                <a href="../img/<?= htmlspecialchars(basename($alb['image'])) ?>"
                    data-lightbox="albuns"
                    data-title="<?= htmlspecialchars($alb['title']) ?>">

                    <img src="../img/<?= htmlspecialchars(basename($alb['image'])) ?>"
                        alt="<?= htmlspecialchars($alb['title']) ?>">

                </a>

            <?php endforeach; ?>

        </div>

    </main>

    <footer>
        <p>&copy; 2026 Criado por Nelson Geovetty. Todos os direitos reservados.</p>

        <div>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</body>

</html/