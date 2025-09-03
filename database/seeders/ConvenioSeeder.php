<?php

namespace Database\Seeders;

use App\Models\Banco;
use App\Models\Convenio;
use Illuminate\Database\Seeder;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar bancos usando Eloquent
        $bancoBB = Banco::where('codigo', 'BB001')->first();
        $bancoCEF = Banco::where('codigo', 'CEF001')->first();
        $bancoBNDES = Banco::where('codigo', 'BNDES001')->first();
        $bancoBCB = Banco::where('codigo', 'BCB001')->first();

        $convenios = [
            [
                'codigo' => 'CONV001',
                'convenio' => 'Convênio Desenvolvimento Urbano',
                'verba' => 'Recursos do Tesouro Nacional',
                'banco_id' => $bancoBB->id,
            ],
            [
                'codigo' => 'CONV002',
                'convenio' => 'Convênio Habitação Popular',
                'verba' => 'FGTS',
                'banco_id' => $bancoCEF->id,
            ],
            [
                'codigo' => 'CONV003',
                'convenio' => 'Convênio Infraestrutura',
                'verba' => 'Recursos BNDES',
                'banco_id' => $bancoBNDES->id,
            ],
            [
                'codigo' => 'CONV004',
                'convenio' => 'Convênio Tecnologia e Inovação',
                'verba' => 'Recursos Próprios',
                'banco_id' => $bancoBCB->id,
            ],
            [
                'codigo' => 'CONV005',
                'convenio' => 'Convênio Educação e Saúde',
                'verba' => 'Recursos do SUS/MEC',
                'banco_id' => $bancoCEF->id,
            ],
        ];

        foreach ($convenios as $convenio) {
            Convenio::create($convenio);
        }
    }
}
