<?php

namespace App\Console\Commands;

use App\Models\Contrato;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class ListarContratos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contratos:listar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todos os contratos com suas relações (banco, verba, código, data, valor, prazo) - Use --pdf para gerar PDF';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $contratos = Contrato::with([
            'convenioServico.convenio.banco'
        ])->orderBy('data_inclusao', 'desc')->get();

        if ($contratos->isEmpty()) {
            $this->warn('⚠️  Nenhum contrato encontrado.');
            return;
        }

        return $this->gerarPDF($contratos);
    }

    /**
     * Gerar PDF com os dados dos contratos
     */
    private function gerarPDF($contratos)
    {
        $this->info('📄 Gerando PDF com dados dos contratos...');

        // Calcular estatísticas
        $estatisticas = [
            'total_contratos' => $contratos->count(),
            'valor_total' => $contratos->sum('valor'),
            'contratos_por_banco' => $contratos->groupBy(function ($contrato) {
                return $contrato->convenioServico->convenio->banco->nome;
            })->map->count()
        ];

        // Preparar dados para o PDF (mesmo formato da tabela)
        $dadosTabela = [];
        foreach ($contratos as $contrato) {
            $dadosTabela[] = [
                'banco' => $contrato->convenioServico->convenio->banco->nome,
                'verba' => $contrato->convenioServico->convenio->verba,
                'codigo' => $contrato->codigo,
                'data_inclusao' => $contrato->data_inclusao->format('d/m/Y H:i'),
                'valor' => $contrato->valor,
                'valor_formatado' => 'R$ ' . number_format($contrato->valor, 2, ',', '.'),
                'prazo' => $contrato->prazo->format('d/m/Y'),
            ];
        }

        // Gerar PDF usando view
        $pdf = Pdf::loadView('pdf.contratos', [
            'contratos' => $dadosTabela,
            'estatisticas' => $estatisticas,
            'data_geracao' => now(),
        ]);

        // Definir caminho de saída
        $output = storage_path('app/relatorio-contratos-' . now()->format('Y-m-d-H-i-s') . '.pdf');

        // Criar diretório se não existir
        $directory = dirname($output);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Salvar PDF
        $pdf->save($output);

        $this->info("✅ PDF gerado com sucesso!");
        $this->line("📁 Arquivo salvo em: {$output}");
        $this->line("📊 Total de contratos: {$estatisticas['total_contratos']}");
        $this->line("💰 Valor total: R$ " . number_format($estatisticas['valor_total'], 2, ',', '.'));

        return 0;
    }
}
