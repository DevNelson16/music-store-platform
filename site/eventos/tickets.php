<?php

require_once __DIR__ . '/../../conexao/db.php';

$sql = "
    SELECT
        e.id AS event_id,
        e.title AS event_name,
        e.city AS city,
        e.venue AS venue,
        e.event_date AS event_date,
        e.price AS price,
        COUNT(t.id) AS total_tickets,
        SUM(CASE WHEN t.status = 'Vendido' THEN 1 ELSE 0 END) AS tickets_sold,
        SUM(CASE WHEN t.status = 'Disponível' THEN 1 ELSE 0 END) AS tickets_available
    FROM events e
    LEFT JOIN tickets t ON e.id = t.event_id
    WHERE e.event_date >= CURDATE()
    GROUP BY e.id
    HAVING tickets_available > 0
    ORDER BY e.event_date ASC
";

$events = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);


$precos = $pdo->query("
    SELECT id AS event_id, price AS min_price
    FROM events
")->fetchAll(PDO::FETCH_KEY_PAIR);

?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Banda Favorita - Bilhetes</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../css/style.css">

</head>


<body class="pg-tickets">


<header class="py-3">

    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-dark">

            <a class="navbar-brand" href="../index2.php">

                <img
                    src="../img/logo.jpg"
                    alt="Logo"
                >

            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="menu"
            >

                <ul class="navbar-nav ms-auto text-end">

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
                        <a href="tour.php" class="nav-link">
                            Turnê
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="tickets.php" class="nav-link">
                            Bilhetes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../contactos/contactos.php" class="nav-link">
                            Contato
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../loja/loja_online.php" class="nav-link">
                            Loja Online
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../admin/login_admin.php" class="nav-link">
                            Admin
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../conta/sair.php" class="nav-link">
                            Sair
                        </a>
                    </li>

                </ul>

            </div>

        </nav>

    </div>

</header>



<main>

    <div class="container">

        <h1 class="titulo">
            Bilhetes para Concertos
        </h1>


        <div class="row g-4">


            <?php if (empty($events)): ?>

                <div class="col-12">

                    <div class="alert alert-info">

                        Não existem eventos disponíveis no momento.

                    </div>

                </div>

            <?php endif; ?>


            <?php foreach ($events as $event): ?>


                <div class="col-md-4">

                    <div class="ticket-card">


                        <h3>

                            <?= htmlspecialchars(
                                $event['event_name'] ?? 'Evento'
                            ) ?>

                        </h3>


                        <div class="info">

                            🏟️

                            <?= htmlspecialchars(
                                $event['venue'] ?? 'Local não definido'
                            ) ?>

                        </div>


                        <div class="info">

                            📅

                            <?php

                            
if (!empty($event['event_date'])) {
    echo date("d/m/Y", strtotime($event['event_date']));
} else {
    echo "Data não definida";
}
?>

                        </div>


                        <p>

                            Bilhetes disponíveis:

                            <strong>

                                <?= (int) ($event['tickets_available'] ?? 0) ?> de <?= (int) ($event['total_tickets'] ?? 0) ?>

                            </strong>

                            de

                            <?= (int) (
                                $event['capacity'] ?? 0
                            ) ?>

                        </p>


                        <p class="preco">

                            Desde

                            <?= number_format(
                                (float) (
                                    $precos[$event['event_id']] ?? 0
                                ),
                                2,
                                ",",
                                "."
                            ) ?>

                            €

                        </p>


                            <?php if (($event['tickets_available'] ?? 0) > 0): ?>


                            <a
                                href="comprar_ticket.php?event_id=<?= (int) $event['event_id'] ?>"
                                class="btn btn-ticket w-100"
                            >

                                Comprar Bilhete

                            </a>


                        <?php else: ?>


                            <button
                                class="btn btn-secondary w-100"
                                disabled
                            >

                                Bilhetes Esgotados

                            </button>


                        <?php endif; ?>


                    </div>

                </div>


            <?php endforeach; ?>


        </div>

    </div>

</main>



<footer>

    <p>

        &copy; 2026 Criado por Nelson Geovetty.
        Todos os direitos reservados.

    </p>

</footer>



<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>