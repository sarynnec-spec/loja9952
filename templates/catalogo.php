<?php
$basePath = $basePath ?? '';
$projectPath = $projectPath ?? preg_replace('#/public$#', '', $basePath) ?: '';
$placeholder = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22600%22%20height%3D%22360%22%20viewBox%3D%220%200%20600%20360%22%3E%3Cdefs%3E%3ClinearGradient%20id%3D%22g%22%20x1%3D%220%25%22%20x2%3D%22100%25%22%20y1%3D%220%25%22%20y2%3D%22100%25%22%3E%3Cstop%20stop-color%3D%22%23111114%22/%3E%3Cstop%20offset%3D%221%22%20stop-color%3D%22%23202026%22/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect%20fill%3D%22url(%23g)%22%20width%3D%22600%22%20height%3D%22360%22/%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-family%3D%22Arial%22%20font-size%3D%2224%22%20fill%3D%22%23ffffff%22%3ESem%20imagem%3C/text%3E%3C/svg%3E';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
    <style>
        .hero {
            display: none;
        }
        .intro-screen {
            position: relative;
            min-height: 100vh;
            display: grid;
            align-items: end;
            width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            margin-bottom: 28px;
            padding: 0;
            overflow: hidden;
            border-radius: 0;
            z-index: 0;
        }
        .intro-media {
            position: absolute;
            inset: 0;
            width: 100%;
            min-height: 100%;
            border-radius: 0;
            overflow: hidden;
            border: none;
            box-shadow: none;
            background: #050505;
            z-index: -1;
            pointer-events: none;
        }
        .intro-media video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: contrast(1.1) saturate(1.05) brightness(0.75);
        }
        .intro-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 45%, rgba(0, 0, 0, 0.55) 78%, rgba(0, 0, 0, 0.86) 100%);
            pointer-events: none;
        }
        .intro-content {
            position: relative;
            z-index: 1;
            max-width: 560px;
            padding: clamp(20px, 4vw, 48px);
            padding-bottom: clamp(28px, 5vw, 52px);
            display: flex;
            flex-direction: column;
            text-shadow: 0 2px 24px rgba(0, 0, 0, 0.82);
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            margin-bottom: 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.06);
            color: #f5d6d5;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-size: 0.74rem;
        }
        .eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
            box-shadow: 0 0 18px rgba(229, 57, 53, 0.8);
        }
        .intro-content h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 4.2vw, 3.4rem);
            line-height: 0.98;
            letter-spacing: -0.04em;
            text-transform: uppercase;
            color: #fff;
            animation: neonPulse 2.4s ease-in-out infinite;
        }
        @keyframes neonPulse {
            0%, 100% {
                text-shadow:
                    0 0 6px rgba(255, 60, 60, 0.9),
                    0 0 16px rgba(255, 30, 30, 0.8),
                    0 0 32px rgba(229, 57, 53, 0.7),
                    0 0 60px rgba(229, 57, 53, 0.5),
                    0 14px 50px rgba(0, 0, 0, 0.5);
            }
            50% {
                text-shadow:
                    0 0 10px rgba(255, 90, 90, 1),
                    0 0 26px rgba(255, 40, 40, 0.95),
                    0 0 48px rgba(229, 57, 53, 0.85),
                    0 0 90px rgba(229, 57, 53, 0.65),
                    0 14px 50px rgba(0, 0, 0, 0.5);
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .intro-content h1 { animation: none; }
        }
        .intro-content p {
            margin: 0 0 20px;
            color: rgba(247, 244, 239, 0.86);
            max-width: 52ch;
            font-size: 0.98rem;
            line-height: 1.55;
        }
        .intro-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .intro-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 18px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.14);
        }
        .intro-actions .primary {
            background: linear-gradient(135deg, var(--accent), #6f0000);
            color: #fff;
            box-shadow: 0 14px 36px rgba(229, 57, 53, 0.28);
        }
        .intro-actions .secondary {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text);
        }
        .intro-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }
        .intro-badge {
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(247, 244, 239, 0.82);
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }
        .hero::after {
            content: "";
            position: absolute;
            inset: auto -20px -40px auto;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(229, 57, 53, 0.42), transparent 68%);
            pointer-events: none;
            filter: blur(2px);
        }
        .hero::before {
            content: "";
            position: absolute;
            inset: 12px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 0 0 1px rgba(229, 57, 53, 0.12);
            pointer-events: none;
        }
        .hero h1 { margin: 0 0 8px; font-size: clamp(2rem, 4vw, 3.4rem); }
        .hero p { margin: 0; color: var(--muted); max-width: 70ch; }
        .filtros-toggle-input { display: none; }
        .filtros-toggle-label { display: none; }
        .filtros {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin: 18px 0 28px;
            padding: 18px;
            border-radius: 18px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: var(--shadow);
        }
        @media (max-width: 760px) {
            .filtros-toggle-label {
                display: block;
                margin: 18px 0 0;
                padding: 14px 18px;
                border-radius: 18px;
                border: 1px solid var(--border);
                background: rgba(255, 255, 255, 0.06);
                color: var(--text);
                font-weight: 700;
                cursor: pointer;
                text-align: center;
            }
            .filtros {
                max-height: 0;
                opacity: 0;
                overflow: hidden;
                margin: 0;
                padding: 0 18px;
                border-width: 0;
                transition: max-height 280ms ease, opacity 220ms ease, padding 280ms ease, margin 280ms ease;
            }
            .filtros-toggle-input:checked ~ .filtros {
                max-height: 600px;
                opacity: 1;
                margin: 10px 0 28px;
                padding: 18px;
                border-width: 1px;
            }
        }
        .filtros input, .filtros select {
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.28);
            color: var(--text);
            min-width: 170px;
        }
        .filtros button, .filtros a {
            padding: 12px 16px;
            border-radius: 999px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-weight: 700;
        }
        .filtros button { background: linear-gradient(135deg, var(--accent), #7a0c0c); color: #fff; }
        .filtros a { background: rgba(255, 255, 255, 0.08); color: var(--text); }
        .meta { color: var(--muted); margin-bottom: 18px; }
        .grelha { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 20px; }
        .card {
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.06);
            box-shadow:
                0 0 0 1px rgba(229, 57, 53, 0.14),
                0 18px 40px rgba(0, 0, 0, 0.42);
            transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease, filter 220ms ease;
            animation: floatUp 500ms ease both;
            transform-style: preserve-3d;
            position: relative;
        }
        .card:hover {
            transform: translateY(-8px) perspective(900px) rotateX(2deg);
            border-color: rgba(229, 57, 53, 0.62);
            box-shadow:
                0 0 0 1px rgba(229, 57, 53, 0.34),
                0 0 28px rgba(229, 57, 53, 0.22),
                0 30px 70px rgba(0, 0, 0, 0.58);
            filter: saturate(1.06);
        }
        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 35%, rgba(0, 0, 0, 0.28));
            pointer-events: none;
        }
        .card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: #111;
            filter: contrast(1.08) saturate(1.08);
            transition: transform 320ms ease, filter 320ms ease;
        }
        .card:hover img {
            transform: scale(1.05);
            filter: contrast(1.12) saturate(1.18);
        }
        .card-body { padding: 16px; }
        .card-body h3 { margin: 0 0 6px; font-size: 1.1rem; }
        .card-body p { color: var(--muted); margin: 0 0 12px; }
        .preco { font-size: 1.35rem; font-weight: 800; color: #fff; animation: precoGlow 2.6s ease-in-out infinite; }
        .preco span { color: var(--accent); }
        @keyframes precoGlow {
            0%, 100% { text-shadow: 0 0 8px rgba(229, 57, 53, 0.35); }
            50% { text-shadow: 0 0 18px rgba(255, 50, 50, 0.75), 0 0 34px rgba(229, 57, 53, 0.4); }
        }
        .detalhe, .btn-carrinho {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 0.92rem;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .detalhe {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
        }
        .btn-carrinho {
            background: linear-gradient(135deg, var(--accent), #6f0000);
            color: #fff;
            animation: btnNeon 2.2s ease-in-out infinite;
        }
        @keyframes btnNeon {
            0%, 100% { box-shadow: 0 0 6px rgba(229, 57, 53, 0.5), 0 4px 14px rgba(0, 0, 0, 0.3); }
            50% { box-shadow: 0 0 18px rgba(255, 40, 40, 0.95), 0 0 34px rgba(229, 57, 53, 0.55), 0 4px 14px rgba(0, 0, 0, 0.3); }
        }
        @media (prefers-reduced-motion: reduce) {
            .preco, .btn-carrinho { animation: none; }
        }
        .acoes-card { display: flex; gap: 10px; flex-wrap: wrap; }
        .empty {
            padding: 22px;
            border-radius: 18px;
            border: 1px dashed var(--border);
            color: var(--muted);
            background: rgba(255, 255, 255, 0.04);
        }
        @keyframes floatUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
        @media (max-width: 760px) {
            .intro-content {
                padding: 20px;
                padding-bottom: 28px;
            }
            .intro-content h1 {
                font-size: clamp(1.8rem, 10vw, 2.8rem);
            }
        }
        .site-shell.site-main {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>
    <div class="site-shell site-main">
        <section class="intro-screen" aria-label="Apresentação inicial">
            <div class="intro-media">
                <video autoplay muted loop playsinline preload="auto">
                    <source src="<?= htmlspecialchars($basePath . '/uploads/luxury_car_intro.mp4') ?>" type="video/mp4">
                </video>
                <div class="intro-overlay"></div>
                <div class="intro-content">
                    <div class="eyebrow">Luxury Car Dealership</div>
                    <h1>AutoShop</h1>
                    <p>Viaturas premium selecionadas e inspecionadas, prontas para entrega imediata. Visita o nosso stand ou reserva o teu próximo carro em poucos cliques.</p>
                    <div class="intro-actions">
                        <a class="primary" href="#catalogo">Explorar catálogo</a>
                        <a class="secondary" href="<?= htmlspecialchars($basePath . '/carrinho') ?>">Ver lista</a>
                    </div>
                    <div class="intro-badges">
                        <span class="intro-badge">Viaturas inspecionadas</span>
                        <span class="intro-badge">Stand físico e online</span>
                        <span class="intro-badge">Reserva sem compromisso</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="hero" id="catalogo">
            <h1>AutoShop</h1>
            <p>Descobre a nossa seleção de veículos e encontra o carro certo para ti.</p>
        </section>

        <div class="filtros-wrap">
        <input type="checkbox" id="filtros-toggle" class="filtros-toggle-input">
        <label for="filtros-toggle" class="filtros-toggle-label">Filtros ▾</label>
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
                <option <?= (($_GET['combustivel'] ?? '') === $c) ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                <?php endforeach ?>
            </select>
            <input type="number" name="preco_max" placeholder="Preço máximo (EUR)" value="<?= htmlspecialchars($_GET['preco_max'] ?? '') ?>">
            <input type="number" name="ano_min" placeholder="Ano mínimo" value="<?= htmlspecialchars($_GET['ano_min'] ?? '') ?>">
            <input type="text" name="pesquisa" placeholder="Pesquisar modelo..." value="<?= htmlspecialchars($_GET['pesquisa'] ?? '') ?>">
            <button type="submit">Filtrar</button>
            <a href="<?= htmlspecialchars($basePath . '/') ?>">Limpar</a>
        </form>
        </div>

        <p class="meta"><?= count($veiculos) ?> veículo(s) encontrado(s)</p>

        <?php if (empty($veiculos)): ?>
            <div class="empty">Nenhum veículo corresponde aos filtros selecionados.</div>
        <?php else: ?>
        <div class="grelha">
        <?php foreach ($veiculos as $v): ?>
            <?php $imagem = function_exists('veiculo_imagem_profissional') ? veiculo_imagem_profissional($v, $projectPath) : $placeholder; ?>
            <article class="card" style="animation-delay: <?= (int) ($v['id'] % 8) * 45 ?>ms">
                <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($v['marca'] . ' ' . $v['modelo']) ?>">
                <div class="card-body">
                    <h3><?= htmlspecialchars($v['marca'] . ' ' . $v['modelo']) ?></h3>
                    <p>
                        <?= (int) $v['ano'] ?> ·
                        <?= number_format((float) $v['quilometros'], 0, '.', '.') ?> km ·
                        <?= htmlspecialchars((string) $v['combustivel']) ?>
                    </p>
                    <div class="preco"><span>€</span> <?= number_format((float) $v['preco'], 2, ',', '.') ?></div>
                    <div class="acoes-card">
                        <a class="detalhe" href="<?= htmlspecialchars($basePath . '/veiculo/detalhe/' . (int) $v['id']) ?>">Ver detalhe</a>
                        <form method="POST" action="<?= htmlspecialchars($basePath . '/carrinho/adicionar') ?>" style="margin:0;">
                            <input type="hidden" name="veiculo_id" value="<?= (int) $v['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <button type="submit" class="btn-carrinho">Reservar veículo</button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
        </div>
        <?php endif ?>
    </div>
</body>
</html>
