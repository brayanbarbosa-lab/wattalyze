@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência e responsividade */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-orange: #e67e22;
        --primary-blue: #3498db;
        --primary-yellow: #f1c40f;
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

    /* Reset e otimizações base */
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

    /* Container principal responsivo */
    .main-container {
        width: 100%;
        padding: var(--spacing-sm);
        margin: 0 auto;
        max-width: 100%;
    }

    /* Header moderno responsivo */
    .modern-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        border-bottom: none;
    }

    .modern-header h1 {
        color: var(--primary-dark);
        font-weight: 700;
        margin: 0 0 var(--spacing-sm) 0;
        font-size: clamp(1.5rem, 4vw, 2rem);
        line-height: 1.2;
    }

    .header-controls {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        width: 100%;
    }

    /* Botões modernos responsivos */
    .modern-btn {
        border-radius: 12px;
        font-weight: 500;
        padding: 10px 16px;
        border: none;
        transition: var(--transition);
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        min-height: 40px;
        will-change: transform;
    }

    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .modern-btn-outline {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e9ecef;
        color: var(--text-muted);
    }

    .modern-btn-outline.active {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
    }

    /* Status filter buttons */
    .status-filters {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
        width: 100%;
    }

    /* Filtros modernos responsivos */
    .filters-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .modern-input-group {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        align-items: center;
    }

    .modern-input-group:focus-within {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
    }

    .modern-input-group .input-group-text {
        background: transparent;
        border: none;
        color: var(--text-muted);
        padding: 12px;
    }

    .modern-input-group .form-control {
        border: none;
        background: transparent;
        font-weight: 500;
        padding: 12px 0;
        flex: 1;
    }

    .modern-input-group .form-control:focus {
        box-shadow: none;
        outline: none;
    }

    .modern-select {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 500;
        transition: var(--transition);
        width: 100%;
        min-height: 44px;
    }

    .modern-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        outline: none;
    }

    /* Grid de filtros responsivo */
    .filters-grid {
        display: grid;
        gap: var(--spacing-sm);
        grid-template-columns: 1fr;
    }

    /* Cards de estatísticas responsivos */
    .stats-container {
        margin-bottom: var(--spacing-md);
    }

    .modern-stat-card {
        background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-dark) 100%);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        will-change: transform;
    }

    .modern-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    .modern-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .modern-stat-card.dark { --card-color: #2c3e50; --card-color-dark: #34495e; }
    .modern-stat-card.green { --card-color: #27ae60; --card-color-dark: #229954; }
    .modern-stat-card.red { --card-color: #e74c3c; --card-color-dark: #c0392b; }
    .modern-stat-card.orange { --card-color: #e67e22; --card-color-dark: #d35400; }

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
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Controles de visualização responsivos */
    .view-controls {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .view-controls-content {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        align-items: center;
    }

    .modern-radio-group {
        display: flex;
        gap: 2px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 4px;
    }

    .modern-radio-group .btn-check:checked + .btn {
        background: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
    }

    /* Container dos dispositivos responsivo */
    .devices-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        min-height: 400px;
    }

    /* Device cards responsivos */
    .device-card {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        margin-bottom: var(--spacing-md);
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
        border-color: var(--primary-green);
    }

    /* Badges modernos */
    .modern-badge {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 500;
        backdrop-filter: blur(10px);
        display: inline-block;
        white-space: nowrap;
    }

    .modern-badge.success {
        background: rgba(39, 174, 96, 0.1);
        color: var(--primary-green);
        border-color: rgba(39, 174, 96, 0.3);
    }

    .modern-badge.danger {
        background: rgba(231, 76, 60, 0.1);
        color: var(--primary-red);
        border-color: rgba(231, 76, 60, 0.3);
    }

    .modern-badge.warning {
        background: rgba(230, 126, 34, 0.1);
        color: var(--primary-orange);
        border-color: rgba(230, 126, 34, 0.3);
    }

    /* Tabela moderna responsiva */
    .table-responsive {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
    }

    .modern-table {
        background: white;
        margin: 0;
    }

    .modern-table thead th {
        background: var(--primary-dark);
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: clamp(0.75rem, 2vw, 0.85rem);
        padding: var(--spacing-sm);
    }

    .modern-table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid #f8f9fa;
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(39, 174, 96, 0.05), rgba(39, 174, 96, 0.1));
        transform: scale(1.005);
    }

    .modern-table td {
        padding: var(--spacing-sm);
        vertical-align: middle;
        font-size: 0.875rem;
    }

    /* Estado vazio responsivo */
    .empty-state {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-xl) var(--spacing-md);
        text-align: center;
    }

    .empty-state i {
        color: rgba(44, 62, 80, 0.3);
        margin-bottom: var(--spacing-md);
        font-size: clamp(3rem, 8vw, 4rem);
    }

    .empty-state h4 {
        color: var(--primary-dark);
        font-weight: 600;
        margin-bottom: var(--spacing-sm);
        font-size: clamp(1.1rem, 3vw, 1.25rem);
    }

    .empty-state p {
        color: var(--text-muted);
        margin-bottom: var(--spacing-md);
        font-size: clamp(0.9rem, 2.5vw, 1rem);
    }

    /* Modal moderno */
    .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-medium);
        backdrop-filter: blur(10px);
    }

    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: var(--spacing-md);
    }

    .modal-header h5 {
        color: var(--primary-dark);
        font-weight: 600;
        font-size: clamp(1rem, 3vw, 1.25rem);
        margin: 0;
    }

    .modal-body {
        padding: var(--spacing-md);
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: var(--spacing-md);
    }

    /* Status indicators */
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 0 8px rgba(255,255,255,0.5);
        flex-shrink: 0;
    }

    .status-online { background-color: var(--primary-green); }
    .status-offline { background-color: var(--primary-red); }
    .status-maintenance { background-color: var(--primary-orange); }

    /* Loading moderno */
    .modern-loading {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: var(--spacing-lg);
        text-align: center;
    }

    .spinner-border {
        color: var(--primary-green);
    }

    /* Chart container responsivo */
    .chart-container {
        position: relative;
        height: 60px;
        width: 100%;
        background: rgba(248, 249, 250, 0.5);
        border-radius: 8px;
        overflow: hidden;
    }

    .chart-canvas {
        width: 100% !important;
        height: 60px !important;
    }

    .chart-loading {
        height: 60px;
        background: linear-gradient(90deg, rgba(39, 174, 96, 0.1) 25%, rgba(39, 174, 96, 0.2) 50%, rgba(39, 174, 96, 0.1) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 8px;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Animações */
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

    /* Utilitários */
    .device-card-hidden,
    .device-row-hidden {
        display: none !important;
    }

    /* Media Queries - Mobile First */

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }
        
        .header-controls {
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .status-filters {
            flex-direction: row;
            gap: 2px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 4px;
            width: auto;
        }
        
        .filters-grid {
            grid-template-columns: 2fr 1fr 1fr auto;
        }
        
        .view-controls-content {
            flex-direction: row;
            justify-content: space-between;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }
        
        .modern-header {
            padding: var(--spacing-lg);
        }
        
        .filters-card,
        .view-controls,
        .devices-container {
            padding: var(--spacing-lg);
        }
        
        .device-card {
            margin-bottom: var(--spacing-lg);
        }
        
        .modern-table thead th,
        .modern-table td {
            padding: var(--spacing-md);
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .devices-container {
            min-height: 500px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 20vw;
            max-width: 75vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 18vw;
            max-width: 77vw;
        }
    }

    /* Reduce motion para acessibilidade */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Print styles */
    @media print {
        .main-container {
            margin: 0 !important;
            max-width: 100% !important;
            padding: var(--spacing-sm) !important;
        }
        
        .modern-header,
        .filters-card,
        .view-controls {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        .modern-btn,
        .chart-container {
            display: none !important;
        }
    }
</style>

<body>
    <div class="main-container">
        <!-- Header Moderno Responsivo -->
        <div class="modern-header animate-fade-in">
            <div class="header-controls">
                <div>
                    <h1>Dispositivos</h1>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-3 align-items-stretch align-sm-items-center">
                    <div class="status-filters">
                        <button type="button" class="btn modern-btn modern-btn-outline filter-btn" data-filter="online">
                            <span class="status-indicator status-online"></span> 
                            <span class="d-none d-sm-inline">Online</span>
                            <span class="modern-badge success ms-1" id="count-online">{{ $devices->where('status', 'online')->count() }}</span>
                        </button>
                        <button type="button" class="btn modern-btn modern-btn-outline filter-btn" data-filter="offline">
                            <span class="status-indicator status-offline"></span> 
                            <span class="d-none d-sm-inline">Offline</span>
                            <span class="modern-badge danger ms-1" id="count-offline">{{ $devices->where('status', 'offline')->count() }}</span>
                        </button>
                        <button type="button" class="btn modern-btn modern-btn-outline filter-btn active" data-filter="all">
                            <span class="d-none d-sm-inline">Todos</span>
                            <span class="d-sm-none">All</span>
                            <span class="modern-badge ms-1" style="background: rgba(108, 117, 125, 0.1); color: #495057;" id="count-all">{{ $devices->count() }}</span>
                        </button>
                    </div>
                    <a href="{{ route('devices.create') }}" class="btn modern-btn modern-btn-primary">
                        <i class="bi bi-plus"></i> 
                        <span class="d-none d-sm-inline">Novo Dispositivo</span>
                        <span class="d-sm-none">Novo</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros Modernos Responsivos -->
        <div class="filters-card animate-fade-in" style="animation-delay: 0.1s;">
            <div class="filters-grid">
                <div class="modern-input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchDevices" placeholder="Pesquisar dispositivos..." autocomplete="off">
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch" style="display: none; padding: 8px;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <select class="form-select modern-select" id="filterEnvironment">
                    <option value="">Todos os ambientes</option>
                    @foreach($environments as $environment)
                    <option value="{{ $environment->id }}">{{ $environment->name }}</option>
                    @endforeach
                </select>
                <select class="form-select modern-select" id="filterType">
                    <option value="">Todos os tipos</option>
                    @foreach($deviceTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <button class="btn modern-btn modern-btn-outline" id="resetFilters" title="Limpar filtros">
                    <i class="bi bi-arrow-clockwise"></i> 
                    <span class="d-none d-md-inline">Limpar</span>
                </button>
            </div>
        </div>

        <!-- Loading Indicator Moderno -->
        <div id="loadingIndicator" class="modern-loading animate-fade-in" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <div class="mt-2 text-muted">Atualizando dispositivos...</div>
        </div>

        <!-- Cards de Estatísticas Modernos -->
        @php
        $stats = [
            'total' => $devices->count(),
            'online' => $devices->where('status', 'online')->count(),
            'offline' => $devices->where('status', 'offline')->count(),
            'maintenance' => $devices->where('status', 'maintenance')->count()
        ];
        @endphp

        <div class="row g-3 g-md-4 stats-container animate-fade-in" id="statsCards" style="animation-delay: 0.2s;">
            <div class="col-6 col-lg-3">
                <div class="card modern-stat-card dark text-white">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="stat-subtitle mb-2">Total</h6>
                                <h2 class="stat-number" id="stat-total">{{ $stats['total'] }}</h2>
                            </div>
                            <i class="bi bi-cpu-fill opacity-75" style="font-size: clamp(1.5rem, 4vw, 2rem);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card modern-stat-card green text-white">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="stat-subtitle mb-2">Online</h6>
                                <h2 class="stat-number" id="stat-online">{{ $stats['online'] }}</h2>
                            </div>
                            <i class="bi bi-check-circle-fill opacity-75" style="font-size: clamp(1.5rem, 4vw, 2rem);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card modern-stat-card red text-white">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="stat-subtitle mb-2">Offline</h6>
                                <h2 class="stat-number" id="stat-offline">{{ $stats['offline'] }}</h2>
                            </div>
                            <i class="bi bi-x-circle-fill opacity-75" style="font-size: clamp(1.5rem, 4vw, 2rem);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card modern-stat-card orange text-white">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="stat-subtitle mb-2">Manutenção</h6>
                                <h2 class="stat-number" id="stat-maintenance">{{ $stats['maintenance'] }}</h2>
                            </div>
                            <i class="bi bi-wrench opacity-75" style="font-size: clamp(1.5rem, 4vw, 2rem);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($stats['total'] > 0)
        <!-- Controles de Visualização Modernos -->
        <div class="view-controls animate-fade-in" style="animation-delay: 0.3s;">
            <div class="view-controls-content">
                <div class="modern-radio-group">
                    <input type="radio" class="btn-check" name="viewMode" id="cardView" autocomplete="off" checked>
                    <label class="btn modern-btn modern-btn-outline" for="cardView">
                        <i class="bi bi-grid-3x3-gap"></i> 
                        <span class="d-none d-sm-inline ms-1">Cards</span>
                    </label>

                    <input type="radio" class="btn-check" name="viewMode" id="listView" autocomplete="off">
                    <label class="btn modern-btn modern-btn-outline" for="listView">
                        <i class="bi bi-list"></i> 
                        <span class="d-none d-sm-inline ms-1">Lista</span>
                    </label>
                </div>
                <small class="text-muted" id="resultsCount">Exibindo {{ $stats['total'] }} dispositivo(s)</small>
            </div>
        </div>

        <!-- Container dos Dispositivos Moderno -->
        <div class="devices-container animate-fade-in" style="animation-delay: 0.4s;" id="devicesContainer">
            <!-- Visualização em Cards -->
            <div class="row g-3 g-md-4" id="cardContainer">
                @foreach($devices as $device)
                @include('devices.partials.device-card', ['device' => $device])
                @endforeach
            </div>

            <!-- Visualização em Lista -->
            <div id="listContainer" style="display: none;">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Dispositivo</th>
                                <th class="d-none d-md-table-cell">Status</th>
                                <th class="d-none d-lg-table-cell">Tipo</th>
                                <th class="d-none d-lg-table-cell">Ambiente</th>
                                <th class="d-none d-sm-table-cell">Potência</th>
                                <th class="d-none d-md-table-cell">Consumo</th>
                                <th>Ações</th>
                                <th class="d-none d-md-table-cell"></th>
                            </tr>
                        </thead>
                        <tbody id="listTableBody">
                            @foreach($devices as $device)
                            @include('devices.partials.device-row', ['device' => $device])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Paginação -->
        @if(method_exists($devices, 'links'))
        <div class="d-flex justify-content-center mt-4 animate-fade-in" style="animation-delay: 0.5s;">
            {{ $devices->links() }}
        </div>
        @endif
        @else
        <!-- Estado Vazio Moderno -->
        <div class="empty-state animate-fade-in" style="animation-delay: 0.3s;">
            <i class="bi bi-cpu"></i>
            <h4>Nenhum dispositivo cadastrado</h4>
            <p>
                Adicione dispositivos para começar a monitorar o consumo de energia em tempo real.
            </p>
            <a href="{{ route('devices.create') }}" class="btn modern-btn modern-btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Adicionar Primeiro Dispositivo
            </a>
        </div>
        @endif
    </div>

    <!-- Modal de Confirmação Moderno -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o dispositivo <strong id="deviceToDelete"></strong>?</p>
                    <p class="text-muted small">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn modern-btn modern-btn-outline" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn modern-btn" style="background: var(--primary-red); color: white;" id="confirmDelete">
                        <i class="bi bi-trash"></i> Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Otimizado e Responsivo -->
    <script>
        class ResponsiveDeviceManager {
            constructor() {
                this.elements = this.cacheElements();
                this.state = {
                    currentFilter: 'all',
                    searchTerm: '',
                    environmentFilter: '',
                    typeFilter: '',
                    viewMode: 'card'
                };
                this.charts = new Map();
                this.deviceData = this.cacheDeviceData();
                this.chartJsLoaded = false;
                this.isMobile = window.innerWidth < 768;
                this.init();
            }

            cacheElements() {
                return {
                    searchInput: document.getElementById('searchDevices'),
                    clearSearch: document.getElementById('clearSearch'),
                    environmentSelect: document.getElementById('filterEnvironment'),
                    typeSelect: document.getElementById('filterType'),
                    resetButton: document.getElementById('resetFilters'),
                    filterButtons: document.querySelectorAll('.filter-btn'),
                    cardContainer: document.getElementById('cardContainer'),
                    listContainer: document.getElementById('listContainer'),
                    viewModeInputs: document.querySelectorAll('input[name="viewMode"]'),
                    resultsCount: document.getElementById('resultsCount'),
                    loadingIndicator: document.getElementById('loadingIndicator'),
                    deleteModal: new bootstrap.Modal(document.getElementById('deleteModal'))
                };
            }

            cacheDeviceData() {
                const devices = [];
                document.querySelectorAll('.device-card, .device-row').forEach(el => {
                    devices.push({
                        element: el,
                        name: (el.dataset.name || '').toLowerCase(),
                        status: el.dataset.status || '',
                        environment: el.dataset.environment || '',
                        type: el.dataset.type || '',
                        id: el.dataset.deviceId || ''
                    });
                });
                return devices;
            }

            init() {
                this.setupEventListeners();
                this.setupResponsiveHandlers();
                this.waitForChartJs().then(() => {
                    this.setupCharts();
                });
                this.updateStats();
            }

            setupResponsiveHandlers() {
                // Handle responsive changes
                const mediaQuery = window.matchMedia('(max-width: 767px)');
                const handleViewportChange = (e) => {
                    this.isMobile = e.matches;
                    this.handleResponsiveChanges();
                };
                
                mediaQuery.addListener(handleViewportChange);
                this.handleResponsiveChanges();
            }

            handleResponsiveChanges() {
                // Adjust chart sizes for mobile
                if (this.chartJsLoaded) {
                    this.charts.forEach(chart => {
                        if (chart) {
                            chart.resize();
                        }
                    });
                }

                // Update filter layout for mobile
                this.updateMobileLayout();
            }

            updateMobileLayout() {
                const statusFilters = document.querySelector('.status-filters');
                if (statusFilters) {
                    if (this.isMobile) {
                        statusFilters.style.flexDirection = 'column';
                    } else {
                        statusFilters.style.flexDirection = 'row';
                    }
                }
            }

            async waitForChartJs() {
                return new Promise((resolve) => {
                    const checkChartJs = () => {
                        if (typeof Chart !== 'undefined') {
                            this.chartJsLoaded = true;
                            console.log('Chart.js carregado com sucesso');
                            resolve();
                        } else {
                            setTimeout(checkChartJs, 100);
                        }
                    };
                    checkChartJs();
                });
            }

            setupEventListeners() {
                // Search with debounce
                this.elements.searchInput?.addEventListener('input',
                    this.debounce((e) => this.handleSearch(e.target.value), 300)
                );

                this.elements.clearSearch?.addEventListener('click', () => {
                    this.elements.searchInput.value = '';
                    this.handleSearch('');
                });

                // Filters
                this.elements.environmentSelect?.addEventListener('change', (e) => {
                    this.state.environmentFilter = e.target.value;
                    this.applyFilters();
                });

                this.elements.typeSelect?.addEventListener('change', (e) => {
                    this.state.typeFilter = e.target.value;
                    this.applyFilters();
                });

                // Status buttons
                this.elements.filterButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.handleStatusFilter(btn.dataset.filter);
                    });
                });

                // Reset
                this.elements.resetButton?.addEventListener('click', () => this.resetFilters());

                // View mode
                this.elements.viewModeInputs.forEach(input => {
                    input.addEventListener('change', (e) => {
                        if (e.target.checked) {
                            this.switchViewMode(e.target.id === 'cardView' ? 'card' : 'list');
                        }
                    });
                });

                // Delete modal
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.delete-device-btn')) {
                        e.preventDefault();
                        const btn = e.target.closest('.delete-device-btn');
                        this.showDeleteModal(btn.dataset.deviceId, btn.dataset.deviceName);
                    }
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', (e) => {
                    // Ctrl/Cmd + F for search focus
                    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                        e.preventDefault();
                        this.elements.searchInput?.focus();
                    }
                    
                    // Escape to clear search
                    if (e.key === 'Escape' && this.elements.searchInput === document.activeElement) {
                        this.elements.searchInput.value = '';
                        this.handleSearch('');
                        this.elements.searchInput.blur();
                    }
                });
            }

            debounce(func, wait) {
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

            handleSearch(term) {
                this.state.searchTerm = term.toLowerCase();
                this.elements.clearSearch.style.display = term ? 'block' : 'none';
                this.applyFilters();
            }

            handleStatusFilter(status) {
                this.state.currentFilter = status;

                // Update buttons
                this.elements.filterButtons.forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.filter === status);
                });

                this.applyFilters();
            }

            applyFilters() {
                this.showLoading(true);

                // Use requestAnimationFrame for smooth performance
                requestAnimationFrame(() => {
                    let visibleCount = 0;

                    this.deviceData.forEach(device => {
                        const matchesSearch = !this.state.searchTerm ||
                            device.name.includes(this.state.searchTerm);

                        const matchesStatus = this.state.currentFilter === 'all' ||
                            device.status === this.state.currentFilter;

                        const matchesEnvironment = !this.state.environmentFilter ||
                            device.environment === this.state.environmentFilter;

                        const matchesType = !this.state.typeFilter ||
                            device.type === this.state.typeFilter;

                        const isVisible = matchesSearch && matchesStatus &&
                            matchesEnvironment && matchesType;

                        device.element.style.display = isVisible ? '' : 'none';

                        if (isVisible) {
                            visibleCount++;
                            // Load chart if needed
                            if (this.chartJsLoaded) {
                                this.loadChartIfNeeded(device.element);
                            }
                        }
                    });

                    this.updateResultsCount(visibleCount);
                    this.showLoading(false);
                });
            }

            resetFilters() {
                this.state = {
                    currentFilter: 'all',
                    searchTerm: '',
                    environmentFilter: '',
                    typeFilter: '',
                    viewMode: this.state.viewMode
                };

                this.elements.searchInput.value = '';
                this.elements.clearSearch.style.display = 'none';
                this.elements.environmentSelect.value = '';
                this.elements.typeSelect.value = '';

                this.handleStatusFilter('all');
            }

            switchViewMode(mode) {
                this.state.viewMode = mode;

                if (mode === 'card') {
                    this.elements.cardContainer.style.display = '';
                    this.elements.listContainer.style.display = 'none';
                } else {
                    this.elements.cardContainer.style.display = 'none';
                    this.elements.listContainer.style.display = '';
                }

                // Re-apply filters for new mode
                this.applyFilters();
            }

            setupCharts() {
                if (!this.chartJsLoaded) {
                    console.warn('Chart.js não está carregado ainda');
                    return;
                }

                // Setup intersection observer for lazy loading
                if ('IntersectionObserver' in window) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.loadChartIfNeeded(entry.target);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, {
                        rootMargin: '50px'
                    });

                    this.deviceData.forEach(device => {
                        if (device.element.classList.contains('device-card')) {
                            observer.observe(device.element);
                        }
                    });
                }
            }

            loadChartIfNeeded(element) {
                const canvas = element.querySelector('.chart-canvas');
                if (!canvas || this.charts.has(canvas.id)) {
                    return;
                }

                const deviceId = canvas.dataset.deviceId;
                if (!deviceId) {
                    console.warn('Device ID não encontrado no canvas');
                    return;
                }

                try {
                    const chartData = JSON.parse(canvas.dataset.chartData || '[]');
                    const status = canvas.dataset.status;
                    const unit = canvas.dataset.unit;

                    if (chartData.length === 0) {
                        console.log(`Sem dados para device ${deviceId}`);
                        return;
                    }

                    this.createChart(canvas, chartData, status, unit, deviceId);
                } catch (error) {
                    console.error(`Erro ao processar dados do gráfico para device ${deviceId}:`, error);
                    this.showChartError(canvas);
                }
            }

            createChart(canvas, data, status, unit, deviceId) {
                if (!this.chartJsLoaded) {
                    console.warn('Chart.js não carregado');
                    return;
                }

                const colors = {
                    online: { border: '#28a745', background: 'rgba(40, 167, 69, 0.1)' },
                    offline: { border: '#dc3545', background: 'rgba(220, 53, 69, 0.1)' },
                    maintenance: { border: '#ffc107', background: 'rgba(255, 193, 7, 0.1)' }
                };

                const color = colors[status] || colors.offline;

                // Process data
                const labels = data.map(item => {
                    if (!item.date) return 'N/A';
                    
                    const dateParts = item.date.split('-');
                    if (dateParts.length !== 3) return 'N/A';
                    
                    const dt = new Date(
                        parseInt(dateParts[0]),
                        parseInt(dateParts[1]) - 1,
                        parseInt(dateParts[2]),
                        12, 0, 0
                    );
                    
                    return dt.toLocaleDateString('pt-BR', {
                        day: this.isMobile ? 'numeric' : '2-digit',
                        month: this.isMobile ? 'numeric' : '2-digit'
                    });
                });

                const values = data.map(item => {
                    const value = parseFloat(item.value);
                    return isNaN(value) ? 0 : value;
                });

                try {
                    const ctx = canvas.getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                borderColor: color.border,
                                backgroundColor: color.background,
                                pointBackgroundColor: color.border,
                                pointBorderColor: color.border,
                                borderWidth: this.isMobile ? 1 : 2,
                                pointRadius: this.isMobile ? 1 : 2,
                                pointHoverRadius: this.isMobile ? 3 : 4,
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            devicePixelRatio: Math.min(window.devicePixelRatio, 2),
                            animation: {
                                duration: this.isMobile ? 500 : 1000
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(0,0,0,0.8)',
                                    displayColors: false,
                                    titleFont: { size: this.isMobile ? 10 : 12 },
                                    bodyFont: { size: this.isMobile ? 9 : 11 },
                                    callbacks: {
                                        label: (context) => {
                                            const value = context.parsed.y;
                                            const precision = unit === 'kWh' ? 2 : 1;
                                            return `${value.toFixed(precision)} ${unit}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    grid: { display: false },
                                    ticks: {
                                        maxRotation: 0,
                                        font: { size: this.isMobile ? 8 : 9 },
                                        color: '#6c757d',
                                        maxTicksLimit: this.isMobile ? 4 : 6
                                    }
                                },
                                y: {
                                    display: false,
                                    grid: { display: false },
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    this.charts.set(canvas.id, chart);
                    console.log(`Gráfico criado com sucesso para device ${deviceId}`);
                } catch (error) {
                    console.error(`Erro ao criar gráfico para device ${deviceId}:`, error);
                    this.showChartError(canvas);
                }
            }

            showChartError(canvas) {
                const container = canvas.parentElement;
                if (container) {
                    container.innerHTML = `
                        <div class="text-center text-muted small py-2">
                            <i class="bi bi-exclamation-triangle opacity-50"></i>
                            <div style="font-size: 0.75rem;">Erro ao carregar gráfico</div>
                        </div>
                    `;
                }
            }

            updateResultsCount(count) {
                if (this.elements.resultsCount) {
                    this.elements.resultsCount.textContent =
                        `Exibindo ${count} dispositivo${count !== 1 ? 's' : ''}`;
                }
            }

            showLoading(show) {
                if (this.elements.loadingIndicator) {
                    this.elements.loadingIndicator.style.display = show ? 'block' : 'none';
                }
            }

            showDeleteModal(deviceId, deviceName) {
                const deviceToDeleteElement = document.getElementById('deviceToDelete');
                if (deviceToDeleteElement) {
                    deviceToDeleteElement.textContent = deviceName;
                }

                const confirmBtn = document.getElementById('confirmDelete');
                if (confirmBtn) {
                    confirmBtn.onclick = () => this.deleteDevice(deviceId);
                }

                this.elements.deleteModal.show();
            }

            deleteDevice(deviceId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/devices/${deviceId}`;
                form.style.display = 'none';

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                }

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }

            updateStats() {
                // Update real-time counters if needed
            }
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando ResponsiveDeviceManager...');
            
            setTimeout(() => {
                try {
                    window.deviceManager = new ResponsiveDeviceManager();
                    console.log('ResponsiveDeviceManager inicializado com sucesso');
                } catch (error) {
                    console.error('Erro ao inicializar ResponsiveDeviceManager:', error);
                }
            }, 500);
        });

        // Debug: check if Chart.js loaded
        window.addEventListener('load', function() {
            if (typeof Chart !== 'undefined') {
                console.log('Chart.js carregado:', Chart.version);
            } else {
                console.error('Chart.js NÃO foi carregado!');
            }
        });

        
    </script>
</body>
