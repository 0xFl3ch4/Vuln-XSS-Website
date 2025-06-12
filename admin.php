<?php
session_start();
$messages = $_SESSION['messages'] ?? [];
?>

<h1>Painel de Administração</h1>
<p>Mensagens recebidas:</p>

<?php foreach (array_reverse($messages) as $msg): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= $msg['name'] ?></strong> escreveu:
        <div><?= $msg['message'] ?></div>
        <small><?= $msg['created_at'] ?></small>
    </div>
<?php endforeach; ?>
