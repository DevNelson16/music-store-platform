<?php

session_start();

/* CONEXÃO COM A BASE DE DADOS */

$host = "localhost";
$user = "root";
$password_db = "";
$database = "banda_db";

$conn = new mysqli($host, $user, $password_db, $database);

if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


/* ============================
   LOGIN
   ============================ */

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {

        $erro = "Preencha todos os campos.";
    } else {

        $sql = "SELECT id, password, role 
                FROM users_banda 
                WHERE username = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {

            $erro = "Erro na consulta à base de dados: " . $conn->error;
        } else {

            $stmt->bind_param("s", $username);
            $stmt->execute();

            $stmt->store_result();

            if ($stmt->num_rows === 1) {

                $stmt->bind_result($id, $hashed_password, $role);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {

                    $_SESSION["user_id"] = $id;
                    $_SESSION["username"] = $username;
                    $_SESSION["role"] = $role;

                    header("Location: conta/profile.php");
                    exit;
                } else {

                    $erro = "Credenciais inválidas.";
                }
            } else {

                $erro = "Credenciais inválidas.";
            }

            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="pg-index">

    <div class="container">

        <div class="form-box">

            <?php if (!empty($erro)): ?>

                <div class="erro">
                    <?= htmlspecialchars($erro) ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <label for="username">
                    Nome:
                </label>

                <input
                    id="username"
                    name="username"
                    type="text"
                    required>


                <label for="password">
                    Senha:
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required>


                <button type="submit">
                    Login
                </button>


                <a href="admin/login_admin.php">
                    <button
                        type="button"
                        class="admin-btn">
                        Login Administrador
                    </button>
                </a>


                <p>
                    Não consegue acessar sua conta?
                </p>


                <p>
                    Esqueceu a senha?

                    <a href="conta/recuperar_senha.php">
                        Recuperar
                    </a>
                </p>


                <p>
                    Não tem uma conta?

                    <a href="conta/registro.php">
                        Registre-se
                    </a>
                </p>

            </form>

        </div>

    </div>

</body>

</html>