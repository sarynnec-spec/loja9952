<?php
$basePath = $basePath ?? '';
$cliente = $cliente ?? [];
$reservas = $reservas ?? [];
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$clienteAtual = \App\Auth::clienteAtual();
$nomeCliente = $cliente['nome'] ?? $clienteAtual['nome'] ?? 'Cliente';
$emailCliente = $cliente['email'] ?? ($_SESSION['cliente_email'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'A minha conta') ?></title>
    <style>
        .account-shell {
            margin-top: 28px;
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            box-shadow: var(--shadow);
        }
        .account-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }
        .panel {
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: rgba(0, 0, 0, 0.24);
        }
        .label { color: var(--muted); text-transform: uppercase; letter-spacing: .08em; font-size: .78rem; }
        .value { margin-top: 6px; font-weight: 700; font-size: 1.05rem; }
        .placeholder {
            margin-top: 22px;
            padding: 14px 16px;
            border: 1px dashed rgba(255,255,255,0.18);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            color: var(--muted);
        }
        .reservas {
            margin-top: 22px;
        }
        .reservas h2 {
            margin: 0 0 12px;
            font-size: 1.1rem;
        }
        .reserva-lista {
            display: grid;
            gap: 12px;
        }
        .reserva-item {
            padding: 16px 18px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.04);
        }
        .reserva-topo {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
            flex-wrap: wrap;
        }
        .reserva-titulo {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }
        .reserva-meta {
            margin-top: 6px;
            color: var(--muted);
            font-size: .95rem;
            line-height: 1.6;
        }
        .reserva-data {
            color: var(--muted);
            font-size: .9rem;
            white-space: nowrap;
        }
        .welcome { color: var(--muted); line-height: 1.7; }
        @media (max-width: 760px) {
            .account-grid { grid-template-columns: 1fr; }
            .reserva-topo { flex-direction: column; }
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/../header.php'; ?>
    <div class="site-shell site-main">
        <div class="account-shell">
            <h1>A minha conta</h1>
            <p class="welcome">Bem-vindo(a), <?= htmlspecialchars((string) $nomeCliente) ?>. A tua conta está pronta para guardar reservas e acompanhar o teu histórico.</p>

            <div class="account-grid">
                <div class="panel">
                    <div class="label">Nome</div>
                    <div class="value"><?= htmlspecialchars((string) $nomeCliente) ?></div>
                </div>
                <div class="panel">
                    <div class="label">Email</div>
                    <div class="value"><?= htmlspecialchars((string) $emailCliente) ?></div>
                </div>
            </div>

            <div class="reservas">
                <h2>As tuas reservas</h2>
                <?php if (empty($reservas)): ?>
                    <div class="placeholder">Ainda não tens reservas registadas.</div>
                <?php else: ?>
                    <div class="reserva-lista">
                        <?php foreach ($reservas as $reserva): ?>
                            <?php
                                $marca = (string) ($reserva['marca'] ?? '');
                                $modelo = (string) ($reserva['modelo'] ?? '');
                                $ano = (string) ($reserva['ano'] ?? '');
                                $preco = (float) ($reserva['preco'] ?? 0);
                                $mensagem = trim((string) ($reserva['mensagem'] ?? ''));
                                $criadoEm = (string) ($reserva['criado_em'] ?? '');
                            ?>
                            <article class="reserva-item">
                                <div class="reserva-topo">
                                    <div>
                                        <p class="reserva-titulo"><?= htmlspecialchars(trim($marca . ' ' . $modelo)) ?></p>
                                        <div class="reserva-meta">
                                            Ano: <?= htmlspecialchars($ano) ?><br>
                                            Preço: <?= number_format($preco, 2, ',', '.') ?> EUR
                                        </div>
                                    </div>
                                    <div class="reserva-data">
                                        <?= htmlspecialchars($criadoEm) ?>
                                    </div>
                                </div>
                                <?php if ($mensagem !== ''): ?>
                                    <div class="reserva-meta"><?= nl2br(htmlspecialchars($mensagem)) ?></div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
