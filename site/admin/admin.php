<?php

session_start();

require_once __DIR__ . '/../../conexao/db.php';

// =====================================================
// VERIFICAR ADMIN
// =====================================================

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login_admin.php');
    exit;
}

// =====================================================
// ÁLBUNS - ADICIONAR
// =====================================================

if (isset($_POST['add_album'])) {

    $title = trim($_POST['title'] ?? '');

    if (!empty($_FILES['image']['name'])) {

        $filename = time() . '_' . preg_replace(
            '/[^a-zA-Z0-9._-]/',
            '_',
            $_FILES['image']['name']
        );

        // A pasta correta é site/img
        $uploadDir = __DIR__ . '/../img/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filepath = $uploadDir . $filename;

        if (move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $filepath
        )) {

            $stmt = $pdo->prepare("
                INSERT INTO albums (title, image)
                VALUES (?, ?)
            ");

            $stmt->execute([
                $title,
                $filename
            ]);
        }
    }

    header('Location: admin.php#albums');
    exit;
}

// =====================================================
// ÁLBUM - EDITAR
// =====================================================

if (isset($_POST['edit_album'])) {

    $stmt = $pdo->prepare("
        UPDATE albums
        SET title = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['title'] ?? '',
        (int) ($_POST['id'] ?? 0)
    ]);

    header('Location: admin.php#albums');
    exit;
}

// =====================================================
// ÁLBUM - APAGAR
// =====================================================

if (isset($_GET['delete_album'])) {

    $id = (int) $_GET['delete_album'];

    $stmt = $pdo->prepare("
        SELECT image
        FROM albums
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($album) {

        $path = __DIR__ . '/../img/' . $album['image'];

        if (
            !empty($album['image']) &&
            file_exists($path)
        ) {
            unlink($path);
        }

        $delete = $pdo->prepare("
            DELETE FROM albums
            WHERE id = ?
        ");

        $delete->execute([$id]);
    }

    header('Location: admin.php#albums');
    exit;
}

// =====================================================
// TOUR - ADICIONAR
// =====================================================

if (isset($_POST['add_tour'])) {

    $stmt = $pdo->prepare("
        INSERT INTO tour_dates
        (
            tour_date,
            city,
            venue
        )
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $_POST['tour_date'] ?? '',
        $_POST['city'] ?? '',
        $_POST['venue'] ?? ''
    ]);

    header('Location: admin.php#tour');
    exit;
}

// =====================================================
// TOUR - EDITAR
// =====================================================

if (isset($_POST['edit_tour'])) {

    $stmt = $pdo->prepare("
        UPDATE tour_dates
        SET
            tour_date = ?,
            city = ?,
            venue = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['tour_date'] ?? '',
        $_POST['city'] ?? '',
        $_POST['venue'] ?? '',
        (int) ($_POST['id'] ?? 0)
    ]);

    header('Location: admin.php#tour');
    exit;
}

// =====================================================
// TOUR - APAGAR
// =====================================================

if (isset($_GET['delete_tour'])) {

    $id = (int) $_GET['delete_tour'];

    $stmt = $pdo->prepare("
        DELETE FROM tour_dates
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    header('Location: admin.php#tour');
    exit;
}

// =====================================================
// MENSAGEM - MARCAR COMO LIDA
// =====================================================

if (isset($_GET['mark_read'])) {

    $id = (int) $_GET['mark_read'];

    $stmt = $pdo->prepare("
        UPDATE contact_messages
        SET status = 'lida'
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    header('Location: admin.php#mensagens');
    exit;
}

// =====================================================
// MENSAGEM - APAGAR
// =====================================================

if (isset($_GET['delete_msg'])) {

    $id = (int) $_GET['delete_msg'];

    $stmt = $pdo->prepare("
        DELETE FROM contact_messages
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    header('Location: admin.php#mensagens');
    exit;
}

// =====================================================
// DASHBOARD
// =====================================================

$totalOrders = $pdo
    ->query("
        SELECT COUNT(*)
        FROM orders
    ")
    ->fetchColumn();

$totalEvents = $pdo
    ->query("
        SELECT COUNT(*)
        FROM events
    ")
    ->fetchColumn();

$totalTickets = $pdo
    ->query("
        SELECT COUNT(*)
        FROM tickets
    ")
    ->fetchColumn();

$soldTickets = $pdo
    ->query("
        SELECT COUNT(*)
        FROM tickets
        WHERE status = 'Vendido'
    ")
    ->fetchColumn();

$availableTickets = $pdo
    ->query("
        SELECT COUNT(*)
        FROM tickets
        WHERE status = 'Disponível'
    ")
    ->fetchColumn();

$totalCustomers = $pdo
    ->query("
        SELECT COUNT(*)
        FROM customers
    ")
    ->fetchColumn();

$totalRevenue = $pdo
    ->query("
        SELECT COALESCE(SUM(total), 0)
        FROM sales
    ")
    ->fetchColumn();

// =====================================================
// PRODUTOS
// =====================================================

$products = $pdo
    ->query("
        SELECT *
        FROM products
        ORDER BY id DESC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// PEDIDOS
// =====================================================

$orders = $pdo
    ->query("
        SELECT *
        FROM orders
        ORDER BY id DESC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// TOUR
// =====================================================

$tour_dates = $pdo
    ->query("
        SELECT *
        FROM tour_dates
        ORDER BY tour_date ASC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// ÁLBUNS
// =====================================================

$albums = $pdo
    ->query("
        SELECT *
        FROM albums
        ORDER BY created_at DESC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// EVENTOS
//
// Estrutura confirmada:
//
// id
// title
// description
// city
// venue
// event_date
// price
// image
// created_at
// =====================================================

$events = $pdo
    ->query("
        SELECT
            id,
            title,
            description,
            city,
            venue,
            event_date,
            price,
            image,
            created_at
        FROM events
        ORDER BY event_date ASC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// BILHETES
//
// Estrutura confirmada:
//
// id
// event_id
// ticket_number
// status
// price
// created_at
// =====================================================

$tickets = $pdo
    ->query("
        SELECT
            tickets.id,
            tickets.event_id,
            tickets.ticket_number,
            tickets.status,
            events.price,
            tickets.created_at,
            events.title AS event_name,
            events.event_date,
            events.venue
        FROM tickets
        INNER JOIN events
            ON tickets.event_id = events.id
        ORDER BY tickets.id DESC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// VENDAS
//
// Estrutura confirmada:
//
// id
// customer_id
// ticket_id
// sale_date
// payment_method
// total
// =====================================================

$sales = $pdo
    ->query("
        SELECT
            sales.id,
            sales.customer_id,
            sales.ticket_id,
            sales.sale_date,
            sales.payment_method,
            sales.total,

            customers.name AS customer_name,

            tickets.ticket_number,
            events.price,

            events.title AS event_name

        FROM sales

        INNER JOIN customers
            ON sales.customer_id = customers.id

        INNER JOIN tickets
            ON sales.ticket_id = tickets.id

        INNER JOIN events
            ON tickets.event_id = events.id

        ORDER BY sales.id DESC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// MENSAGENS
// =====================================================

$messages = $pdo
    ->query("
        SELECT *
        FROM contact_messages
        ORDER BY created_at DESC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <title>Painel Admin - Banda</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../css/style.css">

</head>

<body class="pg-admin">

    <!-- =====================================================
NAVBAR
===================================================== -->

    <nav class="navbar navbar-expand-lg navbar-dark">

        <div class="container">

            <a
                class="navbar-brand"
                href="#">
                Admin Banda
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuAdmin">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div
                class="collapse navbar-collapse"
                id="menuAdmin">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="../index2.php">
                            Site
                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="logout.php">
                            Sair
                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <div class="container py-4">

        <!-- =====================================================
DASHBOARD
===================================================== -->

        <h2 class="section-title">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </h2>

        <div class="row g-4 mb-5">

            <div class="col-md-3">

                <div class="card-dashboard">

                    <i class="bi bi-calendar-event"></i>

                    <h3>
                        <?= (int) $totalEvents ?>
                    </h3>

                    <p>
                        Eventos
                    </p>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-dashboard">

                    <i class="bi bi-ticket-perforated"></i>

                    <h3>
                        <?= (int) $totalTickets ?>
                    </h3>

                    <p>
                        Total Bilhetes
                    </p>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-dashboard">

                    <i class="bi bi-ticket-detailed"></i>

                    <h3>
                        <?= (int) $soldTickets ?>
                    </h3>

                    <p>
                        Bilhetes Vendidos
                    </p>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-dashboard">

                    <i class="bi bi-ticket"></i>

                    <h3>
                        <?= (int) $availableTickets ?>
                    </h3>

                    <p>
                        Bilhetes Disponíveis
                    </p>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-dashboard">

                    <i class="bi bi-people"></i>

                    <h3>
                        <?= (int) $totalCustomers ?>
                    </h3>

                    <p>
                        Clientes
                    </p>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-dashboard">

                    <i class="bi bi-cash"></i>

                    <h3>

                        <?= number_format(
                            (float) $totalRevenue,
                            2,
                            ",",
                            "."
                        ) ?>

                        €

                    </h3>

                    <p>
                        Receita
                    </p>

                </div>

            </div>

        </div>

        <!-- =====================================================
PRODUTOS
===================================================== -->

        <h2 class="section-title">

            <i class="bi bi-shop"></i>

            Produtos

        </h2>

        <a
            href="add_product.php"
            class="btn btn-warning mb-3">
            Adicionar Produto
        </a>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Imagem</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($products as $product): ?>

                        <tr>

                            <td>
                                <?= (int) $product['id'] ?>
                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $product['name'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $product['category'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= number_format(
                                    (float) ($product['price'] ?? 0),
                                    2,
                                    ",",
                                    "."
                                ) ?>

                                €

                            </td>

                            <td>

                                <?php if (!empty($product['image'])): ?>

                                    <img
                                        src="../img/<?= htmlspecialchars($product['image']) ?>"
                                        width="60"
                                        height="60"
                                        style="object-fit: cover;"
                                        alt="Produto">

                                <?php else: ?>

                                    Sem imagem

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="edit_product.php?id=<?= (int) $product['id'] ?>"
                                    class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <a
                                    href="delete_product.php?id=<?= (int) $product['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir produto?')">
                                    Excluir
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
PEDIDOS
===================================================== -->

        <h2 class="section-title">

            <i class="bi bi-cart-check"></i>

            Pedidos

        </h2>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($orders as $order): ?>

                        <tr>

                            <td>
                                <?= (int) $order['id'] ?>
                            </td>

                            <td>

                                <?= number_format(
                                    (float) ($order['total'] ?? 0),
                                    2,
                                    ",",
                                    "."
                                ) ?>

                                €

                            </td>

                            <td>

                                <?php if (!empty($order['created_at'])): ?>

                                    <?= date(
                                        "d/m/Y H:i",
                                        strtotime($order['created_at'])
                                    ) ?>

                                <?php elseif (!empty($order['order_date'])): ?>

                                    <?= date(
                                        "d/m/Y H:i",
                                        strtotime($order['order_date'])
                                    ) ?>

                                <?php else: ?>

                                    Sem data

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="detalhes.php?id=<?= (int) $order['id'] ?>"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-eye"></i>

                                    Ver

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
EVENTOS
===================================================== -->

        <h2
            class="section-title"
            id="eventos">

            <i class="bi bi-calendar-event"></i>

            Eventos

        </h2>

        <a
            href="add_event.php"
            class="btn btn-warning mb-3">
            Adicionar Evento
        </a>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Título</th>
                        <th>Cidade</th>
                        <th>Data</th>
                        <th>Local</th>
                        <th>Preço</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($events as $event): ?>

                        <tr>

                            <td>
                                <?= (int) $event['id'] ?>
                            </td>

                            <td>

                                <?php if (!empty($event['image'])): ?>

                                    <img
                                        src="../img/<?= htmlspecialchars($event['image']) ?>"
                                        width="60"
                                        height="60"
                                        style="object-fit: cover;"
                                        alt="Evento">

                                <?php else: ?>

                                    Sem imagem

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $event['title'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $event['city'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?php if (!empty($event['event_date'])): ?>

                                    <?= date(
                                        "d/m/Y",
                                        strtotime($event['event_date'])
                                    ) ?>

                                <?php else: ?>

                                    Sem data

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $event['venue'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= number_format(
                                    (float) ($event['price'] ?? 0),
                                    2,
                                    ",",
                                    "."
                                ) ?>

                                €

                            </td>

                            <td>

                                <a
                                    href="edit_event.php?id=<?= (int) $event['id'] ?>"
                                    class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <a
                                    href="delete_event.php?id=<?= (int) $event['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir evento?')">
                                    Excluir
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
BILHETES
===================================================== -->

        <h2
            class="section-title"
            id="bilhetes">

            <i class="bi bi-ticket-perforated"></i>

            Bilhetes

        </h2>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Evento</th>
                        <th>Número</th>
                        <th>Data</th>
                        <th>Local</th>
                        <th>Preço</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($tickets as $ticket): ?>

                        <tr>

                            <td>
                                <?= (int) $ticket['id'] ?>
                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $ticket['event_name'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $ticket['ticket_number'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?php if (!empty($ticket['event_date'])): ?>

                                    <?= date(
                                        "d/m/Y",
                                        strtotime($ticket['event_date'])
                                    ) ?>

                                <?php else: ?>

                                    Sem data

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $ticket['venue'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= number_format(
                                    (float) ($ticket['price'] ?? 0),
                                    2,
                                    ",",
                                    "."
                                ) ?>

                                €

                            </td>

                            <td>

                                <?php if (($ticket['status'] ?? '') === 'Vendido'): ?>

                                    <span class="badge bg-danger">
                                        Vendido
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-success">
                                        Disponível
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
VENDAS
===================================================== -->

        <h2
            class="section-title"
            id="vendas">

            <i class="bi bi-cash-stack"></i>

            Vendas de Bilhetes

        </h2>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Evento</th>
                        <th>Bilhete</th>
                        <th>Método</th>
                        <th>Valor</th>
                        <th>Data</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($sales as $sale): ?>

                        <tr>

                            <td>
                                <?= (int) $sale['id'] ?>
                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['customer_name'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['event_name'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['ticket_number'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['payment_method'] ?? '—'
                                ) ?>

                            </td>

                            <td>

                                <?= number_format(
                                    (float) ($sale['total'] ?? 0),
                                    2,
                                    ",",
                                    "."
                                ) ?>

                                €

                            </td>

                            <td>

                                <?php if (!empty($sale['sale_date'])): ?>

                                    <?= date(
                                        "d/m/Y H:i",
                                        strtotime($sale['sale_date'])
                                    ) ?>

                                <?php else: ?>

                                    Sem data

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
TOUR
===================================================== -->

        <h2
            class="section-title"
            id="tour">

            <i class="bi bi-music-note"></i>

            Tour

        </h2>

        <div class="card p-4 mb-4">

            <form
                method="post"
                class="row g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Data
                    </label>

                    <input
                        type="date"
                        name="tour_date"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Cidade
                    </label>

                    <input
                        type="text"
                        name="city"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Local
                    </label>

                    <input
                        type="text"
                        name="venue"
                        class="form-control"
                        required>

                </div>

                <div class="col-12">

                    <button
                        type="submit"
                        name="add_tour"
                        class="btn btn-warning w-100">

                        Adicionar Tour

                    </button>

                </div>

            </form>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Data</th>
                        <th>Cidade</th>
                        <th>Local</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($tour_dates as $tour): ?>

                        <tr>

                            <td>
                                <?= (int) $tour['id'] ?>
                            </td>

                            <td>

                                <?php if (!empty($tour['tour_date'])): ?>

                                    <?= date(
                                        "d/m/Y",
                                        strtotime($tour['tour_date'])
                                    ) ?>

                                <?php else: ?>

                                    Sem data

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $tour['city'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $tour['venue'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <a
                                    href="?delete_tour=<?= (int) $tour['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir data da tour?')">

                                    Excluir

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
ÁLBUNS
===================================================== -->

        <h2
            class="section-title"
            id="albums">

            <i class="bi bi-disc"></i>

            Álbuns

        </h2>

        <a
            href="add_album.php"
            class="btn btn-warning mb-3">
            Adicionar Álbum
        </a>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Título</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($albums as $album): ?>

                        <tr>

                            <td>
                                <?= (int) $album['id'] ?>
                            </td>

                            <td>

                                <?php if (!empty($album['image'])): ?>

                                    <img
                                        src="../img/<?= htmlspecialchars($album['image']) ?>"
                                        width="60"
                                        height="60"
                                        style="object-fit: cover;"
                                        alt="Álbum">

                                <?php else: ?>

                                    Sem imagem

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $album['title'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <a
                                    href="edit_album.php?id=<?= (int) $album['id'] ?>"
                                    class="btn btn-warning btn-sm">

                                    Editar

                                </a>

                                <a
                                    href="?delete_album=<?= (int) $album['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir álbum?')">

                                    Excluir

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- =====================================================
MENSAGENS
===================================================== -->

        <h2
            class="section-title"
            id="mensagens">

            <i class="bi bi-envelope"></i>

            Mensagens

        </h2>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center">

                <thead>

                    <tr>

                        <th>Nome</th>
                        <th>Email</th>
                        <th>Mensagem</th>
                        <th>Status</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($messages as $msg): ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars(
                                    trim(
                                        ($msg['nome'] ?? '') .
                                            ' ' .
                                            ($msg['apelido'] ?? '')
                                    )
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $msg['email'] ?? ''
                                ) ?>

                            </td>

                            <td>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $msg['mensagem'] ?? ''
                                    )
                                ) ?>

                            </td>

                            <td>

                                <?= ucfirst(
                                    htmlspecialchars(
                                        $msg['status'] ?? ''
                                    )
                                ) ?>

                            </td>

                            <td>

                                <a
                                    href="?mark_read=<?= (int) $msg['id'] ?>"
                                    class="btn btn-warning btn-sm">

                                    Lida

                                </a>

                                <a
                                    href="?delete_msg=<?= (int) $msg['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir mensagem?')">

                                    Excluir

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- =====================================================
FOOTER
===================================================== -->

    <footer class="text-center py-4">

        &copy;

        <?= date("Y") ?>

        Nelson Geovetty -

        Todos os direitos reservados

    </footer>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>