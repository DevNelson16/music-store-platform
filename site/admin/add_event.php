<?php

session_start();
require_once __DIR__ . '/../../conexao/db.php';


if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {

    header("Location: login_admin.php");
    exit;
}



if (isset($_POST['add_event'])) {


    $name = $_POST['name'];
    $description = $_POST['description'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];

    $image = null;



    // Upload da imagem

    if (!empty($_FILES['image']['name'])) {


        $image = time() . '_' . basename($_FILES['image']['name']);

        $path = "../img/" . $image;


        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $path
        );
    }




    $stmt = $pdo->prepare("
        INSERT INTO events
        (
            name,
            description,
            date,
            time,
            venue,
            capacity,
            image
        )

        VALUES
        (?,?,?,?,?,?,?)

    ");



    $stmt->execute([

        $name,
        $description,
        $date,
        $time,
        $venue,
        $capacity,
        $image

    ]);

    $event_id = $pdo->lastInsertId();


// Criar os bilhetes automaticamente (um por lugar, até à capacidade).
// O preço fica guardado no evento (tabela events), não em cada bilhete.

for($i = 1; $i <= $capacity; $i++){

    $ticket_number = "GA-" . str_pad($i, 3, "0", STR_PAD_LEFT);

    $stmt = $pdo->prepare("
        INSERT INTO tickets
        (event_id, ticket_number)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $event_id,
        $ticket_number
    ]);

}


    header("Location: admin.php");
    exit;
}


?>



<!DOCTYPE html>
<html lang="pt">


<head>

    <meta charset="UTF-8">

    <title>Adicionar Evento</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


        <link rel="stylesheet" href="../css/style.css">
</head>



<body class="pg-add-event">


    <div class="card">


        <h2 class="text-center mb-4">

            Adicionar Concerto

        </h2>



        <form method="POST" enctype="multipart/form-data">



            <div class="mb-3">

                <label>Nome do evento</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    required>

            </div>




            <div class="mb-3">

                <label>Descrição</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4"></textarea>

            </div>




            <div class="row">


                <div class="col-md-6 mb-3">

                    <label>Local (recinto, cidade)</label>

                    <input
                        type="text"
                        name="venue"
                        class="form-control"
                        placeholder="Ex: Arena MEO, Lisboa"
                        required>

                </div>




                <div class="col-md-6 mb-3">

                    <label>Capacidade</label>

                    <input
                        type="number"
                        name="capacity"
                        class="form-control"
                        min="1"
                        required>

                </div>


            </div>





            <div class="row">


                <div class="col-md-4 mb-3">

                    <label>Data do evento</label>

                    <input
                        type="date"
                        name="date"
                        class="form-control"
                        required>

                </div>




                <div class="col-md-4 mb-3">

                    <label>Hora do evento</label>

                    <input
                        type="time"
                        name="time"
                        class="form-control"
                        required>

                </div>




                <div class="col-md-4 mb-3">

                    <label>Preço do bilhete (€)</label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control"
                        required>

                </div>


            </div>





            <div class="mb-3">

                <label>Imagem do evento</label>

                <input
                    type="file"
                    name="image"
                    class="form-control">

            </div>




            <button
                type="submit"
                name="add_event"
                class="btn btn-warning w-100">

                Guardar Evento

            </button>




        </form>


    </div>


</body>


</html>