<?php
$basePath = $basePath ?? '';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$total_carrinho = count($_SESSION['carrinho'] ?? []);
?>
<style>
    :root {
        color-scheme: dark;
        --bg: #09090b;
        --surface: rgba(255, 255, 255, 0.05);
        --surface-strong: rgba(255, 255, 255, 0.1);
        --border: rgba(255, 255, 255, 0.12);
        --text: #f7f4ef;
        --muted: #b9bcc4;
        --accent: #d81f26;
        --accent-2: #ff6b61;
        --gold: #c8a76a;
        --shadow: 0 22px 60px rgba(0, 0, 0, 0.42);
    }
    html {
        background:
            radial-gradient(circle at top, rgba(216, 31, 38, 0.16), transparent 30%),
            radial-gradient(circle at 85% 12%, rgba(200, 167, 106, 0.12), transparent 18%),
            radial-gradient(circle at 15% 20%, rgba(255, 255, 255, 0.06), transparent 16%),
            linear-gradient(180deg, #121214 0%, #09090b 100%);
        min-height: 100%;
        scroll-behavior: smooth;
    }
    body {
        background: transparent;
        color: var(--text);
        font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        margin: 0;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        pointer-events: none;
        background:
            radial-gradient(circle at 18% 18%, rgba(255, 255, 255, 0.04), transparent 20%),
            radial-gradient(circle at 82% 14%, rgba(229, 57, 53, 0.08), transparent 18%),
            radial-gradient(circle at 50% 100%, rgba(255, 255, 255, 0.03), transparent 18%);
        opacity: 0.85;
        animation: driftGlow 14s ease-in-out infinite alternate;
    }
    a { color: inherit; }
    .site-header {
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(18px);
        background:
            linear-gradient(180deg, rgba(12, 12, 14, 0.92), rgba(8, 8, 10, 0.76)),
            radial-gradient(circle at 50% 0%, rgba(200, 167, 106, 0.08), transparent 38%);
        border-bottom: 1px solid var(--border);
        box-shadow: var(--shadow);
        animation: headerDrop 420ms ease both;
    }
    .site-header__inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    .brand {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        position: relative;
        padding: 8px 12px 8px 10px;
        border-radius: 18px;
        background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
    }
    .brand-name {
        font-size: clamp(1.1rem, 2vw, 1.5rem);
        font-weight: 800;
        letter-spacing: 0.06em;
        color: #ffffff;
    }
    .brand-text {
        font-size: 0.74rem;
        letter-spacing: 0.28em;
        color: rgba(247, 244, 239, 0.78);
        white-space: nowrap;
        position: relative;
        padding-left: 10px;
    }
    .brand-text::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 1px;
        height: 1.4em;
        background: linear-gradient(180deg, transparent, rgba(200, 167, 106, 0.8), transparent);
        transform: translateY(-50%);
    }
    .nav {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .nav a {
        text-decoration: none;
        padding: 11px 15px;
        border-radius: 999px;
        color: var(--text);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.03));
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: transform 180ms ease, background 180ms ease, border-color 180ms ease, box-shadow 180ms ease;
    }
    .nav a:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, 0.09);
        border-color: rgba(200, 167, 106, 0.28);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.24);
    }
    .nav .nav-accent {
        background: linear-gradient(135deg, var(--accent), #6f0c10 72%, #4c0508);
        box-shadow: 0 12px 28px rgba(216, 31, 38, 0.24);
        border-color: rgba(255, 255, 255, 0.06);
        animation: neonBtnPulse 2.2s ease-in-out infinite;
    }
    .nav .nav-accent:hover {
        border-color: rgba(200, 167, 106, 0.32);
        box-shadow: 0 12px 28px rgba(216, 31, 38, 0.3);
    }
    @keyframes neonBtnPulse {
        0%, 100% { box-shadow: 0 12px 28px rgba(216, 31, 38, 0.24), 0 0 6px rgba(229, 57, 53, 0.5); }
        50% { box-shadow: 0 12px 28px rgba(216, 31, 38, 0.24), 0 0 18px rgba(255, 40, 40, 0.95), 0 0 32px rgba(229, 57, 53, 0.55); }
    }
    @media (prefers-reduced-motion: reduce) {
        .nav .nav-accent { animation: none; }
    }
    .site-shell {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px 32px;
    }
    .site-main {
        animation: pageReveal 480ms ease both;
    }
    @keyframes pageReveal {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes headerDrop {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes driftGlow {
        from { transform: translate3d(0, 0, 0) scale(1); }
        to { transform: translate3d(0, -8px, 0) scale(1.02); }
    }
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation: none !important;
            transition: none !important;
            scroll-behavior: auto !important;
        }
    }
    @media (max-width: 760px) {
        .site-header__inner { flex-direction: column; align-items: center; }
        .brand {
            justify-content: center;
            gap: 8px;
            flex-direction: column;
            padding: 10px 12px 12px;
            text-align: center;
        }
        .nav { justify-content: flex-start; }
        .brand-text {
            font-size: 0.68rem;
            padding-left: 0;
        }
        .brand-text::before { display: none; }
    }
</style>
<header class="site-header">
    <div class="site-header__inner">
        <a href="<?= htmlspecialchars($basePath . '/') ?>" class="brand">
            <span class="brand-name">AutoShop</span>
            <span class="brand-text">Carefully Driven</span>
        </a>
        <nav class="nav">
            <a href="<?= htmlspecialchars($basePath . '/') ?>">Catálogo</a>
            <a href="<?= htmlspecialchars($basePath . '/carrinho') ?>">Lista (<?= $total_carrinho ?>)</a>
            <?php if ($_SESSION['logado'] ?? false): ?>
                <a href="<?= htmlspecialchars($basePath . '/conta') ?>">A minha conta</a>
                <a class="nav-accent" href="<?= htmlspecialchars($basePath . '/logout') ?>">Sair</a>
            <?php else: ?>
                <a class="nav-accent" href="<?= htmlspecialchars($basePath . '/login') ?>">Entrar</a>
            <?php endif ?>
        </nav>
    </div>
</header>
