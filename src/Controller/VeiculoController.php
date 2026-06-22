<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\VeiculoModel;

class VeiculoController
{
    private ?VeiculoModel $model = null;
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    private function model(): VeiculoModel
    {
        if (!$this->model instanceof VeiculoModel) {
            $this->model = new VeiculoModel();
        }

        return $this->model;
    }

    private function fallbackVeiculos(): array
    {
        return [
            [
                'id' => 1,
                'marca' => 'BMW',
                'modelo' => 'Serie 3 320d',
                'ano' => 2023,
                'quilometros' => 12000,
                'combustivel' => 'Diesel',
                'preco' => 45900,
                'imagem' => null,
            ],
            [
                'id' => 2,
                'marca' => 'Audi',
                'modelo' => 'A4 35 TDI',
                'ano' => 2022,
                'quilometros' => 18000,
                'combustivel' => 'Diesel',
                'preco' => 42900,
                'imagem' => null,
            ],
            [
                'id' => 3,
                'marca' => 'Mercedes-Benz',
                'modelo' => 'Classe C 220d',
                'ano' => 2023,
                'quilometros' => 9000,
                'combustivel' => 'Diesel',
                'preco' => 52900,
                'imagem' => null,
            ],
        ];
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

        try {
            $veiculos = $this->model()->listar($filtros);
            $marcas = $this->model()->getMarcas();
        } catch (\Throwable $e) {
            $veiculos = $this->fallbackVeiculos();
            $marcas = [
                ['id' => 1, 'nome' => 'BMW'],
                ['id' => 2, 'nome' => 'Audi'],
                ['id' => 3, 'nome' => 'Mercedes-Benz'],
            ];
            error_log('VeiculoController catalogo sem base de dados: ' . $e->getMessage());
        }
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

        try {
            $veiculo = $this->model()->getById($id);
        } catch (\Throwable $e) {
            $veiculos = array_column($this->fallbackVeiculos(), null, 'id');
            $veiculo = $veiculos[$id] ?? false;
            error_log('VeiculoController detalhe sem base de dados: ' . $e->getMessage());
        }
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
