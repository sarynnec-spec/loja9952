<?php
$basePath = $basePath ?? '';
$erros = $erros ?? [];
$nome = $nome ?? ($_POST['nome'] ?? '');
$email = $email ?? ($_POST['email'] ?? '');
$telefone = $telefone ?? ($_POST['telefone'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'Registar') ?></title>
    <style>
        .auth-wrap {
            display: grid;
            place-items: center;
            min-height: calc(100vh - 120px);
            padding: 28px 0;
        }
        .auth-box {
            width: min(100%, 620px);
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            box-shadow: var(--shadow);
            animation: floatUp 500ms ease both;
        }
        .eyebrow {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(229, 57, 53, 0.18);
            border: 1px solid rgba(229, 57, 53, 0.35);
            margin-bottom: 14px;
        }
        .campo { margin-bottom: 14px; }
        .campo label { display: block; font-weight: 700; margin-bottom: 6px; }
        .campo input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-sizing: border-box;
            background: rgba(0, 0, 0, 0.28);
            color: var(--text);
        }
        .btn {
            background: linear-gradient(135deg, var(--accent), #6f0000);
            color: #fff;
            border: none;
            padding: 12px 18px;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 700;
        }
        .erro {
            color: #ffb4b0;
            background: rgba(229, 57, 53, 0.12);
            border: 1px solid rgba(229, 57, 53, 0.35);
            padding: 12px 14px;
            border-radius: 12px;
            margin: 0 0 14px;
        }
        .link-alt {
            margin-top: 14px;
            display: inline-block;
            color: var(--muted);
            text-decoration: none;
        }
        .link-alt:hover { color: #fff; }
        h1 { margin: 0 0 18px; font-size: 2rem; }
    </style>
</head>
<body>
    <?php require __DIR__ . '/../header.php'; ?>
    <div class="site-shell site-main auth-wrap">
        <div class="auth-box">
            <span class="eyebrow">Novo cliente</span>
            <h1>Criar conta</h1>

            <?php foreach ($erros as $erro): ?>
                <p class="erro"><?= htmlspecialchars($erro) ?></p>
            <?php endforeach; ?>

            <form method="POST" action="<?= htmlspecialchars($basePath . '/registar') ?>">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input id="nome" type="text" name="nome" value="<?= htmlspecialchars((string) $nome) ?>" required>
                </div>
                <div class="campo">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?= htmlspecialchars((string) $email) ?>" required>
                </div>
                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" type="text" name="telefone" value="<?= htmlspecialchars((string) $telefone) ?>">
                </div>
                <div class="campo">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div class="campo">
                    <label for="password2">Confirmar password</label>
                    <input id="password2" type="password" name="password2" required>
                </div>
                <button type="submit" class="btn">Registar</button>
            </form>

            <a class="link-alt" href="<?= htmlspecialchars($basePath . '/login') ?>">Já tens conta? Fazer login</a>
        </div>
    </div>
</body>
</html>
