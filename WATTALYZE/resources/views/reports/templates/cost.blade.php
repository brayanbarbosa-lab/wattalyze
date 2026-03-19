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
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }
        .kpi-icon { font-size: 24pt; margin-bottom: 10px; }
        .kpi-value { font-size: 18pt; font-weight: 700; color: #2E8B57; margin: 10px 0; }
        .kpi-label { font-size: 10pt; color: #718096; font-weight: 600; text-transform: uppercase; }
        .section-title {
            font-size: 18pt;
            font-weight: 700;
            color: #1a202c;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #2E8B57;
        }
        .device-section {
            background: #ffffff;
            padding: 25px;
            margin: 20px 0;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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
        .device-name { font-size: 16pt; font-weight: 700; color: #2D3748; }
        .efficiency-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 10pt;
        }
        .badge-high { background: #C6F6D5; color: #22543D; }
        .badge-medium { background: #FED7D7; color: #742A2A; }
        .chart-container {
            margin: 20px 0;
            text-align: center;
            page-break-inside: avoid;
        }
        .chart-title { font-size: 12pt; font-weight: 600; color: #4A5568; margin-bottom: 15px; }
        .chart-image { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .insights-box {
            background: #EDF2F7;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
        }
        .insights-box h4 { color: #2D3748; font-size: 13pt; margin-bottom: 12px; font-weight: 600; }
        .insights-box ul { list-style: none; padding-left: 0; }
        .insights-box li { padding: 8px 0; padding-left: 25px; position: relative; }
        .insights-box li:before { content: "✓"; position: absolute; left: 0; color: #2E8B57; font-weight: bold; }
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
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $reportData['report_name'] }}</h1>
        <div class="subtitle">Relatório de Análise de Custos Energéticos</div>
    </div>

    <!-- Período -->
    <div class="period-info">
        <strong>Período Analisado:</strong> {{ $reportData['period_start'] }} até {{ $reportData['period_end'] }}
        <br>
        <strong>Gerado em:</strong> {{ $reportData['generated_at'] }}
    </div>

    <!-- KPIs -->
    @php
        $metrics = $reportData['metrics'] ?? [];
        $devices = $metrics['devices'] ?? [];
        $summary = $metrics['summary'] ?? [];
    @endphp

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-value">R$ {{ number_format($summary['total_cost'] ?? 0, 2, ',', '.') }}</div>
            <div class="kpi-label">Custo Total</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value">R$ {{ number_format($summary['average_cost'] ?? 0, 2, ',', '.') }}</div>
            <div class="kpi-label">Custo Médio/dia</div>
        </div>
        <div class="kpi-card">
            
            <div class="kpi-value">{{ count($devices) }}</div>
            <div class="kpi-label">Dispositivos</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value">{{ count($devices) > 0 ? round($summary['average_cost'] / count($devices), 2) : 0 }}</div>
            <div class="kpi-label">Custo Médio por Dispositivo</div>
        </div>
    </div>

    <!-- Seções por Dispositivo -->
    @foreach($devices as $deviceName => $metrics)
    <div class="device-section">
        <div class="device-header">
            <div class="device-name">{{ $deviceName }}</div>
            <div class="efficiency-badge badge-{{ ($metrics['cost_efficiency_score'] ?? 0) >= 70 ? 'high' : 'medium' }}">
                Score: {{ $metrics['cost_efficiency_score'] ?? 0 }}/100
            </div>
        </div>

        <!-- Gráfico de Distribuição -->
        @if(isset($reportData['charts'][$deviceName]['bracket_pie']) && !empty($reportData['charts'][$deviceName]['bracket_pie']))
        <div class="chart-container">
            <div class="chart-title">Distribuição de Custos por Faixa Tarifária</div>
            <img src="{{ $reportData['charts'][$deviceName]['bracket_pie'] }}" class="chart-image" alt="Distribuição">
        </div>
        @endif

        <!-- Economia Potencial -->
        @if(($metrics['savings_potential'] ?? 0) > 0)
        <div style="background: #FED7D7; padding: 25px; border-radius: 10px; text-align: center; margin: 20px 0; border: 2px solid #FC8181;">
            <h3 style="color: #742A2A; font-size: 16pt; margin-bottom: 10px;">💡 Economia Potencial</h3>
            <div style="font-size: 32pt; font-weight: 700; color: #C53030;">{{ number_format($metrics['savings_potential'] ?? 0, 1) }}%</div>
        </div>
        @endif

        <!-- Insights -->
        <div class="insights-box">
            <h4>Análise e Recomendações</h4>
            <ul>
                <li>Custo total: <strong>R$ {{ number_format($metrics['total_cost'] ?? 0, 2, ',', '.') }}</strong></li>
                <li>Custo médio diário: <strong>R$ {{ number_format($metrics['average_daily_cost'] ?? 0, 2, ',', '.') }}</strong></li>
                <li>Projeção mensal: <strong>R$ {{ number_format(($metrics['projections']['monthly'] ?? 0), 2, ',', '.') }}</strong></li>
                <li>Projeção anual: <strong>R$ {{ number_format(($metrics['projections']['yearly'] ?? 0), 2, ',', '.') }}</strong></li>
            </ul>
        </div>
    </div>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <p>Relatório gerado automaticamente pelo sistema Wattalyze</p>
        <p>© {{ date('Y') }} - Todos os direitos reservados</p>
    </div>
</body>
</html>
