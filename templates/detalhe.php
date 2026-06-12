<?php
$basePath = $basePath ?? '';
$projectPath = $projectPath ?? preg_replace('#/public$#', '', $basePath) ?: '';
$placeholder = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22960%22%20height%3D%22540%22%20viewBox%3D%220%200%20960%20540%22%3E%3Crect%20fill%3D%22%23111114%22%20width%3D%22960%22%20height%3D%22540%22/%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-family%3D%22Arial%22%20font-size%3D%2230%22%20fill%3D%22%23ffffff%22%3ESem%20imagem%3C/text%3E%3C/svg%3E';
$imagem = function_exists('veiculo_imagem_profissional') ? veiculo_imagem_profissional($veiculo, $projectPath) : $placeholder;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?> — AutoShop</title>
    <style>
        .page-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
            gap: 24px;
            margin-top: 28px;
            align-items: start;
        }
        .visual, .panel {
            border: 1px solid var(--border);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            box-shadow:
                0 0 0 1px rgba(229, 57, 53, 0.18),
                0 20px 60px rgba(0, 0, 0, 0.52);
            overflow: hidden;
        }
        .visual {
            position: relative;
            transform: perspective(1200px) rotateY(-3deg) translateZ(0);
            transition: transform 220ms ease, box-shadow 220ms ease;
        }
        .visual:hover {
            transform: perspective(1200px) rotateY(0deg) translateY(-4px);
            box-shadow:
                0 0 0 1px rgba(229, 57, 53, 0.35),
                0 0 30px rgba(229, 57, 53, 0.22),
                0 28px 76px rgba(0, 0, 0, 0.6);
        }
        .visual::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 55%, rgba(0, 0, 0, 0.34));
            pointer-events: none;
        }
        .visual img {
            width: 100%;
            height: 100%;
            min-height: 420px;
            object-fit: cover;
            display: block;
            filter: contrast(1.1) saturate(1.1);
        }
        .panel { padding: 24px; position: relative; }
        .panel::before {
            content: "";
            position: absolute;
            inset: 12px;
            border-radius: 18px;
            border: 1px solid rgba(229, 57, 53, 0.16);
            pointer-events: none;
        }
        .badge {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(229, 57, 53, 0.18);
            color: #fff;
            border: 1px solid rgba(229, 57, 53, 0.35);
            margin-bottom: 16px;
            box-shadow: 0 0 18px rgba(229, 57, 53, 0.22);
        }
        h1 { margin: 0 0 12px; font-size: clamp(2rem, 4vw, 3rem); }
        .back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-top: 18px;
            margin-bottom: 18px;
            color: var(--muted);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 16px;
            margin: 16px 0 18px;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        th { color: #fff; width: 34%; }
        td { color: var(--muted); }
        .price {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin: 10px 0 18px;
            text-shadow: 0 0 16px rgba(229, 57, 53, 0.3);
        }
        .price span { color: var(--accent); }
        .descricao {
            margin-top: 20px;
            color: var(--muted);
            line-height: 1.7;
        }
        .cta {
            margin-top: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 999px;
            padding: 12px 18px;
            background: linear-gradient(135deg, var(--accent), #6f0000);
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
        }
        @media (max-width: 900px) {
            .page-grid { grid-template-columns: 1fr; }
            .visual img { min-height: 280px; }
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>
    <div class="site-shell site-main">
        <a class="back" href="<?= htmlspecialchars($basePath . '/') ?>">← Voltar ao catálogo</a>
        <div class="page-grid">
            <div class="visual">
                <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?>">
            </div>
            <div class="panel">
                <span class="badge">Detalhe do veículo</span>
                <h1><?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?></h1>
                <div class="price"><span>€</span> <?= number_format($veiculo['preco'], 2, ',', '.') ?></div>
                <table>
                    <tr><th>Marca</th><td><?= htmlspecialchars($veiculo['marca']) ?></td></tr>
                    <tr><th>Modelo</th><td><?= htmlspecialchars($veiculo['modelo']) ?></td></tr>
                    <tr><th>Ano</th><td><?= $veiculo['ano'] ?></td></tr>
                    <tr><th>Quilómetros</th><td><?= number_format($veiculo['quilometros'], 0, '.', '.') ?> km</td></tr>
                    <tr><th>Combustível</th><td><?= htmlspecialchars($veiculo['combustivel']) ?></td></tr>
                    <?php if ($veiculo['cilindrada']): ?>
                    <tr><th>Cilindrada</th><td><?= htmlspecialchars($veiculo['cilindrada']) ?></td></tr>
                    <?php endif ?>
                </table>

                <?php if ($veiculo['descricao']): ?>
                    <div class="descricao">
                        <strong>Descrição</strong><br>
                        <?= nl2br(htmlspecialchars($veiculo['descricao'])) ?>
                    </div>
                <?php endif ?>

                <form method="POST" action="<?= htmlspecialchars($basePath . '/carrinho/adicionar') ?>">
                    <input type="hidden" name="veiculo_id" value="<?= $veiculo['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="cta">🛒 Adicionar à lista de reservas</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
