@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência e manutenção */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-orange: #e67e22;
        --primary-blue: #3498db;
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

    /* Container principal - Mobile First */
    .main-container {
        width: 100%;
        min-height: 100vh;
        padding: var(--spacing-sm);
        margin: 0;
    }

    /* Cards modernos responsivos */
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

    /* Header moderno responsivo */
    .modern-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .modern-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0 0 var(--spacing-sm) 0;
        position: relative;
        line-height: 1.2;
    }

    .modern-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: clamp(40px, 8vw, 60px);
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--primary-dark));
        border-radius: 2px;
    }

    /* Header actions responsivas */
    .header-actions {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        align-items: stretch;
        width: 100%;
    }

    /* Botão moderno responsivo */
    .modern-btn {
        background: linear-gradient(135deg, var(--primary-green) 0%, #229954 100%);
        border: none;
        border-radius: 12px;
        color: white;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-align: center;
        white-space: nowrap;
        will-change: transform;
    }

    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }

    /* Environment card responsiva */
    .environment-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        overflow: visible;
        margin-bottom: var(--spacing-md);
        position: relative;
        will-change: transform;
    }

    .environment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(39, 174, 96, 0.03) 0%, transparent 50%);
        pointer-events: none;
    }

    .environment-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    /* Environment header responsivo */
    .env-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #34495e 100%);
        color: white;
        padding: var(--spacing-md);
        position: relative;
        overflow: visible;
    }

    .env-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .env-title {
        font-size: clamp(1.1rem, 3vw, 1.5rem);
        font-weight: 600;
        margin: 0 0 var(--spacing-sm) 0;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        line-height: 1.3;
    }

    /* Header controls responsivas */
    .env-controls {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
        width: 100%;
    }

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
        display: inline-block;
        white-space: nowrap;
    }

    .modern-badge.success {
        background: rgba(39, 174, 96, 0.9);
        border-color: rgba(39, 174, 96, 1);
    }

    /* Seletores customizados responsivos */
    .modern-select {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 8px 12px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: var(--transition);
        width: 100%;
        min-height: 40px;
    }

    .modern-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        outline: none;
    }

    /* Info cards responsivas */
    .info-card {
        background: rgba(248, 249, 250, 0.8);
        border: 1px solid rgba(233, 236, 239, 0.5);
        border-radius: 12px;
        backdrop-filter: blur(5px);
        transition: var(--transition);
        overflow: hidden;
    }

    .info-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 0;
    }

    .info-stat {
        text-align: center;
        padding: var(--spacing-sm);
        border-right: 1px solid rgba(233, 236, 239, 0.3);
    }

    .info-stat:last-child {
        border-right: none;
    }

    .info-stat-label {
        color: var(--text-muted);
        font-size: clamp(0.7rem, 2vw, 0.875rem);
        margin-bottom: 0.25rem;
        font-weight: 500;
        line-height: 1.2;
    }

    .info-stat-value {
        font-weight: 700;
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        color: var(--primary-dark);
        line-height: 1.2;
    }

    /* Chart container responsivo */
    .chart-container {
        background: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-sm);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin: var(--spacing-sm) 0;
        position: relative;
    }

    .chart-header {
        display: flex;
        align-items: center;
        margin-bottom: var(--spacing-sm);
        padding-bottom: var(--spacing-sm);
        border-bottom: 2px solid #f8f9fa;
        flex-wrap: wrap;
        gap: var(--spacing-xs);
    }

    .chart-icon {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        margin-right: 0.5rem;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .chart-title {
        font-size: clamp(1rem, 2.5vw, 1.125rem);
        font-weight: 600;
        color: var(--primary-dark);
        margin: 0;
        line-height: 1.3;
    }

    /* Chart height responsiva */
    .chart-wrapper {
        height: 250px;
        position: relative;
    }

    /* Devices section responsiva */
    .devices-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #34495e 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-md);
        position: relative;
        overflow: hidden;
    }

    .devices-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }

    .devices-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-sm);
        gap: var(--spacing-sm);
        flex-wrap: wrap;
    }

    .devices-title {
        font-size: clamp(1rem, 2.5vw, 1.125rem);
        font-weight: 600;
        margin: 0;
        line-height: 1.3;
    }

    .devices-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: var(--spacing-sm);
        align-items: start;
    }

    .device-item {
        text-align: center;
        padding: var(--spacing-sm);
        transition: var(--transition);
        border-radius: 8px;
        cursor: pointer;
        will-change: transform;
    }

    .device-item:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.1);
    }

    .device-item i {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        margin-bottom: 0.5rem;
        display: block;
    }

    .device-item .small {
        font-size: clamp(0.7rem, 2vw, 0.875rem);
        line-height: 1.2;
    }

    /* Add device button */
    .add-device-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 2px dashed rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        padding: var(--spacing-sm);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        min-height: 80px;
        will-change: transform;
    }

    .add-device-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    /* Empty state responsivo */
    .empty-state {
        text-align: center;
        padding: var(--spacing-xl) var(--spacing-md);
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: clamp(3rem, 8vw, 4rem);
        margin-bottom: var(--spacing-md);
        color: #dee2e6;
    }

    .empty-state h4 {
        color: var(--text-muted);
        margin-bottom: var(--spacing-sm);
        font-size: clamp(1.1rem, 3vw, 1.25rem);
    }

    .empty-state p {
        margin-bottom: var(--spacing-md);
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        line-height: 1.5;
    }

    /* Dropdown moderno responsivo */
    .modern-dropdown {
        position: relative;
    }

    .modern-dropdown .dropdown-toggle {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        color: var(--text-muted);
        font-weight: 500;
        transition: var(--transition);
        padding: 8px 12px;
        font-size: 0.85rem;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-dropdown .dropdown-toggle:hover,
    .modern-dropdown .dropdown-toggle:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.1);
    }

    .modern-dropdown .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: var(--shadow-medium);
        padding: 0.5rem 0;
        z-index: 1060;
        min-width: 150px;
    }

    .modern-dropdown .dropdown-item {
        padding: 0.75rem 1.25rem;
        transition: var(--transition);
        border-radius: 0;
        font-size: 0.875rem;
    }

    .modern-dropdown .dropdown-item:hover {
        background: rgba(39, 174, 96, 0.1);
        color: var(--primary-green);
    }

    .modern-dropdown .dropdown-item.text-danger:hover {
        background: rgba(231, 76, 60, 0.1);
        color: var(--primary-red);
    }

    /* Alerts modernos */
    .modern-alert {
        border: none;
        border-radius: 12px;
        border-left: 4px solid;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-sm) var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .modern-alert.alert-success {
        border-left-color: var(--primary-green);
        background: linear-gradient(90deg, rgba(39, 174, 96, 0.1) 0%, rgba(39, 174, 96, 0.05) 100%);
    }

    /* Loading state */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border-radius: var(--border-radius);
        z-index: 10;
    }

    .loading-spinner {
        width: 2rem;
        height: 2rem;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary-green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: var(--spacing-sm);
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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

    /* Media Queries - Mobile First Approach */
    
    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }
        
        .header-actions {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .env-controls {
            flex-direction: row;
            gap: var(--spacing-sm);
            align-items: center;
        }
        
        .modern-select {
            width: auto;
            min-width: 140px;
        }
        
        .chart-wrapper {
            height: 300px;
        }
        
        .devices-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
        
        .info-stats {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
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
        
        .env-header {
            padding: var(--spacing-lg);
        }
        
        .chart-container {
            padding: var(--spacing-md);
        }
        
        .chart-wrapper {
            height: 350px;
        }
        
        .devices-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
        
        .info-stats {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .info-stat {
            padding: var(--spacing-md);
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .chart-wrapper {
            height: 400px;
        }
        
        .devices-section {
            max-height: none;
        }
        
        .devices-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 17vw;
            max-width: 78vw;
            padding: var(--spacing-xl);
        }
        
        .chart-wrapper {
            height: 450px;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 15vw;
            max-width: 80vw;
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
        
        .modern-card,
        .environment-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
        }
        
        .modern-btn,
        .dropdown,
        .loading-overlay {
            display: none !important;
        }
    }
</style>

<body>
    <div class="main-container">
        {{-- Header moderno --}}
        <div class="modern-header animate-fade-in">
            <div class="header-actions">
                <div>
                    <h1 class="modern-title">Ambientes</h1>
                </div>
                <a href="{{ route('environments.create') }}" class="modern-btn">
                    <i class="bi bi-plus"></i> Novo Ambiente
                </a>
            </div>
        </div>

        {{-- Alert de sucesso --}}
        @if(session('success'))
            <div class="modern-alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Lista de ambientes --}}
        @if($environments->count() > 0)
            @foreach($environments as $index => $environment)
                <div class="environment-card animate-fade-in" 
                     style="animation-delay: {{ 0.1 + ($index * 0.1) }}s;" 
                     data-environment-id="{{ $environment->id }}">
                    
                    {{-- Cabeçalho do ambiente --}}
                    <div class="env-header">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-md-center gap-3">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <h4 class="env-title">{{ $environment->name }}</h4>
                                @if($environment->is_default)
                                    <span class="modern-badge">Padrão</span>
                                @endif
                            </div>
                            
                            <div class="env-controls">
                                <select class="form-select modern-select type-select" data-env-id="{{ $environment->id }}">
                                    <option value="energy" selected>⚡ Energia (kWh)</option>
                                    <option value="temperature">🌡️ Temperatura (°C)</option>
                                    <option value="humidity">💧 Umidade (%)</option>
                                </select>

                                <select class="form-select modern-select">
                                    <option selected>Últimos 7 dias</option>
                                </select>

                                <div class="dropdown modern-dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('environments.edit', $environment) }}">
                                            <i class="bi bi-pencil me-2"></i>Editar
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('environments.destroy', $environment) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este ambiente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Excluir
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Conteúdo do card --}}
                    <div class="p-3 p-md-4">
                        {{-- Informações básicas do ambiente --}}
                        <div class="row mb-3 mb-md-4">
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="info-stats">
                                        <div class="info-stat">
                                            <div class="info-stat-label">Tipo</div>
                                            <div class="info-stat-value">{{ ucfirst($environment->type) }}</div>
                                        </div>
                                        @if($environment->size_sqm)
                                        <div class="info-stat">
                                            <div class="info-stat-label">Área</div>
                                            <div class="info-stat-value">{{ $environment->size_sqm }}m²</div>
                                        </div>
                                        @endif
                                        @if($environment->occupancy)
                                        <div class="info-stat">
                                            <div class="info-stat-label">Ocupação</div>
                                            <div class="info-stat-value">{{ $environment->occupancy }} pessoas</div>
                                        </div>
                                        @endif
                                        <div class="info-stat">
                                            <div class="info-stat-label">Dispositivos</div>
                                            <div class="info-stat-value">{{ $environment->devices->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Gráfico --}}
                        <div class="chart-container">
                            <div class="chart-header">
                                <i class="bi bi-lightning-charge-fill text-success chart-icon" id="icon-env-{{ $environment->id }}"></i>
                                <h6 class="chart-title" id="title-env-{{ $environment->id }}">Consumo de Energia</h6>
                            </div>

                            <div class="chart-wrapper">
                                <canvas id="chart-env-{{ $environment->id }}"></canvas>
                                
                                {{-- Loading indicator --}}
                                <div id="loading-env-{{ $environment->id }}" class="loading-overlay d-none">
                                    <div class="loading-spinner"></div>
                                    <div class="text-muted">Carregando dados...</div>
                                </div>
                            </div>
                        </div>

                        {{-- Dispositivos conectados --}}
                        <div class="devices-section">
                            <div class="devices-header">
                                <h6 class="devices-title">Dispositivos Conectados</h6>
                                <span class="modern-badge success">{{ $environment->devices->count() }}</span>
                            </div>
                            
                            @if($environment->devices->count() > 0)
                                <div class="devices-grid">
                                    @foreach($environment->devices as $device)
                                        <div class="device-item" data-bs-toggle="tooltip" data-bs-title="{{ $device->deviceType->name ?? 'Dispositivo' }}">
                                            @php
                                                $deviceIcon = 'bi-cpu';
                                                $typeName = strtolower($device->deviceType->name ?? '');
                                                if (str_contains($typeName, 'temperature')) {
                                                    $deviceIcon = 'bi-thermometer';
                                                } elseif (str_contains($typeName, 'humidity')) {
                                                    $deviceIcon = 'bi-droplet';
                                                } elseif (str_contains($typeName, 'energy') || str_contains($typeName, 'power')) {
                                                    $deviceIcon = 'bi-lightning-charge';
                                                }
                                            @endphp
                                            <i class="bi {{ $deviceIcon }}"></i>
                                            <div class="small">{{ Str::limit($device->name, 15) }}</div>
                                        </div>
                                    @endforeach
                                    
                                    <a href="{{ route('devices.create', ['environment_id' => $environment->id]) }}" 
                                       class="add-device-btn"
                                       data-bs-toggle="tooltip" 
                                       data-bs-title="Adicionar dispositivo">
                                        <i class="bi bi-plus-lg"></i>
                                        <small>Adicionar</small>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="bi bi-exclamation-circle fs-4 text-warning mb-2"></i>
                                    <p class="mb-2">Nenhum dispositivo conectado</p>
                                    <a href="{{ route('devices.create', ['environment_id' => $environment->id]) }}" class="btn btn-outline-light btn-sm">
                                        <i class="bi bi-plus me-1"></i>Adicionar Primeiro Dispositivo
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            {{-- Empty state moderno --}}
            <div class="modern-card animate-fade-in">
                <div class="empty-state">
                    <i class="bi bi-house"></i>
                    <h4>Nenhum ambiente cadastrado</h4>
                    <p>Comece criando seu primeiro ambiente para monitorar o consumo de energia.</p>
                    <a href="{{ route('environments.create') }}" class="modern-btn">
                        <i class="bi bi-plus me-2"></i>Criar Primeiro Ambiente
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Chart.js com loading otimizado --}}
    <script>
        // Carregamento assíncrono do Chart.js
        if (!window.Chart) {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            script.onload = initializeCharts;
            document.head.appendChild(script);
        } else {
            initializeCharts();
        }

        function initializeCharts() {
            document.addEventListener('DOMContentLoaded', function () {
                // Dados e configurações
                const environmentDailyConsumption = @json($environmentDailyConsumption);
                const charts = {};

                // Configurações responsivas para cada tipo
                const typeConfigs = {
                    energy: {
                        label: 'Consumo de Energia',
                        unit: 'kWh',
                        icon: 'bi-lightning-charge-fill',
                        color: '#27ae60'
                    },
                    temperature: {
                        label: 'Temperatura',
                        unit: '°C',
                        icon: 'bi-thermometer-half',
                        color: '#e67e22'
                    },
                    humidity: {
                        label: 'Umidade',
                        unit: '%',
                        icon: 'bi-droplet-fill',
                        color: '#3498db'
                    }
                };

                function createChart(ctx, data, type) {
                    const config = typeConfigs[type];
                    const isMobile = window.innerWidth < 768;
                    
                    // Gradiente otimizado
                    const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
                    gradient.addColorStop(0, config.color + '40');
                    gradient.addColorStop(1, config.color + '10');
                    
                    return new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(d => {
                                const dt = new Date(d.date + 'T12:00:00');
                                return dt.toLocaleDateString('pt-BR', { 
                                    month: isMobile ? 'numeric' : 'short', 
                                    day: 'numeric' 
                                });
                            }),
                            datasets: [{
                                label: config.label,
                                data: data.map(d => parseFloat(d.value)),
                                backgroundColor: gradient,
                                borderColor: config.color,
                                borderWidth: isMobile ? 1 : 2,
                                borderRadius: isMobile ? 4 : 8,
                                barThickness: isMobile ? 20 : 30,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            devicePixelRatio: Math.min(window.devicePixelRatio, 2),
                            interaction: {
                                intersect: false,
                                mode: 'index'
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
                                            size: isMobile ? 10 : 12,
                                            weight: '500'
                                        },
                                        color: '#6c757d',
                                        maxTicksLimit: isMobile ? 5 : 8,
                                        callback: function(value) {
                                            return value.toFixed(1) + (isMobile ? '' : ' ' + config.unit);
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: isMobile ? 9 : 12,
                                            weight: '500'
                                        },
                                        color: '#6c757d',
                                        maxRotation: 0,
                                        maxTicksLimit: isMobile ? 5 : 7
                                    }
                                }
                            },
                            plugins: {
                                legend: { 
                                    display: false 
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: 'white',
                                    bodyColor: 'white',
                                    cornerRadius: 12,
                                    displayColors: false,
                                    titleFont: {
                                        size: isMobile ? 11 : 13
                                    },
                                    bodyFont: {
                                        size: isMobile ? 10 : 12
                                    },
                                    callbacks: {
                                        label: function(context) {
                                            return config.label + ': ' + context.parsed.y.toFixed(2) + ' ' + config.unit;
                                        }
                                    }
                                }
                            },
                            animation: {
                                duration: isMobile ? 500 : 750,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });
                }

                function updateChartAppearance(envId, type) {
                    const config = typeConfigs[type];
                    const icon = document.getElementById(`icon-env-${envId}`);
                    const title = document.getElementById(`title-env-${envId}`);
                    
                    if (icon) {
                        icon.className = `bi ${config.icon} chart-icon`;
                        icon.style.color = config.color;
                    }
                    
                    if (title) {
                        title.textContent = config.label;
                    }
                }

                // Inicializar tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Inicializar gráficos
                Object.entries(environmentDailyConsumption).forEach(([envId, typesData]) => {
                    const ctx = document.getElementById(`chart-env-${envId}`)?.getContext('2d');
                    if (!ctx) return;

                    const energyData = typesData.energy || [];
                    charts[envId] = createChart(ctx, energyData, 'energy');
                    updateChartAppearance(envId, 'energy');
                });

                // Event listeners com debounce
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

                // Mudança de tipo de dados
                document.querySelectorAll('.type-select').forEach(select => {
                    select.addEventListener('change', debounce(function () {
                        const envId = this.getAttribute('data-env-id');
                        if (!envId) return;

                        const dataByType = environmentDailyConsumption[envId];
                        if (!dataByType) return;

                        const type = this.value;
                        const chartData = dataByType[type] || [];
                        const config = typeConfigs[type];

                        // Loading state
                        const loadingEl = document.getElementById(`loading-env-${envId}`);
                        const chartEl = document.getElementById(`chart-env-${envId}`);
                        
                        if (loadingEl && chartEl) {
                            loadingEl.classList.remove('d-none');
                            chartEl.style.opacity = '0.3';
                        }

                        setTimeout(() => {
                            const chart = charts[envId];
                            if (!chart) return;

                            const isMobile = window.innerWidth < 768;
                            const gradient = chart.canvas.getContext('2d').createLinearGradient(0, 0, 0, chart.canvas.height);
                            gradient.addColorStop(0, config.color + '40');
                            gradient.addColorStop(1, config.color + '10');

                            // Atualizar configurações responsivas
                            chart.data.datasets[0].label = config.label;
                            chart.data.datasets[0].data = chartData.map(d => parseFloat(d.value));
                            chart.data.datasets[0].backgroundColor = gradient;
                            chart.data.datasets[0].borderColor = config.color;
                            chart.data.datasets[0].borderWidth = isMobile ? 1 : 2;
                            chart.data.datasets[0].borderRadius = isMobile ? 4 : 8;
                            chart.data.datasets[0].barThickness = isMobile ? 20 : 30;
                            
                            chart.options.scales.y.ticks.callback = function(value) {
                                return value.toFixed(1) + (isMobile ? '' : ' ' + config.unit);
                            };
                            
                            chart.options.plugins.tooltip.callbacks.label = function(context) {
                                return config.label + ': ' + context.parsed.y.toFixed(2) + ' ' + config.unit;
                            };

                            updateChartAppearance(envId, type);
                            chart.update('active');

                            if (loadingEl && chartEl) {
                                loadingEl.classList.add('d-none');
                                chartEl.style.opacity = '1';
                            }
                        }, 300);
                    }, 200));
                });

                // Redimensionamento responsivo
                const resizeObserver = new ResizeObserver(debounce(() => {
                    Object.values(charts).forEach(chart => {
                        if (chart && chart.canvas) {
                            const isMobile = window.innerWidth < 768;
                            
                            // Atualizar propriedades responsivas
                            chart.data.datasets[0].borderWidth = isMobile ? 1 : 2;
                            chart.data.datasets[0].borderRadius = isMobile ? 4 : 8;
                            chart.data.datasets[0].barThickness = isMobile ? 20 : 30;
                            chart.options.scales.y.ticks.font.size = isMobile ? 10 : 12;
                            chart.options.scales.x.ticks.font.size = isMobile ? 9 : 12;
                            chart.options.scales.y.ticks.maxTicksLimit = isMobile ? 5 : 8;
                            chart.options.scales.x.ticks.maxTicksLimit = isMobile ? 5 : 7;
                            chart.options.animation.duration = isMobile ? 500 : 750;
                            
                            chart.resize();
                            chart.update('none');
                        }
                    });
                }, 250));

                // Observar mudanças no container principal
                const mainContainer = document.querySelector('.main-container');
                if (mainContainer) {
                    resizeObserver.observe(mainContainer);
                }
            });
        }
    </script>
</body>
