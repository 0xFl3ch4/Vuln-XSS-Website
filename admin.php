<?php
session_start();

function is_admin_authenticated() {
    if (!isset($_COOKIE['admin_auth'])) return false;
    list($payload, $signature) = explode('.', $_COOKIE['admin_auth'] ?? '', 2);
    return hash_equals(hash_hmac('sha256', $payload, "1111"), $signature) && $payload === 'admin';
}

if (!is_admin_authenticated()) {
    header('Location: adminLogin.php');
    exit;
}

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $id = (int)$_POST['id'];
    if (isset($_SESSION['messages'][$id])) {
        switch ($_POST['action']) {
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

    header('Location: admin.php');
    exit;
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
                <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="accept">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn-accept">Aceitar</button>
            </form>

            <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="reject">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn-reject">Rejeitar</button>
            </form>
            <?php endif; ?>
                <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn-delete">Remover</button>
            </form>

        </div>
    </div>
<?php endforeach; ?>

</div>

</body>
</html>
