<?php
session_start();
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';

    $_SESSION['messages'][] = [
        'name' => $name,
        'message' => $message,
        'created_at' => date('Y-m-d H:i:s'),
    ];

    echo "<p>Mensagem enviada!</p>";
}
?>

<h1>Formulário de Contato</h1>
<form method="POST">
    <label>Nome: <input type="text" name="name"></label><br><br>
    <label>Mensagem: <textarea name="message"></textarea></label><br><br>
    <button type="submit">Enviar</button>
</form>
