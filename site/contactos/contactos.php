<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

// Guardar mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        INSERT INTO contact_messages
        (nome, apelido, data_nascimento, email, telefone, mensagem)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['nome'],
        $_POST['apelido'],
        $_POST['dataNascimento'],
        $_POST['email'],
        $_POST['telefone'],
        $_POST['mensagem']
    ]);

    echo json_encode(['success' => true]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Site dedicado à banda/artista favorita.">
    <meta name="keywords" content="música, banda, contacto">

    <title>Banda Favorita - Contacto</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KEY.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../css/style.css">
</head>

<body class="pg-contactos">

    <header class="bg-dark text-white py-3">

        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark">

                <a class="navbar-brand" href="#">
                    <img src="../img/logo.jpg" alt="Logo Força Suprema">
                </a>

                <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal">

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
                            <a href="../galeria/albuns.php" class="nav-link">Álbuns</a>
                        </li>

                        <li class="nav-item">
                            <a href="../eventos/tour.php" class="nav-link">Turnê</a>
                        </li>

                        <li class="nav-item">
                            <a href="../eventos/tickets.php" class="nav-link">Bilhetes</a>
                        </li>

                        <li class="nav-item">
                            <a href="contactos.php" class="nav-link active">Contacto</a>
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

        <div class="card-form">

            <h2>Fale Connosco</h2>

            <form id="contactForm">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apelido</label>
                        <input type="text" class="form-control" name="apelido" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" name="dataNascimento" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="tel" class="form-control" name="telefone" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Mensagem</label>
                        <textarea class="form-control" name="mensagem" rows="5" required></textarea>
                    </div>

                </div>

                <div class="text-center mt-4">

                    <button class="btn btn-banda btn-lg">
                        Enviar Mensagem
                    </button>

                </div>

            </form>

            <div id="mensagemSucesso"
                class="alert alert-success mt-4 text-center d-none">

                Mensagem enviada com sucesso!

            </div>

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

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {

            e.preventDefault();

            const formData = new FormData(this);

            fetch('contactos.php', {

                    method: 'POST',
                    body: formData

                })

                .then(response => response.json())

                .then(data => {

                    if (data.success) {

                        document.getElementById('mensagemSucesso').classList.remove('d-none');

                        this.reset();

                    }

                });

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>