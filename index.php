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
        'status' => 'pendente',
    ];

    $sent = true;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Contato</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>Formulário de Contato</header>
<div class="container">

<?php if (isset($sent)): ?>
    <div class="success">Mensagem enviada com sucesso!</div>
<?php endif; ?>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="name" required>

    <label>Mensagem:</label>
    <textarea name="message" required></textarea>

    <button type="submit">Enviar</button>
</form>
<br>
<a href="admin.php" class="btn-admin">Ir para Admin</a>

</div>

</body>
</html>
