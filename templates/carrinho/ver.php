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
        body { font-family: Arial, sans-serif; max-width: 980px; margin: 0 auto; padding: 20px; }
        h1 { margin-bottom: 8px; }
        .resumo { color: #455a64; margin-bottom: 18px; }
        .lista { display: grid; gap: 14px; }
        .item {
            display: grid;
            grid-template-columns: 160px 1fr auto;
            gap: 14px;
            align-items: center;
            border: 1px solid #d7dee4;
            border-radius: 8px;
            padding: 12px;
            background: #fff;
        }
        .item img {
            width: 160px;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            background: #eceff1;
        }
        .dados h2 { margin: 0 0 6px; font-size: 1.05rem; color: #1a237e; }
        .dados .preco { margin: 0; font-weight: bold; color: #1565c0; font-size: 1.05rem; }
        .acoes { display: flex; flex-direction: column; gap: 8px; }
        .btn {
            border: none;
            border-radius: 6px;
            padding: 9px 12px;
            cursor: pointer;
            font-size: 0.92rem;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        .btn-remover { background: #c62828; color: #fff; }
        .btn-checkout { background: #1565c0; color: #fff; margin-top: 20px; }
        .btn-voltar { background: #eceff1; color: #263238; margin-top: 20px; margin-left: 8px; }
        .vazio {
            border: 1px dashed #b0bec5;
            border-radius: 8px;
            padding: 20px;
            color: #546e7a;
            background: #fafcfd;
        }
        .msg {
            margin: 0 0 14px;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        .msg-ok { background: #e8f5e9; color: #1b5e20; border: 1px solid #c8e6c9; }
        .msg-info { background: #e3f2fd; color: #0d47a1; border: 1px solid #bbdefb; }
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
        <a class="btn btn-voltar" href="<?= htmlspecialchars($basePath . '/') ?>">Continuar a ver ve�culos</a>
    <?php endif; ?>
</body>
</html>

