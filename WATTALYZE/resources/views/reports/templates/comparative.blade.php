<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportData['report_name'] }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #2D3748;
            background: #ffffff;
        }

        .header {
            background: linear-gradient(135deg, #2E8B57 0%, #1a5d3a 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 28pt;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header .subtitle {
            font-size: 14pt;
            opacity: 0.95;
            font-weight: 500;
        }

        .period-info {
            background: #F7FAFC;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #2E8B57;
            margin-bottom: 25px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 25px 0;
        }

        .summary-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #E2E8F0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .card-icon {
            font-size: 24pt;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 18pt;
            font-weight: 700;
            color: #2E8B57;
            margin: 10px 0;
        }

        .card-label {
            font-size: 10pt;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 18pt;
            font-weight: 700;
            color: #1a202c;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #2E8B57;
        }

        .chart-container {
            margin: 25px 0;
            text-align: center;
            page-break-inside: avoid;
        }

        .chart-title {
            font-size: 12pt;
            font-weight: 600;
            color: #4A5568;
            margin-bottom: 15px;
        }

        .chart-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .comparison-table th {
            background: #2E8B57;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 11pt;
        }

        .comparison-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #E2E8F0;
        }

        .comparison-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .comparison-table tr:hover {
            background: #f0f4f8;
        }

        .trend-up {
            color: #e74c3c;
            font-weight: 600;
        }

        .trend-down {
            color: #27ae60;
            font-weight: 600;
        }

        .trend-stable {
            color: #f39c12;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: 600;
        }

        .badge-high {
            background: #C6F6D5;
            color: #22543D;
        }

        .badge-medium {
            background: #FED7D7;
            color: #742A2A;
        }

        .insights-box {
            background: #EDF2F7;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
        }

        .insights-box h4 {
            color: #2D3748;
            font-size: 13pt;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .insights-box ul {
            list-style: none;
            padding-left: 0;
        }

        .insights-box li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }

        .insights-box li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #2E8B57;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding: 20px;
            background: #F7FAFC;
            border-radius: 8px;
            text-align: center;
            font-size: 9pt;
            color: #718096;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $reportData['report_name'] }}</h1>
        <div class="subtitle">Relatório Comparativo de Consumo</div>
    </div>

    <!-- Período -->
    <div class="period-info">
        <strong>Período Analisado:</strong> {{ $reportData['period_start'] }} até {{ $reportData['period_end'] }}
        <br>
        <strong>Gerado em:</strong> {{ $reportData['generated_at'] }}
    </div>

    <!-- Resumo -->
    <h2 class="section-title">Resumo Executivo</h2>
    <div class="summary-grid">
        <div class="summary-card">
            <div class="card-icon"></div>
            <div class="card-value">{{ number_format($reportData['metrics']['summary']['average_variation'], 1, ',', '.') }}%</div>
            <div class="card-label">Variação Média</div>
        </div>
        <div class="summary-card">
            <div class="card-icon"></div>
            <div class="card-value">{{ $reportData['metrics']['summary']['devices_increasing'] }}</div>
            <div class="card-label">Em Crescimento</div>
        </div>
        <div class="summary-card">
            <div class="card-icon"></div>
            <div class="card-value">{{ $reportData['metrics']['summary']['devices_stable'] }}</div>
            <div class="card-label">Estáveis</div>
        </div>
        <div class="summary-card">
            <div class="card-icon"></div>
            <div class="card-value">{{ $reportData['metrics']['summary']['devices_decreasing'] }}</div>
            <div class="card-label">Em Redução</div>
        </div>
    </div>

    <!-- Gráfico de Comparação -->
    <h2 class="section-title">Comparação Lado a Lado</h2>
    @if(isset($reportData['charts']['grouped_comparison']))
    <div class="chart-container">
        <div class="chart-title">Período Atual vs Período Anterior</div>
        <img src="{{ $reportData['charts']['grouped_comparison'] }}" class="chart-image" alt="Comparação">
    </div>
    @endif

    <!-- Gráfico de Tendências -->
    <h2 class="section-title">Análise de Tendências</h2>
    @if(isset($reportData['charts']['trends']))
    <div class="chart-container">
        <div class="chart-title">Tendências de Consumo ao Longo do Tempo</div>
        <img src="{{ $reportData['charts']['trends'] }}" class="chart-image" alt="Tendências">
    </div>
    @endif

    <!-- Tabela Comparativa Detalhada -->
    <h2 class="section-title">Detalhes Comparativos</h2>
    <table class="comparison-table">
        <thead>
            <tr>
                <th>Dispositivo</th>
                <th>Período Atual (kWh)</th>
                <th>Período Anterior (kWh)</th>
                <th>Variação (%)</th>
                <th>Tendência</th>
                <th>Ranking</th>
                <th>Contribuição (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['metrics']['devices'] as $device => $data)
            <tr>
                <td><strong>{{ $device }}</strong></td>
                <td>{{ number_format($data['current_total'], 2, ',', '.') }}</td>
                <td>{{ number_format($data['previous_total'], 2, ',', '.') }}</td>
                <td class="trend-{{ $data['trend'] }}">
                    {{ $data['variation'] > 0 ? '↑' : '↓' }}
                    {{ number_format(abs($data['variation']), 1, ',', '.') }}%
                </td>

                <td>
                    @if($data['trend'] === 'increasing')
                    <span class="trend-up">Crescimento</span>
                    @elseif($data['trend'] === 'decreasing')
                    <span class="trend-down">Redução</span>
                    @else
                    <span class="trend-stable">Estável</span>
                    @endif
                </td>
                <td><strong>#{{ $data['ranking_position'] }}</strong></td>
                <td>{{ number_format($data['contribution_percentage'], 1, ',', '.') }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Gráfico de Contribuição -->
    <h2 class="section-title">Distribuição de Consumo</h2>
    @if(isset($reportData['charts']['contribution']))
    <div class="chart-container">
        <div class="chart-title">Contribuição de Cada Dispositivo (Período Atual)</div>
        <img src="{{ $reportData['charts']['contribution'] }}" class="chart-image" alt="Contribuição">
    </div>
    @endif

    <!-- Insights -->
    <h2 class="section-title">Insights e Recomendações</h2>
    <div class="insights-box">
        <h4>Análise dos Dados</h4>
        <ul>
            <li>Variação média geral: <strong>{{ number_format($reportData['metrics']['summary']['average_variation'], 1, ',', '.') }}%</strong></li>
            <li>Dispositivos com consumo crescente: <strong>{{ $reportData['metrics']['summary']['devices_increasing'] }}</strong></li>
            <li>Dispositivos com consumo reduzido: <strong>{{ $reportData['metrics']['summary']['devices_decreasing'] }}</strong></li>
            @if($reportData['metrics']['summary']['average_variation'] > 10)
            <li>Aumento significativo no consumo. Verifique possíveis mau funcionamento de equipamentos.</li>
            @elseif($reportData['metrics']['summary']['average_variation'] < -10)
                <li>✓ Redução significativa no consumo. Bom trabalho na otimização!</li>
                @else
                <li>Consumo relativamente estável entre os períodos.</li>
                @endif
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Relatório gerado automaticamente pelo sistema Wattalyze</p>
        <p>© {{ date('Y') }} - Todos os direitos reservados</p>
    </div>
</body>

</html>