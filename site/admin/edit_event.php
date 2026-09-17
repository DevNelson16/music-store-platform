<?php

session_start();
require_once __DIR__ . '/../../conexao/db.php';


if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {

    header("Location: login_admin.php");
    exit;
}



$id = $_GET['id'] ?? null;


if (!$id) {

    header("Location: admin.php");
    exit;
}



// Buscar evento

$stmt = $pdo->prepare("
    SELECT *
    FROM events
    WHERE id=?
");

$stmt->execute([$id]);

$event = $stmt->fetch();



if (!$event) {

    echo "Evento não encontrado";
    exit;
}



// Atualizar evento

if (isset($_POST['update_event'])) {


    $stmt = $pdo->prepare("
        UPDATE events SET

        title=?,
        description=?,
        venue=?,
        event_date=?

        WHERE id=?

    ");



    $stmt->execute([

        $_POST['name'],
        $_POST['description'],
        $_POST['venue'],
        $_POST['date'],
        $id

    ]);



    header("Location: admin.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <title>Editar Evento</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">


    <div class="container mt-5">


        <div class="card p-4">


            <h2 class="mb-4 text-center">

                Editar Evento

            </h2>



            <form method="POST">



                <div class="mb-3">

                    <label>Nome do evento</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($event['title']) ?>"
                        required>

                </div>



                <div class="mb-3">

                    <label>Descrição</label>

                    <textarea
                        name="description"
                        class="form-control"><?= htmlspecialchars($event['description']) ?></textarea>

                </div>



                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label>Local (recinto, cidade)</label>

                        <input
                            type="text"
                            name="venue"
                            class="form-control"
                            value="<?= htmlspecialchars($event['venue']) ?>"
                            required>

                    </div>


                </div>




                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label>Data</label>

                        <input
                            type="date"
                            name="date"
                            class="form-control"
                            value="<?= htmlspecialchars($event['event_date']) ?>"
                            required>

                    </div>


                </div>

                <p class="text-muted small">
                    O preço dos bilhetes é gerido individualmente na secção
                    de Bilhetes do painel de administração.
                </p>



                <button
                    name="update_event"
                    class="btn btn-warning w-100">

                    Guardar Alterações

                </button>



            </form>


        </div>


    </div>


</body>

</html>