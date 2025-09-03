<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RelatorioAgrupado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contratos:agrupado {--arquivo : Gerar arquivo de texto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Relatório de contratos agrupado por banco e verba com estatísticas - Use --arquivo para gerar arquivo de texto';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('arquivo')) {
            return $this->gerarArquivo();
        }

        $this->info('📊 Relatório Agrupado por Banco e Verba');
        $this->line('');

        $sql = "
            SELECT 
                b.nome as nome_banco,
                c.verba as verba,
                MIN(ct.data_inclusao) as contrato_mais_antigo,
                MAX(ct.data_inclusao) as contrato_mais_novo,
                SUM(ct.valor) as soma_valores,
                COUNT(ct.id) as total_contratos
            FROM contrato ct
            INNER JOIN convenio_servico cs ON ct.convenio_servico_id = cs.id
            INNER JOIN convenio c ON cs.convenio_id = c.id
            INNER JOIN banco b ON c.banco_id = b.id
            GROUP BY b.nome, c.verba
            ORDER BY b.nome, c.verba
        ";

        $resultados = DB::select($sql);

        if (empty($resultados)) {
            $this->warn('⚠️  Nenhum resultado encontrado.');
            return 1;
        }

        $dadosTabela = [];
        $totalGeral = 0;
        $totalContratos = 0;

        foreach ($resultados as $resultado) {
            $dadosTabela[] = [
                'Banco' => $resultado->nome_banco,
                'Verba' => $resultado->verba,
                'Contrato + Antigo' => date('d/m/Y H:i', strtotime($resultado->contrato_mais_antigo)),
                'Contrato + Novo' => date('d/m/Y H:i', strtotime($resultado->contrato_mais_novo)),
                'Soma Valores' => 'R$ ' . number_format($resultado->soma_valores, 2, ',', '.'),
                'Qtd Contratos' => $resultado->total_contratos,
            ];
            
            $totalGeral += $resultado->soma_valores;
            $totalContratos += $resultado->total_contratos;
        }

        $this->table([
            'Nome do Banco',
            'Verba',
            'Contrato + Antigo',
            'Contrato + Novo', 
            'Soma Valores',
            'Qtd Contratos'
        ], $dadosTabela);

        $this->line('');
        $this->info('📈 Resumo Geral:');
        $this->line("Total de Agrupamentos: " . count($resultados));
        $this->line("Total de Contratos: {$totalContratos}");
        $this->line('Valor Total Geral: R$ ' . number_format($totalGeral, 2, ',', '.'));

        $this->line('');
        $this->info('🏦 Resumo por Banco:');
        
        $bancos = collect($resultados)->groupBy('nome_banco');
        foreach ($bancos as $banco => $grupos) {
            $valorBanco = $grupos->sum('soma_valores');
            $contratosBanco = $grupos->sum('total_contratos');
            $this->line("• {$banco}: {$contratosBanco} contratos, R$ " . number_format($valorBanco, 2, ',', '.'));
        }

        return 0;
    }

    /**
     * Gerar arquivo de texto com o relatório
     */
    private function gerarArquivo()
    {
        $sql = "
            SELECT 
                b.nome as nome_banco,
                c.verba as verba,
                MIN(ct.data_inclusao) as contrato_mais_antigo,
                MAX(ct.data_inclusao) as contrato_mais_novo,
                SUM(ct.valor) as soma_valores,
                COUNT(ct.id) as total_contratos
            FROM contrato ct
            INNER JOIN convenio_servico cs ON ct.convenio_servico_id = cs.id
            INNER JOIN convenio c ON cs.convenio_id = c.id
            INNER JOIN banco b ON c.banco_id = b.id
            GROUP BY b.nome, c.verba
            ORDER BY b.nome, c.verba
        ";

        $resultados = DB::select($sql);

        if (empty($resultados)) {
            $this->error('Nenhum resultado encontrado para gerar o arquivo.');
            return 1;
        }

        $conteudo = [];
        $conteudo[] = "==================================================";
        $conteudo[] = "RELATÓRIO AGRUPADO POR BANCO E VERBA";
        $conteudo[] = "==================================================";
        $conteudo[] = "Gerado em: " . now()->format('d/m/Y H:i:s');
        $conteudo[] = "";

        $conteudo[] = "RESULTADOS:";
        $conteudo[] = str_repeat('-', 150);
        $conteudo[] = sprintf(
            "%-40s | %-25s | %-18s | %-18s | %-15s | %-12s",
            "BANCO",
            "VERBA", 
            "CONTRATO + ANTIGO",
            "CONTRATO + NOVO",
            "SOMA VALORES",
            "QTD CONTRATOS"
        );
        $conteudo[] = str_repeat('-', 150);

        $totalGeral = 0;
        $totalContratos = 0;

        foreach ($resultados as $resultado) {
            $conteudo[] = sprintf(
                "%-40s | %-25s | %-18s | %-18s | %-15s | %-12s",
                $resultado->nome_banco,
                $resultado->verba,
                date('d/m/Y H:i', strtotime($resultado->contrato_mais_antigo)),
                date('d/m/Y H:i', strtotime($resultado->contrato_mais_novo)),
                'R$ ' . number_format($resultado->soma_valores, 2, ',', '.'),
                $resultado->total_contratos
            );
            
            $totalGeral += $resultado->soma_valores;
            $totalContratos += $resultado->total_contratos;
        }

        $conteudo[] = str_repeat('-', 150);
        $conteudo[] = "";

        $conteudo[] = "RESUMO GERAL:";
        $conteudo[] = str_repeat('-', 30);
        $conteudo[] = "Total de Agrupamentos: " . count($resultados);
        $conteudo[] = "Total de Contratos: {$totalContratos}";
        $conteudo[] = "Valor Total Geral: R$ " . number_format($totalGeral, 2, ',', '.');
        $conteudo[] = "";

        $conteudo[] = "RESUMO POR BANCO:";
        $conteudo[] = str_repeat('-', 30);
        
        $bancos = collect($resultados)->groupBy('nome_banco');
        foreach ($bancos as $banco => $grupos) {
            $valorBanco = $grupos->sum('soma_valores');
            $contratosBanco = $grupos->sum('total_contratos');
            $conteudo[] = "• {$banco}: {$contratosBanco} contratos, R$ " . number_format($valorBanco, 2, ',', '.');
        }

        $conteudo[] = "";
        $conteudo[] = str_repeat('=', 50);
        $conteudo[] = "Relatório gerado automaticamente pelo Sistema de Contratos";

        $output = storage_path('app/relatorio-agrupado-' . now()->format('Y-m-d-H-i-s') . '.txt');

        $directory = dirname($output);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($output, implode("\n", $conteudo));

        $this->info("Arquivo gerado: {$output}");
        $this->line("Total de agrupamentos: " . count($resultados));
        $this->line("Valor total: R$ " . number_format($totalGeral, 2, ',', '.'));

        return 0;
    }
}
