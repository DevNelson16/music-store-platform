<?php
// Conexão com banco (ligação central — conexao/db.php)
require_once __DIR__ . '/../../conexao/db.php';

// Recebe os dados
$nome = $_POST['nome'] ?? '';
$apelido = $_POST['apelido'] ?? '';
$dataNascimento = $_POST['dataNascimento'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';

// Grava no banco
$stmt = $pdo->prepare("INSERT INTO contactos (nome, apelido, data_nascimento, email, telefone, mensagem) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$nome, $apelido, $dataNascimento, $email, $telefone, $mensagem]);

// Envia por e-mail (PHPMailer)
// ATENÇÃO: a biblioteca PHPMailer não está incluída neste projeto.
// Instala com "composer require phpmailer/phpmailer" ou descarrega manualmente
// e coloca a pasta "PHPMailer" dentro de site/, para este bloco funcionar.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Exemplo para Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'teuemail@gmail.com'; // <-- Teu email
    $mail->Password = 'tuasenhaouappkey';    // <-- Senha ou App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remetente e destinatário
    $mail->setFrom($email, $nome);
    $mail->addAddress('teuemail@gmail.com', 'Nelson'); // <-- Teu email

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Nova mensagem de contato';
    $mail->Body    = "
        <strong>Nome:</strong> $nome $apelido<br>
        <strong>Email:</strong> $email<br>
        <strong>Telefone:</strong> $telefone<br>
        <strong>Data de nascimento:</strong> $dataNascimento<br><br>
        <strong>Mensagem:</strong><br>$mensagem
    ";

    $mail->send();
    echo 'sucesso';
} catch (Exception $e) {
    echo 'erro';
}
