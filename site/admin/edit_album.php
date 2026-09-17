<?php
session_start();
require_once __DIR__ . '/../../conexao/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login_admin.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$album = $pdo->query("SELECT * FROM albums WHERE id=$id")->fetch();

if (!$album) {
    header('Location: admin.php');
    exit;
}

if(isset($_POST['edit_album'])){
    $title = $_POST['title'] ?? '';
    $imgName = $album['image'];

    if(!empty($_FILES['image']['name'])){
        // Apaga a imagem antiga
        if(file_exists('../img/'.$album['image'])) unlink('../img/'.$album['image']);
        $imgName = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../img/'.$imgName);
    }

    $stmt = $pdo->prepare("UPDATE albums SET title=?, image=? WHERE id=?");
    $stmt->execute([$title, $imgName, $id]);

    header('Location: admin.php');
    exit;
}
?>

<div class="container mt-5">
    <h2>Editar Álbum</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Título do Álbum:</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($album['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Imagem Atual:</label><br>
            <img src="../img/<?= htmlspecialchars($album['image']) ?>" style="max-width:120px; border-radius:4px;">
        </div>
        <div class="mb-3">
            <label>Nova Imagem (opcional):</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="edit_album" class="btn btn-warning">Salvar Alterações</button>
        <a href="admin.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>