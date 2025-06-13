<?php
session_start();

if ($_COOKIE['admin'] !== 'true') {
    header('Location: adminLogin.php');
    exit;
}

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['messages'][$id])) {
        switch ($_GET['action']) {
            case 'accept':
                $_SESSION['messages'][$id]['status'] = 'aceito';
                break;
            case 'reject':
                $_SESSION['messages'][$id]['status'] = 'rejeitado';
                break;
            case 'delete':
                unset($_SESSION['messages'][$id]);
                break;
        }
    }
}

$messages = $_SESSION['messages'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>Painel de Administração</header>
<div class="container">

<h1>Mensagens Recebidas</h1>

<?php foreach (array_reverse($messages, true) as $id => $msg): ?>
    <div class="ticket">
        <!-- VULNERABILIDADE: Sem htmlspecialchars no nome -->
        <strong><?= $msg['name'] ?></strong> escreveu:
        
        <!-- VULNERABILIDADE: Mensagem diretamente exibida -->
        <div><?= $msg['message'] ?></div>
        
        <small><?= $msg['created_at'] ?></small>
        <div class="status">Status: <?= $msg['status'] ?></div>

        <div class="actions">
            <?php if ($msg['status'] === 'pendente'): ?>
                <a href="?action=accept&id=<?= $id ?>" class="btn-accept">Aceitar</a>
                <a href="?action=reject&id=<?= $id ?>" class="btn-reject">Rejeitar</a>
            <?php endif; ?>
                <a href="?action=delete&id=<?= $id ?>" class="btn-delete">Remover</a>
        </div>
    </div>
<?php endforeach; ?>

</div>
</body>
</html>
