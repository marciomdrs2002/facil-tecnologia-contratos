<?php

namespace Database\Seeders;

use App\Models\Convenio;
use App\Models\ConvenioServico;
use Illuminate\Database\Seeder;

class ConvenioServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar convênios usando Eloquent
        $convenios = Convenio::all();

        $convenioServicos = [
            [
                'codigo' => 'SERV001',
                'convenio_id' => $convenios->where('codigo', 'CONV001')->first()->id,
                'servico' => 'Consultoria em Planejamento Urbano',
            ],
            [
                'codigo' => 'SERV002',
                'convenio_id' => $convenios->where('codigo', 'CONV001')->first()->id,
                'servico' => 'Execução de Obras de Infraestrutura',
            ],
            [
                'codigo' => 'SERV003',
                'convenio_id' => $convenios->where('codigo', 'CONV002')->first()->id,
                'servico' => 'Construção de Unidades Habitacionais',
            ],
            [
                'codigo' => 'SERV004',
                'convenio_id' => $convenios->where('codigo', 'CONV002')->first()->id,
                'servico' => 'Regularização Fundiária',
            ],
            [
                'codigo' => 'SERV005',
                'convenio_id' => $convenios->where('codigo', 'CONV003')->first()->id,
                'servico' => 'Desenvolvimento de Software',
            ],
            [
                'codigo' => 'SERV006',
                'convenio_id' => $convenios->where('codigo', 'CONV003')->first()->id,
                'servico' => 'Implementação de Sistemas',
            ],
            [
                'codigo' => 'SERV007',
                'convenio_id' => $convenios->where('codigo', 'CONV004')->first()->id,
                'servico' => 'Pesquisa e Desenvolvimento',
            ],
            [
                'codigo' => 'SERV008',
                'convenio_id' => $convenios->where('codigo', 'CONV004')->first()->id,
                'servico' => 'Consultoria Tecnológica',
            ],
            [
                'codigo' => 'SERV009',
                'convenio_id' => $convenios->where('codigo', 'CONV005')->first()->id,
                'servico' => 'Treinamento e Capacitação',
            ],
            [
                'codigo' => 'SERV010',
                'convenio_id' => $convenios->where('codigo', 'CONV005')->first()->id,
                'servico' => 'Equipamentos Médicos e Educacionais',
            ],
        ];

        foreach ($convenioServicos as $convenioServico) {
            ConvenioServico::create($convenioServico);
        }
    }
}
