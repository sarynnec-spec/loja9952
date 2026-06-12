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

    $mapaExato = [
        'bmw serie 3 320d' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1400&q=80',
        'bmw x5 xdrive30d' => 'https://images.unsplash.com/photo-1549399542-7e9f0e3e7c0a?auto=format&fit=crop&w=1400&q=80',
        'mercedes-benz classe c 220d' => 'https://images.unsplash.com/photo-1489824904134-891ab64532f1?auto=format&fit=crop&w=1400&q=80',
        'audi a4 35 tdi' => 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80',
        'volkswagen golf 8 gti' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1400&q=80',
        'toyota yaris gr' => 'https://images.unsplash.com/photo-1517523988262-8ebf1b64ae83?auto=format&fit=crop&w=1400&q=80',
        'renault megane e-tech' => 'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1400&q=80',
        'peugeot e-2008' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1400&q=80',
        'ford mustang mach-e' => 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1400&q=80',
        'volkswagen t-roc 1.5 tsi' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=1400&q=80',
    ];

    if (isset($mapaExato[$texto])) {
        return $mapaExato[$texto];
    }

    if (str_contains($texto, 'bmw')) {
        return 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'mercedes')) {
        return 'https://images.unsplash.com/photo-1489824904134-891ab64532f1?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'audi')) {
        return 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'volkswagen')) {
        return 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'toyota')) {
        return 'https://images.unsplash.com/photo-1517523988262-8ebf1b64ae83?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'renault')) {
        return 'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'peugeot')) {
        return 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1400&q=80';
    }
    if (str_contains($texto, 'ford')) {
        return 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1400&q=80';
    }

    $defaults = [
        'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1400&q=80',
        'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1400&q=80',
        'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1400&q=80',
        'https://images.unsplash.com/photo-1489824904134-891ab64532f1?auto=format&fit=crop&w=1400&q=80',
    ];

    return $defaults[crc32($texto) % count($defaults)];
}
