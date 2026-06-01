<?php
$basePath = $basePath ?? '';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?> — AutoShop</title>
    <link rel="stylesheet" href="/css/estilo.css">
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>
    <a href="<?= htmlspecialchars($basePath . '/') ?>">← Voltar ao catálogo</a>
    <h1><?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?></h1>

    <img src="/uploads/<?= htmlspecialchars($veiculo['imagem'] ?? 'placeholder.png') ?>"
         alt="" style="max-width:600px; border-radius:8px;">

    <table>
        <tr><th>Marca</th>      <td><?= htmlspecialchars($veiculo['marca']) ?></td></tr>
        <tr><th>Modelo</th>     <td><?= htmlspecialchars($veiculo['modelo']) ?></td></tr>
        <tr><th>Ano</th>        <td><?= $veiculo['ano'] ?></td></tr>
        <tr><th>Quilômetros</th><td><?= number_format($veiculo['quilometros'], 0, '.', '.') ?> km</td></tr>
        <tr><th>Combustível</th><td><?= htmlspecialchars($veiculo['combustivel']) ?></td></tr>
        <?php if ($veiculo['cilindrada']): ?>
        <tr><th>Cilindrada</th><td><?= htmlspecialchars($veiculo['cilindrada']) ?></td></tr>
        <?php endif ?>
        <tr><th>Preço</th>      <td><strong><?= number_format($veiculo['preco'], 2, ',', '.') ?> €</strong></td></tr>
    </table>

    <?php if ($veiculo['descricao']): ?>
        <h3>Descrição</h3>
        <p><?= nl2br(htmlspecialchars($veiculo['descricao'])) ?></p>
    <?php endif ?>

    <form method="POST" action="<?= htmlspecialchars($basePath . '/carrinho/adicionar') ?>">
        <input type="hidden" name="veiculo_id" value="<?= $veiculo['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <button type="submit">🛒 Adicionar à lista de reservas</button>
    </form>
</body>
</html>
