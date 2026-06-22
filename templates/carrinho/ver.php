<?php
$basePath = $basePath ?? '';
$veiculos = $veiculos ?? [];
$totalVeiculos = count($veiculos);

if (function_exists('csrf_token')) {
    $csrfToken = csrf_token();
} else {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrfToken = $_SESSION['csrf_token'];
}

$placeholder = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22160%22%20height%3D%2290%22%20viewBox%3D%220%200%20160%2090%22%3E%3Crect%20fill%3D%22%23eceff1%22%20width%3D%22160%22%20height%3D%2290%22/%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-family%3D%22Arial%22%20font-size%3D%2212%22%20fill%3D%22%2360707a%22%3ESem%20imagem%3C/text%3E%3C/svg%3E';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'Lista de compras') ?></title>
    <style>
        .site-shell.site-main { padding-top: 28px; }
        h1 { margin: 0 0 8px; font-size: clamp(1.8rem, 3.4vw, 2.6rem); }
        .resumo { color: var(--muted); margin-bottom: 18px; }
        .lista { display: grid; gap: 14px; }
        .item {
            display: grid;
            grid-template-columns: 160px 1fr auto;
            gap: 14px;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }
        .item img {
            width: 160px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            background: #111;
        }
        .dados h2 { margin: 0 0 6px; font-size: 1.05rem; color: var(--text); }
        .dados .preco { margin: 0; font-weight: bold; color: #fff; font-size: 1.05rem; }
        .acoes { display: flex; flex-direction: column; gap: 8px; }
        .btn {
            border: none;
            border-radius: 999px;
            padding: 10px 14px;
            cursor: pointer;
            font-size: 0.92rem;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            font-weight: 700;
        }
        .btn-remover { background: linear-gradient(135deg, var(--accent), #6f0000); color: #fff; }
        .btn-checkout {
            background: linear-gradient(135deg, var(--accent), #6f0000);
            color: #fff;
            margin-top: 20px;
            animation: neonBtnPulse 2.2s ease-in-out infinite;
        }
        .btn-voltar { background: rgba(255, 255, 255, 0.08); color: var(--text); margin-top: 20px; margin-left: 8px; }
        @keyframes neonBtnPulse {
            0%, 100% { box-shadow: 0 0 6px rgba(229, 57, 53, 0.5); }
            50% { box-shadow: 0 0 18px rgba(255, 40, 40, 0.95), 0 0 32px rgba(229, 57, 53, 0.55); }
        }
        @media (prefers-reduced-motion: reduce) {
            .btn-checkout { animation: none; }
        }
        .vazio {
            border: 1px dashed var(--border);
            border-radius: 16px;
            padding: 22px;
            color: var(--muted);
            background: rgba(255, 255, 255, 0.04);
        }
        .msg {
            margin: 0 0 14px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 0.95rem;
        }
        .msg-ok { background: rgba(46, 125, 50, 0.14); color: #d4ffd7; border: 1px solid rgba(46, 125, 50, 0.35); }
        .msg-info { background: rgba(13, 71, 161, 0.14); color: #cfe6ff; border: 1px solid rgba(13, 71, 161, 0.35); }
        @media (max-width: 760px) {
            .item {
                grid-template-columns: 1fr;
            }
            .item img {
                width: 100%;
                height: 180px;
            }
            .acoes {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/../header.php'; ?>
    <div class="site-shell site-main">
    <h1>Lista de compras</h1>
    <p class="resumo">Total de veículos na lista: <strong><?= $totalVeiculos ?></strong></p>

    <?php if (!empty($_SESSION['msg_ok'])): ?>
        <p class="msg msg-ok"><?= htmlspecialchars($_SESSION['msg_ok']) ?></p>
        <?php unset($_SESSION['msg_ok']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_info'])): ?>
        <p class="msg msg-info"><?= htmlspecialchars($_SESSION['msg_info']) ?></p>
        <?php unset($_SESSION['msg_info']); ?>
    <?php endif; ?>

    <?php if ($totalVeiculos === 0): ?>
        <div class="vazio">
            A tua lista está vazia. Adiciona veículos no catálogo para continuares.
        </div>
        <a class="btn btn-voltar" href="<?= htmlspecialchars($basePath . '/') ?>">Voltar ao catálogo</a>
    <?php else: ?>
        <div class="lista">
            <?php foreach ($veiculos as $v): ?>
                <?php
                    $id = (int) ($v['id'] ?? 0);
                    $marca = (string) ($v['marca'] ?? '');
                    $modelo = (string) ($v['modelo'] ?? '');
                    $preco = (float) ($v['preco'] ?? 0);
                    $imagem = !empty($v['imagem'])
                        ? '/uploads/' . rawurlencode((string) $v['imagem'])
                        : $placeholder;
                ?>
                <article class="item">
                    <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars(trim($marca . ' ' . $modelo)) ?>">
                    <div class="dados">
                        <h2><?= htmlspecialchars(trim($marca . ' ' . $modelo)) ?></h2>
                        <p class="preco"><?= number_format($preco, 2, ',', '.') ?> EUR</p>
                    </div>
                    <div class="acoes">
                        <form method="POST" action="<?= htmlspecialchars($basePath . '/carrinho/remover') ?>">
                            <input type="hidden" name="veiculo_id" value="<?= $id ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-remover">Remover</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <a class="btn btn-checkout" href="<?= htmlspecialchars($basePath . '/checkout') ?>">Prosseguir para checkout</a>
        <a class="btn btn-voltar" href="<?= htmlspecialchars($basePath . '/') ?>">Continuar a ver veículos</a>
    <?php endif; ?>
    </div>
</body>
</html>

