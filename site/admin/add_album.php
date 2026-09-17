<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login_admin.php');
    exit;
}

if (isset($_POST['add_album'])) {
    $title = $_POST['title'] ?? '';

    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../img/' . $imgName);

        $stmt = $pdo->prepare("INSERT INTO albums (title, image) VALUES (?, ?)");
        $stmt->execute([$title, $imgName]);

        header('Location: admin.php');
        exit;
    }
}
?>

<div class="container mt-5">
    <h2>Adicionar Álbum</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Título do Álbum:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Imagem:</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="add_album" class="btn btn-warning">Adicionar Álbum</button>
        <a href="admin.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>