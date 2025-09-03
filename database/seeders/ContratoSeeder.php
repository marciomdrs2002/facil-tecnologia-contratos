<?php

namespace Database\Seeders;

use App\Models\ConvenioServico;
use App\Models\Contrato;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar convênio_servicos usando Eloquent
        $convenioServicos = ConvenioServico::all();

        $contratos = [
            [
                'codigo' => 'CONT001',
                'prazo' => Carbon::now()->addMonths(12),
                'valor' => 150000.00,
                'data_inclusao' => Carbon::now()->subDays(30),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV001')->first()->id,
            ],
            [
                'codigo' => 'CONT002',
                'prazo' => Carbon::now()->addMonths(18),
                'valor' => 2500000.00,
                'data_inclusao' => Carbon::now()->subDays(45),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV002')->first()->id,
            ],
            [
                'codigo' => 'CONT003',
                'prazo' => Carbon::now()->addMonths(24),
                'valor' => 5000000.00,
                'data_inclusao' => Carbon::now()->subDays(60),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV003')->first()->id,
            ],
            [
                'codigo' => 'CONT004',
                'prazo' => Carbon::now()->addMonths(6),
                'valor' => 750000.00,
                'data_inclusao' => Carbon::now()->subDays(15),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV004')->first()->id,
            ],
            [
                'codigo' => 'CONT005',
                'prazo' => Carbon::now()->addMonths(8),
                'valor' => 300000.00,
                'data_inclusao' => Carbon::now()->subDays(20),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV005')->first()->id,
            ],
            [
                'codigo' => 'CONT006',
                'prazo' => Carbon::now()->addMonths(10),
                'valor' => 450000.00,
                'data_inclusao' => Carbon::now()->subDays(25),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV006')->first()->id,
            ],
            [
                'codigo' => 'CONT007',
                'prazo' => Carbon::now()->addMonths(36),
                'valor' => 1200000.00,
                'data_inclusao' => Carbon::now()->subDays(90),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV007')->first()->id,
            ],
            [
                'codigo' => 'CONT008',
                'prazo' => Carbon::now()->addMonths(4),
                'valor' => 85000.00,
                'data_inclusao' => Carbon::now()->subDays(10),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV008')->first()->id,
            ],
            [
                'codigo' => 'CONT009',
                'prazo' => Carbon::now()->addMonths(6),
                'valor' => 180000.00,
                'data_inclusao' => Carbon::now()->subDays(35),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV009')->first()->id,
            ],
            [
                'codigo' => 'CONT010',
                'prazo' => Carbon::now()->addMonths(15),
                'valor' => 950000.00,
                'data_inclusao' => Carbon::now()->subDays(50),
                'convenio_servico_id' => $convenioServicos->where('codigo', 'SERV010')->first()->id,
            ],
        ];

        foreach ($contratos as $contrato) {
            Contrato::create($contrato);
        }
    }
}
