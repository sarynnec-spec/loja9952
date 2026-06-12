<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

$envPath = __DIR__ . '/../.env';
if (is_file($envPath)) {
    $env = parse_ini_file($envPath, false, INI_SCANNER_RAW) ?: [];
    foreach ($env as $k => $v) {
        $_ENV[$k] = (string) $v;
    }
}

use App\Controller\CarrinhoController;
use App\Controller\AuthController;
use App\Controller\ContaController;
use App\Controller\CheckoutController;
use App\Controller\VeiculoController;

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$basePath = rtrim($scriptDir, '/');
if ($basePath === '/') {
    $basePath = '';
}

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
if ($basePath !== '' && str_starts_with($requestPath, $basePath)) {
    $requestPath = substr($requestPath, strlen($basePath));
}

$path = trim($requestPath, '/');
$partes = $path === '' ? [] : explode('/', $path);

$recurso = $partes[0] ?? '';
$acao = $partes[1] ?? '';
$id = (int) ($partes[2] ?? 0);

$ctrl = new VeiculoController($basePath);
$carrinhoCtrl = new CarrinhoController($basePath);
$authCtrl = new AuthController($basePath);
$contaCtrl = new ContaController();
$checkoutCtrl = new CheckoutController($basePath);
$routeKey = ($recurso === '' && $acao === '') ? '/' : ($acao === '' ? $recurso . '/' : "$recurso/$acao");

if ($recurso === 'checkout' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && $acao === 'confirmar') {
    $checkoutCtrl->confirmar();
    exit;
}

match ($routeKey) {
    '/' => $ctrl->catalogo(),
    'veiculo/detalhe' => $ctrl->detalhe($id),
    'carrinho/' => $carrinhoCtrl->ver(),
    'carrinho/adicionar' => $carrinhoCtrl->adicionar(),
    'carrinho/remover' => $carrinhoCtrl->remover(),
    'checkout/' => $checkoutCtrl->ver(),
    'login/' => $authCtrl->login(),
    'registar/' => $authCtrl->registar(),
    'logout/' => $authCtrl->logout(),
    'conta/' => $contaCtrl->ver(),
    default => $ctrl->catalogo(),
};
