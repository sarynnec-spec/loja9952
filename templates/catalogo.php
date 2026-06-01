<?php
$basePath = $basePath ?? '';
$projectPath = $projectPath ?? preg_replace('#/public$#', '', $basePath) ?: '';
$placeholder = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22600%22%20height%3D%22360%22%20viewBox%3D%220%200%20600%20360%22%3E%3Crect%20fill%3D%22%23eceff1%22%20width%3D%22600%22%20height%3D%22360%22/%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-family%3D%22Arial%22%20font-size%3D%2224%22%20fill%3D%22%2360707a%22%3ESem%20imagem%3C/text%3E%3C/svg%3E';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1100px; margin: 0 auto; padding: 20px; }
        .filtros { background: #f0f4f8; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; gap: 12px; flex-wrap: wrap; }
        .filtros input, .filtros select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .filtros button { background: #1565c0; color: #fff; padding: 8px 18px; border: none; border-radius: 4px; cursor: pointer; }
        .grelha { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; overflow: hidden; transition: box-shadow 0.2s; }
        .card:hover { box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12); }
        .card img { width: 100%; height: 180px; object-fit: cover; background: #eee; }
        .card-body { padding: 14px; }
        .card-body h3 { margin: 0 0 6px; font-size: 1rem; color: #1a237e; }
        .preco { font-size: 1.3rem; font-weight: bold; color: #1565c0; }
        .detalhe { display: inline-block; margin-top: 10px; background: #1565c0; color: #fff; padding: 7px 14px; border-radius: 4px; text-decoration: none; font-size: 0.9rem; }
        .btn-carrinho { display: inline-block; margin-top: 10px; background: #1a237e; color: #fff; padding: 7px 14px; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; }
        .acoes-card { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-top: 8px; }
    </style>
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>
    <h1>AutoShop - Catálogo de Veículos</h1>

    <form class="filtros" method="GET" action="<?= htmlspecialchars($basePath . '/') ?>">
        <select name="marca_id">
            <option value="">Todas as marcas</option>
            <?php foreach ($marcas as $m): ?>
            <option value="<?= (int) $m['id'] ?>" <?= (($_GET['marca_id'] ?? '') == $m['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($m['nome']) ?>
            </option>
            <?php endforeach ?>
        </select>
        <select name="combustivel">
            <option value="">Combustível</option>
            <?php foreach (['Gasolina', 'Diesel', 'Eletrico', 'Hibrido'] as $c): ?>
            <option <?= (($_GET['combustivel'] ?? '') === $c) ? 'selected' : '' ?>><?= $c ?></option>
            <?php endforeach ?>
        </select>
        <input type="number" name="preco_max" placeholder="Preço máximo (EUR)" value="<?= htmlspecialchars($_GET['preco_max'] ?? '') ?>">
        <input type="number" name="ano_min" placeholder="Ano mínimo" value="<?= htmlspecialchars($_GET['ano_min'] ?? '') ?>">
        <input type="text" name="pesquisa" placeholder="Pesquisar modelo..." value="<?= htmlspecialchars($_GET['pesquisa'] ?? '') ?>">
        <button type="submit">Filtrar</button>
        <a href="<?= htmlspecialchars($basePath . '/') ?>" style="padding:8px 14px;color:#555;text-decoration:none;">Limpar</a>
    </form>

    <p><?= count($veiculos) ?> veículo(s) encontrado(s)</p>

    <?php if (empty($veiculos)): ?>
        <p style="color:#888;">Nenhum veículo corresponde aos filtros selecionados.</p>
    <?php else: ?>
    <div class="grelha">
    <?php foreach ($veiculos as $v): ?>
        <?php
            $imagem = !empty($v['imagem'])
                ? $projectPath . '/uploads/' . rawurlencode((string) $v['imagem'])
                : $placeholder;
        ?>
        <div class="card">
            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($v['marca'] . ' ' . $v['modelo']) ?>">
            <div class="card-body">
                <h3><?= htmlspecialchars($v['marca'] . ' ' . $v['modelo']) ?></h3>
                <p>
                    <?= (int) $v['ano'] ?> .
                    <?= number_format((float) $v['quilometros'], 0, '.', '.') ?> km .
                    <?= htmlspecialchars((string) $v['combustivel']) ?>
                </p>
                <div class="preco"><?= number_format((float) $v['preco'], 2, ',', '.') ?> EUR</div>
                <div class="acoes-card">
                    <a class="detalhe" href="<?= htmlspecialchars($basePath . '/veiculo/detalhe/' . (int) $v['id']) ?>">Ver detalhe</a>
                    <form method="POST" action="<?= htmlspecialchars($basePath . '/carrinho/adicionar') ?>" style="margin:0;">
                        <input type="hidden" name="veiculo_id" value="<?= (int) $v['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <button type="submit" class="btn-carrinho">Adicionar ao carrinho</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    </div>
    <?php endif ?>
</body>
</html>
