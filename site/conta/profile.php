<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index2.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
        <link rel="stylesheet" href="../css/style.css">
</head>
<body class="pg-profile">
    <div class="welcome-box">
        <?php
        echo "Bem-vindo, " . htmlspecialchars($_SESSION["username"]) . "! <a href='../index2.php'>Entrar</a>";
        ?>
    </div>
</body>
</html>
