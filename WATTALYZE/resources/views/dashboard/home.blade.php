@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência e fácil manutenção */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-orange: #e67e22;
        --bg-light: #f8f9fa;
        --text-muted: #6c757d;
        --border-radius: 16px;
        --border-radius-small: 8px;
        --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.08);
        --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --spacing-xs: 0.5rem;
        --spacing-sm: 1rem;
        --spacing-md: 1.5rem;
        --spacing-lg: 2rem;
        --spacing-xl: 3rem;
    }

    /* Reset e base otimizada */
    * {
        box-sizing: border-box;
    }

    body {

        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }



    /* Container principal otimizado */
    .main-container {
        min-height: 100vh;
        padding: var(--spacing-sm);
    }

    /* Cards modernos com melhor performance */
    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        will-change: transform;
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    /* Cards de estatísticas otimizados */
    .stat-card {
        background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-dark) 100%);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        min-height: 140px;
        will-change: transform;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    /* Variações de cores para cards */
    .stat-card.dark { --card-color: #2c3e50; --card-color-dark: #34495e; }
    .stat-card.green { --card-color: #27ae60; --card-color-dark: #229954; }
    .stat-card.red { --card-color: #e74c3c; --card-color-dark: #c0392b; }
    .stat-card.orange { --card-color: #e67e22; --card-color-dark: #d35400; }

    /* Tipografia otimizada */
    .stat-number {
        font-size: clamp(1.5rem, 4vw, 2.2rem);
        font-weight: 700;
        margin: 0;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        line-height: 1.2;
    }

    .stat-subtitle {
        font-size: clamp(0.75rem, 2vw, 0.9rem);
        opacity: 0.9;
        font-weight: 500;
        margin-bottom: var(--spacing-xs);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Cards de dispositivos responsivos */
    .device-card {
        border: none;
        border-radius: var(--border-radius);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--device-color) 0%, var(--device-color-dark) 100%);
        min-height: 160px;
        will-change: transform;
    }

    .device-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .device-card:hover {
        transform: translateY(-2px) scale(1.01);
        box-shadow: var(--shadow-medium);
    }

    /* Estados dos dispositivos */
    .device-card.online { --device-color: #27ae60; --device-color-dark: #229954; }
    .device-card.offline { --device-color: #2c3e50; --device-color-dark: #34495e; }
    .device-card.maintenance { --device-color: #e67e22; --device-color-dark: #d35400; }

    /* Badges modernos */
    .modern-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 500;
        backdrop-filter: blur(10px);
    }

    /* Seletor customizado */
    .modern-select {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: var(--spacing-xs) var(--spacing-sm);
        font-weight: 500;
        transition: var(--transition);
        min-width: 180px;
    }

    .modern-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        outline: none;
    }

    /* Lista de alertas otimizada */
    .alert-list {
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .alert-item {
        border: none;
        border-left: 4px solid transparent;
        transition: var(--transition);
        position: relative;
        padding: var(--spacing-sm) var(--spacing-md);
        will-change: transform;
    }

    .alert-item:hover {
        transform: translateX(4px);
    }

    .alert-item.alert-danger {
        border-left-color: #e74c3c;
        background: linear-gradient(90deg, rgba(231, 76, 60, 0.1) 0%, rgba(231, 76, 60, 0.05) 100%);
    }

    .alert-item.alert-warning {
        border-left-color: #f39c12;
        background: linear-gradient(90deg, rgba(243, 156, 18, 0.1) 0%, rgba(243, 156, 18, 0.05) 100%);
    }

    .alert-item.alert-info {
        border-left-color: #3498db;
        background: linear-gradient(90deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%);
    }

    /* Títulos modernos */
    .modern-title {
        font-size: clamp(1.1rem, 3vw, 1.4rem);
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: var(--spacing-md);
        position: relative;
    }

    .modern-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-green), var(--primary-dark));
        border-radius: 2px;
    }

    /* Container do gráfico responsivo */
    .chart-container {
        position: relative;
        background: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-md);
        height: 400px;
    }

    /* Animações otimizadas */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Skeleton loading para UX */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: var(--border-radius-small);
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Utilitários responsivos */
    .text-responsive {
        font-size: clamp(0.875rem, 2.5vw, 1rem);
    }

    .icon-responsive {
        font-size: clamp(1rem, 3vw, 1.5rem);
    }

    /* Media Queries Otimizadas - Mobile First */
    
    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }
        
        .chart-container {
            height: 350px;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }
        
        .sidebar {
            width: 250px;
        }
        
        .chart-container {
            height: 400px;
            padding: var(--spacing-lg);
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .stat-number {
            font-size: 2.2rem;
        }
        
        .device-card {
            min-height: 180px;
        }
        
        .chart-container {
            height: 450px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            padding: var(--spacing-xl);
        }
        
        .chart-container {
            height: 500px;
        }
    }

    /* Pequenas telas (mobile) */
    @media (max-width: 767.98px) {
        .sidebar {
            transform: translateX(-100%);
            position: fixed;
            z-index: 1050;
            width: 280px;
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
        
        .main-container {
            margin-left: 0 !important;
            padding: var(--spacing-sm);
        }
        
        .row.g-4 {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }
        
        .modern-card {
            margin-bottom: var(--spacing-sm);
        }
        
        .stat-card {
            min-height: 120px;
        }
        
        .device-card {
            min-height: 140px;
        }
        
        .chart-container {
            padding: var(--spacing-sm);
            height: 300px;
        }
        
        .modern-select {
            width: 100%;
            margin-top: var(--spacing-xs);
        }
        
        .d-md-flex .col-md-6:first-child {
            margin-bottom: var(--spacing-sm);
        }
        
        .alert-item {
            padding: var(--spacing-sm);
        }
        
        .modern-title {
            font-size: 1.1rem;
            margin-bottom: var(--spacing-sm);
        }
    }

    /* Muito pequenas (até 480px) */
    @media (max-width: 479.98px) {
        .main-container {
            padding: 0.75rem;
        }
        
        .chart-container {
            height: 250px;
            padding: 0.75rem;
        }
        
        .stat-card .card-body {
            padding: 1rem !important;
        }
        
        .device-card .card-body {
            padding: 1rem !important;
        }
    }

    /* Otimizações de performance */
    .gpu-optimized {
        transform: translateZ(0);
        backface-visibility: hidden;
        perspective: 1000;
    }

    /* Reduce motion para usuários com preferências */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }

    /* Print styles */
    @media print {
        .sidebar,
        .modern-select,
        .chart-container canvas {
            display: none !important;
        }
        
        .main-container {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .modern-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">


            {{-- Conteúdo principal --}}
            <main class="col-md-10 ms-sm-auto main-container">
                {{-- Cartões de Estatísticas Modernos --}}
                <div class="row g-4 mb-4">
                    <div class="col-12 col-sm-6 col-xl-4 animate-fade-in gpu-optimized" style="animation-delay: 0.1s;">
                        <div class="card text-white stat-card dark">
                            <div class="card-body p-3 p-md-4">
                                <h6 class="stat-subtitle mb-2">Consumo Total (7 dias)</h6>
                                <h2 class="stat-number">{{ number_format($totalConsumptionValue, 4, ',', '.') }} kWh</h2>
                                <div class="d-flex align-items-center mt-3">
                                    <i class="fas fa-bolt me-2 opacity-75 icon-responsive"></i>
                                    <small class="opacity-75 text-responsive">Últimos 7 dias</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-4 animate-fade-in gpu-optimized" style="animation-delay: 0.2s;">
                        <div class="card text-white stat-card green">
                            <div class="card-body p-3 p-md-4">
                                <h6 class="stat-subtitle mb-2">Dispositivos Ativos</h6>
                                <h2 class="stat-number">{{ $devices->count() }}</h2>
                                <div class="d-flex align-items-center mt-3">
                                    <i class="fas fa-microchip me-2 opacity-75 icon-responsive"></i>
                                    <small class="opacity-75 text-responsive">Online agora</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-4 animate-fade-in gpu-optimized" style="animation-delay: 0.3s;">
                        <div class="card text-white stat-card red">
                            <div class="card-body p-3 p-md-4">
                                <h6 class="stat-subtitle mb-2">Alertas Ativos</h6>
                                <h2 class="stat-number">{{ $alerts->count() }}</h2>
                                <div class="d-flex align-items-center mt-3">
                                    <i class="fas fa-exclamation-triangle me-2 opacity-75 icon-responsive"></i>
                                    <small class="opacity-75 text-responsive">Requer atenção</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Gráfico de Consumo Moderno --}}
                <div class="modern-card mb-4 animate-fade-in gpu-optimized" style="animation-delay: 0.4s;">
                    <div class="card-body p-3 p-md-4">
                        <h5 class="modern-title">Consumo Diário</h5>
                        <div class="row align-items-center mb-4">
                            <div class="col-12 col-md-6">
                                <p class="text-muted mb-2 mb-md-0 text-responsive">Análise dos últimos 7 dias</p>
                            </div>
                            <div class="col-12 col-md-6 text-md-end">
                                <label for="dataTypeSelector" class="form-label me-3 text-responsive">Tipo de dado:</label>
                                <select id="dataTypeSelector" class="form-select modern-select">
                                    <option value="energy" selected>⚡ Energia (kWh)</option>
                                    <option value="temperature">🌡️ Temperatura (°C)</option>
                                    <option value="humidity">💧 Umidade (%)</option>
                                </select>
                            </div>
                        </div>

                        <div class="chart-container">
                            <canvas id="dailyConsumptionChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Dispositivos Modernos --}}
                <div class="mb-4 animate-fade-in gpu-optimized" style="animation-delay: 0.5s;">
                    <h5 class="modern-title">Dispositivos Conectados</h5>
                    @if($devices->isEmpty())
                        <div class="modern-card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-plug fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0 text-responsive">Nenhum dispositivo conectado no momento</p>
                            </div>
                        </div>
                    @else
                        <div class="row g-3 g-md-4">
                            @foreach($devices as $index => $device)
                                @php
                                    $deviceId = $device->id;
                                    $dailyData = $dailyConsumption[$deviceId]['energy']
                                        ?? $dailyConsumption[$deviceId]['temperature']
                                        ?? $dailyConsumption[$deviceId]['humidity']
                                        ?? [];

                                    $todayConsumption = 0;
                                    $isEnergyDevice = true;
                                    $unit = 'kWh';
                                    $icon = 'fa-plug';
                                    $deviceTypeName = strtolower($device->deviceType->name ?? '');

                                    if (str_contains($deviceTypeName, 'temperature')) {
                                        $isEnergyDevice = false;
                                        $unit = '°C';
                                        $icon = 'fa-thermometer-half';
                                    } elseif (str_contains($deviceTypeName, 'humidity')) {
                                        $isEnergyDevice = false;
                                        $unit = '%';
                                        $icon = 'fa-tint';
                                    }

                                    if (!empty($dailyData)) {
                                        $lastDay = end($dailyData);
                                        $todayConsumption = $lastDay['value'] ?? 0;
                                    }

                                    $statusClass = match($device->status) {
                                        'online' => 'online',
                                        'offline' => 'offline',
                                        default => 'maintenance'
                                    };
                                @endphp
                                <div class="col-12 col-sm-6 col-lg-4 animate-fade-in gpu-optimized" style="animation-delay: {{ 0.6 + ($index * 0.1) }}s;">
                                    <div class="card text-white device-card {{ $statusClass }} h-100">
                                        <div class="card-body p-3 p-md-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="flex-grow-1 me-2">
                                                    <h5 class="card-title mb-1 text-responsive">{{ Str::limit($device->name, 20) }}</h5>
                                                    <p class="mb-0 opacity-75 text-responsive">{{ ucfirst($device->status) }}</p>
                                                </div>
                                                <i class="fas {{ $icon }} fa-lg opacity-75 flex-shrink-0"></i>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <span class="modern-badge text-responsive">
                                                    {{ Str::limit($device->deviceType->name ?? 'Tipo desconhecido', 15) }}
                                                </span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div class="flex-grow-1">
                                                    <small class="opacity-75 text-responsive">Leitura atual</small>
                                                    <div class="fw-bold" style="font-size: clamp(1rem, 3vw, 1.25rem);">
                                                        @if($todayConsumption > 0 || !$isEnergyDevice)
                                                            {{ number_format($todayConsumption, 4, ',', '.') }} {{ $unit }}
                                                        @else
                                                            <span class="opacity-50">N/A</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-end flex-shrink-0">
                                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                         style="width: 12px; height: 12px; background: {{ $device->status === 'online' ? '#00ff00' : '#ff6b6b' }}; box-shadow: 0 0 8px rgba(255,255,255,0.5);">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Alertas Modernos --}}
                <div class="modern-card mb-4 animate-fade-in gpu-optimized" style="animation-delay: 0.7s;">
                    <div class="card-body p-3 p-md-4">
                        <h5 class="modern-title">Centro de Alertas</h5>
                        @if($alerts->isEmpty())
                            <div class="text-center py-4 py-md-5">
                                <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                                <p class="text-muted mb-0 text-responsive">Nenhum alerta ativo. Sistema funcionando normalmente!</p>
                            </div>
                        @else
                            <div class="alert-list">
                                @foreach($alerts as $alert)
                                    @php
                                        $alertClass = match($alert->severity) {
                                            'high' => 'alert-danger',
                                            'low' => 'alert-info',
                                            default => 'alert-warning'
                                        };
                                        
                                        $alertIcon = match($alert->severity) {
                                            'high' => 'fa-exclamation-circle text-danger',
                                            'low' => 'fa-info-circle text-info',
                                            default => 'fa-exclamation-triangle text-warning'
                                        };
                                    @endphp
                                    <div class="alert-item {{ $alertClass }} d-flex align-items-start justify-content-between flex-wrap">
                                        <div class="d-flex align-items-start flex-grow-1 me-2">
                                            <i class="fas {{ $alertIcon }} me-3 mt-1 flex-shrink-0"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium text-responsive">{{ $alert->message }}</div>
                                                <small class="text-muted text-responsive">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $alert->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modern-badge mt-2 mt-sm-0 flex-shrink-0" style="background: rgba(108, 117, 125, 0.1); color: #495057; border-color: rgba(108, 117, 125, 0.2);">
                                            <i class="fas fa-microchip me-1"></i>
                                            <span class="text-responsive">{{ Str::limit($alert->device->name ?? 'Dispositivo desconhecido', 15) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- Modal de overlay para mobile --}}
    <div class="modal-backdrop fade d-md-none" id="sidebarBackdrop" style="display: none;"></div>
</body>

{{-- Carregamento assíncrono de recursos --}}
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></noscript>

<script>
    // Carregamento otimizado do Chart.js
    if (!window.Chart) {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = initializeChart;
        document.head.appendChild(script);
    } else {
        initializeChart();
    }

    function initializeChart() {
        document.addEventListener('DOMContentLoaded', function() {
            // Cache de dados para evitar reprocessamento
            const dailyConsumptionData = @json($dailyConsumption ?? []);
            const deviceTypes = @json($devices->pluck('deviceType.name', 'id') ?? []);

            // Debounce para otimizar mudanças do selector
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Função otimizada para agregar dados
            function aggregateDataByType(type) {
                const aggregated = new Map();

                Object.entries(dailyConsumptionData).forEach(([deviceId, deviceData]) => {
                    if (!deviceData[type]) return;

                    const typeName = (deviceTypes[deviceId] || '').toLowerCase();

                    if (type === 'energy' && (typeName.includes('temperature') || typeName.includes('humidity'))) {
                        return;
                    }

                    if ((type === 'temperature' && !typeName.includes('temperature')) ||
                        (type === 'humidity' && !typeName.includes('humidity'))) {
                        return;
                    }

                    deviceData[type].forEach(day => {
                        const currentValue = aggregated.get(day.date) || 0;
                        aggregated.set(day.date, currentValue + day.value);
                    });
                });

                return Object.fromEntries(aggregated);
            }

            function formatLabels(dates) {
                return dates.map(dateStr => {
                    const [year, month, day] = dateStr.split('-');
                    return `${day}/${month}`;
                });
            }

            // Configurações otimizadas do gráfico
            const ctx = document.getElementById('dailyConsumptionChart');
            if (!ctx) return;
            
            const ctxContext = ctx.getContext('2d');
            let chart = null;

            function createChart(labels, values, type) {
                const colors = {
                    energy: {
                        border: '#27ae60',
                        background: 'rgba(39, 174, 96, 0.1)',
                        gradient: ['#27ae60', '#2ecc71']
                    },
                    temperature: {
                        border: '#f39c12',
                        background: 'rgba(243, 156, 18, 0.1)',
                        gradient: ['#f39c12', '#f1c40f']
                    },
                    humidity: {
                        border: '#3498db',
                        background: 'rgba(52, 152, 219, 0.1)',
                        gradient: ['#3498db', '#5dade2']
                    },
                };

                if (chart) {
                    chart.destroy();
                }

                // Criar gradiente
                const gradient = ctxContext.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colors[type].gradient[0] + '40');
                gradient.addColorStop(1, colors[type].gradient[1] + '10');

                chart = new Chart(ctxContext, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: {
                                energy: 'Consumo de Energia (kWh)',
                                temperature: 'Temperatura (°C)',
                                humidity: 'Umidade (%)'
                            }[type],
                            data: values,
                            borderColor: colors[type].border,
                            backgroundColor: gradient,
                            pointBackgroundColor: colors[type].border,
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: window.innerWidth < 768 ? 4 : 6,
                            pointHoverRadius: window.innerWidth < 768 ? 6 : 8,
                            fill: true,
                            tension: 0.4,
                            borderWidth: window.innerWidth < 768 ? 2 : 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        devicePixelRatio: Math.min(window.devicePixelRatio, 2),
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: window.innerWidth < 768 ? 12 : 14,
                                        weight: '500'
                                    },
                                    color: '#2c3e50',
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: colors[type].border,
                                borderWidth: 1,
                                cornerRadius: 12,
                                displayColors: false,
                                titleFont: {
                                    size: window.innerWidth < 768 ? 12 : 14
                                },
                                bodyFont: {
                                    size: window.innerWidth < 768 ? 11 : 13
                                },
                                callbacks: {
                                    label: context => {
                                        let suffix = '';
                                        if (type === 'energy') suffix = ' kWh';
                                        else if (type === 'temperature') suffix = ' °C';
                                        else if (type === 'humidity') suffix = ' %';
                                        return `${context.parsed.y.toFixed(4)}${suffix}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: {
                                        size: window.innerWidth < 768 ? 10 : 12,
                                        weight: '500'
                                    },
                                    color: '#6c757d',
                                    maxTicksLimit: window.innerWidth < 768 ? 5 : 8
                                },
                                title: {
                                    display: window.innerWidth >= 768,
                                    text: {
                                        energy: 'Consumo (kWh)',
                                        temperature: 'Temperatura (°C)',
                                        humidity: 'Umidade (%)'
                                    }[type],
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    },
                                    color: '#2c3e50'
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: {
                                        size: window.innerWidth < 768 ? 10 : 12,
                                        weight: '500'
                                    },
                                    color: '#6c757d',
                                    maxTicksLimit: window.innerWidth < 768 ? 4 : 7
                                },
                                title: {
                                    display: window.innerWidth >= 768,
                                    text: 'Data',
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    },
                                    color: '#2c3e50'
                                }
                            }
                        }
                    }
                });
            }

            // Inicialização
            let currentType = 'energy';
            let aggregated = aggregateDataByType(currentType);
            let sortedDates = Object.keys(aggregated).sort();
            let labels = formatLabels(sortedDates);
            let values = sortedDates.map(date => parseFloat(aggregated[date].toFixed(4)));

            createChart(labels, values, currentType);

            // Event listener com debounce
            const selector = document.getElementById('dataTypeSelector');
            if (selector) {
                selector.addEventListener('change', debounce((e) => {
                    currentType = e.target.value;
                    aggregated = aggregateDataByType(currentType);
                    sortedDates = Object.keys(aggregated).sort();
                    labels = formatLabels(sortedDates);
                    values = sortedDates.map(date => parseFloat(aggregated[date].toFixed(currentType === 'energy' ? 6 : 2)));
                    createChart(labels, values, currentType);
                }, 300));
            }

            // Redimensionamento otimizado
            const resizeObserver = new ResizeObserver(debounce(() => {
                if (chart) {
                    chart.resize();
                }
            }, 250));

            resizeObserver.observe(ctx);
        });
    }

    // Menu mobile otimizado
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtns = document.querySelectorAll('[data-bs-toggle="collapse"]');
        const sidebar = document.querySelector('.sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        toggleBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (sidebar && backdrop) {
                    sidebar.classList.toggle('show');
                    if (sidebar.classList.contains('show')) {
                        backdrop.style.display = 'block';
                        setTimeout(() => backdrop.classList.add('show'), 10);
                        document.body.style.overflow = 'hidden';
                    } else {
                        backdrop.classList.remove('show');
                        setTimeout(() => {
                            backdrop.style.display = 'none';
                            document.body.style.overflow = '';
                        }, 300);
                    }
                }
            });
        });

        if (backdrop) {
            backdrop.addEventListener('click', function() {
                if (sidebar) {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                    setTimeout(() => {
                        backdrop.style.display = 'none';
                        document.body.style.overflow = '';
                    }, 300);
                }
            });
        }
    });

    // Lazy loading para animações
    const observeElements = () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        });

        document.querySelectorAll('.animate-fade-in').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    };

    if ('IntersectionObserver' in window) {
        observeElements();
    }
</script>
