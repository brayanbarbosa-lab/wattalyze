@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-blue: #3498db;
        --primary-orange: #e67e22;
        --primary-purple: #9b59b6;
        --bg-light: #f8f9fa;
        --text-muted: #6c757d;
        --gray-light: #ecf0f1;
        --gray-medium: #95a5a6;
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

    /* Container principal responsivo */
    .report-generator-container {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        padding: var(--spacing-sm);
        min-height: calc(100vh - 200px);
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

    /* Header do formulário */
    .form-header {
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

    .form-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .form-header-icon {
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: var(--spacing-sm);
        opacity: 0.9;
    }

    .form-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        margin: 0;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .form-subtitle {
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        opacity: 0.8;
        text-align: center;
        margin: 0;
    }

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
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        line-height: 1.4;
    }

    .form-label .label-icon {
        color: var(--primary-green);
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .form-label .text-danger {
        color: var(--primary-red) !important;
        font-weight: 700;
    }

    /* Inputs e selects modernos */
    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        padding: 12px 16px;
        font-size: clamp(0.875rem, 2vw, 1rem);
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

    /* Multi-select estilizado */
    .form-select[multiple] {
        min-height: 120px;
        padding: 8px;
    }

    .form-select[multiple] option {
        padding: 8px 12px;
        margin: 2px 0;
        border-radius: 6px;
        transition: var(--transition);
    }

    .form-select[multiple] option:checked {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
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
        font-size: clamp(0.75rem, 1.8vw, 0.875rem);
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

    /* Helper text */
    .form-text {
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        color: var(--text-muted);
        margin-top: 0.25rem;
        display: block;
    }

    /* Botões modernos */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #229954 100%);
        border: none;
        border-radius: var(--border-radius-small);
        color: white;
        padding: 14px 28px;
        font-weight: 600;
        font-size: clamp(0.85rem, 2vw, 1rem);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        will-change: transform;
        cursor: pointer;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        background: linear-gradient(135deg, #229954 0%, var(--primary-green) 100%);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        color: var(--text-muted);
        padding: 12px 24px;
        font-weight: 600;
        font-size: clamp(0.85rem, 2vw, 1rem);
        transition: var(--transition);
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        will-change: transform;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: var(--bg-light);
        border-color: var(--text-muted);
        color: var(--primary-dark);
        transform: translateY(-1px);
        text-decoration: none;
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
        font-size: clamp(1.1rem, 3vw, 1.3rem);
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

    /* Preview card */
    .preview-card {
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05));
        border: 2px solid rgba(39, 174, 96, 0.2);
        border-radius: var(--border-radius-small);
        padding: var(--spacing-md);
        margin-top: var(--spacing-md);
        display: none;
    }

    .preview-card.show {
        display: block;
        animation: fadeInUp 0.3s ease;
    }

    .preview-title {
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: var(--spacing-sm);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-content {
        font-size: 0.9rem;
        color: var(--primary-dark);
        line-height: 1.5;
    }

    /* Section de Métricas Customizadas */
    .metrics-section {
        display: none;
    }

    .metrics-section.show {
        display: block;
        animation: fadeInUp 0.3s ease;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: var(--spacing-md);
        margin-top: var(--spacing-md);
    }

    .metric-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: var(--spacing-sm);
        background: white;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        cursor: pointer;
        transition: var(--transition);
    }

    .metric-checkbox:hover {
        border-color: var(--primary-green);
        background: rgba(39, 174, 96, 0.05);
    }

    .metric-checkbox input[type="checkbox"] {
        cursor: pointer;
        width: 18px;
        height: 18px;
        accent-color: var(--primary-green);
    }

    .metric-checkbox label {
        cursor: pointer;
        margin: 0;
        flex: 1;
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
        .report-generator-container {
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

        .form-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .form-header-content {
            text-align: left;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .report-generator-container {
            padding: var(--spacing-lg);
        }

        .form-grid.three-cols {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-grid .col-2 {
            grid-column: span 2;
        }

        .metrics-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .report-generator-container {
            max-width: 1000px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .report-generator-container {
            margin-left: 25vw;
            max-width: 65vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .report-generator-container {
            margin-left: 20vw;
            max-width: 70vw;
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
        .report-generator-container {
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

    .form-header-content {
        display: flex;
        align-items: center;
        
        gap: 6px;
        
    }

    .form-header-icon i {
        font-size: 32px;
        
    }

    .form-title {
        margin: 0;
       
    }
</style>

<div class="report-generator-container">
    <div class="form-card animate-fade-in">
        {{-- Header do formulário --}}
        <div class="form-header">
            <div class="form-header-content">
                <div class="form-header-icon">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>
                <h2 class="form-title">Gerar Relatório</h2>
                
            </div>
        </div>

        {{-- Progress indicator --}}
        <div class="form-progress">
            <div class="form-progress-bar" id="progressBar"></div>
        </div>

        <form method="POST" action="{{ route('reports.generate') }}" novalidate class="needs-validation" id="reportForm">
            @csrf

            {{-- Seção: Configurações Básicas --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-gear"></i>
                    Configurações Básicas
                </h3>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="label-icon bi bi-tag"></i>
                        Nome do Relatório <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required autocomplete="name"
                        placeholder="Ex: Consumo Mensal Outubro 2025">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="valid-feedback">Nome válido!</div>
                    @enderror
                    <small class="form-text">Escolha um nome descritivo para identificar facilmente o relatório</small>
                </div>

                <div class="form-grid">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="label-icon bi bi-file-bar-graph"></i>
                            Tipo de Relatório <span class="text-danger">*</span>
                        </label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required id="reportType">
                            <option value="">Selecione o tipo</option>
                            <option value="consumption" {{ old('type') == 'consumption' ? 'selected' : '' }}>
                                ⚡ Consumo de Energia
                            </option>
                            <option value="cost" {{ old('type') == 'cost' ? 'selected' : '' }}>
                                💰 Análise de Custos
                            </option>
                            <option value="efficiency" {{ old('type') == 'efficiency' ? 'selected' : '' }}>
                                📈 Eficiência Energética
                            </option>
                            <option value="comparative" {{ old('type') == 'comparative' ? 'selected' : '' }}>
                                📊 Relatório Comparativo
                            </option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="valid-feedback">Tipo selecionado!</div>
                        @enderror
                    </div>

                    {{-- Formato (apenas PDF) --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="label-icon bi bi-file-pdf"></i>
                            Formato de Saída <span class="text-danger">*</span>
                        </label>
                        <select name="format" class="form-select @error('format') is-invalid @enderror" required>
                            <option value="pdf" selected>
                                📄 PDF
                            </option>
                        </select>
                        <small class="form-text">Relatórios são gerados em PDF para melhor compatibilidade</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Período de Análise --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-calendar-range"></i>
                    Período de Análise
                </h3>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="label-icon bi bi-clock-history"></i>
                        Tipo de Período
                    </label>
                    <select name="period_type" class="form-select @error('period_type') is-invalid @enderror"
                        id="periodType" required>
                        <option value="">Selecione o período</option>
                        <option value="daily" {{ old('period_type') == 'daily' ? 'selected' : '' }}>
                            📅 Diário
                        </option>
                        <option value="weekly" {{ old('period_type') == 'weekly' ? 'selected' : '' }}>
                            📅 Semanal
                        </option>
                        <option value="monthly" {{ old('period_type') == 'monthly' ? 'selected' : '' }}>
                            📅 Mensal
                        </option>
                        <option value="yearly" {{ old('period_type') == 'yearly' ? 'selected' : '' }}>
                            📅 Anual
                        </option>
                        <option value="custom" {{ old('period_type') == 'custom' ? 'selected' : '' }}>
                            🎯 Personalizado
                        </option>
                    </select>
                    @error('period_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="valid-feedback">Período definido!</div>
                    @enderror
                    <small class="form-text">Escolha o intervalo de tempo para análise dos dados</small>
                </div>

                <div class="form-grid" id="dateInputs">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="label-icon bi bi-calendar-event"></i>
                            Data de Início <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="period_start" class="form-control @error('period_start') is-invalid @enderror"
                            value="{{ old('period_start') }}" required max="{{ date('Y-m-d') }}">
                        @error('period_start')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="valid-feedback">Data válida!</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="label-icon bi bi-calendar-check"></i>
                            Data de Fim <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="period_end" class="form-control @error('period_end') is-invalid @enderror"
                            value="{{ old('period_end') }}" required max="{{ date('Y-m-d') }}">
                        @error('period_end')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="valid-feedback">Data válida!</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Seção: Filtros --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-funnel"></i>
                    Filtros de Dados
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="label-icon bi bi-cpu"></i>
                            Dispositivos Específicos
                        </label>
                        <select name="devices[]" class="form-select @error('devices') is-invalid @enderror"
                            multiple size="5">
                            @forelse($devices as $device)
                            <option value="{{ $device->id }}"
                                {{ in_array($device->id, old('devices', [])) ? 'selected' : '' }}>
                                📱 {{ $device->name }}
                                @if($device->environment)
                                ({{ $device->environment->name }})
                                @endif
                            </option>
                            @empty
                            <option disabled>Nenhum dispositivo disponível</option>
                            @endforelse
                        </select>
                        @error('devices')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Deixe vazio para incluir todos. Use Ctrl/Cmd para múltipla seleção</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="label-icon bi bi-house"></i>
                            Ambientes Específicos
                        </label>
                        <select name="environments[]" class="form-select @error('environments') is-invalid @enderror"
                            multiple size="5">
                            @forelse($environments as $env)
                            <option value="{{ $env->id }}"
                                {{ in_array($env->id, old('environments', [])) ? 'selected' : '' }}>
                                🏠 {{ $env->name }}
                                @if($env->devices_count ?? 0 > 0)
                                ({{ $env->devices_count }} dispositivos)
                                @endif
                            </option>
                            @empty
                            <option disabled>Nenhum ambiente disponível</option>
                            @endforelse
                        </select>
                        @error('environments')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Deixe vazio para incluir todos. Use Ctrl/Cmd para múltipla seleção</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Métricas Customizadas (apenas para relatório personalizado) --}}
            <div class="form-section metrics-section" id="customMetricsSection">
                <h3 class="section-title">
                    <i class="bi bi-graph-up"></i>
                    Selecione as Métricas
                </h3>
                <p class="form-text mb-3">Escolha quais métricas deseja incluir no relatório personalizado:</p>

                <div class="metrics-grid">
                    {{-- Métricas de Consumo --}}
                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_total" value="total"
                            {{ in_array('total', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_total">
                            <strong>Total kWh</strong>
                            <small class="d-block text-muted">Consumo total</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_average" value="average"
                            {{ in_array('average', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_average">
                            <strong>Média</strong>
                            <small class="d-block text-muted">Consumo médio</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_maximum" value="maximum"
                            {{ in_array('maximum', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_maximum">
                            <strong>Máximo</strong>
                            <small class="d-block text-muted">Pico de consumo</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_minimum" value="minimum"
                            {{ in_array('minimum', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_minimum">
                            <strong>Mínimo</strong>
                            <small class="d-block text-muted">Menor consumo</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_median" value="median"
                            {{ in_array('median', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_median">
                            <strong>Mediana</strong>
                            <small class="d-block text-muted">Valor central</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_std_dev" value="std_dev"
                            {{ in_array('std_dev', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_std_dev">
                            <strong>Desvio Padrão</strong>
                            <small class="d-block text-muted">Variabilidade</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_variance" value="variance"
                            {{ in_array('variance', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_variance">
                            <strong>Variância</strong>
                            <small class="d-block text-muted">Dispersão de dados</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_q1" value="q1"
                            {{ in_array('q1', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_q1">
                            <strong>Q1 (25%)</strong>
                            <small class="d-block text-muted">1º quartil</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="metric_q3" value="q3"
                            {{ in_array('q3', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="metric_q3">
                            <strong>Q3 (75%)</strong>
                            <small class="d-block text-muted">3º quartil</small>
                        </label>
                    </div>

                    {{-- Tipo de Gráfico --}}
                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="chart_line_trend" value="line_trend"
                            {{ in_array('line_trend', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="chart_line_trend">
                            <strong>Gráfico Linha</strong>
                            <small class="d-block text-muted">Tendência</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="chart_comparison" value="comparison"
                            {{ in_array('comparison', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="chart_comparison">
                            <strong>Gráfico Barras</strong>
                            <small class="d-block text-muted">Comparação</small>
                        </label>
                    </div>

                    <div class="metric-checkbox">
                        <input type="checkbox" name="custom_metrics[]" id="chart_distribution" value="distribution"
                            {{ in_array('distribution', old('custom_metrics', [])) ? 'checked' : '' }}>
                        <label for="chart_distribution">
                            <strong>Gráfico Pizza</strong>
                            <small class="d-block text-muted">Distribuição</small>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Preview do relatório --}}
            <div class="preview-card" id="reportPreview">
                <div class="preview-title">
                    <i class="bi bi-eye"></i>
                    Prévia do Relatório
                </div>
                <div class="preview-content" id="previewContent">
                    <!-- Conteúdo será gerado dinamicamente -->
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    <span>Gerar Relatório</span>
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    <span>Voltar aos Relatórios</span>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    class ResponsiveReportGenerator {
        constructor() {
            this.form = document.getElementById('reportForm');
            this.progressBar = document.getElementById('progressBar');
            this.requiredFields = ['name', 'type', 'format', 'period_type', 'period_start', 'period_end'];
            this.previewCard = document.getElementById('reportPreview');
            this.previewContent = document.getElementById('previewContent');
            this.periodType = document.getElementById('periodType');
            this.reportType = document.getElementById('reportType');
            this.customMetricsSection = document.getElementById('customMetricsSection');
            this.formatSelect = this.form.querySelector('select[name="format"]');

            this.init();
        }

        init() {
            this.setupEventListeners();
            this.setupValidation();
            this.updateProgress();
            this.setupPeriodTypeHandler();
            this.setupDateValidation();
            this.setupCustomReportHandler();
            this.setDefaultFormat();
            this.generatePreview();
        }

        setupEventListeners() {
            // Form submission
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));

            // Real-time validation and progress
            this.form.querySelectorAll('input, select').forEach(field => {
                field.addEventListener('input', () => {
                    this.validateField(field);
                    this.updateProgress();
                    this.generatePreview();
                });
                field.addEventListener('change', () => {
                    this.validateField(field);
                    this.updateProgress();
                    this.generatePreview();
                });
                field.addEventListener('blur', () => this.validateField(field));
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    e.preventDefault();
                    this.form.submit();
                }
            });
        }

        setDefaultFormat() {
            // Sempre PDF como padrão
            this.formatSelect.value = 'pdf';

        }

        setupCustomReportHandler() {
            this.reportType.addEventListener('change', (e) => {
                if (e.target.value === 'custom') {
                    this.customMetricsSection.classList.add('show');
                } else {
                    this.customMetricsSection.classList.remove('show');
                }
                this.generatePreview();
            });

            // Mostrar seção se já estava selecionado
            if (this.reportType.value === 'custom') {
                this.customMetricsSection.classList.add('show');
            }
        }

        setupValidation() {
            const dateInputs = this.form.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.addEventListener('change', () => this.validateDateRange());
            });
        }

        setupPeriodTypeHandler() {
            this.periodType.addEventListener('change', (e) => {
                this.handlePeriodTypeChange(e.target.value);
            });
        }

        setupDateValidation() {
            const startDate = this.form.querySelector('input[name="period_start"]');
            const endDate = this.form.querySelector('input[name="period_end"]');

            startDate.addEventListener('change', () => {
                endDate.min = startDate.value;
                this.validateDateRange();
            });

            endDate.addEventListener('change', () => {
                startDate.max = endDate.value;
                this.validateDateRange();
            });
        }

        handlePeriodTypeChange(value) {
            const today = new Date();
            const startDate = this.form.querySelector('input[name="period_start"]');
            const endDate = this.form.querySelector('input[name="period_end"]');

            switch (value) {
                case 'daily':
                    startDate.value = today.toISOString().split('T')[0];
                    endDate.value = today.toISOString().split('T')[0];
                    break;
                case 'weekly':
                    const weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());
                    const weekEnd = new Date(weekStart);
                    weekEnd.setDate(weekStart.getDate() + 6);
                    startDate.value = weekStart.toISOString().split('T')[0];
                    endDate.value = weekEnd.toISOString().split('T')[0];
                    break;
                case 'monthly':
                    const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                    const monthEnd = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    startDate.value = monthStart.toISOString().split('T')[0];
                    endDate.value = monthEnd.toISOString().split('T')[0];
                    break;
                case 'yearly':
                    const yearStart = new Date(today.getFullYear(), 0, 1);
                    const yearEnd = new Date(today.getFullYear(), 11, 31);
                    startDate.value = yearStart.toISOString().split('T')[0];
                    endDate.value = yearEnd.toISOString().split('T')[0];
                    break;
                case 'custom':
                    // Deixar para o usuário definir
                    break;
            }

            this.validateDateRange();
            this.generatePreview();
        }

        validateField(field) {
            const value = field.value.trim();
            let isValid = true;

            // Required field validation
            if (field.hasAttribute('required') && !value) {
                isValid = false;
            }

            // Specific validations
            if (field.name === 'name' && value && value.length < 3) {
                isValid = false;
            }

            // Update field appearance
            field.classList.toggle('is-invalid', !isValid);
            field.classList.toggle('is-valid', isValid && value);

            return isValid;
        }

        validateDateRange() {
            const startDate = this.form.querySelector('input[name="period_start"]');
            const endDate = this.form.querySelector('input[name="period_end"]');

            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);

                if (start > end) {
                    endDate.setCustomValidity('Data de fim deve ser posterior à data de início');
                    endDate.classList.add('is-invalid');
                    endDate.classList.remove('is-valid');
                    return false;
                } else {
                    endDate.setCustomValidity('');
                    endDate.classList.remove('is-invalid');
                    endDate.classList.add('is-valid');
                    return true;
                }
            }
            return true;
        }

        updateProgress() {
            const requiredInputs = this.requiredFields.map(fieldName =>
                this.form.querySelector(`[name="${fieldName}"]`)
            ).filter(field => field !== null);

            const completedInputs = requiredInputs.filter(input => {
                return input.value.trim() !== '';
            });

            const progress = (completedInputs.length / requiredInputs.length) * 100;
            this.progressBar.style.width = progress + '%';
        }

        generatePreview() {
            const formData = new FormData(this.form);
            const data = Object.fromEntries(formData);

            if (!data.name || !data.type) {
                this.previewCard.classList.remove('show');
                return;
            }

            const deviceNames = Array.from(this.form.querySelectorAll('select[name="devices[]"] option:checked'))
                .map(option => option.textContent.trim());

            const envNames = Array.from(this.form.querySelectorAll('select[name="environments[]"] option:checked'))
                .map(option => option.textContent.trim());

            const selectedMetrics = Array.from(this.form.querySelectorAll('input[name="custom_metrics[]"]:checked'))
                .map(checkbox => checkbox.value);

            let previewHtml = `
                <div class="row g-2">
                    <div class="col-md-6">
                        <strong>Nome:</strong> ${data.name}
                    </div>
                    <div class="col-md-6">
                        <strong>Tipo:</strong> ${this.getTypeDescription(data.type)}
                    </div>
                    <div class="col-md-6">
                        <strong>Período:</strong> ${this.getPeriodDescription(data.period_type)}
                    </div>
                    <div class="col-md-6">
                        <strong>Formato:</strong> PDF
                    </div>
            `;

            if (data.period_start && data.period_end) {
                previewHtml += `
                    <div class="col-12">
                        <strong>Datas:</strong> ${this.formatDate(data.period_start)} até ${this.formatDate(data.period_end)}
                    </div>
                `;
            }

            if (deviceNames.length > 0) {
                previewHtml += `
                    <div class="col-12">
                        <strong>Dispositivos:</strong> ${deviceNames.slice(0, 3).join(', ')}${deviceNames.length > 3 ? ` e mais ${deviceNames.length - 3}` : ''}
                    </div>
                `;
            }

            if (envNames.length > 0) {
                previewHtml += `
                    <div class="col-12">
                        <strong>Ambientes:</strong> ${envNames.slice(0, 3).join(', ')}${envNames.length > 3 ? ` e mais ${envNames.length - 3}` : ''}
                    </div>
                `;
            }

            if (data.type === 'custom' && selectedMetrics.length > 0) {
                previewHtml += `
                    <div class="col-12">
                        <strong>Métricas:</strong> ${selectedMetrics.slice(0, 4).join(', ')}${selectedMetrics.length > 4 ? ` e mais ${selectedMetrics.length - 4}` : ''}
                    </div>
                `;
            }

            previewHtml += '</div>';

            this.previewContent.innerHTML = previewHtml;
            this.previewCard.classList.add('show');
        }

        getTypeDescription(type) {
            const types = {
                'consumption': 'Consumo de Energia',
                'cost': 'Análise de Custos',
                'efficiency': 'Eficiência Energética',
                'comparative': 'Relatório Comparativo',
                'custom': 'Personalizado'
            };
            return types[type] || type;
        }

        getPeriodDescription(period) {
            const periods = {
                'daily': 'Diário',
                'weekly': 'Semanal',
                'monthly': 'Mensal',
                'yearly': 'Anual',
                'custom': 'Personalizado'
            };
            return periods[period] || period;
        }

        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('pt-BR');
        }

        handleSubmit(e) {
            let isFormValid = true;

            // Validate all fields
            this.form.querySelectorAll('input[required], select[required]').forEach(field => {
                if (!this.validateField(field)) {
                    isFormValid = false;
                }
            });

            if (!this.validateDateRange()) {
                isFormValid = false;
            }

            if (!isFormValid) {
                e.preventDefault();

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
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        }
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        new ResponsiveReportGenerator();
    });
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">