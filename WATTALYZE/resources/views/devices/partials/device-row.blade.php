@php
$deviceId = $device->id;
$dailyData = $dailyConsumption[$deviceId] ?? [];
$todayConsumption = 0;

if (!empty($dailyData)) {
$lastRecord = end($dailyData);
$todayConsumption = $lastRecord['value'] ?? 0;
}

$instantaneousPower = $influxData[$deviceId]['instantaneous_power'] ?? null;

// Determinar ícone do dispositivo baseado no tipo
$deviceIcon = 'bi-cpu';
$deviceColor = '--primary-blue';
$typeName = strtolower($device->deviceType->name ?? '');

if (str_contains($typeName, 'temperature')) {
$deviceIcon = 'bi-thermometer-half';
$deviceColor = '--primary-orange';
} elseif (str_contains($typeName, 'humidity')) {
$deviceIcon = 'bi-droplet';
$deviceColor = '--primary-blue';
} elseif (str_contains($typeName, 'energy') || str_contains($typeName, 'power')) {
$deviceIcon = 'bi-lightning-charge';
$deviceColor = '--primary-green';
}
@endphp

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-blue: #3498db;
        --primary-orange: #e67e22;
        --primary-red: #e74c3c;
        --primary-purple: #9b59b6;
        --bg-light: #f8f9fa;
        --text-muted: #6c757d;
        --border-radius: 12px;
        --border-radius-small: 8px;
        --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.08);
        --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --spacing-xs: 0.5rem;
        --spacing-sm: 1rem;
        --spacing-md: 1.5rem;
    }

    /* Linha do dispositivo moderna e responsiva */
    .device-row {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none !important;
        transition: var(--transition);
        position: relative;
        cursor: pointer;
        will-change: transform;
    }

    .device-row::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: transparent;
        transition: var(--transition);
        border-radius: 0 2px 2px 0;
        z-index: 1;
    }

    .device-row:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-light);
        background: rgba(255, 255, 255, 1);
        z-index: 10;
    }

    .device-row:hover::before {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        box-shadow: 0 0 15px rgba(39, 174, 96, 0.3);
    }

    .device-row td {
        border: none !important;
        padding: clamp(0.75rem, 2vw, 1.2rem) clamp(0.5rem, 1.5vw, 1rem);
        vertical-align: middle;
        position: relative;
    }

    /* Adaptação responsiva da tabela */
    @media (max-width: 767.98px) {
        .device-row {
            display: block;
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            margin-bottom: var(--spacing-sm);
            box-shadow: var(--shadow-light);
            border: 1px solid rgba(233, 236, 239, 0.5) !important;
        }

        .device-row::before {
            width: 100%;
            height: 4px;
            top: 0;
            left: 0;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .device-row td {
            display: block;
            padding: var(--spacing-sm);
            border-bottom: 1px solid rgba(233, 236, 239, 0.3) !important;
        }

        .device-row td:last-child {
            border-bottom: none !important;
        }

        .device-row td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary-dark);
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        /* Primeira coluna (device info) não precisa de label */
        .device-row td:first-child::before {
            display: none;
        }

        /* Última coluna (actions) tem layout especial */
        .device-row td:last-child {
            text-align: center;
            padding-top: var(--spacing-md);
        }

        .device-row td:last-child::before {
            display: none;
        }
    }

    /* Indicador de status moderno */
    .status-indicator {
        width: clamp(10px, 2.5vw, 14px);
        height: clamp(10px, 2.5vw, 14px);
        border-radius: 50%;
        display: inline-block;
        position: relative;
        margin-right: var(--spacing-xs);
        flex-shrink: 0;
    }

    .status-indicator::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50%;
        background: inherit;
        opacity: 0.3;
        animation: pulse 2s infinite ease-in-out;
    }

    .status-online {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        box-shadow: 0 0 12px rgba(39, 174, 96, 0.4);
    }

    .status-offline {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        box-shadow: 0 0 12px rgba(149, 165, 166, 0.4);
    }

    .status-maintenance {
        background: linear-gradient(135deg, #e67e22, #f39c12);
        box-shadow: 0 0 12px rgba(230, 126, 34, 0.4);
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.3;
        }

        50% {
            transform: scale(1.15);
            opacity: 0.1;
        }
    }

    /* Badge moderno responsivo */
    .modern-status-badge {
        background: linear-gradient(135deg, var(--badge-color), var(--badge-color-dark));
        color: white;
        border: none;
        border-radius: 20px;
        padding: clamp(4px, 1vw, 6px) clamp(8px, 2vw, 12px);
        font-size: clamp(0.7rem, 1.8vw, 0.75rem);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: var(--shadow-light);
        white-space: nowrap;
    }

    .modern-status-badge.bg-success {
        --badge-color: #27ae60;
        --badge-color-dark: #229954;
    }

    .modern-status-badge.bg-danger {
        --badge-color: #e74c3c;
        --badge-color-dark: #c0392b;
    }

    .modern-status-badge.bg-warning {
        --badge-color: #f39c12;
        --badge-color-dark: #e67e22;
        color: #000;
    }

    .modern-status-badge i {
        font-size: 0.65rem;
        flex-shrink: 0;
    }

    /* Informações do dispositivo responsivas */
    .device-info {
        display: flex;
        align-items: flex-start;
        gap: var(--spacing-xs);
    }

    .device-content {
        flex: 1;
        min-width: 0;
    }

    .device-name {
        font-weight: 700;
        color: var(--primary-dark);
        font-size: clamp(0.9rem, 2.2vw, 1rem);
        margin: 0 0 0.25rem 0;
        line-height: 1.3;
        word-break: break-word;
    }

    .device-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .device-meta small {
        color: var(--text-muted);
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        display: flex;
        align-items: center;
        gap: 4px;
        line-height: 1.2;
    }

    .device-meta i {
        width: 12px;
        flex-shrink: 0;
        font-size: 0.75em;
    }

    /* Tipo de dispositivo responsivo */
    .device-type-info {
        display: flex;
        align-items: center;
        gap: clamp(8px, 2vw, 12px);
    }

    .device-type-icon {
        width: clamp(32px, 8vw, 40px);
        height: clamp(32px, 8vw, 40px);
        border-radius: var(--border-radius-small);

        background: linear-gradient(135deg, var({
                    {
                    $deviceColor
                }
            }), var(--primary-blue));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-light);
    flex-shrink: 0;
    }

    .device-type-icon i {
        font-size: clamp(0.9rem, 2.2vw, 1.1rem);
    }

    .device-type-content {
        flex: 1;
        min-width: 0;
    }

    .device-type-name {
        font-weight: 600;
        color: var(--primary-dark);
        margin: 0 0 2px 0;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        line-height: 1.2;
        word-break: break-word;
    }

    .device-power-rating {
        color: var(--text-muted);
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        margin: 0;
        line-height: 1.2;
    }

    /* Ambiente responsivo */
    .environment-info {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: clamp(6px, 1.5vw, 8px) clamp(8px, 2vw, 12px);
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05));
        border-radius: var(--border-radius-small);
        border-left: 3px solid var(--primary-green);
        min-height: 36px;
    }

    .environment-info i {
        color: var(--primary-green);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        flex-shrink: 0;
    }

    .environment-info span {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        word-break: break-word;
    }

    /* Métricas responsivas */
    .metric-value {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: clamp(6px, 1.5vw, 8px) clamp(8px, 2vw, 12px);
        background: rgba(52, 152, 219, 0.1);
        border-radius: var(--border-radius-small);
        border-left: 3px solid var(--primary-blue);
        min-height: 36px;
    }

    .metric-value.power {
        background: linear-gradient(135deg, rgba(230, 126, 34, 0.1), rgba(243, 156, 18, 0.05));
        border-left-color: var(--primary-orange);
    }

    .metric-value.power i {
        color: var(--primary-orange);
    }

    .metric-value.consumption {
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05));
        border-left-color: var(--primary-green);
    }

    .metric-value.consumption i {
        color: var(--primary-green);
    }

    .metric-value i {
        color: var(--primary-blue);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        flex-shrink: 0;
    }

    .metric-number {
        font-weight: 700;
        color: var(--primary-dark);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        word-break: break-word;
    }

    /* Botões de ação responsivos */
    .modern-action-group {
        display: flex;
        gap: clamp(4px, 1vw, 6px);
        justify-content: center;
        flex-wrap: wrap;
    }

    .modern-action-btn {
        width: clamp(32px, 8vw, 36px);
        height: clamp(32px, 8vw, 36px);
        border-radius: var(--border-radius-small);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        will-change: transform;
    }

    .modern-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        pointer-events: none;
    }

    .modern-action-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: var(--shadow-medium);
    }

    .modern-action-btn i {
        font-size: clamp(0.8rem, 2vw, 0.9rem);
    }

    .modern-action-btn.view {
        background: linear-gradient(135deg, #3498db, #5dade2);
        color: white;
    }

    .modern-action-btn.edit {
        background: linear-gradient(135deg, #f39c12, #f1c40f);
        color: white;
    }

    .modern-action-btn.diagnostics {
        background: linear-gradient(135deg, #9b59b6, #af7ac5);
        color: white;
    }

    .modern-action-btn.delete {
        background: linear-gradient(135deg, #e74c3c, #ec7063);
        color: white;
    }

    /* Estado vazio responsivo */
    .empty-state {
        color: var(--text-muted);
        font-style: italic;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: clamp(6px, 1.5vw, 8px) clamp(8px, 2vw, 12px);
        background: rgba(108, 117, 125, 0.1);
        border-radius: var(--border-radius-small);
        min-height: 36px;
        font-size: clamp(0.8rem, 2vw, 0.85rem);
    }

    .empty-state i {
        opacity: 0.5;
        flex-shrink: 0;
        font-size: 0.9em;
    }

    /* Animações de performance */
    @media (prefers-reduced-motion: reduce) {

        .device-row,
        .modern-action-btn,
        .status-indicator::before {
            transition: none;
            animation: none;
        }
    }

    /* Loading skeleton para dispositivos */
    .device-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: var(--border-radius-small);
        height: 20px;
        margin: 2px 0;
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    /* Media query específica para tablets */
    @media (min-width: 768px) and (max-width: 1023.98px) {
        .device-type-info {
            flex-direction: column;
            text-align: center;
            gap: 6px;
        }

        .device-type-content {
            text-align: center;
        }

        .modern-action-group {
            flex-direction: column;
            gap: 4px;
        }
    }

    /* Otimizações para telas muito pequenas */
    @media (max-width: 479.98px) {
        .device-row td {
            padding: var(--spacing-xs);
        }

        .modern-action-group {
            gap: 8px;
        }

        .modern-action-btn {
            min-width: 40px;
            min-height: 40px;
        }
    }

    .metric-value.temperature {
        background: linear-gradient(135deg, rgba(230, 126, 34, 0.1), rgba(243, 156, 18, 0.05));
        border-left-color: var(--primary-orange);
    }

    .metric-value.temperature i {
        color: var(--primary-orange);
    }

    .metric-value.humidity {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.05));
        border-left-color: var(--primary-blue);
    }

    .metric-value.humidity i {
        color: var(--primary-blue);
    }
</style>

<tr class="device-row"
    data-status="{{ $device->status }}"
    data-environment="{{ $device->environment_id }}"
    data-type="{{ $device->device_type_id }}"
    data-name="{{ strtolower($device->name) }}"
    data-device-id="{{ $device->id }}">

    <!-- Dispositivo -->
    <td data-label="Dispositivo">
        <div class="device-info">
            <div class="status-indicator status-{{ $device->status }}"></div>
            <div class="device-content">
                <h6 class="device-name">{{ $device->name }}</h6>
                <div class="device-meta">
                    @if($device->location)
                    <small>
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ Str::limit($device->location, 30) }}</span>
                    </small>
                    @endif
                    @if($device->mac_address)
                    <small class="font-monospace">
                        <i class="bi bi-ethernet"></i>
                        <span>{{ $device->mac_address }}</span>
                    </small>
                    @endif
                    @if($device->serial_number)
                    <small class="font-monospace">
                        <i class="bi bi-upc-scan"></i>
                        <span>{{ Str::limit($device->serial_number, 15) }}</span>
                    </small>
                    @endif
                </div>
            </div>
        </div>
    </td>

    <!-- Status (oculto em mobile - mostrado no indicador) -->
    <td data-label="Status" class="d-none d-md-table-cell">
        <span class="modern-status-badge @if($device->status === 'online') bg-success @elseif($device->status === 'offline') bg-danger @else bg-warning @endif">
            <i class="bi bi-circle-fill"></i>
            <span>{{ ucfirst($device->status) }}</span>
        </span>
    </td>

    <!-- Tipo -->
    <td data-label="Tipo" class="d-none d-lg-table-cell">
        @if($device->deviceType)
        <div class="device-type-info">
            <div class="device-type-icon">
                <i class="{{ $deviceIcon }}"></i>
            </div>
            <div class="device-type-content">
                <div class="device-type-name">{{ Str::limit($device->deviceType->name, 20) }}</div>
                @if($device->rated_power)
                <div class="device-power-rating">{{ number_format($device->rated_power, 0) }}W</div>
                @endif
            </div>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-question-circle"></i>
            <span>Não definido</span>
        </div>
        @endif
    </td>

    <!-- Ambiente -->
    <td data-label="Ambiente" class="d-none d-lg-table-cell">
        @if($device->environment)
        <div class="environment-info">
            <i class="bi bi-house-fill"></i>
            <span>{{ Str::limit($device->environment->name, 20) }}</span>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-question-circle"></i>
            <span>Não definido</span>
        </div>
        @endif
    </td>
    @if(str_contains($typeName, 'temperature'))
    <td data-label="Temperatura" class="d-none d-md-table-cell">
        @if($currentTemperature !== null)
        <div class="metric-value temperature">
            <i class="bi bi-thermometer-half"></i>
            <span class="metric-number">{{ number_format($currentTemperature, 1) }}°C</span>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-dash-circle"></i>
            <span>Sem dados</span>
        </div>
        @endif
    </td>
    @endif

    @if(str_contains($typeName, 'humidity'))
    <td data-label="Umidade" class="d-none d-md-table-cell">
        @if($currentHumidity !== null)
        <div class="metric-value humidity">
            <i class="bi bi-droplet-fill"></i>
            <span class="metric-number">{{ number_format($currentHumidity, 1) }}%</span>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-dash-circle"></i>
            <span>Sem dados</span>
        </div>
        @endif
    </td>
    @endif


    <!-- Ações -->
    <td data-label="Ações">
        <div class="modern-action-group">

            <a href="{{ route('devices.edit', $device) }}"
                class="modern-action-btn edit"
                title="Editar dispositivo"
                data-bs-toggle="tooltip">
                <i class="bi bi-pencil"></i>
            </a>
            <button type="button"
                class="modern-action-btn delete delete-device-btn"
                data-device-id="{{ $device->id }}"
                data-device-name="{{ $device->name }}"
                title="Excluir dispositivo"
                data-bs-toggle="tooltip">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </td>
</tr>

<!-- Mini card para mobile (exibido apenas quando necessário) -->
@push('mobile-cards')
<div class="device-mobile-card d-md-none" data-device-id="{{ $device->id }}" style="display: none;">
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="d-flex align-items-start justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    <div class="status-indicator status-{{ $device->status }} me-2"></div>
                    <div>
                        <h6 class="mb-1 fw-bold">{{ $device->name }}</h6>
                        <small class="text-muted">
                            @if($device->deviceType)
                            {{ $device->deviceType->name }}
                            @endif
                            @if($device->environment)
                            • {{ $device->environment->name }}
                            @endif
                        </small>
                    </div>
                </div>
                <span class="modern-status-badge @if($device->status === 'online') bg-success @elseif($device->status === 'offline') bg-danger @else bg-warning @endif">
                    {{ ucfirst($device->status) }}
                </span>
            </div>

            @if($instantaneousPower !== null || $todayConsumption > 0)
            <div class="row g-2 mb-3">
                @if($instantaneousPower !== null && $instantaneousPower > 0)
                <div class="col-6">
                    <div class="metric-value power">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span class="metric-number">{{ number_format($instantaneousPower, 0) }}W</span>
                    </div>
                </div>
                @endif

                @if($todayConsumption > 0)
                <div class="col-6">
                    <div class="metric-value consumption">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span class="metric-number">{{ number_format($todayConsumption, 2) }}kWh</span>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <div class="modern-action-group">
                <a href="{{ route('devices.show', $device) }}" class="modern-action-btn view">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('devices.edit', $device) }}" class="modern-action-btn edit">
                    <i class="bi bi-pencil"></i>
                </a>
                @if($device->status === 'online')
                <button type="button" class="modern-action-btn diagnostics" onclick="showDiagnostics('{{ $device->id }}')">
                    <i class="bi bi-activity"></i>
                </button>
                @endif
                <button type="button" class="modern-action-btn delete delete-device-btn"
                    data-device-id="{{ $device->id }}" data-device-name="{{ $device->name }}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

<script>
    // Função para diagnósticos (se necessária)
    function showDiagnostics(deviceId) {
        // Implementar modal ou redirecionamento para diagnósticos
        console.log('Diagnósticos para dispositivo:', deviceId);
    }

    // Inicializar tooltips se não for mobile
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth >= 768) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
</script>