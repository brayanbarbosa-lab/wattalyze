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

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 25px 0;
        }

        .kpi-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #E2E8F0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .kpi-icon {
            font-size: 24pt;
            margin-bottom: 10px;
        }

        .kpi-value {
            font-size: 18pt;
            font-weight: 700;
            color: #2E8B57;
            margin: 10px 0;
        }

        .kpi-label {
            font-size: 10pt;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 18pt;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #2E8B57;
        }

        .device-section {
            background: #ffffff;
            padding: 25px;
            margin: 20px 0;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            page-break-inside: avoid;
        }

        .device-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #E2E8F0;
        }

        .device-name {
            font-size: 16pt;
            font-weight: 700;
            color: #2D3748;
        }

        .efficiency-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 10pt;
        }

        .badge-high {
            background: #C6F6D5;
            color: #22543D;
        }

        .badge-medium {
            background: #FED7D7;
            color: #742A2A;
        }

        .badge-low {
            background: #FED7D7;
            color: #742A2A;
        }

        .chart-container {
            margin: 20px 0;
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

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .metric-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2E8B57;
        }

        .metric-label {
            font-size: 10pt;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .metric-value {
            font-size: 16pt;
            font-weight: 700;
            color: #2D3748;
        }

        .peak-hours {
            background: #FFF5E6;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #e67e22;
            margin: 15px 0;
        }

        .peak-hours h4 {
            color: #7c5319;
            margin-bottom: 10px;
            font-size: 12pt;
        }

        .peak-list {
            list-style: none;
            padding-left: 0;
        }

        .peak-list li {
            padding: 5px 0;
            color: #5a4a1a;
            font-size: 11pt;
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

        .ranking-section {
            margin: 20px 0;
        }

        .ranking-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ranking-table th {
            background: #2E8B57;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .ranking-table td {
            padding: 12px;
            border-bottom: 1px solid #E2E8F0;
        }

        .ranking-table tr:nth-child(even) {
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
        <h1>⚡ {{ $reportData['report_name'] }}</h1>
        <div class="subtitle">Relatório de Eficiência Energética</div>
    </div>

    <!-- Período -->
    <div class="period-info">
        <strong>Período Analisado:</strong> {{ $reportData['period_start'] }} até {{ $reportData['period_end'] }}
        <br>
        <strong>Gerado em:</strong> {{ $reportData['generated_at'] }}
    </div>

    <!-- Eficiência Geral -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon"></div>
            <div class="kpi-value">{{ $reportData['metrics']['overall_efficiency'] }}%</div>
            <div class="kpi-label">Eficiência Geral</div>
        </div>
    </div>

    <!-- Heatmap -->
    @if(isset($reportData['charts']['heatmap']))
    <div class="chart-container">
        <div class="chart-title">Mapa de Calor - Consumo por Hora/Dia</div>
        <img src="{{ $reportData['charts']['heatmap'] }}" class="chart-image" alt="Heatmap">
    </div>
    @endif

    <!-- Radar Chart -->
    @if(isset($reportData['charts']['efficiency_radar']))
    <div class="chart-container">
        <div class="chart-title">Comparativo de Eficiência - Múltiplas Dimensões</div>
        <img src="{{ $reportData['charts']['efficiency_radar'] }}" class="chart-image" alt="Radar">
    </div>
    @endif

    <!-- Seções por Dispositivo -->
    @foreach($reportData['metrics']['devices'] as $deviceName => $metrics)
    <div class="device-section">
        <div class="device-header">
            <div class="device-name">{{ $deviceName }}</div>
            <div class="efficiency-badge badge-{{ $metrics['efficiency_score'] >= 70 ? 'high' : ($metrics['efficiency_score'] >= 50 ? 'medium' : 'low') }}">
                Score: {{ $metrics['efficiency_score'] }}/100
            </div>
        </div>

        <!-- Métricas -->
        <div class="metrics-grid">
            <div class="metric-box">
                <div class="metric-label">kWh por Hora</div>
                <div class="metric-value">{{ number_format($metrics['kwh_per_hour'], 2, ',', '.') }}</div>
            </div>
            <div class="metric-box">
                <div class="metric-label">Load Factor</div>
                <div class="metric-value">{{ number_format($metrics['load_factor'], 1, ',', '.') }}%</div>
            </div>
            <div class="metric-box">
                <div class="metric-label">Status</div>
                <div class="metric-value">{{ $metrics['load_factor'] >= 60 ? '✓ Bom' : '⚠ Baixo' }}</div>
            </div>
        </div>

        <!-- Horários de Pico -->
        @if(!empty($metrics['peak_hours']))
        <div class="peak-hours">
            <h4>Horários de Pico de Consumo</h4>
            <ul class="peak-list">
                @foreach($metrics['peak_hours'] as $peak)
                <li><strong>{{ $peak['hour'] }}</strong> - {{ number_format($peak['avg_consumption'], 2, ',', '.') }} kWh</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Gauge de Eficiência -->
        @if(isset($reportData['charts']['gauges'][$deviceName]))
        <div class="chart-container">
            <img src="{{ $reportData['charts']['gauges'][$deviceName] }}" class="chart-image" alt="Gauge {{ $deviceName }}">
        </div>
        @endif

        <!-- Comparação com Benchmark -->
        @if(isset($metrics['benchmark_comparison']))
        <div class="insights-box">
            <h4>Comparação com Benchmark</h4>
            <ul>
                <li><strong>kWh/hora Real:</strong> {{ number_format($metrics['benchmark_comparison']['actual']['kwh_per_hour'], 2, ',', '.') }}</li>
                <li><strong>kWh/hora Ideal:</strong> {{ number_format($metrics['benchmark_comparison']['benchmark']['kwh_per_hour'], 2, ',', '.') }}</li>
                <li><strong>Variação:</strong> {{ $metrics['benchmark_comparison']['variance']['kwh_per_hour'] > 0 ? '+' : '' }}{{ number_format($metrics['benchmark_comparison']['variance']['kwh_per_hour'], 1, ',', '.') }}%</li>
            </ul>
        </div>
        @endif

        <!-- Sugestões de Otimização -->
        @if(!empty($metrics['optimization_suggestions']))
        <div class="insights-box">
            <h4>Sugestões de Otimização</h4>
            <ul>
                @foreach($metrics['optimization_suggestions'] as $suggestion)
                <li>{{ $suggestion }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    @endforeach

    <!-- Ranking Geral -->
    @if(!empty($reportData['metrics']['ranking']))
    <div class="device-section ranking-section">
        <h3 class="section-title">Ranking de Eficiência</h3>

        @if(isset($reportData['charts']['ranking']))
        <div class="chart-container">
            <img src="{{ $reportData['charts']['ranking'] }}" class="chart-image" alt="Ranking">
        </div>
        @endif

        <table class="ranking-table">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Dispositivo</th>
                    <th>Score de Eficiência</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['metrics']['ranking'] as $device => $score)
                <tr>
                    <td><strong>#{{ $loop->iteration }}</strong></td>
                    <td>{{ $device }}</td>
                    <td>{{ $reportData['metrics']['devices'][$device]['efficiency_score'] }}/100</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Relatório gerado automaticamente pelo sistema Wattalyze</p>
        <p>© {{ date('Y') }} - Todos os direitos reservados</p>
    </div>
</body>

</html>