<?php
declare(strict_types=1);

namespace App;

class Auth
{
    public static function verificar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!($_SESSION['logado'] ?? false)) {
            $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
            $basePath = rtrim($scriptDir, '/');
            if ($basePath === '/') {
                $basePath = '';
            }
            header('Location: ' . $basePath . '/login');
            exit;
        }
    }

    public static function clienteAtual(): array
    {
        return [
            'id' => $_SESSION['cliente_id'] ?? null,
            'nome' => $_SESSION['cliente_nome'] ?? 'Cliente',
        ];
    }
}
