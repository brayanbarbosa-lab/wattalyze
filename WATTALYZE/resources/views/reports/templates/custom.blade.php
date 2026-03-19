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
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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

        .section-title {
            font-size: 18pt;
            font-weight: 700;
            color: #1a202c;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #2E8B57;
        }

        .metrics-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }

        .metric-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .metric-name {
            font-size: 11pt;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .metric-value {
            font-size: 24pt;
            font-weight: 700;
            color: #2E8B57;
        }

        .metric-unit {
            font-size: 12pt;
            color: #4A5568;
            margin-left: 5px;
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .data-export {
            background: #F0F7FF;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10pt;
        }

        .data-table th {
            background: #3498db;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: 600;
        }

        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #E2E8F0;
        }

        .data-table tr:nth-child(even) {
            background: #f8f9fa;
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
        <h1>🔧 {{ $reportData['report_name'] }}</h1>
        <div class="subtitle">Relatório Personalizado</div>
    </div>

    <!-- Período -->
    <div class="period-info">
        <strong>Período Analisado:</strong> {{ $reportData['period_start'] }} até {{ $reportData['period_end'] }}
        <br>
        <strong>Gerado em:</strong> {{ $reportData['generated_at'] }}
    </div>

    <!-- Métricas Customizadas -->
    <h2 class="section-title">📊 Métricas Selecionadas</h2>
    <div class="metrics-container">
        @foreach($reportData['metrics'] as $deviceName => $deviceMetrics)
            @foreach($deviceMetrics as $metricName => $metricValue)
                <div class="metric-card">
                    <div class="metric-name">{{ $deviceName }} - {{ str_replace('_', ' ', ucfirst($metricName)) }}</div>
                    <div class="metric-value">
                        {{ is_numeric($metricValue) ? number_format($metricValue, 2, ',', '.') : $metricValue }}
                        <span class="metric-unit">{{ in_array($metricName, ['total', 'average']) ? 'kWh' : '' }}</span>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>

    <!-- Gráficos -->
    @if(!empty($reportData['charts']))
    <h2 class="section-title">📈 Visualizações</h2>

    @if(isset($reportData['charts']['trend']))
    <div class="chart-container">
        <div class="chart-title">Tendência de Consumo</div>
        <img src="{{ $reportData['charts']['trend'] }}" class="chart-image" alt="Tendência">
    </div>
    @endif

    @if(isset($reportData['charts']['comparison']))
    <div class="chart-container">
        <div class="chart-title">Comparação entre Dispositivos</div>
        <img src="{{ $reportData['charts']['comparison'] }}" class="chart-image" alt="Comparação">
    </div>
    @endif

    @if(isset($reportData['charts']['distribution']))
    <div class="chart-container">
        <div class="chart-title">Distribuição de Consumo</div>
        <img src="{{ $reportData['charts']['distribution'] }}" class="chart-image" alt="Distribuição">
    </div>
    @endif
    @endif

    <!-- Dados Brutos para Exportação -->
    @if(!empty($reportData['raw_data']))
    <h2 class="section-title">📋 Dados Brutos</h2>
    <div class="data-export">
        <p><strong>Extrato dos dados utilizados no relatório:</strong></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Consumo (kWh)</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($reportData['raw_data'], 0, 50) as $row)
                <tr>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['hour'] }}</td>
                    <td>{{ number_format($row['consumption_kwh'], 4, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($reportData['raw_data']) > 50)
        <p style="margin-top: 15px; font-size: 10pt; color: #718096;">
            <strong>Total de registros:</strong> {{ count($reportData['raw_data']) }} (Exibindo primeiros 50)
        </p>
        @endif
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Relatório gerado automaticamente pelo sistema Wattalyze</p>
        <p>© {{ date('Y') }} - Todos os direitos reservados</p>
    </div>
</body>
</html>
