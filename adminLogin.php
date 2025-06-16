<?php
session_start();

$correctPin = '1111';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = $_POST['pin'] ?? '';

    if ($pin === $correctPin) {
        $payload = 'admin';
        $signature = hash_hmac('sha256', $payload, '1111');
        setcookie('admin_auth', $payload . '.' . $signature, [
            'httponly' => true,
            'secure' => false, // set to true if using HTTPS
            'samesite' => 'Strict',
            'path' => '/'
        ]);
        header('Location: admin.php');
        exit;
    } else {
        $error = 'PIN inválido.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>Login de Administrador</header>
<div class="container">

<h1>Entrar</h1>
<form method="POST">
    <label>PIN:</label>
    <input type="password" name="pin" />
    <button type="submit">Entrar</button>
</form>

<?php if (isset($error)) echo "<div class='success' style='background:#f8d7da; color:#721c24;'>$error</div>"; ?>

</div>
</body>
</html>
