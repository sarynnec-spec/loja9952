<?php
$basePath = $basePath ?? '';
$titulo = $titulo ?? 'Gerir Veículos';
$veiculos = $veiculos ?? [];
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
            --border: rgba(255, 255, 255, 0.12);
            --text: #f5f5f5;
            --muted: #b8bcc6;
            --accent: #e53935;
            --accent-2: #ff7a59;
            --danger: #ef5350;
            --shadow: 0 24px 60px rgba(0, 0, 0, 0.38);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(229, 57, 53, 0.18), transparent 28%),
                linear-gradient(180deg, #121214 0%, #09090b 100%);
        }
        a { color: inherit; text-decoration: none; }
        .wrap {
            max-width: 1180px;
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
        .toolbar {
            margin: 18px 0 22px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            justify-content: space-between;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border-radius: 999px;
            font-weight: 700;
            border: 1px solid transparent;
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
        .table-wrap {
            margin-top: 18px;
            overflow-x: auto;
            border-radius: 22px;
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 980px;
        }
        thead th {
            text-align: left;
            padding: 16px;
            font-size: 0.9rem;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.03);
        }
        tbody td {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
        }
        tbody tr:hover { background: rgba(255, 255, 255, 0.03); }
        .thumb {
            width: 80px;
            height: 54px;
            border-radius: 12px;
            object-fit: cover;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .badge {
            display: inline-flex;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 0.86rem;
            background: rgba(255, 255, 255, 0.08);
            color: var(--muted);
        }
        .badge-on { color: #8ef0b4; }
        .badge-off { color: #ff9d9d; }
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-edit {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.08);
        }
        .btn-delete {
            background: rgba(239, 83, 80, 0.14);
            border-color: rgba(239, 83, 80, 0.25);
            color: #ffd7d7;
        }
        .empty {
            padding: 22px;
            color: var(--muted);
        }
        @keyframes reveal {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 760px) {
            .toolbar { align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <h1>Gerir veículos</h1>
            <p>Tabela de veículos com ações rápidas para editar, apagar e adicionar novos registos.</p>
        </section>

        <div class="toolbar">
            <div class="badge"><?= count($veiculos) ?> veículo(s)</div>
            <a class="btn btn-primary" href="<?= htmlspecialchars($basePath . '/admin/veiculos/criar') ?>">Adicionar novo</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Quilómetros</th>
                        <th>Combustível</th>
                        <th>Preço</th>
                        <th>Disponível</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($veiculos)): ?>
                        <tr>
                            <td class="empty" colspan="9">Ainda não existem veículos para mostrar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($veiculos as $v): ?>
                            <?php
                                $id = (int) ($v['id'] ?? 0);
                                $imagem = trim((string) ($v['imagem'] ?? ''));
                                $imagemSrc = $imagem !== ''
                                    ? htmlspecialchars($basePath . '/uploads/' . $imagem)
                                    : 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2280%22%20height%3D%2254%22%20viewBox%3D%220%200%2080%2054%22%3E%3Crect%20fill%3D%22%2316161a%22%20width%3D%2280%22%20height%3D%2254%22/%3E%3C/svg%3E';
                            ?>
                            <tr>
                                <td>
                                    <img class="thumb" src="<?= $imagemSrc ?>" alt="<?= htmlspecialchars(($v['marca'] ?? '') . ' ' . ($v['modelo'] ?? '')) ?>">
                                </td>
                                <td><?= htmlspecialchars((string) ($v['marca'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($v['modelo'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($v['ano'] ?? '')) ?></td>
                                <td><?= number_format((float) ($v['quilometros'] ?? 0), 0, ',', '.') ?> km</td>
                                <td><?= htmlspecialchars((string) ($v['combustivel'] ?? '')) ?></td>
                                <td>€ <?= number_format((float) ($v['preco'] ?? 0), 2, ',', '.') ?></td>
                                <td>
                                    <?php if (!empty($v['disponivel'])): ?>
                                        <span class="badge badge-on">Disponível</span>
                                    <?php else: ?>
                                        <span class="badge badge-off">Indisponível</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-edit" href="<?= htmlspecialchars($basePath . '/admin/veiculos/editar/' . $id) ?>">Editar</a>
                                        <form method="POST" action="<?= htmlspecialchars($basePath . '/admin/veiculos/apagar/' . $id) ?>" style="margin:0;" onsubmit="return confirm('Tens a certeza que queres apagar este veículo?')">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
                                            <button class="btn btn-delete" type="submit">Apagar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
