<?php
$imagem = '../img/logo.jpg';

echo '<h1>Teste de imagem</h1>';

echo '<p>Caminho usado pelo navegador:</p>';
echo $imagem;

echo '<br><br>';

echo '<p>Caminho físico:</p>';
echo __DIR__ . '/../img/logo.jpg';

echo '<br><br>';

if (file_exists(__DIR__ . '/../img/logo.jpg')) {
    echo '<strong style="color:green">A imagem EXISTE.</strong>';
} else {
    echo '<strong style="color:red">A imagem NÃO EXISTE nesse caminho.</strong>';
}
?>

<br><br>

<img src="../img/logo.jpg" width="300">