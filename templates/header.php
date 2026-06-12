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
        --bg: #0b0b0d;
        --surface: rgba(255, 255, 255, 0.06);
        --surface-strong: rgba(255, 255, 255, 0.1);
        --border: rgba(255, 255, 255, 0.12);
        --text: #f5f5f5;
        --muted: #b9bcc4;
        --accent: #e53935;
        --accent-2: #ff6f61;
        --shadow: 0 18px 50px rgba(0, 0, 0, 0.35);
    }
    html {
        background:
            radial-gradient(circle at top, rgba(229, 57, 53, 0.2), transparent 34%),
            radial-gradient(circle at 85% 12%, rgba(255, 255, 255, 0.08), transparent 20%),
            linear-gradient(180deg, #121214 0%, #09090b 100%);
        min-height: 100%;
    }
    body {
        background: transparent;
        color: var(--text);
        font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        margin: 0;
        min-height: 100vh;
    }
    a { color: inherit; }
    .site-header {
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(16px);
        background: rgba(8, 8, 10, 0.8);
        border-bottom: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    .site-header__inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
    }
    .brand {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .brand-mark {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent), #6f0000);
        box-shadow: 0 10px 30px rgba(229, 57, 53, 0.35);
    }
    .brand span { font-size: 1rem; }
    .nav {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .nav a {
        text-decoration: none;
        padding: 10px 14px;
        border-radius: 999px;
        color: var(--text);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid transparent;
        transition: transform 180ms ease, background 180ms ease, border-color 180ms ease;
    }
    .nav a:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.12);
    }
    .nav .nav-accent {
        background: linear-gradient(135deg, var(--accent), #7a0c0c);
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
    @media (max-width: 760px) {
        .site-header__inner { flex-direction: column; align-items: flex-start; }
        .nav { justify-content: flex-start; }
    }
</style>
<header class="site-header">
    <div class="site-header__inner">
        <a href="<?= htmlspecialchars($basePath . '/') ?>" class="brand">
            <span class="brand-mark" aria-hidden="true"></span>
            <span>AutoShop</span>
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
