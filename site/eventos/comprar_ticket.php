<?php

require_once __DIR__ . '/../../conexao/db.php';


if (!isset($_GET['event_id'])) {
    header("Location: tickets.php");
    exit;
}


$event_id = $_GET['event_id'];


// Buscar evento

$stmt = $pdo->prepare("
    SELECT *
    FROM events
    WHERE id = ?
");

$stmt->execute([$event_id]);

$event = $stmt->fetch();


if (!$event) {

    echo "Evento não encontrado.";
    exit;

}

// Preço do bilhete: o preço é definido por evento (tabela events),
// não por bilhete individual
$preco_bilhete = $event['price'] ?? 0;


// Processar compra

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $pagamento = $_POST['pagamento'];



    try {


        // Iniciar transação

        $pdo->beginTransaction();



        // Procurar bilhete disponível (sem venda associada)

        $stmt = $pdo->prepare("
            SELECT t.id
            FROM tickets t
            LEFT JOIN sales s ON s.ticket_id = t.id
            WHERE t.event_id = ?
            AND s.id IS NULL
            ORDER BY t.id ASC
            LIMIT 1
            FOR UPDATE
        ");


        $stmt->execute([$event_id]);


        $ticket = $stmt->fetch();



        if (!$ticket) {


            $pdo->rollBack();


            echo "
            <div class='alert alert-danger text-center'>
            Não existem bilhetes disponíveis para este evento.
            </div>";

            exit;

        }



        $ticket_id = $ticket['id'];
        $ticket_price = $event['price'] ?? 0;





        // Verificar se cliente já existe

        $stmt = $pdo->prepare("
            SELECT id
            FROM customers
            WHERE email = ?
        ");


        $stmt->execute([$email]);


        $customer = $stmt->fetch();




        if ($customer) {


            // Cliente já existe

            $customer_id = $customer['id'];



            // Atualizar dados

            $stmt = $pdo->prepare("
                UPDATE customers
                SET name = ?, phone = ?
                WHERE id = ?
            ");


            $stmt->execute([
                $nome,
                $telefone,
                $customer_id
            ]);



        } else {



            // Criar novo cliente


            $stmt = $pdo->prepare("
                INSERT INTO customers
                (name,email,phone)

                VALUES (?,?,?)
            ");



            $stmt->execute([

                $nome,
                $email,
                $telefone

            ]);



            $customer_id = $pdo->lastInsertId();


        }





        // Criar venda


        $stmt = $pdo->prepare("
            INSERT INTO sales
            (
                customer_id,
                ticket_id,
                payment_method,
                total
            )

            VALUES (?,?,?,?)
        ");



        $stmt->execute([
    $customer_id,
    $ticket_id,
    $pagamento,
    $ticket_price
]);

// Marcar o bilhete como vendido, para o contador de
// bilhetes disponíveis descer corretamente
$stmt = $pdo->prepare("
    UPDATE tickets
    SET status = 'Vendido'
    WHERE id = ?
");
$stmt->execute([$ticket_id]);






        // O bilhete passa a estar "vendido" automaticamente, pois
        // agora existe um registo associado na tabela sales — não é
        // necessário nenhum UPDATE extra na tabela tickets.


        // Confirmar tudo

        $pdo->commit();




        header("Location: ../loja/sucesso_compra.php");

        exit;



    } catch(Exception $e) {


        $pdo->rollBack();


        echo "Erro na compra: " . $e->getMessage();

        exit;

    }


}


?>



<!DOCTYPE html>
<html lang="pt">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Comprar Bilhete</title>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <link rel="stylesheet" href="../css/style.css">
</head>



<body class="pg-comprar-ticket">


<main>


<div class="card-compra">


<h1>
Comprar Bilhete
</h1>



<h3>

<?= htmlspecialchars($event['title']) ?>

</h3>



<p>
🏟️ <?= htmlspecialchars($event['venue']) ?>
</p>



<p>
📅 <?= date("d/m/Y",strtotime($event['event_date'])) ?>
</p>



<p>
💶 <?= number_format($preco_bilhete,2,",",".") ?> €
</p>





<form method="POST">



<div class="mb-3">

<label class="form-label">
Nome
</label>


<input 
type="text"
name="nome"
class="form-control"
required>

</div>




<div class="mb-3">

<label class="form-label">
Email
</label>


<input 
type="email"
name="email"
class="form-control"
required>

</div>




<div class="mb-3">

<label class="form-label">
Telefone
</label>


<input 
type="text"
name="telefone"
class="form-control"
required>

</div>




<div class="mb-3">

<label class="form-label">
Pagamento
</label>


<select name="pagamento" class="form-control">


<option value="MB WAY">
MB WAY
</option>


<option value="Cartão">
Cartão
</option>


<option value="Transferência">
Transferência
</option>


</select>


</div>




<button class="btn btn-compra w-100">

Finalizar Compra

</button>



</form>



</div>


</main>



</body>

</html>