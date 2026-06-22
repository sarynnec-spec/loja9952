<?php
$basePath = $basePath ?? '';
$titulo = $titulo ?? 'Administração — Login';
$erro = $erro ?? '';
$email = $email ?? ($_POST['email'] ?? '');
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
            --border: rgba(255, 255, 255, 0.12);
            --text: #f5f5f5;
            --muted: #b8bcc6;
            --accent: #e53935;
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
        .auth-wrap {
            display: grid;
            place-items: center;
            min-height: 100vh;
            padding: 28px 20px;
        }
        .auth-box {
            width: min(100%, 420px);
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }
        .eyebrow {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(229, 57, 53, 0.18);
            border: 1px solid rgba(229, 57, 53, 0.35);
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 14px;
        }
        h1 { margin: 0 0 18px; font-size: 1.8rem; }
        .campo { margin-bottom: 14px; }
        .campo label { display: block; font-weight: 700; margin-bottom: 6px; }
        .campo input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.28);
            color: var(--text);
        }
        .btn {
            width: 100%;
            background: linear-gradient(135deg, var(--accent), #6f0000);
            color: #fff;
            border: none;
            padding: 12px 18px;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1rem;
            animation: neonBtnPulse 2.2s ease-in-out infinite;
        }
        @keyframes neonBtnPulse {
            0%, 100% { box-shadow: 0 0 6px rgba(229, 57, 53, 0.5); }
            50% { box-shadow: 0 0 18px rgba(255, 40, 40, 0.95), 0 0 32px rgba(229, 57, 53, 0.55); }
        }
        @media (prefers-reduced-motion: reduce) {
            .btn { animation: none; }
        }
        .erro {
            padding: 12px 14px;
            border-radius: 12px;
            margin: 0 0 14px;
            color: #ffb4b0;
            background: rgba(229, 57, 53, 0.12);
            border: 1px solid rgba(229, 57, 53, 0.35);
        }
        .link-alt {
            display: inline-block;
            margin-top: 16px;
            color: var(--muted);
        }
        .link-alt:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-box">
            <span class="eyebrow">Área administrativa</span>
            <h1>Login admin</h1>

            <?php if ($erro): ?>
                <p class="erro"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <form method="POST" action="<?= htmlspecialchars($basePath . '/admin/login') ?>">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="campo">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?= htmlspecialchars((string) $email) ?>" required>
                </div>
                <div class="campo">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button type="submit" class="btn">Entrar</button>
            </form>

            <a class="link-alt" href="<?= htmlspecialchars($basePath . '/') ?>">&larr; Voltar ao site</a>
        </div>
    </div>
</body>
</html>
