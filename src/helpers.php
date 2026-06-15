<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_validar(): void
{
    $token = (string) ($_POST['csrf_token'] ?? '');

    if (!hash_equals(csrf_token(), $token)) {
        http_response_code(419);
        exit('CSRF token invalido.');
    }
}

function veiculo_imagem_profissional(array $veiculo, string $projectPath = ''): string
{
    $arquivo = (string) ($veiculo['imagem'] ?? '');
    if ($arquivo !== '') {
        $prefixo = rtrim($projectPath, '/');
        return $prefixo . '/uploads/' . rawurlencode($arquivo);
    }

    $marca = strtolower(trim((string) ($veiculo['marca'] ?? '')));
    $modelo = strtolower(trim((string) ($veiculo['modelo'] ?? '')));
    $texto = trim($marca . ' ' . $modelo);

    $mapa = [
        'bmw serie 3 320d' => ['#0f172a', '#d1d5db', '#93c5fd'],
        'bmw x5 xdrive30d' => ['#111827', '#f8fafc', '#60a5fa'],
        'mercedes-benz classe c 220d' => ['#111111', '#f8fafc', '#cbd5e1'],
        'audi a4 35 tdi' => ['#0b1220', '#e5e7eb', '#f97316'],
        'volkswagen golf 8 gti' => ['#111827', '#f8fafc', '#ef4444'],
        'toyota yaris gr' => ['#0f172a', '#f8fafc', '#22c55e'],
        'renault megane e-tech' => ['#0b1020', '#f8fafc', '#a855f7'],
        'peugeot e-2008' => ['#111827', '#f8fafc', '#38bdf8'],
        'ford mustang mach-e' => ['#0b0f19', '#f8fafc', '#fb7185'],
        'volkswagen t-roc 1.5 tsi' => ['#111827', '#f8fafc', '#f59e0b'],
    ];

    if (isset($mapa[$texto])) {
        $cores = $mapa[$texto];
    } elseif (str_contains($texto, 'bmw')) {
        $cores = ['#0f172a', '#d1d5db', '#93c5fd'];
    } elseif (str_contains($texto, 'mercedes')) {
        $cores = ['#111111', '#f8fafc', '#cbd5e1'];
    } elseif (str_contains($texto, 'audi')) {
        $cores = ['#0b1220', '#e5e7eb', '#f97316'];
    } elseif (str_contains($texto, 'volkswagen')) {
        $cores = ['#111827', '#f8fafc', '#ef4444'];
    } elseif (str_contains($texto, 'toyota')) {
        $cores = ['#0f172a', '#f8fafc', '#22c55e'];
    } elseif (str_contains($texto, 'renault')) {
        $cores = ['#0b1020', '#f8fafc', '#a855f7'];
    } elseif (str_contains($texto, 'peugeot')) {
        $cores = ['#111827', '#f8fafc', '#38bdf8'];
    } elseif (str_contains($texto, 'ford')) {
        $cores = ['#0b0f19', '#f8fafc', '#fb7185'];
    } else {
        $cores = ['#111827', '#f8fafc', '#e11d48'];
    }

    [$bg, $body, $accent] = $cores;
    $label = strtoupper(trim($marca . ' ' . $modelo));
    $label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1600" height="900" viewBox="0 0 1600 900">
  <defs>
    <linearGradient id="bg" x1="0" x2="1" y1="0" y2="1">
      <stop offset="0" stop-color="{$bg}" stop-opacity="0"/>
      <stop offset="1" stop-color="{$bg}" stop-opacity="0"/>
    </linearGradient>
    <linearGradient id="body" x1="0" x2="1" y1="0" y2="1">
      <stop offset="0" stop-color="{$body}" stop-opacity="0.98"/>
      <stop offset="1" stop-color="#d4d4d8" stop-opacity="0.82"/>
    </linearGradient>
    <linearGradient id="shine" x1="0" x2="1" y1="0" y2="0">
      <stop offset="0" stop-color="#ffffff" stop-opacity="0"/>
      <stop offset="0.5" stop-color="#ffffff" stop-opacity="0.22"/>
      <stop offset="1" stop-color="#ffffff" stop-opacity="0"/>
    </linearGradient>
    <radialGradient id="glow" cx="50%" cy="38%" r="60%">
      <stop offset="0" stop-color="{$accent}" stop-opacity="0.18"/>
      <stop offset="1" stop-color="{$accent}" stop-opacity="0"/>
    </radialGradient>
    <filter id="shadow" x="-30%" y="-30%" width="160%" height="160%">
      <feDropShadow dx="0" dy="28" stdDeviation="18" flood-color="#000000" flood-opacity="0.42"/>
    </filter>
  </defs>
  <rect width="1600" height="900" fill="url(#bg)"/>
  <ellipse cx="800" cy="590" rx="430" ry="120" fill="#000" fill-opacity="0.26"/>
  <ellipse cx="800" cy="360" rx="520" ry="260" fill="url(#glow)"/>
  <g transform="translate(175 165)" filter="url(#shadow)">
    <path d="M240 450c0-48 34-89 80-98l88-18 78-86c21-23 51-36 82-36h196c36 0 70 17 91 46l54 74 96 21c48 10 83 52 83 101v68H240v-72z" fill="url(#body)"/>
    <path d="M353 252h480c24 0 46 11 61 29l45 54H297l19-29c14-33 47-54 77-54z" fill="#ffffff" fill-opacity="0.22"/>
    <path d="M309 303h650c20 0 38 11 49 29l34 54H258l18-31c13-32 40-52 64-52z" fill="#111827" fill-opacity="0.45"/>
    <path d="M356 268h392c18 0 34 8 46 21l21 23H336l7-9c6-22 14-35 13-35z" fill="#ffffff" fill-opacity="0.14"/>
    <path d="M612 219h111c21 0 40 8 55 23l30 30H566l16-20c12-21 19-33 30-33z" fill="#ffffff" fill-opacity="0.18"/>
    <rect x="328" y="308" width="116" height="88" rx="18" fill="#0b1020" fill-opacity="0.82"/>
    <rect x="447" y="308" width="124" height="88" rx="18" fill="#0b1020" fill-opacity="0.82"/>
    <rect x="574" y="308" width="128" height="88" rx="18" fill="#0b1020" fill-opacity="0.82"/>
    <rect x="706" y="308" width="130" height="88" rx="18" fill="#0b1020" fill-opacity="0.82"/>
    <circle cx="394" cy="486" r="76" fill="#0a0a0a"/>
    <circle cx="394" cy="486" r="40" fill="#cbd5e1"/>
    <circle cx="901" cy="486" r="76" fill="#0a0a0a"/>
    <circle cx="901" cy="486" r="40" fill="#cbd5e1"/>
    <rect x="240" y="444" width="781" height="18" rx="9" fill="#1f2937" fill-opacity="0.66"/>
    <rect x="284" y="287" width="742" height="10" rx="5" fill="url(#shine)"/>
    <path d="M370 452c0 31 25 56 56 56h56c31 0 56-25 56-56v-18H370v18zm523 0c0 31 25 56 56 56h56c31 0 56-25 56-56v-18H893v18z" fill="#111827" fill-opacity="0.56"/>
    <path d="M296 330h704" stroke="{$accent}" stroke-opacity="0.55" stroke-width="6" stroke-linecap="round"/>
    <path d="M336 347h626" stroke="#ffffff" stroke-opacity="0.16" stroke-width="3" stroke-linecap="round"/>
    <text x="800" y="738" text-anchor="middle" font-family="Inter, Arial, sans-serif" font-size="44" font-weight="700" fill="#ffffff" fill-opacity="0.82">{$label}</text>
  </g>
</svg>
SVG;

    return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
}
