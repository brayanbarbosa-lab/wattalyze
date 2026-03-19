@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-orange: #e67e22;
        --primary-blue: #3498db;
        --primary-purple: #9b59b6;
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

    /* Body e Container responsivos */
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .main-container {
        width: 100%;
        padding: var(--spacing-sm);
        margin: 0 auto;
        min-height: 100vh;
    }

    /* Navegação com abas responsiva */
    .nav-tabs {
        border: none;
        margin-bottom: var(--spacing-md);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 8px;
        box-shadow: var(--shadow-light);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nav-tabs .nav-item {
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        color: var(--text-muted);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 16px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        text-decoration: none;
        will-change: transform;
    }

    .nav-tabs .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        opacity: 0;
        transition: var(--transition);
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white !important;
        box-shadow: var(--shadow-light);
        transform: translateY(-1px);
    }

    .nav-tabs .nav-link:hover:not(.active) {
        background: rgba(39, 174, 96, 0.1);
        color: var(--primary-green);
        transform: translateY(-1px);
    }

    /* Título moderno responsivo */
    .modern-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-md);
        position: relative;
        display: flex;
        align-items: center;
        line-height: 1.2;
    }

    .modern-title::before {
        content: '';
        width: 4px;
        height: clamp(30px, 6vw, 40px);
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        border-radius: 2px;
        margin-right: var(--spacing-sm);
        flex-shrink: 0;
    }

    /* Cards modernos responsivos */
    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: var(--spacing-md);
        overflow: hidden;
        transition: var(--transition);
        position: relative;
        will-change: transform;
    }

    .modern-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-dark), #34495e);
        color: white;
        font-weight: 700;
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        border: none;
        padding: var(--spacing-md);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    .card-body {
        padding: var(--spacing-md);
    }

    /* Formulários modernos responsivos */
    .form-label {
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        gap: 8px;
        line-height: 1.4;
    }

    .form-label::before {
        content: '';
        width: 3px;
        height: 16px;
        background: var(--primary-green);
        border-radius: 2px;
        flex-shrink: 0;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        padding: 12px 16px;
        font-weight: 500;
        font-size: clamp(0.85rem, 2vw, 1rem);
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.8);
        width: 100%;
        min-height: 48px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15);
        background: white;
        outline: none;
    }

    .form-text {
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    /* Grid responsivo para formulário */
    .form-grid {
        display: grid;
        gap: var(--spacing-sm);
        grid-template-columns: 1fr;
    }

    /* Botões modernos responsivos */
    .modern-btn {
        padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 24px);
        font-weight: 600;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        border-radius: var(--border-radius-small);
        border: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
        will-change: transform;
        min-height: 44px;
    }

    .modern-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        pointer-events: none;
    }

    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-primary.modern-btn {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .btn-success.modern-btn {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .btn-warning.modern-btn {
        background: linear-gradient(135deg, var(--primary-orange), #f39c12);
        color: white;
    }

    .btn-danger.modern-btn {
        background: linear-gradient(135deg, var(--primary-red), #ec7063);
        color: white;
    }

    .btn-secondary.modern-btn {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: white;
    }

    .btn-sm.modern-btn {
        padding: 8px 16px;
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        min-height: 36px;
    }

    /* Tabela moderna responsiva */
    .modern-table-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        transition: var(--transition);
    }

    .modern-table-container:hover {
        box-shadow: var(--shadow-medium);
    }

    table.table {
        margin: 0;
        border: none;
    }

    table.table thead {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    table.table thead th {
        border: none;
        font-weight: 700;
        font-size: clamp(0.75rem, 2vw, 0.9rem);
        padding: var(--spacing-md) var(--spacing-sm);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    table.table tbody tr {
        border: none;
        transition: var(--transition);
        position: relative;
    }

    table.table tbody tr::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: var(--primary-green);
        transition: var(--transition);
    }

    table.table tbody tr:hover {
        background: rgba(39, 174, 96, 0.05);
        transform: translateX(4px);
    }

    table.table tbody tr:hover::before {
        width: 4px;
    }

    table.table tbody td {
        border: none;
        padding: var(--spacing-md) var(--spacing-sm);
        vertical-align: middle;
        font-weight: 500;
        color: var(--primary-dark);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
    }

    /* Cards para mobile */
    .rule-card-mobile {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: var(--spacing-sm);
        overflow: hidden;
        position: relative;
        display: none;
        transition: var(--transition);
    }

    .rule-card-mobile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
    }

    .rule-card-mobile:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .rule-card-body {
        padding: var(--spacing-md);
    }

    .rule-card-title {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-xs);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rule-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-md);
    }

    .rule-card-meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .rule-card-meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .rule-card-meta-value {
        font-size: 0.9rem;
        color: var(--primary-dark);
        font-weight: 500;
    }

    .rule-card-actions {
        display: flex;
        gap: var(--spacing-xs);
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Badge responsivo */
    .rule-type-badge {
        background: rgba(52, 152, 219, 0.1);
        color: var(--primary-blue);
        border: 1px solid rgba(52, 152, 219, 0.3);
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Estado vazio responsivo */
    .empty-state {
        text-align: center;
        padding: var(--spacing-xl) var(--spacing-md);
        color: var(--text-muted);
    }

    .empty-state-icon {
        font-size: clamp(3rem, 8vw, 4rem);
        margin-bottom: var(--spacing-md);
        color: var(--primary-green);
    }

    .empty-state h4 {
        font-size: clamp(1.2rem, 3vw, 1.4rem);
        color: var(--primary-dark);
        margin-bottom: var(--spacing-sm);
    }

    .empty-state p {
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        margin: 0;
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

        .nav-tabs {
            flex-direction: row;
            gap: 8px;
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
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

        .form-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-grid .col-full {
            grid-column: 1 / -1;
        }

        /* Mostrar tabela, ocultar cards */
        .modern-table-container {
            display: block !important;
        }

        .rule-card-mobile {
            display: none !important;
        }

        table.table tbody tr:hover {
            transform: translateX(4px);
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .form-grid.form-row-large {
            grid-template-columns: 2fr 1fr 1fr;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 30vw;
            max-width: 65vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 25vw;
            max-width: 70vw;
        }
    }

    /* Mobile específico */
    @media (max-width: 767.98px) {
        .modern-table-container {
            display: none !important;
        }

        .rule-card-mobile {
            display: block !important;
        }

        .nav-tabs .nav-link {
            justify-content: center;
        }

        .form-actions {
            text-align: center;
        }

        .modern-btn {
            width: 100%;
            max-width: 300px;
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

        .modern-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .modern-btn,
        .nav-tabs {
            display: none !important;
        }
    }
</style>

<div class="main-container">
    {{-- Navegação com abas responsiva --}}
    <ul class="nav nav-tabs animate-fade-in">
        <li class="nav-item">
            <a href="{{ route('alerts.rules') }}" class="nav-link {{ request()->routeIs('alerts.rules') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Regras de Alerta</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('alerts.active') }}" class="nav-link {{ request()->routeIs('alerts.active') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Alertas Ativos</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('alerts.history') }}" class="nav-link {{ request()->routeIs('alerts.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Histórico</span>
            </a>
        </li>
    </ul>

    <h2 class="modern-title animate-fade-in" style="animation-delay: 0.1s;">
        Regras de Alerta
    </h2>

    {{-- Formulário de criação responsivo --}}
    <div class="modern-card animate-fade-in" style="animation-delay: 0.2s;">
        <div class="card-header">
            <i class="bi bi-plus-circle"></i>
            <span>Nova Regra</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('alerts.rules.store') }}" novalidate class="needs-validation">
                @csrf
                <div class="form-grid">
                    <div class="mb-3">
                        <label class="form-label">Nome da Regra <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required
                            placeholder="Ex: Consumo Alto Sala">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="valid-feedback">Nome válido!</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Alerta <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Selecione o tipo</option>
                            <option value="consumption_threshold" {{ old('type') == 'consumption_threshold' ? 'selected' : '' }}>
                                ⚡ Limite de Consumo
                            </option>
                            <option value="cost_threshold" {{ old('type') == 'cost_threshold' ? 'selected' : '' }}>
                                💰 Limite de Custo
                            </option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="valid-feedback">Tipo selecionado!</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Valor do Limite</label>
                        <input type="number" name="threshold_value"
                            class="form-control @error('threshold_value') is-invalid @enderror"
                            value="{{ old('threshold_value') }}"
                            step="0.01" min="0" placeholder="0.00">
                        @error('threshold_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-grid form-row-large">
                    <div class="mb-3 col-full">
                        <label class="form-label">Dispositivo Específico</label>
                        <select name="device_id" class="form-select @error('device_id') is-invalid @enderror">
                            <option value="">🔧 Todos os dispositivos</option>
                            @foreach($devices as $device)
                            <option value="{{ $device->id }}" {{ old('device_id') == $device->id ? 'selected' : '' }}>
                                📱 {{ $device->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('device_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ambiente Específico</label>
                        <select name="environment_id" class="form-select @error('environment_id') is-invalid @enderror">
                            <option value="">🏠 Todos os ambientes</option>
                            @foreach($environments as $env)
                            <option value="{{ $env->id }}" {{ old('environment_id') == $env->id ? 'selected' : '' }}>
                                🏡 {{ $env->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('environment_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="data_inicio" class="form-label">Data Início (Opcional)</label>
                        <input type="date"
                            class="form-control @error('data_inicio') is-invalid @enderror"
                            id="data_inicio"
                            name="data_inicio"
                            value="{{ old('data_inicio') }}">
                        @error('data_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Deixe em branco para ativar imediatamente</small>
                    </div>

                    <div class="col-md-6">
                        <label for="data_fim" class="form-label">Data Fim (Opcional)</label>
                        <input type="date"
                            class="form-control @error('data_fim') is-invalid @enderror"
                            id="data_fim"
                            name="data_fim"
                            value="{{ old('data_fim') }}">
                        @error('data_fim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Deixe em branco para vigência indefinida</small>
                    </div>

                    <div class="mb-3 d-flex align-items-end">
                        <button type="submit" class="modern-btn btn-primary w-100">
                            <i class="bi bi-plus-lg"></i>
                            <span>Criar Regra</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de regras existentes --}}
    <div class="modern-card animate-fade-in" style="animation-delay: 0.3s;">
        <div class="card-header">
            <i class="bi bi-list-ul"></i>
            <span>Regras Existentes</span>
        </div>
        <div class="card-body p-0">
            @if($rules->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <h4>Nenhuma regra cadastrada</h4>
                <p class="text-muted">Crie sua primeira regra de alerta usando o formulário acima.</p>
            </div>
            @else
            {{-- Tabela Desktop --}}
            <div class="modern-table-container">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th></th>
                                <th><i class="bi bi-tag me-2"></i>Nome</th>
                                <th><i class="bi bi-gear me-2"></i>Tipo</th>
                                <th><i class="bi bi-toggle-on me-2"></i>Status</th>
                                <th class="text-center"><i class="bi bi-tools me-2"></i>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rules as $rule)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-shield-check text-success me-2"></i>
                                        <strong>{{ $rule->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="rule-type-badge">
                                        {{ ucwords(str_replace('_', ' ', $rule->type)) }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('alerts.rules.toggle', $rule->id) }}">
                                        @csrf
                                        <button type="submit" class="modern-btn btn-sm {{ $rule->is_active ? 'btn-success' : 'btn-secondary' }}">
                                            <i class="bi bi-{{ $rule->is_active ? 'check-circle' : 'x-circle' }}"></i>
                                            <span>{{ $rule->is_active ? 'Ativa' : 'Inativa' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">

                                        <form method="POST" action="{{ route('alerts.rules.destroy', $rule->id) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="modern-btn btn-danger btn-sm"
                                                onclick="return confirm('Tem certeza que deseja excluir esta regra?')"
                                                title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Cards Mobile --}}
            @foreach($rules as $index => $rule)
            <div class="rule-card-mobile animate-fade-in" style="animation-delay: {{ 0.4 + ($index * 0.1) }}s;">
                <div class="rule-card-body">
                    <div class="rule-card-title">
                        <i class="bi bi-shield-check text-success"></i>
                        {{ $rule->name }}
                    </div>

                    <div class="rule-card-meta">
                        <div class="rule-card-meta-item">
                            <div class="rule-card-meta-label">Tipo</div>
                            <div class="rule-card-meta-value">
                                <span class="rule-type-badge">
                                    {{ ucwords(str_replace('_', ' ', $rule->type)) }}
                                </span>
                            </div>
                        </div>
                        <div class="rule-card-meta-item">
                            <div class="rule-card-meta-label">Status</div>
                            <div class="rule-card-meta-value">
                                <span class="modern-btn btn-sm {{ $rule->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    <i class="bi bi-{{ $rule->is_active ? 'check-circle' : 'x-circle' }}"></i>
                                    {{ $rule->is_active ? 'Ativa' : 'Inativa' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rule-card-actions">
                        <form method="POST" action="{{ route('alerts.rules.toggle', $rule->id) }}" class="flex-fill">
                            @csrf
                            <button type="submit" class="modern-btn btn-sm {{ $rule->is_active ? 'btn-secondary' : 'btn-success' }} w-100">
                                <i class="bi bi-{{ $rule->is_active ? 'pause' : 'play' }}"></i>
                                {{ $rule->is_active ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>
                        <a href="{{ route('alerts.rules.edit', $rule->id) }}"
                            class="modern-btn btn-warning btn-sm flex-fill">
                            <i class="bi bi-pencil"></i>
                            Editar
                        </a>
                        <form method="POST" action="{{ route('alerts.rules.destroy', $rule->id) }}" class="flex-fill">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="modern-btn btn-danger btn-sm w-100"
                                onclick="return confirm('Tem certeza que deseja excluir esta regra?')">
                                <i class="bi bi-trash"></i>
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Paginação --}}
            @if(method_exists($rules, 'links'))
            <div class="d-flex justify-content-center p-3 animate-fade-in" style="animation-delay: 0.5s;">
                {{ $rules->links() }}
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validação em tempo real
        const form = document.querySelector('.needs-validation');
        const inputs = form.querySelectorAll('input[required], select[required]');

        // Validação individual dos campos
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });

        // Validação no submit
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                // Focar no primeiro campo inválido
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }

            form.classList.add('was-validated');
        });

        // Inicializar tooltips se não for mobile
        if (window.innerWidth >= 768) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">