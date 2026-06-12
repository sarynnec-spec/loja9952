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
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'Confirmar reserva') ?></title>
    <style>
        .checkout-shell {
            margin-top: 28px;
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            box-shadow: var(--shadow);
        }
        .checkout-grid {
            display: grid;
            gap: 14px;
            margin: 18px 0 22px;
        }
        .item {
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 16px 18px;
            background: rgba(0, 0, 0, 0.24);
        }
        .item h2 { margin: 0 0 6px; font-size: 1.05rem; }
        .item p { margin: 4px 0; color: var(--muted); }
        .campo { margin-bottom: 16px; }
        .campo label { display: block; font-weight: 700; margin-bottom: 6px; }
        .campo textarea {
            width: 100%;
            min-height: 110px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-sizing: border-box;
            resize: vertical;
            font-family: inherit;
            background: rgba(0, 0, 0, 0.28);
            color: var(--text);
        }
        .total { font-weight: 800; margin: 18px 0 10px; font-size: 1.05rem; }
        .aviso {
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(229, 57, 53, 0.12);
            border: 1px solid rgba(229, 57, 53, 0.35);
            color: #fff;
            margin-bottom: 18px;
        }
        .acoes { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn {
            display: inline-block;
            border: none;
            border-radius: 999px;
            padding: 12px 18px;
            font-size: 0.95rem;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-weight: 700;
        }
        .btn-confirmar { background: linear-gradient(135deg, var(--accent), #6f0000); color: #fff; }
        .btn-voltar { background: rgba(255, 255, 255, 0.08); color: var(--text); }
        .vazio {
            border: 1px dashed var(--border);
            border-radius: 18px;
            padding: 18px;
            color: var(--muted);
            background: rgba(255, 255, 255, 0.04);
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/../header.php'; ?>
    <div class="site-shell site-main">
        <div class="checkout-shell">
            <h1>Confirmar reserva</h1>

            <?php if ($totalVeiculos === 0): ?>
                <div class="vazio">Não existem veículos no carrinho para reservar.</div>
                <div class="acoes" style="margin-top:16px;">
                    <a class="btn btn-voltar" href="<?= htmlspecialchars($basePath . '/carrinho') ?>">Voltar ao carrinho</a>
                </div>
            <?php else: ?>
                <div class="checkout-grid">
                    <?php foreach ($veiculos as $veiculo): ?>
                        <?php
                            $marca = (string) ($veiculo['marca'] ?? '');
                            $modelo = (string) ($veiculo['modelo'] ?? '');
                            $preco = (float) ($veiculo['preco'] ?? 0);
                        ?>
                        <article class="item">
                            <h2><?= htmlspecialchars(trim($marca . ' ' . $modelo)) ?></h2>
                            <p><strong>Marca:</strong> <?= htmlspecialchars($marca) ?></p>
                            <p><strong>Modelo:</strong> <?= htmlspecialchars($modelo) ?></p>
                            <p><strong>Preço:</strong> <?= number_format($preco, 2, ',', '.') ?> EUR</p>
                        </article>
                    <?php endforeach; ?>
                </div>

                <p class="total">Total de veículos a reservar: <?= $totalVeiculos ?></p>

                <div class="aviso">Esta é uma reserva simulada — sem pagamento online.</div>

                <form method="POST" action="<?= htmlspecialchars($basePath . '/checkout/confirmar') ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

                    <div class="campo">
                        <label for="mensagem">Informações adicionais para o vendedor</label>
                        <textarea id="mensagem" name="mensagem" placeholder="Escreve aqui notas opcionais para a reserva"></textarea>
                    </div>

                    <div class="acoes">
                        <button type="submit" class="btn btn-confirmar">Confirmar reserva</button>
                        <a class="btn btn-voltar" href="<?= htmlspecialchars($basePath . '/carrinho') ?>">Voltar ao carrinho</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
