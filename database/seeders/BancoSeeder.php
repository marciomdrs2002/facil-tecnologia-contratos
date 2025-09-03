<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bancos = [
            [
                'codigo' => 'BB001',
                'nome' => 'Banco do Brasil',
            ],
            [
                'codigo' => 'CEF001',
                'nome' => 'Caixa Econômica Federal',
            ],
            [
                'codigo' => 'BNDES001',
                'nome' => 'Banco Nacional de Desenvolvimento Econômico e Social',
            ],
            [
                'codigo' => 'BCB001',
                'nome' => 'Banco Central do Brasil',
            ],
            [
                'codigo' => 'BRAD001',
                'nome' => 'Banco Bradesco',
            ],
        ];

        foreach ($bancos as $banco) {
            Banco::create($banco);
        }
    }
}
