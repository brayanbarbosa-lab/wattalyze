@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-blue: #0d6efd;
        --primary-warning: #ffc107;
        --primary-success: #198754;
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
        min-height: 100vh;
    }

    /* Header responsivo */
    .header-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        border: none;
    }

    .header-content {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        align-items: flex-start;
    }

    .header-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
        line-height: 1.2;
    }

    .header-subtitle {
        color: var(--text-muted);
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        margin: 0;
    }

    /* Breadcrumb responsivo */
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: clamp(0.8rem, 2vw, 0.875rem);
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: var(--primary-blue);
        transition: var(--transition);
    }

    .breadcrumb-item a:hover {
        color: var(--primary-dark);
    }

    /* Cards modernos */
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: var(--spacing-md);
        overflow: hidden;
        transition: var(--transition);
    }

    .form-card:hover {
        box-shadow: var(--shadow-medium);
    }

    .card-header {
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding: var(--spacing-md);
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .card-header.bg-primary {
        background: linear-gradient(135deg, var(--primary-blue), #0a58ca) !important;
    }

    .card-header.bg-secondary {
        background: linear-gradient(135deg, var(--text-muted), #495057) !important;
    }

    .card-header.bg-warning {
        background: linear-gradient(135deg, var(--primary-warning), #e0a800) !important;
        color: #000 !important;
    }

    .card-header.bg-success {
        background: linear-gradient(135deg, var(--primary-success), #157347) !important;
    }

    .card-header h5,
    .card-header h6 {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        font-weight: 600;
    }

    .card-body {
        padding: var(--spacing-md);
    }

    /* Form controls responsivos */
    .form-label {
        font-weight: 600;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        line-height: 1.4;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        padding: 12px 16px;
        font-size: clamp(0.875rem, 2vw, 1rem);
        font-weight: 500;
        transition: var(--transition);
        background: white;
        min-height: 44px;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        outline: none;
        background: white;
    }

    /* Estados de validação */
    .form-control.is-valid,
    .form-select.is-valid {
        border-color: var(--primary-success);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 1.48 1.48L7.88 4.12l.94.94L5.66 8.22z'/%3e%3c/svg%3e");
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
        font-size: clamp(0.75rem, 1.8vw, 0.875rem);
        font-weight: 500;
        margin-top: 0.5rem;
        padding-left: 8px;
    }

    .valid-feedback {
        color: var(--primary-success);
    }

    .invalid-feedback {
        color: var(--primary-red);
    }

    /* Input groups */
    .input-group .form-control,
    .input-group .form-select {
        border-radius: 0;
    }

    .input-group .form-control:first-child,
    .input-group .form-select:first-child {
        border-radius: var(--border-radius-small) 0 0 var(--border-radius-small);
    }

    .input-group .form-control:last-child,
    .input-group .form-select:last-child {
        border-radius: 0 var(--border-radius-small) var(--border-radius-small) 0;
    }

    .input-group-text {
        background: var(--bg-light);
        border: 2px solid #e9ecef;
        font-weight: 500;
        padding: 12px 16px;
    }

    /* Botões modernos */
    .btn {
        border-radius: var(--border-radius-small);
        font-weight: 600;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        padding: 12px 20px;
        min-height: 44px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        will-change: transform;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-blue), #0a58ca);
        border: none;
        color: white;
        box-shadow: var(--shadow-light);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0a58ca, var(--primary-blue));
        color: white;
        box-shadow: var(--shadow-medium);
    }

    .btn-secondary {
        background: white;
        border: 2px solid #e9ecef;
        color: var(--text-muted);
    }

    .btn-secondary:hover {
        background: var(--bg-light);
        border-color: var(--text-muted);
        color: var(--primary-dark);
    }

    .btn-outline-primary {
        background: transparent;
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
    }

    .btn-outline-primary:hover {
        background: var(--primary-blue);
        color: white;
    }

    .btn-outline-secondary {
        background: transparent;
        border: 2px solid #e9ecef;
        color: var(--text-muted);
    }

    .btn-outline-secondary:hover {
        background: var(--text-muted);
        color: white;
    }

    /* Alerts responsivos */
    .alert {
        border-radius: var(--border-radius-small);
        border: none;
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .alert-danger {
        background: linear-gradient(90deg, rgba(231, 76, 60, 0.1) 0%, rgba(231, 76, 60, 0.05) 100%);
        border-left: 4px solid var(--primary-red);
        color: #721c24;
    }

    .alert-info {
        background: linear-gradient(90deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
        border-left: 4px solid var(--primary-blue);
        color: #055160;
    }

    .alert-success {
        background: linear-gradient(90deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
        border-left: 4px solid var(--primary-success);
        color: #0a3622;
    }

    /* Sidebar responsiva */
    .sidebar-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: var(--spacing-md);
        position: sticky;
        top: var(--spacing-sm);
    }

    /* Progress bar */
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.3s ease;
        background: linear-gradient(90deg, var(--primary-success), #20c997);
    }

    /* Accordion customizado */
    .accordion-button {
        background: transparent;
        border: none;
        font-weight: 500;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        padding: 0.75rem 0;
    }

    .accordion-button:not(.collapsed) {
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--primary-blue);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    .accordion-body {
        padding: 0.75rem 0;
    }

    /* Modal responsivo */
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

    .modal-title {
        font-size: clamp(1.1rem, 3vw, 1.25rem);
        font-weight: 600;
        color: var(--primary-dark);
    }

    .modal-body {
        padding: var(--spacing-md);
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: var(--spacing-md);
    }

    /* Tooltips */
    .tooltip {
        font-size: 0.875rem;
    }

    /* Form check */
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.1em;
        border: 2px solid #dee2e6;
        transition: var(--transition);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    .form-check-input:checked {
        background-color: var(--primary-success);
        border-color: var(--primary-success);
    }

    .form-check-input:checked[disabled] {
        background-color: var(--primary-success);
        border-color: var(--primary-success);
        opacity: 0.8;
    }

    .form-check-label {
        font-size: clamp(0.8rem, 2vw, 0.875rem);
        margin-left: 0.5rem;
    }

    /* Layout responsivo */
    .content-layout {
        display: grid;
        gap: var(--spacing-md);
        grid-template-columns: 1fr;
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

    /* Media Queries - Mobile First */

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }

        .header-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            padding: var(--spacing-lg);
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        .content-layout {
            grid-template-columns: 1fr 300px;
        }

        .header-section,
        .card-body {
            padding: var(--spacing-lg);
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .content-layout {
            grid-template-columns: 1fr 320px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 20vw;
            max-width: 75vw;
        }

        .content-layout {
            grid-template-columns: 1fr 350px;
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

        .sidebar-card,
        .btn-secondary {
            display: none !important;
        }

        .form-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<div class="main-container">
    <!-- Header Responsivo -->
    <div class="header-section animate-fade-in">
        <div class="header-content">
            <div>
                <h1 class="header-title">Cadastrar Novo Dispositivo</h1>
                <p class="header-subtitle">Adicione um dispositivo para começar o monitoramento de energia</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('devices.index') }}">
                            <i class="bi bi-house"></i> 
                            <span class="d-none d-sm-inline">Dispositivos</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Novo</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Mensagens de Erro -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-exclamation-triangle-fill me-2 mt-1 flex-shrink-0"></i>
            <div class="flex-grow-1">
                <strong>Ops! Encontramos alguns problemas:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Layout Principal -->
    <div class="content-layout">
        <!-- Formulário Principal -->
        <div>
            <form action="{{ route('devices.store') }}" method="POST" id="deviceForm" novalidate class="needs-validation">
                @csrf

                <!-- Card: Informações Básicas -->
                <div class="form-card animate-fade-in" style="animation-delay: 0.1s;">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-info-circle"></i> Informações Básicas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">
                                    Nome do Dispositivo <span class="text-danger">*</span>
                                    <i class="bi bi-question-circle" data-bs-toggle="tooltip" 
                                       title="Nome para identificar facilmente o dispositivo"></i>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required maxlength="255" autocomplete="name"
                                       placeholder="Ex: TV Sala, Geladeira Cozinha">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="valid-feedback">Nome válido!</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label">Status Inicial <span class="text-danger">*</span></label>
                                <select id="status" name="status" required
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="offline" {{ old('status', 'offline') == 'offline' ? 'selected' : '' }}>
                                        🔴 Offline
                                    </option>
                                    <option value="online" {{ old('status') == 'online' ? 'selected' : '' }}>
                                        🟢 Online
                                    </option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                        🟡 Manutenção
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="valid-feedback">Status definido!</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="device_type_id" class="form-label">Tipo de Dispositivo</label>
                                <select id="device_type_id" name="device_type_id"
                                        class="form-select @error('device_type_id') is-invalid @enderror">
                                    <option value="">Selecione um tipo</option>
                                    @foreach ($deviceTypes as $type)
                                    <option value="{{ $type->id }}"
                                            {{ old('device_type_id') == $type->id ? 'selected' : '' }}
                                            data-icon="{{ $type->icon ?? 'bi bi-cpu' }}">
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('device_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="environment_id" class="form-label">Ambiente</label>
                                <div class="input-group">
                                    <select id="environment_id" name="environment_id"
                                            class="form-select @error('environment_id') is-invalid @enderror">
                                        <option value="">Selecione um ambiente</option>
                                        @foreach ($environments as $env)
                                        <option value="{{ $env->id }}" {{ old('environment_id') == $env->id ? 'selected' : '' }}>
                                            🏠 {{ $env->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button"
                                            data-bs-toggle="modal" data-bs-target="#newEnvironmentModal"
                                            title="Criar novo ambiente">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                @error('environment_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="location" class="form-label">Localização Específica</label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}"
                                       class="form-control @error('location') is-invalid @enderror"
                                       maxlength="255" placeholder="Ex: Próximo à janela, Mesa do escritório">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Identificação Técnica -->
                <div class="form-card animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="card-header bg-secondary text-white">
                        <h5><i class="bi bi-gear"></i> Identificação Técnica</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="mac_address" class="form-label">
                                    Endereço MAC <span class="text-danger">*</span>
                                    <i class="bi bi-question-circle" data-bs-toggle="tooltip"
                                       title="Endereço MAC único do dispositivo (formato: XX:XX:XX:XX:XX:XX)"></i>
                                </label>
                                <input type="text" id="mac_address" name="mac_address" value="{{ old('mac_address') }}"
                                       class="form-control font-monospace @error('mac_address') is-invalid @enderror"
                                       required maxlength="17" placeholder="00:11:22:33:44:55"
                                       pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$">
                                @error('mac_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="valid-feedback">MAC válido!</div>
                                @enderror
                                <div class="form-text">Formato: XX:XX:XX:XX:XX:XX</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="serial_number" class="form-label">Número de Série</label>
                                <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                                       class="form-control font-monospace @error('serial_number') is-invalid @enderror"
                                       maxlength="255" placeholder="Ex: SN123456789">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="model" class="form-label">Modelo</label>
                                <input type="text" id="model" name="model" value="{{ old('model') }}"
                                       class="form-control @error('model') is-invalid @enderror"
                                       maxlength="255" placeholder="Ex: XR-2000">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="manufacturer" class="form-label">Fabricante</label>
                                <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}"
                                       class="form-control @error('manufacturer') is-invalid @enderror"
                                       maxlength="255" placeholder="Ex: Samsung, LG">
                                @error('manufacturer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="firmware_version" class="form-label">Versão do Firmware</label>
                                <input type="text" id="firmware_version" name="firmware_version" 
                                       value="{{ old('firmware_version') }}"
                                       class="form-control @error('firmware_version') is-invalid @enderror"
                                       maxlength="255" placeholder="Ex: v1.2.3">
                                @error('firmware_version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Especificações Elétricas -->
                <div class="form-card animate-fade-in" style="animation-delay: 0.3s;">
                    <div class="card-header bg-warning text-dark">
                        <h5><i class="bi bi-lightning"></i> Especificações Elétricas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label for="rated_power" class="form-label">
                                    Potência Nominal (W)
                                    <i class="bi bi-question-circle" data-bs-toggle="tooltip"
                                       title="Potência máxima do dispositivo em Watts"></i>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" max="999999"
                                           id="rated_power" name="rated_power" value="{{ old('rated_power') }}"
                                           class="form-control @error('rated_power') is-invalid @enderror"
                                           placeholder="Ex: 150">
                                    <span class="input-group-text">W</span>
                                </div>
                                @error('rated_power')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="rated_voltage" class="form-label">
                                    Tensão Nominal (V)
                                    <i class="bi bi-question-circle" data-bs-toggle="tooltip"
                                       title="Tensão de operação do dispositivo"></i>
                                </label>
                                <select class="form-select @error('rated_voltage') is-invalid @enderror"
                                        id="rated_voltage" name="rated_voltage">
                                    <option value="">Selecione</option>
                                    <option value="110" {{ old('rated_voltage') == '110' ? 'selected' : '' }}>110V</option>
                                    <option value="127" {{ old('rated_voltage') == '127' ? 'selected' : '' }}>127V</option>
                                    <option value="220" {{ old('rated_voltage') == '220' ? 'selected' : '' }}>220V</option>
                                    <option value="240" {{ old('rated_voltage') == '240' ? 'selected' : '' }}>240V</option>
                                    <option value="custom">Outro</option>
                                </select>
                                @error('rated_voltage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <input type="number" step="0.01" min="0" max="1000"
                                       id="custom_voltage" name="custom_voltage"
                                       class="form-control mt-2" placeholder="Voltagem customizada"
                                       style="display: none;">
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="installation_date" class="form-label">Data de Instalação</label>
                                <input type="date" id="installation_date" name="installation_date"
                                       value="{{ old('installation_date') }}"
                                       class="form-control @error('installation_date') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}">
                                @error('installation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estimativa de Consumo -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-start" id="consumptionEstimate" style="display: none !important;">
                                    <i class="bi bi-lightbulb me-2 mt-1 flex-shrink-0"></i>
                                    <div>
                                        <strong>Estimativa de Consumo:</strong>
                                        <span id="estimateText"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="form-card animate-fade-in" style="animation-delay: 0.4s;">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
                            <p class="mb-0 text-muted">
                                <i class="bi bi-info-circle"></i>
                                Os campos marcados com <span class="text-danger">*</span> são obrigatórios
                            </p>
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <a href="{{ route('devices.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                                <button type="button" class="btn btn-outline-primary" id="previewBtn">
                                    <i class="bi bi-eye"></i> Prévia
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm me-2" id="submitSpinner" style="display: none;"></span>
                                    <i class="bi bi-save"></i> Salvar Dispositivo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar com Ajuda -->
        <div class="sidebar-container">
            <!-- Card de Ajuda -->
            <div class="sidebar-card animate-fade-in" style="animation-delay: 0.5s;">
                <div class="card-header bg-success text-white">
                    <h6><i class="bi bi-question-circle"></i> Precisa de Ajuda?</h6>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="helpAccordion">
                        <div class="accordion-item">
                            <h6 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#helpMAC">
                                    Como encontrar o MAC?
                                </button>
                            </h6>
                            <div id="helpMAC" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    <p class="small">O endereço MAC pode ser encontrado:</p>
                                    <ul class="mb-0 small">
                                        <li>Na etiqueta do dispositivo</li>
                                        <li>No manual do produto</li>
                                        <li>Nas configurações de rede</li>
                                        <li>No aplicativo do fabricante</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h6 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#helpPower">
                                    Potência Nominal
                                </button>
                            </h6>
                            <div id="helpPower" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    <p class="small">A potência nominal está geralmente:</p>
                                    <ul class="mb-2 small">
                                        <li>Na etiqueta energética</li>
                                        <li>No manual do produto</li>
                                        <li>Na parte traseira/inferior do dispositivo</li>
                                    </ul>
                                    <p class="mb-0 small"><strong>Exemplos comuns:</strong></p>
                                    <ul class="mb-0 small">
                                        <li>TV 42": 100-150W</li>
                                        <li>Geladeira: 150-400W</li>
                                        <li>Micro-ondas: 700-1200W</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h6 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#helpTips">
                                    Dicas Importantes
                                </button>
                            </h6>
                            <div id="helpTips" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                <div class="accordion-body">
                                    <ul class="mb-0 small">
                                        <li>Use nomes descritivos para facilitar identificação</li>
                                        <li>Organize por ambientes para melhor controle</li>
                                        <li>Mantenha as informações técnicas atualizadas</li>
                                        <li>Configure o tipo correto para relatórios precisos</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="sidebar-card animate-fade-in" style="animation-delay: 0.6s;">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-list-check"></i>
                        Progresso do Cadastro
                    </h6>
                    <div class="progress mb-2">
                        <div class="progress-bar" id="formProgress" style="width: 0%"></div>
                    </div>
                    <small class="text-muted" id="progressText">0% concluído</small>

                    <div class="mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkBasic" disabled>
                            <label class="form-check-label" for="checkBasic">
                                Informações básicas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkTechnical" disabled>
                            <label class="form-check-label" for="checkTechnical">
                                Dados técnicos
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkSpecs" disabled>
                            <label class="form-check-label" for="checkSpecs">
                                Especificações (opcional)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Novo Ambiente -->
<div class="modal fade" id="newEnvironmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-house-add"></i>
                    Criar Novo Ambiente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newEnvironmentForm">
                    <div class="mb-3">
                        <label for="newEnvName" class="form-label">Nome do Ambiente <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="newEnvName" 
                               placeholder="Ex: Sala de Estar" required>
                    </div>
                    <div class="mb-3">
                        <label for="newEnvDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="newEnvDescription" rows="2" 
                                  placeholder="Descrição opcional"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveNewEnvironment">
                    <i class="bi bi-save"></i> Criar Ambiente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Prévia do Dispositivo -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye"></i>
                    Prévia do Dispositivo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Conteúdo será gerado dinamicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('deviceForm').submit()">
                    <i class="bi bi-save"></i> Confirmar e Salvar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
class ResponsiveDeviceFormManager {
    constructor() {
        this.form = document.getElementById('deviceForm');
        this.requiredFields = ['name', 'mac_address', 'status'];
        this.optionalFields = ['device_type_id', 'environment_id', 'location'];
        this.technicalFields = ['serial_number', 'model', 'manufacturer', 'firmware_version'];
        this.isMobile = window.innerWidth < 768;
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupValidation();
        this.setupTooltips();
        this.updateProgress();
        this.setupMACFormatter();
        this.setupVoltageHandler();
        this.calculateConsumptionEstimate();
        this.setupResponsiveHandlers();
    }

    setupResponsiveHandlers() {
        const mediaQuery = window.matchMedia('(max-width: 767px)');
        const handleViewportChange = (e) => {
            this.isMobile = e.matches;
            this.handleResponsiveChanges();
        };
        
        mediaQuery.addListener(handleViewportChange);
        this.handleResponsiveChanges();
    }

    handleResponsiveChanges() {
        // Adjust tooltips for mobile
        if (this.isMobile) {
            // Disable tooltips on touch devices
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                const bsTooltip = bootstrap.Tooltip.getInstance(tooltip);
                if (bsTooltip) {
                    bsTooltip.dispose();
                }
            });
        } else {
            this.setupTooltips();
        }
    }

    setupEventListeners() {
        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        // Real-time validation
        this.form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', () => {
                this.validateField(field);
                this.updateProgress();
                this.calculateConsumptionEstimate();
            });
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('change', () => {
                this.validateField(field);
                this.updateProgress();
                this.calculateConsumptionEstimate();
            });
        });

        // Preview button
        document.getElementById('previewBtn').addEventListener('click', () => this.showPreview());

        // New environment
        document.getElementById('saveNewEnvironment').addEventListener('click', () => this.createNewEnvironment());

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    }

    setupValidation() {
        // Real-time validation with debounce
        const debounce = (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        // Name field validation
        const nameField = document.getElementById('name');
        nameField.addEventListener('input', debounce((e) => {
            if (e.target.value.length > 255) {
                e.target.value = e.target.value.substring(0, 255);
            }
        }, 300));

        // Installation date validation
        const dateField = document.getElementById('installation_date');
        dateField.addEventListener('change', (e) => {
            const selectedDate = new Date(e.target.value);
            const today = new Date();
            
            if (selectedDate > today) {
                e.target.setCustomValidity('A data não pode ser no futuro');
            } else {
                e.target.setCustomValidity('');
            }
        });
    }

    setupMACFormatter() {
        const macInput = document.getElementById('mac_address');
        macInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9A-Fa-f]/g, '');
            let formatted = '';

            for (let i = 0; i < value.length && i < 12; i += 2) {
                if (i > 0) formatted += ':';
                formatted += value.substr(i, 2);
            }

            e.target.value = formatted.toUpperCase();
        });
    }

    setupVoltageHandler() {
        const voltageSelect = document.getElementById('rated_voltage');
        const customVoltage = document.getElementById('custom_voltage');

        voltageSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customVoltage.style.display = 'block';
                customVoltage.required = true;
                customVoltage.focus();
            } else {
                customVoltage.style.display = 'none';
                customVoltage.required = false;
                customVoltage.value = '';
            }
        });
    }

    setupTooltips() {
        if (!this.isMobile) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover focus'
                });
            });
        }
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            message = 'Este campo é obrigatório';
        }

        // Specific validations
        switch (field.id) {
            case 'mac_address':
                const macPattern = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;
                if (value && !macPattern.test(value)) {
                    isValid = false;
                    message = 'Formato de MAC inválido (XX:XX:XX:XX:XX:XX)';
                }
                break;

            case 'name':
                if (value && value.length < 2) {
                    isValid = false;
                    message = 'Nome deve ter pelo menos 2 caracteres';
                }
                break;

            case 'rated_power':
                if (value && (isNaN(value) || parseFloat(value) < 0 || parseFloat(value) > 999999)) {
                    isValid = false;
                    message = 'Potência deve ser um número entre 0 e 999999';
                }
                break;

            case 'custom_voltage':
                if (field.style.display !== 'none' && value && (isNaN(value) || parseFloat(value) < 0 || parseFloat(value) > 1000)) {
                    isValid = false;
                    message = 'Voltagem deve ser um número entre 0 e 1000';
                }
                break;
        }

        // Update field appearance
        field.classList.toggle('is-invalid', !isValid);
        field.classList.toggle('is-valid', isValid && value);

        // Update error message
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                          field.closest('.input-group')?.nextElementSibling?.classList.contains('invalid-feedback') && 
                          field.closest('.input-group').nextElementSibling;
        if (feedback) {
            feedback.textContent = message;
        }

        return isValid;
    }

    updateProgress() {
        // Check basic fields
        const basicComplete = this.requiredFields.every(fieldId => {
            const field = document.getElementById(fieldId);
            return field && field.value.trim();
        });

        // Check technical fields
        const technicalComplete = this.technicalFields.some(fieldId => {
            const field = document.getElementById(fieldId);
            return field && field.value.trim();
        });

        // Check optional specs
        const specsComplete = document.getElementById('rated_power').value.trim() ||
            document.getElementById('rated_voltage').value.trim();

        // Update checkboxes and progress
        document.getElementById('checkBasic').checked = basicComplete;
        document.getElementById('checkTechnical').checked = technicalComplete;
        document.getElementById('checkSpecs').checked = specsComplete;

        let progress = 0;
        if (basicComplete) progress += 60;
        if (technicalComplete) progress += 25;
        if (specsComplete) progress += 15;

        document.getElementById('formProgress').style.width = progress + '%';
        document.getElementById('progressText').textContent = progress + '% concluído';
    }

    calculateConsumptionEstimate() {
        const power = parseFloat(document.getElementById('rated_power').value);
        const estimateDiv = document.getElementById('consumptionEstimate');
        const estimateText = document.getElementById('estimateText');

        if (power > 0) {
            const dailyKwh = (power * 8) / 1000; // 8 horas por dia
            const monthlyKwh = dailyKwh * 30;
            const monthlyCost = monthlyKwh * 0.65; // R$ 0,65 por kWh (média)

            estimateText.innerHTML = `
                <br>• Consumo diário estimado: <strong>${dailyKwh.toFixed(2)} kWh</strong>
                <br>• Consumo mensal estimado: <strong>${monthlyKwh.toFixed(2)} kWh</strong>
                <br>• Custo mensal estimado: <strong>R$ ${monthlyCost.toFixed(2)}</strong>
                <br><small class="text-muted">(Baseado em 8h/dia de uso e tarifa média)</small>
            `;
            estimateDiv.style.display = 'flex';
        } else {
            estimateDiv.style.display = 'none';
        }
    }

    showPreview() {
        const formData = new FormData(this.form);
        const data = Object.fromEntries(formData);

        // Get selected option texts
        const deviceType = document.getElementById('device_type_id');
        const environment = document.getElementById('environment_id');

        const deviceTypeName = deviceType.selectedOptions[0]?.text || 'Não definido';
        const environmentName = environment.selectedOptions[0]?.text || 'Não definido';

        const previewHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <h6><i class="bi bi-info-circle text-primary"></i> Informações Básicas</h6>
                    <table class="table table-sm table-borderless">
                        <tr><td class="fw-semibold">Nome:</td><td>${data.name || '<em class="text-muted">Não informado</em>'}</td></tr>
                        <tr><td class="fw-semibold">Status:</td><td><span class="badge bg-${data.status === 'online' ? 'success' : data.status === 'offline' ? 'danger' : 'warning'}">${data.status || 'offline'}</span></td></tr>
                        <tr><td class="fw-semibold">Tipo:</td><td>${deviceTypeName}</td></tr>
                        <tr><td class="fw-semibold">Ambiente:</td><td>${environmentName}</td></tr>
                        <tr><td class="fw-semibold">Localização:</td><td>${data.location || '<em class="text-muted">Não informada</em>'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6><i class="bi bi-gear text-secondary"></i> Especificações Técnicas</h6>
                    <table class="table table-sm table-borderless">
                        <tr><td class="fw-semibold">MAC:</td><td><code class="text-primary">${data.mac_address || '<em class="text-muted">Não informado</em>'}</code></td></tr>
                        <tr><td class="fw-semibold">Serial:</td><td><code class="text-secondary">${data.serial_number || '<em class="text-muted">Não informado</em>'}</code></td></tr>
                        <tr><td class="fw-semibold">Modelo:</td><td>${data.model || '<em class="text-muted">Não informado</em>'}</td></tr>
                        <tr><td class="fw-semibold">Fabricante:</td><td>${data.manufacturer || '<em class="text-muted">Não informado</em>'}</td></tr>
                        <tr><td class="fw-semibold">Firmware:</td><td>${data.firmware_version || '<em class="text-muted">Não informado</em>'}</td></tr>
                    </table>
                </div>
                ${data.rated_power || data.rated_voltage || data.installation_date ? `
                <div class="col-12">
                    <h6><i class="bi bi-lightning text-warning"></i> Especificações Elétricas</h6>
                    <table class="table table-sm table-borderless">
                        ${data.rated_power ? `<tr><td class="fw-semibold">Potência:</td><td>${data.rated_power} W</td></tr>` : ''}
                        ${data.rated_voltage && data.rated_voltage !== 'custom' ? `<tr><td class="fw-semibold">Tensão:</td><td>${data.rated_voltage} V</td></tr>` : ''}
                        ${data.custom_voltage ? `<tr><td class="fw-semibold">Tensão:</td><td>${data.custom_voltage} V</td></tr>` : ''}
                        ${data.installation_date ? `<tr><td class="fw-semibold">Instalação:</td><td>${new Date(data.installation_date).toLocaleDateString('pt-BR')}</td></tr>` : ''}
                    </table>
                </div>
                ` : ''}
            </div>
        `;

        document.getElementById('previewContent').innerHTML = previewHTML;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }

    createNewEnvironment() {
        const name = document.getElementById('newEnvName').value.trim();
        const description = document.getElementById('newEnvDescription').value.trim();

        if (!name) {
            alert('Nome do ambiente é obrigatório');
            return;
        }

        // Add new option to select
        const newOption = new Option(name, 'temp_' + Date.now(), true, true);
        document.getElementById('environment_id').add(newOption);

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('newEnvironmentModal')).hide();
        document.getElementById('newEnvironmentForm').reset();

        // Show success message
        this.showAlert('success', `Ambiente "${name}" criado temporariamente. Será salvo definitivamente junto com o dispositivo.`);
    }

    showAlert(type, message) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            <strong>${type === 'success' ? 'Sucesso!' : 'Erro!'}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        this.form.insertBefore(alert, this.form.firstChild);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    handleSubmit(e) {
        let isFormValid = true;

        // Validate all fields
        this.form.querySelectorAll('input, select, textarea').forEach(field => {
            if (!this.validateField(field)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            e.preventDefault();

            this.showAlert('danger', 'Por favor, corrija os campos destacados antes de continuar.');

            // Scroll to first error
            const firstError = this.form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                setTimeout(() => firstError.focus(), 500);
            }

            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');

        submitBtn.disabled = true;
        submitSpinner.style.display = 'inline-block';
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Salvando...
        `;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ResponsiveDeviceFormManager();
});
</script>
