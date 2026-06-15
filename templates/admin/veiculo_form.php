<?php
$basePath = $basePath ?? '';
$titulo = $titulo ?? 'Veículo';
$erros = $erros ?? [];
$marcas = $marcas ?? [];
$veiculo = $veiculo ?? [];
$modo = $modo ?? (!empty($veiculo['id']) ? 'editar' : 'criar');
$acao = $acao ?? ($modo === 'editar'
    ? $basePath . '/admin/veiculos/editar/' . (int) ($veiculo['id'] ?? 0)
    : $basePath . '/admin/veiculos/criar');
$botaoTexto = $botaoTexto ?? ($modo === 'editar' ? 'Guardar alterações' : 'Criar veículo');

$valor = static function (string $chave, mixed $default = '') use ($veiculo): string {
    if (isset($_POST[$chave])) {
        return (string) $_POST[$chave];
    }
    return isset($veiculo[$chave]) ? (string) $veiculo[$chave] : (string) $default;
};

$imagemAtual = $veiculo['imagem'] ?? '';
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
            --surface: rgba(255, 255, 255, 0.06);
            --surface-strong: rgba(255, 255, 255, 0.1);
            --border: rgba(255, 255, 255, 0.12);
            --text: #f5f5f5;
            --muted: #b8bcc6;
            --accent: #e53935;
            --danger: #ef5350;
            --shadow: 0 24px 60px rgba(0, 0, 0, 0.38);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(229, 57, 53, 0.18), transparent 26%),
                linear-gradient(180deg, #121214 0%, #09090b 100%);
        }
        a { color: inherit; text-decoration: none; }
        .wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 20px 48px;
            animation: reveal 420ms ease both;
        }
        .hero {
            padding: 28px;
            border-radius: 24px;
            border: 1px solid var(--border);
            background:
                linear-gradient(135deg, rgba(229, 57, 53, 0.2), rgba(255, 255, 255, 0.05)),
                rgba(255, 255, 255, 0.04);
            box-shadow: var(--shadow);
        }
        h1 { margin: 0 0 8px; font-size: clamp(2rem, 4vw, 3rem); }
        .hero p { margin: 0; color: var(--muted); }
        .panel {
            margin-top: 20px;
            padding: 24px;
            border-radius: 22px;
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow);
        }
        .errors {
            margin: 0 0 18px;
            padding: 16px 18px;
            border-radius: 18px;
            border: 1px solid rgba(239, 83, 80, 0.28);
            background: rgba(239, 83, 80, 0.12);
            color: #ffd9d9;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .field.full { grid-column: 1 / -1; }
        label {
            font-size: 0.95rem;
            color: var(--muted);
        }
        input, select, textarea {
            width: 100%;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.26);
            color: var(--text);
            outline: none;
        }
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        input:focus, select:focus, textarea:focus {
            border-color: rgba(229, 57, 53, 0.65);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.15);
        }
        .actions {
            margin-top: 20px;
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
            font-weight: 700;
            border: 1px solid transparent;
            cursor: pointer;
            transition: transform 180ms ease, background 180ms ease, border-color 180ms ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #7a0c0c);
            color: #fff;
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.08);
        }
        .image-preview {
            display: grid;
            gap: 12px;
            margin-top: 12px;
        }
        .image-preview img {
            width: 240px;
            max-width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 18px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.05);
        }
        .helper {
            color: var(--muted);
            font-size: 0.9rem;
        }
        .switch {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--muted);
            width: fit-content;
        }
        @keyframes reveal {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 780px) {
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <span class="switch"><?= $modo === 'editar' ? 'Editar veículo' : 'Criar veículo' ?></span>
            <h1><?= htmlspecialchars($titulo) ?></h1>
            <p>Preenche os dados do veículo e faz upload de uma imagem para a ficha ficar completa.</p>
        </section>

        <section class="panel">
            <?php if (!empty($erros)): ?>
                <div class="errors">
                    <strong>Corrige estes pontos:</strong>
                    <ul>
                        <?php foreach ($erros as $erro): ?>
                            <li><?= htmlspecialchars($erro) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= htmlspecialchars($acao) ?>" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">

                <div class="grid">
                    <div class="field">
                        <label for="marca_id">Marca</label>
                        <select id="marca_id" name="marca_id" required>
                            <option value="">Seleciona uma marca</option>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?= (int) $marca['id'] ?>" <?= ($valor('marca_id') == (string) $marca['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($marca['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="modelo">Modelo</label>
                        <input id="modelo" name="modelo" type="text" value="<?= htmlspecialchars($valor('modelo')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="ano">Ano</label>
                        <input id="ano" name="ano" type="number" min="1900" max="2100" value="<?= htmlspecialchars($valor('ano')) ?>" required>
                    </div>

                    <div class="field">
                        <label for="quilometros">Quilómetros</label>
                        <input id="quilometros" name="quilometros" type="number" min="0" step="1" value="<?= htmlspecialchars($valor('quilometros', '0')) ?>">
                    </div>

                    <div class="field">
                        <label for="combustivel">Combustível</label>
                        <select id="combustivel" name="combustivel" required>
                            <?php
                            $combustiveis = ['Gasolina', 'Diesel', 'Eletrico', 'Hibrido'];
                            $combustivelAtual = $valor('combustivel');
                            ?>
                            <option value="">Seleciona</option>
                            <?php foreach ($combustiveis as $combustivel): ?>
                                <option value="<?= htmlspecialchars($combustivel) ?>" <?= $combustivelAtual === $combustivel ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($combustivel) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="cilindrada">Cilindrada</label>
                        <input id="cilindrada" name="cilindrada" type="text" value="<?= htmlspecialchars($valor('cilindrada')) ?>" placeholder="Ex.: 1998 cc">
                    </div>

                    <div class="field">
                        <label for="preco">Preço</label>
                        <input id="preco" name="preco" type="number" min="0" step="0.01" value="<?= htmlspecialchars($valor('preco')) ?>" required>
                    </div>

                    <div class="field full">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao" placeholder="Descreve o estado, extras e observações"><?= htmlspecialchars($valor('descricao')) ?></textarea>
                    </div>

                    <div class="field full">
                        <label for="imagem">Imagem do veículo</label>
                        <input id="imagem" name="imagem" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        <div class="helper">Formatos aceites: JPG, PNG e WEBP. Máximo recomendado: 5MB.</div>

                        <?php if (!empty($imagemAtual)): ?>
                            <div class="image-preview">
                                <div class="helper">Imagem atual</div>
                                <img src="<?= htmlspecialchars($basePath . '/uploads/' . $imagemAtual) ?>" alt="Imagem atual do veículo">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit"><?= htmlspecialchars($botaoTexto) ?></button>
                    <a class="btn btn-secondary" href="<?= htmlspecialchars($basePath . '/admin/veiculos') ?>">Voltar à lista</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
