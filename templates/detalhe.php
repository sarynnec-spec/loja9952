<?php
$basePath = $basePath ?? '';
$projectPath = $projectPath ?? preg_replace('#/public$#', '', $basePath) ?: '';
$placeholder = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22600%22%20height%3D%22360%22%20viewBox%3D%220%200%20600%20360%22%3E%3Crect%20fill%3D%22%23eceff1%22%20width%3D%22600%22%20height%3D%22360%22/%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-family%3D%22Arial%22%20font-size%3D%2224%22%20fill%3D%22%2360707a%22%3ESem%20imagem%3C/text%3E%3C/svg%3E';
$imagem = !empty($veiculo['imagem'])
    ? $projectPath . '/uploads/' . rawurlencode((string) $veiculo['imagem'])
    : $placeholder;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        img { width: 100%; max-height: 420px; object-fit: cover; background: #eee; }
        .content { padding: 16px; }
        .price { font-size: 1.6rem; font-weight: bold; color: #1565c0; margin-top: 8px; }
        .back { display: inline-block; margin-top: 14px; color: #1565c0; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?>">
        <div class="content">
            <h1><?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?></h1>
            <p>Ano: <?= (int) $veiculo['ano'] ?></p>
            <p>Quilometros: <?= number_format((float) $veiculo['quilometros'], 0, '.', '.') ?> km</p>
            <p>Combustivel: <?= htmlspecialchars((string) $veiculo['combustivel']) ?></p>
            <div class="price"><?= number_format((float) $veiculo['preco'], 2, ',', '.') ?> EUR</div>
            <a class="back" href="<?= htmlspecialchars($basePath . '/') ?>">Voltar ao catalogo</a>
        </div>
    </div>
</body>
</html>
