<?php
namespace App\Controller;

use App\Auth;
use App\Model\ReservaModel;
use App\Model\VeiculoModel;

class CheckoutController {
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    public function ver(): void {
        Auth::verificar();
        if (session_status() === PHP_SESSION_NONE) session_start();
 
        $ids = $_SESSION['carrinho'] ?? [];
        if (empty($ids)) {
            header('Location: ' . $this->basePath . '/carrinho');
            exit;
        }
 
        $model    = new VeiculoModel();
        $veiculos = array_filter(array_map(fn($id) => $model->getById($id), $ids));
        $titulo   = 'Confirmar reserva';
        $basePath = $this->basePath;
        require __DIR__ . '/../../templates/checkout/ver.php';
    }
 
    public function confirmar(): void {
        Auth::verificar();
        csrf_validar();
 
        $ids       = $_SESSION['carrinho'] ?? [];
        $clienteId = $_SESSION['cliente_id'];
        $mensagem  = trim($_POST['mensagem'] ?? '');
 
        $reservaModel = new ReservaModel();
        $confirmadas  = 0;
 
        foreach ($ids as $veiculoId) {
            try {
                $reservaModel->criar($clienteId, (int)$veiculoId, $mensagem);
                $confirmadas++;
            } catch (\Exception $e) {
                // Veículo pode já não estar disponível — ignorar
                error_log('Erro ao criar reserva: '.$e->getMessage());
            }
        }
 
        // Limpar carrinho após checkout:
        $_SESSION['carrinho'] = [];
        $_SESSION['msg_ok']   = "$confirmadas reserva(s) confirmada(s)! A nossa equipa entrará em contacto.";
        header('Location: ' . $this->basePath . '/conta');
        exit;
    }
}

