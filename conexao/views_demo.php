<?php
/**
 * views_demo.php
 * Demonstra a utilização das 4 views criadas na base de dados
 * carrinho_db, confirmando que devolvem os dados esperados.
 * Usa a ligação central definida em db.php.
 */
require_once __DIR__ . '/db.php';

function renderTable(PDO $pdo, string $viewName, string $title): void
{
    echo "<h2>{$title} <small>(view: {$viewName})</small></h2>";
    $stmt = $pdo->query("SELECT * FROM {$viewName}");
    $rows = $stmt->fetchAll();

    if (!$rows) {
        echo "<p>Sem dados.</p>";
        return;
    }

    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr>";
    foreach (array_keys($rows[0]) as $col) {
        echo "<th>" . htmlspecialchars($col) . "</th>";
    }
    echo "</tr>";

    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars((string) $value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table><br>";
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Demonstração das Views — carrinho_db</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; margin-bottom: 30px; }
        th { background: #2c3e50; color: #fff; padding: 6px; }
        td { padding: 6px; }
        h1 { color: #2c3e50; }
    </style>
</head>
<body>
    <h1>Demonstração das Views — Gestão de Eventos e Bilhetes</h1>

    <?php
    renderTable($pdo, 'event_details', 'Detalhes dos Eventos');
    renderTable($pdo, 'customer_sales_summary', 'Resumo de Compras por Cliente');
    renderTable($pdo, 'event_sales_summary', 'Resumo de Vendas por Evento');
    renderTable($pdo, 'tickets_status', 'Estado dos Bilhetes');
    ?>
</body>
</html>
