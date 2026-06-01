<?php
$basePath = $basePath ?? '';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$total_carrinho = count($_SESSION['carrinho'] ?? []);
?>
<header style="background:#1A237E;color:#fff;padding:14px 24px;display:flex;justify-content:space-between;align-items:center;">
    <a href="<?= htmlspecialchars($basePath . '/') ?>" style="color:#fff;font-size:1.3rem;font-weight:bold;text-decoration:none;">🚗 AutoShop</a>
    <nav style="display:flex;gap:20px;align-items:center;">
        <a href="<?= htmlspecialchars($basePath . '/') ?>" style="color:#fff;text-decoration:none;">Catálogo</a>
        <a href="<?= htmlspecialchars($basePath . '/carrinho') ?>" style="color:#fff;text-decoration:none;">
            🛒 Lista (<?= $total_carrinho ?>)
        </a>
        <?php if ($_SESSION['logado'] ?? false): ?>
            <a href="<?= htmlspecialchars($basePath . '/conta') ?>" style="color:#fff;text-decoration:none;">A minha conta</a>
            <a href="<?= htmlspecialchars($basePath . '/logout') ?>" style="color:#ccc;text-decoration:none;">Sair</a>
        <?php else: ?>
            <a href="<?= htmlspecialchars($basePath . '/login') ?>" style="color:#fff;text-decoration:none;">Entrar</a>
        <?php endif ?>
    </nav>
</header>
