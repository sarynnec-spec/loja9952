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
