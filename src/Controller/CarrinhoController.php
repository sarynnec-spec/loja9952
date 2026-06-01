<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\VeiculoModel;

class CarrinhoController
{
    private VeiculoModel $model;
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->model = new VeiculoModel();
        $this->basePath = $basePath;
    }

    public function ver(): void
    {
        $ids = $_SESSION['carrinho'] ?? [];
        $veiculos = array_map(fn ($id) => $this->model->getById((int) $id), $ids);
        $veiculos = array_filter($veiculos);
        $titulo = 'A minha lista de reservas';
        $basePath = $this->basePath;

        require __DIR__ . '/../../templates/carrinho/ver.php';
    }

    public function adicionar(): void
    {
        csrf_validar();

        $id = (int) ($_POST['veiculo_id'] ?? 0);
        if ($id > 0) {
            $carrinho = $_SESSION['carrinho'] ?? [];
            if (!in_array($id, $carrinho, true)) {
                $carrinho[] = $id;
                $_SESSION['carrinho'] = $carrinho;
                $_SESSION['msg_ok'] = 'Veiculo adicionado a lista!';
            } else {
                $_SESSION['msg_info'] = 'Este veiculo ja esta na tua lista.';
            }
        }

        header('Location: ' . $this->basePath . '/carrinho');
        exit;
    }

    public function remover(): void
    {
        csrf_validar();

        $id = (int) ($_POST['veiculo_id'] ?? 0);
        $carrinho = $_SESSION['carrinho'] ?? [];
        $carrinho = array_values(array_filter($carrinho, fn ($item) => (int) $item !== $id));
        $_SESSION['carrinho'] = $carrinho;

        header('Location: ' . $this->basePath . '/carrinho');
        exit;
    }
}
