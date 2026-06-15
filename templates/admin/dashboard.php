<?php
$basePath = $basePath ?? '';
$titulo = $titulo ?? 'Dashboard Admin';
$totalVeic = (int) ($totalVeic ?? 0);
$totalRes = (int) ($totalRes ?? 0);
$pendentes = (int) ($pendentes ?? 0);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #09090b;
            --surface: rgba(255, 255, 255, 0.06);
            --surface-strong: rgba(255, 255, 255, 0.1);
            --border: rgba(255, 255, 255, 0.12);
            --text: #f5f5f5;
            --muted: #b8bcc6;
            --accent: #e53935;
            --accent-2: #ff7a59;
            --good: #35c27a;
            --shadow: 0 24px 60px rgba(0, 0, 0, 0.38);
        }
        * { box-sizing: border-box; }
        html, body { min-height: 100%; }
        body {
            margin: 0;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(229, 57, 53, 0.22), transparent 28%),
                radial-gradient(circle at 85% 10%, rgba(255, 122, 89, 0.16), transparent 20%),
                linear-gradient(180deg, #121214 0%, #09090b 100%);
        }
        a { color: inherit; text-decoration: none; }
        .wrap {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 20px 48px;
            animation: pageReveal 420ms ease both;
        }
        .hero {
            position: relative;
            overflow: hidden;
            padding: 30px;
            border-radius: 24px;
            border: 1px solid var(--border);
            background:
                linear-gradient(135deg, rgba(229, 57, 53, 0.22), rgba(255, 255, 255, 0.05)),
                rgba(255, 255, 255, 0.04);
            box-shadow: var(--shadow);
        }
        .hero::after {
            content: "";
            position: absolute;
            right: -40px;
            top: -40px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(229, 57, 53, 0.28), transparent 68%);
            pointer-events: none;
        }
        .eyebrow {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--muted);
            font-size: 0.9rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        h1 {
            margin: 14px 0 10px;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.05;
        }
        .hero p {
            margin: 0;
            max-width: 68ch;
            color: var(--muted);
            font-size: 1.02rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 22px;
        }
        .stat-card, .link-card {
            border-radius: 22px;
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow);
        }
        .stat-card {
            padding: 22px;
            min-height: 152px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .stat-label {
            color: var(--muted);
            font-size: 0.95rem;
        }
        .stat-value {
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            letter-spacing: -0.04em;
        }
        .stat-note {
            color: var(--muted);
            font-size: 0.95rem;
        }
        .stat-accent { color: #fff; }
        .stat-good { color: #8ef0b4; }
        .links {
            margin-top: 26px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }
        .link-card {
            padding: 22px;
        }
        .link-card h2 {
            margin: 0 0 8px;
            font-size: 1.2rem;
        }
        .link-card p {
            margin: 0 0 16px;
            color: var(--muted);
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-weight: 700;
            transition: transform 180ms ease, background 180ms ease, border-color 180ms ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #7a0c0c);
            color: #fff;
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.08);
        }
        .quick-links {
            margin-top: 26px;
            padding: 22px;
            border-radius: 22px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: var(--shadow);
        }
        .quick-links h2 {
            margin: 0 0 14px;
            font-size: 1.1rem;
        }
        .quick-links .actions a {
            background: rgba(255, 255, 255, 0.08);
        }
        @keyframes pageReveal {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 900px) {
            .stats, .links { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <span class="eyebrow">Área administrativa</span>
            <h1>Dashboard</h1>
            <p>
                Aqui tens uma vista rápida do estado da loja: total de veículos, total de reservas e quantas ainda estão pendentes.
            </p>

            <div class="stats">
                <article class="stat-card">
                    <div class="stat-label">Total de veículos</div>
                    <div class="stat-value stat-accent"><?= number_format($totalVeic, 0, ',', '.') ?></div>
                    <div class="stat-note">Veículos atualmente registados no sistema.</div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Total de reservas</div>
                    <div class="stat-value"><?= number_format($totalRes, 0, ',', '.') ?></div>
                    <div class="stat-note">Reservas criadas por clientes.</div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Reservas pendentes</div>
                    <div class="stat-value stat-good"><?= number_format($pendentes, 0, ',', '.') ?></div>
                    <div class="stat-note">Pedidos à espera de confirmação.</div>
                </article>
            </div>
        </section>

        <section class="links">
            <article class="link-card">
                <h2>Gerir veículos</h2>
                <p>Ir para a secção onde podes ver, adicionar e editar veículos.</p>
                <div class="actions">
                    <a class="btn btn-primary" href="<?= htmlspecialchars($basePath . '/admin/veiculos') ?>">Abrir veículos</a>
                </div>
            </article>

            <article class="link-card">
                <h2>Gerir reservas</h2>
                <p>Consultar reservas, confirmar, cancelar ou tratar pendentes.</p>
                <div class="actions">
                    <a class="btn btn-primary" href="<?= htmlspecialchars($basePath . '/admin/reservas') ?>">Abrir reservas</a>
                    <a class="btn btn-secondary" href="<?= htmlspecialchars($basePath . '/admin') ?>">Voltar ao painel</a>
                </div>
            </article>
        </section>

        <section class="quick-links">
            <h2>Atalhos rápidos</h2>
            <div class="actions">
                <a class="btn btn-secondary" href="<?= htmlspecialchars($basePath . '/admin/veiculos') ?>">Lista de veículos</a>
                <a class="btn btn-secondary" href="<?= htmlspecialchars($basePath . '/admin/reservas') ?>">Lista de reservas</a>
                <a class="btn btn-secondary" href="<?= htmlspecialchars($basePath . '/admin/login') ?>">Login admin</a>
            </div>
        </section>
    </div>
</body>
</html>
