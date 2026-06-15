<?php
$basePath = $basePath ?? '';
$titulo = $titulo ?? 'Gerir Reservas';
$reservas = $reservas ?? [];
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
        .badge {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--muted);
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
            min-width: 1000px;
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
            vertical-align: top;
        }
        tbody tr:hover { background: rgba(255, 255, 255, 0.03); }
        .state-form {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }
        select {
            padding: 11px 12px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.26);
            color: var(--text);
        }
        .pill {
            display: inline-flex;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: var(--muted);
            font-size: 0.88rem;
        }
        .status-pendente { color: #ffd27d; }
        .status-confirmada { color: #8ef0b4; }
        .status-cancelada { color: #ff9d9d; }
        .empty {
            padding: 22px;
            color: var(--muted);
        }
        @keyframes reveal {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <h1>Gerir reservas</h1>
            <p>Tabela de reservas com cliente, veículo, estado e data. Podes mudar o estado diretamente na linha.</p>
        </section>

        <div class="toolbar">
            <div class="badge"><?= count($reservas) ?> reserva(s)</div>
            <a class="btn btn-primary" href="<?= htmlspecialchars($basePath . '/admin/dashboard') ?>">Voltar ao dashboard</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Veículo</th>
                        <th>Estado</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reservas)): ?>
                        <tr>
                            <td class="empty" colspan="5">Ainda não existem reservas para mostrar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reservas as $r): ?>
                            <?php
                                $estado = (string) ($r['estado'] ?? 'pendente');
                                $id = (int) ($r['id'] ?? 0);
                                $data = !empty($r['criado_em']) ? date('d/m/Y H:i', strtotime((string) $r['criado_em'])) : '-';
                            ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars((string) ($r['cliente'] ?? '')) ?></strong><br>
                                    <span class="pill"><?= htmlspecialchars((string) ($r['email'] ?? '')) ?></span><br>
                                    <span class="pill"><?= htmlspecialchars((string) ($r['telefone'] ?? '')) ?></span>
                                </td>
                                <td>
                                    <?= htmlspecialchars((string) ($r['marca'] ?? '')) ?> <?= htmlspecialchars((string) ($r['modelo'] ?? '')) ?><br>
                                    <span class="pill"><?= htmlspecialchars((string) ($r['ano'] ?? '')) ?></span><br>
                                    <span class="pill">€ <?= number_format((float) ($r['preco'] ?? 0), 2, ',', '.') ?></span>
                                </td>
                                <td>
                                    <span class="pill status-<?= htmlspecialchars($estado) ?>"><?= htmlspecialchars(ucfirst($estado)) ?></span>
                                </td>
                                <td><?= htmlspecialchars($data) ?></td>
                                <td>
                                    <form class="state-form" method="POST" action="<?= htmlspecialchars($basePath . '/admin/reservas/estado') ?>">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
                                        <input type="hidden" name="reserva_id" value="<?= $id ?>">
                                        <select name="estado">
                                            <option value="pendente" <?= $estado === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                            <option value="confirmada" <?= $estado === 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
                                            <option value="cancelada" <?= $estado === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                        </select>
                                        <button class="btn btn-secondary" type="submit">Atualizar</button>
                                    </form>
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
