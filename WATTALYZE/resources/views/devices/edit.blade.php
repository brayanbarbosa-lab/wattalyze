@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-blue: #3498db;
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
        max-width: 900px;
        margin: 0 auto;
        padding: var(--spacing-sm);
        min-height: 100vh;
    }

    /* Card do formulário moderno */
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(39, 174, 96, 0.03) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Header do dispositivo */
    .device-header {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        align-items: center;
        padding: var(--spacing-md);
        background: linear-gradient(135deg, var(--primary-dark) 0%, #34495e 100%);
        color: white;
        border-radius: var(--border-radius);
        margin-bottom: var(--spacing-lg);
        position: relative;
        overflow: hidden;
    }

    .device-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .device-icon {
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: var(--spacing-sm);
        opacity: 0.9;
    }

    .device-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        margin: 0;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .device-subtitle {
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        opacity: 0.8;
        text-align: center;
        margin: 0;
    }

    /* Status indicator no header */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: var(--spacing-sm);
    }

    .status-indicator.online {
        background: rgba(39, 174, 96, 0.2);
        color: white;
        border: 1px solid rgba(39, 174, 96, 0.3);
    }

    .status-indicator.offline {
        background: rgba(231, 76, 60, 0.2);
        color: white;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .status-indicator.maintenance {
        background: rgba(230, 126, 34, 0.2);
        color: white;
        border: 1px solid rgba(230, 126, 34, 0.3);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-dot.online { background: #00ff00; }
    .status-dot.offline { background: #ff6b6b; }
    .status-dot.maintenance { background: #ffa500; }

    /* Progress indicator */
    .form-progress {
        background: #f8f9fa;
        border-radius: 20px;
        height: 6px;
        margin-bottom: var(--spacing-lg);
        overflow: hidden;
    }

    .form-progress-bar {
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
        height: 100%;
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 20px;
    }

    /* Labels modernos */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
        display: block;
        position: relative;
    }

    .form-label .text-danger {
        color: var(--primary-red) !important;
        font-weight: 700;
    }

    .form-label .label-icon {
        color: var(--primary-green);
        margin-right: 0.5rem;
        font-size: 0.875rem;
    }

    /* Inputs e selects modernos */
    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        padding: 12px 16px;
        font-size: 1rem;
        font-weight: 500;
        transition: var(--transition);
        background: white;
        min-height: 48px;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15);
        outline: none;
        background: white;
    }

    /* Estados de validação */
    .form-control.is-valid,
    .form-select.is-valid {
        border-color: var(--primary-green);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2327ae60' d='m2.3 6.73.94-.94 1.48 1.48L7.88 4.12l.94.94L5.66 8.22z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--primary-red);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e74c3c'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4M8.2 4.6l-2.4 2.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    /* Feedback de validação */
    .valid-feedback,
    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        padding-left: 8px;
    }

    .valid-feedback {
        color: var(--primary-green);
    }

    .invalid-feedback {
        color: var(--primary-red);
    }

    /* Botões modernos */
    .btn-success {
        background: linear-gradient(135deg, var(--primary-green) 0%, #229954 100%);
        border: none;
        border-radius: var(--border-radius-small);
        color: white;
        padding: 14px 28px;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        will-change: transform;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        background: linear-gradient(135deg, #229954 0%, var(--primary-green) 100%);
        color: white;
    }

    .btn-secondary {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        color: var(--text-muted);
        padding: 12px 24px;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        will-change: transform;
    }

    .btn-secondary:hover {
        background: var(--bg-light);
        border-color: var(--text-muted);
        color: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* Actions container */
    .form-actions {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        margin-top: var(--spacing-xl);
        padding-top: var(--spacing-lg);
        border-top: 2px solid #f8f9fa;
    }

    /* Grid responsivo para inputs relacionados */
    .form-grid {
        display: grid;
        gap: var(--spacing-md);
        grid-template-columns: 1fr;
    }

    /* Seções do formulário */
    .form-section {
        margin-bottom: var(--spacing-xl);
        position: relative;
    }

    .form-section:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: calc(-1 * var(--spacing-lg));
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #e9ecef 20%, #e9ecef 80%, transparent 100%);
    }

    /* Section titles */
    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-md);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    /* Helper text */
    .form-text {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
        display: block;
    }

    /* Input groups com ícones */
    .input-icon-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1rem;
        z-index: 2;
    }

    .input-icon-group .form-control,
    .input-icon-group .form-select {
        padding-left: 40px;
    }

    /* Loading state */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Animações */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Media Queries - Mobile First */

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }

        .form-card {
            padding: var(--spacing-xl);
        }

        .form-actions {
            flex-direction: row;
            justify-content: flex-start;
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-grid .col-full {
            grid-column: 1 / -1;
        }

        .device-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .device-info {
            text-align: left;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        .form-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-grid .col-2 {
            grid-column: span 2;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .main-container {
            max-width: 1000px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 30vw;
            max-width: 60vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 25vw;
            max-width: 50vw;
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

        .form-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .btn-secondary {
            display: none !important;
        }
    }
</style>

<div class="main-container">
    <div class="form-card animate-fade-in">
        {{-- Header do dispositivo --}}
        <div class="device-header">
            <div class="device-info">
                <div class="device-icon">
                    @php
                        $deviceIcon = 'bi-cpu';
                        $typeName = strtolower($device->deviceType->name ?? '');
                        if (str_contains($typeName, 'temperature')) {
                            $deviceIcon = 'bi-thermometer-half';
                        } elseif (str_contains($typeName, 'humidity')) {
                            $deviceIcon = 'bi-droplet';
                        } elseif (str_contains($typeName, 'energy') || str_contains($typeName, 'power')) {
                            $deviceIcon = 'bi-lightning-charge';
                        }
                    @endphp
                    <i class="bi {{ $deviceIcon }}"></i>
                </div>
                <h1 class="device-title">Editar Dispositivo</h1>
                <p class="device-subtitle">{{ $device->name }}</p>
            </div>
            <div class="status-indicator {{ $device->status }}">
                <span class="status-dot {{ $device->status }}"></span>
                {{ ucfirst($device->status) }}
            </div>
        </div>

        {{-- Progress indicator --}}
        <div class="form-progress">
            <div class="form-progress-bar" id="progressBar"></div>
        </div>

        <form action="{{ route('devices.update', $device->id) }}" method="POST" novalidate class="needs-validation" id="deviceForm">
            @csrf
            @method('PATCH')

            {{-- Seção: Identificação --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-tag"></i>
                    Identificação
                </h3>

                <div class="mb-4">
                    <label for="name" class="form-label">
                        <i class="label-icon bi bi-device-hdd"></i>
                        Nome do Dispositivo <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-group">
                        <i class="input-icon bi bi-device-hdd"></i>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $device->name) }}" 
                               required autocomplete="name" placeholder="Ex: Sensor Principal, Monitor Sala 01...">
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="valid-feedback">Nome válido!</div>
                    @enderror
                    <small class="form-text">Nome único e descritivo para identificação</small>
                </div>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="mac_address" class="form-label">
                            <i class="label-icon bi bi-ethernet"></i>
                            MAC Address <span class="text-danger">*</span>
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-ethernet"></i>
                            <input type="text" class="form-control @error('mac_address') is-invalid @enderror" 
                                   id="mac_address" name="mac_address" value="{{ old('mac_address', $device->mac_address) }}" 
                                   required pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$"
                                   placeholder="00:11:22:33:44:55">
                        </div>
                        @error('mac_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="valid-feedback">MAC Address válido!</div>
                        @enderror
                        <small class="form-text">Endereço físico único do dispositivo</small>
                    </div>

                    <div class="mb-4">
                        <label for="serial_number" class="form-label">
                            <i class="label-icon bi bi-upc-scan"></i>
                            Número de Série
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-upc-scan"></i>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number', $device->serial_number) }}"
                                   placeholder="Ex: SN123456789">
                        </div>
                        @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Número de série do fabricante</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Especificações --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Especificações
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="model" class="form-label">
                            <i class="label-icon bi bi-diagram-3"></i>
                            Modelo
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-diagram-3"></i>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model', $device->model) }}"
                                   placeholder="Ex: ESP32-WROOM, Arduino Nano">
                        </div>
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="manufacturer" class="form-label">
                            <i class="label-icon bi bi-building"></i>
                            Fabricante
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-building"></i>
                            <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" 
                                   id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $device->manufacturer) }}"
                                   placeholder="Ex: Espressif, Arduino, Sonoff">
                        </div>
                        @error('manufacturer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="firmware_version" class="form-label">
                            <i class="label-icon bi bi-code-square"></i>
                            Versão do Firmware
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-code-square"></i>
                            <input type="text" class="form-control @error('firmware_version') is-invalid @enderror" 
                                   id="firmware_version" name="firmware_version" value="{{ old('firmware_version', $device->firmware_version) }}"
                                   placeholder="Ex: v1.2.3, 2024.10.1">
                        </div>
                        @error('firmware_version')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Versão atual do software do dispositivo</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Configuração --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-gear"></i>
                    Configuração
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="status" class="form-label">
                            <i class="label-icon bi bi-circle"></i>
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-circle"></i>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="online" {{ old('status', $device->status) == 'online' ? 'selected' : '' }}>
                                    🟢 Online
                                </option>
                                <option value="offline" {{ old('status', $device->status) == 'offline' ? 'selected' : '' }}>
                                    🔴 Offline
                                </option>
                                <option value="maintenance" {{ old('status', $device->status) == 'maintenance' ? 'selected' : '' }}>
                                    🟡 Em Manutenção
                                </option>
                            </select>
                        </div>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="valid-feedback">Status definido!</div>
                        @enderror
                    </div>

                    <div class="mb-4 col-2">
                        <label for="location" class="form-label">
                            <i class="label-icon bi bi-geo-alt"></i>
                            Localização
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-geo-alt"></i>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $device->location) }}"
                                   placeholder="Ex: Parede Norte, Quadro Principal, Mesa 3">
                        </div>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Localização física específica do dispositivo</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="installation_date" class="form-label">
                        <i class="label-icon bi bi-calendar-check"></i>
                        Data de Instalação
                    </label>
                    <div class="input-icon-group">
                        <i class="input-icon bi bi-calendar-check"></i>
                        <input type="date" class="form-control @error('installation_date') is-invalid @enderror" 
                               id="installation_date" name="installation_date" 
                               value="{{ old('installation_date', $device->installation_date ? $device->installation_date->format('Y-m-d') : '') }}"
                               max="{{ date('Y-m-d') }}">
                    </div>
                    @error('installation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Data quando o dispositivo foi instalado</small>
                </div>
            </div>

            {{-- Seção: Especificações Técnicas --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-lightning-charge"></i>
                    Especificações Elétricas
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="rated_power" class="form-label">
                            <i class="label-icon bi bi-lightning"></i>
                            Potência Nominal (W)
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-lightning"></i>
                            <input type="number" step="0.01" min="0" class="form-control @error('rated_power') is-invalid @enderror" 
                                   id="rated_power" name="rated_power" value="{{ old('rated_power', $device->rated_power) }}"
                                   placeholder="0.00">
                        </div>
                        @error('rated_power')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Potência máxima do dispositivo em Watts</small>
                    </div>

                    <div class="mb-4">
                        <label for="rated_voltage" class="form-label">
                            <i class="label-icon bi bi-speedometer2"></i>
                            Voltagem Nominal (V)
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-speedometer2"></i>
                            <input type="number" step="0.01" min="0" class="form-control @error('rated_voltage') is-invalid @enderror" 
                                   id="rated_voltage" name="rated_voltage" value="{{ old('rated_voltage', $device->rated_voltage) }}"
                                   placeholder="0.00">
                        </div>
                        @error('rated_voltage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Voltagem de operação em Volts</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Associações --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-link-45deg"></i>
                    Associações
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="device_type_id" class="form-label">
                            <i class="label-icon bi bi-collection"></i>
                            Tipo de Dispositivo
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-collection"></i>
                            <select class="form-select @error('device_type_id') is-invalid @enderror" 
                                    id="device_type_id" name="device_type_id">
                                <option value="">-- Selecione um tipo --</option>
                                @foreach($deviceTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('device_type_id', $device->device_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('device_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Categoria funcional do dispositivo</small>
                    </div>

                    <div class="mb-4">
                        <label for="environment_id" class="form-label">
                            <i class="label-icon bi bi-house"></i>
                            Ambiente
                        </label>
                        <div class="input-icon-group">
                            <i class="input-icon bi bi-house"></i>
                            <select class="form-select @error('environment_id') is-invalid @enderror" 
                                    id="environment_id" name="environment_id">
                                <option value="">-- Selecione um ambiente --</option>
                                @foreach($environments as $env)
                                    <option value="{{ $env->id }}" {{ old('environment_id', $device->environment_id) == $env->id ? 'selected' : '' }}>
                                        🏠 {{ $env->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('environment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Ambiente onde o dispositivo está localizado</small>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-success" id="submitBtn">
                    <i class="bi bi-check-circle me-2"></i>
                    Salvar Alterações
                </button>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Voltar para Dispositivos
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('deviceForm');
        const progressBar = document.getElementById('progressBar');
        const inputs = form.querySelectorAll('input[required], select[required]');
        const allInputs = form.querySelectorAll('input, select');

        // Atualizar progresso
        function updateProgress() {
            const requiredInputs = Array.from(inputs);
            const completedInputs = requiredInputs.filter(input => {
                return input.value.trim() !== '';
            });
            
            const progress = (completedInputs.length / requiredInputs.length) * 100;
            progressBar.style.width = progress + '%';
        }

        // Validação do formulário
        form.addEventListener('submit', event => {
            const submitBtn = document.getElementById('submitBtn');
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }
            } else {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }
            
            form.classList.add('was-validated');
        });

        // Validação em tempo real
        allInputs.forEach(input => {
            input.addEventListener('input', updateProgress);
            
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required')) {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });

        // Formatação automática do MAC Address
        const macInput = document.getElementById('mac_address');
        if (macInput) {
            macInput.addEventListener('input', function() {
                let value = this.value.replace(/[^0-9A-Fa-f]/g, '');
                let formattedValue = value.match(/.{1,2}/g)?.join(':') || value;
                if (formattedValue.length > 17) {
                    formattedValue = formattedValue.substring(0, 17);
                }
                this.value = formattedValue.toUpperCase();
            });
        }

        // Validação customizada para data
        const dateInput = document.getElementById('installation_date');
        if (dateInput) {
            dateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                
                if (selectedDate > today) {
                    this.setCustomValidity('A data não pode ser no futuro');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Atualizar status indicator quando status muda
        const statusSelect = document.getElementById('status');
        const statusIndicator = document.querySelector('.status-indicator');
        if (statusSelect && statusIndicator) {
            statusSelect.addEventListener('change', function() {
                const newStatus = this.value;
                statusIndicator.className = `status-indicator ${newStatus}`;
                
                const statusDot = statusIndicator.querySelector('.status-dot');
                if (statusDot) {
                    statusDot.className = `status-dot ${newStatus}`;
                }
                
                statusIndicator.innerHTML = `
                    <span class="status-dot ${newStatus}"></span>
                    ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}
                `;
            });
        }

        // Shortcuts de teclado
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('submitBtn').click();
            }
            
            if (e.key === 'Escape') {
                const backBtn = document.querySelector('.btn-secondary');
                if (backBtn && confirm('Deseja cancelar as alterações?')) {
                    window.location.href = backBtn.href;
                }
            }
        });

        // Inicializar progresso
        updateProgress();

        // Animação dos ícones das seções
        const sectionIcons = document.querySelectorAll('.section-title i');
        sectionIcons.forEach((icon, index) => {
            setTimeout(() => {
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1)';
                }, 200);
            }, index * 200);
        });
    });
</script>
