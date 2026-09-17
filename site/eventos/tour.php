<?php
require_once __DIR__ . '/../../conexao/db.php';

// Buscar apenas as datas da tour que ainda não passaram
$tour_dates = $pdo->query("SELECT * FROM tour_dates WHERE tour_date >= CURDATE() ORDER BY tour_date ASC")->fetchAll();
$hoje = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Banda Favorita - Tour</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KEY.js" crossorigin="anonymous"></script>

      <link rel="stylesheet" href="../css/style.css">
</head>

<body class="pg-tour">

  <!-- Cabeçalho -->
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
              <a href="../galeria/albuns.php" class="nav-link">Álbuns</a>
            </li>

            <li class="nav-item">
              <a href="tour.php" class="nav-link active">Turnê</a>
            </li>

            <li class="nav-item">
                            <a href="tickets.php" class="nav-link">Bilhetes</a>
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

  <!-- Conteúdo -->
  <main>

    <h1 class="h1_torne">Tudo sobre a Tour</h1>
    <h2>Calendário de Shows</h2>

    <div class="tour-container">

      <?php if ($tour_dates): ?>

        <?php foreach ($tour_dates as $d):

          $classe = ($d['tour_date'] < $hoje) ? 'passado' : 'futuro';

        ?>

          <div class="tour-card <?= $classe ?>">

            <i class="bi bi-calendar-event"></i>

            <span>
              <?= date("d \\d\\e F \\d\\e Y", strtotime($d['tour_date'])) ?>
            </span>

            <small>
              <?= htmlspecialchars($d['city']) ?>
              -
              <?= htmlspecialchars($d['venue']) ?>
            </small>

          </div>

        <?php endforeach; ?>

      <?php else: ?>

        <p class="text-center">
          Nenhuma data de tour cadastrada.
        </p>

      <?php endif; ?>

    </div>

  </main>

  <!-- Rodapé -->
  <footer>
    <p>&copy; 2026 Criado por Nelson Geovetty. Todos os direitos reservados.</p>

    <div>
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>