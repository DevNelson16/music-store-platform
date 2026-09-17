<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Site dedicado à banda/artista favorita, incluindo discografia, informações sobre turnês e contacto.">
    <meta name="keywords" content="música, banda, álbuns, turnê, contacto">
    <meta name="author" content="Nelson Geovetty">

    <title>Banda Favorita - Página Inicial</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KEY.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="css/style.css">
</head>

<body class="pg-index2">

    <!-- Cabeçalho -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">

                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <img src="img/logo.jpg" alt="Logo da Banda Força Suprema" style="width:100px;">
                </a>

                <!-- Botão Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto text-end">
                        <li class="nav-item">
                            <a class="nav-link active" href="index2.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sobre.php">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="galeria/albuns.php">Álbuns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="eventos/tour.php">Turnê</a>
                        </li>

                        <li class="nav-item">
                            <a href="eventos/tickets.php" class="nav-link">Bilhetes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contactos/contactos.php">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="loja/loja_online.php">Loja Online</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/login_admin.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="conta/sair.php">Sair</a>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="container py-5">
        <div class="row align-items-center">

            <div class="col-lg-8 col-md-7 mb-4">
                <h2>Bem-vindo ao site da Banda Favorita!</h2>

                <p>
                    Descubra mais sobre a banda, os seus álbuns e as próximas turnês.
                </p>

                <h3>
                    Força Suprema é um grupo formado por quatro integrantes:
                    <strong>NGA</strong>, <strong>Prodígio</strong>,
                    <strong>Don G</strong> e <strong>Masta</strong>.
                    Juntos há mais de 25 anos, os artistas de origem angolana
                    são reconhecidos como uma das maiores referências do rap
                    lusófono, especialmente nas ruas da Linha de Sintra, em Portugal.
                </h3>
            </div>

            <div class="col-lg-4 col-md-5 text-center">
                <img src="img/forca_suprema_.jpg"
                    class="img-fluid rounded"
                    alt="Imagem da Banda Força Suprema">
            </div>

        </div>
    </main>

    <!-- Rodapé -->
    <footer class="text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-2">
                &copy; 2026 Criado por Nelson Geovetty. Todos os direitos reservados.
            </p>

            <div>
                <a href="#" class="text-white mx-2">
                    <i class="fab fa-facebook fa-lg"></i>
                </a>

                <a href="#" class="text-white mx-2">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>

                <a href="#" class="text-white mx-2">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

</body>

</html>