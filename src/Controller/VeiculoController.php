<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\VeiculoModel;

class VeiculoController
{
    private VeiculoModel $model;
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->model = new VeiculoModel();
        $this->basePath = $basePath;
    }

    public function catalogo(): void
    {
        $filtros = [
            'marca_id' => (int) ($_GET['marca_id'] ?? 0) ?: null,
            'combustivel' => $_GET['combustivel'] ?? null,
            'preco_max' => (float) ($_GET['preco_max'] ?? 0) ?: null,
            'ano_min' => (int) ($_GET['ano_min'] ?? 0) ?: null,
            'pesquisa' => trim($_GET['pesquisa'] ?? ''),
        ];
        $filtros = array_filter($filtros);

        $veiculos = $this->model->listar($filtros);
        $marcas = $this->model->getMarcas();
        $titulo = 'Catalogo de Veiculos';
        $basePath = $this->basePath;
        $projectPath = preg_replace('#/public$#', '', $basePath) ?: '';

        require __DIR__ . '/../../templates/catalogo.php';
    }

    public function detalhe(int $id): void
    {
        if ($id <= 0) {
            http_response_code(404);
            echo 'Veiculo nao encontrado.';
            return;
        }

        $veiculo = $this->model->getById($id);
        if (!$veiculo) {
            http_response_code(404);
            echo 'Veiculo nao encontrado.';
            return;
        }

        $basePath = $this->basePath;
        $projectPath = preg_replace('#/public$#', '', $basePath) ?: '';
        $titulo = $veiculo['marca'] . ' ' . $veiculo['modelo'];

        require __DIR__ . '/../../templates/detalhe.php';
    }
}
