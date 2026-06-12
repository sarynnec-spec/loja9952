<?php
declare(strict_types=1);

namespace App\Controller;

use App\Auth;
use App\Model\ClienteModel;
use App\Model\ReservaModel;

class ContaController
{
    public function ver(): void
    {
        Auth::verificar();

        $clienteId = (int) $_SESSION['cliente_id'];
        $cliente = (new ClienteModel())->getById($clienteId);
        $reservas = (new ReservaModel())->getByCliente($clienteId);
        $titulo = 'A minha conta';
        require __DIR__ . '/../../templates/conta/ver.php';
    }
}
