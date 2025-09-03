<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Contratos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        
        .header .info {
            margin-top: 10px;
            color: #7f8c8d;
            font-size: 10px;
        }
        
        .resumo {
            background-color: #ecf0f1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .resumo h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        .resumo-item {
            margin: 5px 0;
            font-weight: bold;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #34495e;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        
        .table td {
            padding: 6px 8px;
            border-bottom: 1px solid #bdc3c7;
            font-size: 10px;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .valor {
            text-align: right;
            font-weight: bold;
            color: #27ae60;
        }
        
        .data {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #bdc3c7;
            padding-top: 15px;
        }
        
        .estatisticas {
            margin-top: 20px;
        }
        
        .estatisticas h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .banco-stats {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Contratos</h1>
        <div class="info">
            Gerado em: {{ $data_geracao->format('d/m/Y H:i:s') }}
        </div>
    </div>

    <div class="resumo">
        <h3>Resumo Executivo</h3>
        <div class="resumo-item">Total de Contratos: {{ $estatisticas['total_contratos'] }}</div>
        <div class="resumo-item">Valor Total: R$ {{ number_format($estatisticas['valor_total'], 2, ',', '.') }}</div>
        <div class="resumo-item">Valor Médio por Contrato: R$ {{ number_format($estatisticas['valor_total'] / $estatisticas['total_contratos'], 2, ',', '.') }}</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 25%;">Nome do Banco</th>
                <th style="width: 20%;">Verba</th>
                <th style="width: 12%;">Código</th>
                <th style="width: 13%;">Data Inclusão</th>
                <th style="width: 15%;">Valor</th>
                <th style="width: 15%;">Prazo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contratos as $contrato)
            <tr>
                <td>{{ $contrato['banco'] }}</td>
                <td>{{ $contrato['verba'] }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $contrato['codigo'] }}</td>
                <td class="data">{{ $contrato['data_inclusao'] }}</td>
                <td class="valor">{{ $contrato['valor_formatado'] }}</td>
                <td class="data">{{ $contrato['prazo'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="estatisticas">
            <h4>Distribuição por Banco</h4>
            @foreach($estatisticas['contratos_por_banco'] as $banco => $quantidade)
                <div class="banco-stats">
                    <strong>{{ $banco }}:</strong> {{ $quantidade }} contratos
                </div>
            @endforeach
        </div>
    </div>

    <div style="margin-top: 40px; text-align: center; font-size: 10px; color: #7f8c8d;">
        Relatório gerado automaticamente pelo Sistema de Contratos
    </div>
</body>
</html>